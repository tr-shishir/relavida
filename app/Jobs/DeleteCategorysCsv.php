<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Category;
use App\Models\CategoryItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteCategorysCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $key;
    public $count;
    public $processing_id;
    public $syncedId;

    /**
     * Create a new job instance.
     *
     * @return void $chunk,$key,$count, $header,$processing_id, $data
     */
    public function __construct($data, $key, $count,$processing_id, $syncedId)
    {
        $this->data = $data;
        $this->key = $key;
        $this->count = $count;
        $this->processing_id = $processing_id;
        $this->syncedId = $syncedId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // dd($this->data,$this->key,$this->count,$this->processing_id,$this->syncedId);
        static $error_count = 0;
        static $success_count = 0;
        static $final_status = null;
        $arr_for_process =array();
        $categoryDataSet=array();
        $categoryId= array();
        $dt_ids = DB::table('categories')->select('id','drm_ref_id')->whereIn('drm_ref_id', $this->data)->get();
        $Cat_id =$dt_ids->pluck('id')->toArray();
        $not_found_drm_ids = array_diff($this->data,$dt_ids->pluck('drm_ref_id')->toArray());
        $found_drm_id = array_intersect($this->data,$dt_ids->pluck('drm_ref_id')->toArray());

           // create array for not found data status
           if(!empty($not_found_drm_ids)){
            foreach($not_found_drm_ids as $no_dt_id){
                $error_count++;
                $arr_for_process[] = [
                    'processing_id' => $this->processing_id,
                    'drm_ref_id' => $no_dt_id,
                    'content_id' => null,
                    'msg' => "Category isn't found in DT shop. DRM ref id of this Category is {$no_dt_id}",
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
                    'msg' => "Category deleted",
                    'is_success' => 1
                ];
                $success_count++;
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


         if (isset($Cat_id) && !empty($Cat_id)) {

             DB::table('categories_items')->whereIn('parent_id',$Cat_id)->delete();
             DB::table('categories')->whereIn('id', $Cat_id)->delete();

         }

         DB::table('sync_processing_data_status_v2')->insert($arr_for_process);

         if(($this->key+1) == $this->count){
            $total_count = DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->pluck('count')->last();
            if($total_count == ($error_count + $success_count)){
                DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "success"]);
            } else{
                DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "failed"]);
            }
            DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['success_count' => $success_count, 'error_count' => $error_count ,'sync_status' => $final_status]);
        }

         clearcache();
    }
}
