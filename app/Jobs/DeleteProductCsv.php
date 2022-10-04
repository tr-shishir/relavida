<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\Export\ExportService;
use \Intervention\Image\ImageManagerStatic as Image;


class DeleteProductCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $header;
    public $key;
    public $count;
    public $processing_id;
    public $syncedId;
    public $is_channel;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $key, $count, $processing_id, $syncedId, $is_channel)
    {
        $this->data = $data;
        $this->key = $key;
        $this->count = $count;
        $this->processing_id = $processing_id;
        $this->syncedId = $syncedId;
        $this->is_channel = $is_channel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        $arr_for_process = [];
        static $error_count = 0;
        static $success_count = 0;
        static $final_status = null;
        $dt_ids = DB::table('content')->select('id','drm_ref_id')->whereIn('drm_ref_id', $this->data)->get();
        $dt_shop_ids = $dt_ids->pluck('id')->toArray();
        $not_found_drm_ids = array_diff($this->data,$dt_ids->pluck('drm_ref_id')->toArray());
        $found_drm_id = array_intersect($this->data,$dt_ids->pluck('drm_ref_id')->toArray());
        $has_subscription = array_unique(DB::table('subscription_order_status')->whereIn('product_id', $dt_shop_ids)->where('order_status', 'active')->where('order_type', 'new')->pluck('product_id')->toArray());
        $has_category = array_unique(DB::table('categories_items')->whereIn('rel_id',$dt_shop_ids)->pluck('rel_id')->toArray());

        // create array for not found data status
        if(!empty($not_found_drm_ids)){
            foreach($not_found_drm_ids as $no_dt_id){
                $error_count++;
                $arr_for_process[] = [
                    'processing_id' => $this->processing_id,
                    'drm_ref_id' => $no_dt_id,
                    'content_id' => null,
                    'msg' => "Product isn't found in DT shop. DRM ref id of this product is {$no_dt_id}",
                    'is_success' => 0
                ];
            }
        }

        // create array for dt data status and deletion process dependency functionality run
        if(!empty($dt_ids)){
            foreach($dt_ids as $dt_id){
                $arr_for_process[] = [
                    'processing_id' => $this->processing_id,
                    'drm_ref_id' => $dt_id->drm_ref_id,
                    'content_id' => $dt_id->id,
                    'msg' => "Product deleted",
                    'is_success' => 1
                ];
                $success_count++;
            }
        }

        if(!empty($has_subscription)){
            dependency_function_for_delete_product($has_subscription, 'subscription');
        }
        if(!empty($has_category)){
            dependency_function_for_delete_product($has_category, 'category');
        }
        // delete product data from table
        if(!empty($dt_shop_ids)){
            DB::table('offers')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('bundle_products')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('categories_items')->whereIn('rel_id', $dt_shop_ids)->delete();
            DB::table('tagging_tagged')->whereIn('taggable_id', $dt_shop_ids)->delete();
            DB::table('product_upselling_item')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('product_details')->whereIn('rel_id', $dt_shop_ids)->delete();
            DB::table('products')->whereIn('content_id', $dt_shop_ids)->delete();
            DB::table('media')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
            DB::table('content_data')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
            DB::table('content')->whereIn('id', $dt_shop_ids)->where('content_type', 'product')->delete();
            $custom_value_id = DB::table('custom_fields')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->pluck('id')->toArray();
            if(isset($custom_value_id) and !empty($custom_value_id)){
                DB::table('custom_fields')->whereIn('id', $custom_value_id)->delete();
                DB::table('custom_fields_values')->whereIn('custom_field_id', $custom_value_id)->delete();
            }
        }
        if($error_count == 0){
            if($final_status != "failed"){
                $final_status = "success";
            }
        } else{
            if($final_status != "failed"){
                $final_status = "failed";
            }
        }

        if(isset($this->is_channel) and $this->is_channel == 'channel') $channel = true;
        else $channel = false;

        DB::table('sync_processing_data_status_v2')->insert($arr_for_process);
        if(!empty($found_drm_id)){
            $drm_total_ids = json_encode($found_drm_id);
            $user_token = Config('microweber.userToken');
            $pass_token = Config('microweber.userPassToken');
            // curl init
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/status/update',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ids' => $drm_total_ids,'type' => 'DELETE', 'channel' => $channel),
            CURLOPT_HTTPHEADER => array(
                'userPassToken: '.$pass_token,
                'userToken: '.$user_token
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            //echo $response;
        }
        if(($this->key+1) == $this->count){
            $total_count = DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->pluck('count')->last();
            if($total_count == ($error_count + $success_count)){
                DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "success"]);
            } else{
                DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "failed"]);
            }
            DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['success_count' => $success_count, 'error_count' => $error_count ,'sync_status' => $final_status]);
            cat_reset_logic();
        }

    }


}
