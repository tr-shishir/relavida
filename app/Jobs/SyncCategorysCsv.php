<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Content;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SyncCategorysCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $header;
    public $key;
    public $count;
    public $processing_id;
    public $syncedId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header, $key, $count, $processing_id, $syncedId)
    {
        $this->data = $data;
        $this->header = $header;
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

        $categoryDataSet = array();
        $errorLogData = array();
        $successLogData = array();
        $errorCount = 0;
        $successCount = 0;
        // $parentIds = array();
        $replaced_data = [
            0 => 'drm_ref_id',
            1 => 'title',
            2 => 'parent_id'
        ];
        $replaced_header = array_replace($this->header, $replaced_data);

        foreach ($this->data as $value) {
            $dataSet = array_combine($replaced_header, $value);

            $validatedData = Validator::make($dataSet, [
                'title' => 'required',
                'drm_ref_id' => 'required|unique:categories,drm_ref_id'

            ]);
            $url =  mw()->url_manager->slug($dataSet['title']) . '-' . rand();

            $bypassValidation = true;
            if ($validatedData->fails()) {
                $hasDrmId = $validatedData->messages()->messages() ?? []; 
                if(array_key_exists('drm_ref_id',$hasDrmId)){
                    $errorLogData[] = [
                        'processing_id' => $this->processing_id,
                        'msg' => "shop category updated on DRM side",
                        'drm_ref_id' => $dataSet['drm_ref_id']
                    ];
                    $successCount++;
                    $bypassValidation = false;
                } else{
                    $errorCount++;
                    $errorLogData[] = [
                        'processing_id' => $this->processing_id,
                        'msg' => json_encode($validatedData->messages()),
                        'drm_ref_id' => $dataSet['drm_ref_id']
                    ];

                    continue;
                }
            }
            $position = DB::table('categories')->max('position') + 1 ?? 0;

            $shop = Content::where([
                'content_type' => 'page',
                'url' => 'shop'
            ])->first();
            $rel_id = $shop->id;

            if ($bypassValidation and $validatedData->validated()) {
                $successCount++;
                // $parentIds[$dataSet['drm_ref_id']] = $dataSet['parent_id'];
                $categoryDataSet[$dataSet['drm_ref_id']] = array_merge(
                    collect($dataSet)->only(
                        [
                            'title',
                            'drm_ref_id',
                            'parent_id'
                        ]
                    )->toArray(),
                    [
                        'rel_type' => 'content',
                        'is_hidden' => 1,
                        'category_subtype' => 'default',
                        'data_type' => 'category',
                        'url' => $url,
                        'rel_id' => $rel_id,
                        'position' => $position,
                        'status' => 1,
                    ],
                );
            }

            $successLogData[$dataSet['drm_ref_id']] = [
                'processing_id' => $this->processing_id,
                'msg' => json_encode($dataSet),
                'drm_ref_id' => $dataSet['drm_ref_id'],
                'is_success' => 1
            ];
        }

        if (isset($errorLogData) && !empty($errorLogData)) {
            DB::table('sync_processing_data_status_v2')->insert($errorLogData);
        }

        if (isset($categoryDataSet) && !empty($categoryDataSet)) {

            DB::table('categories')->insert($categoryDataSet);
        }
        if($successCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('success_count', $successCount);
        if($errorCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('error_count', $errorCount);
        if (($this->key + 1) == $this->count) {

            $catIds = DB::table('categories')->pluck('id', 'drm_ref_id')->toArray();
            foreach ($catIds as $key => $value) {
                DB::table('categories')->where('parent_id', $key)->update(['parent_id' => $value, 'rel_id' => 0]);
            }

            if (isset($successLogData) && !empty($successLogData)) {
                DB::table('sync_processing_data_status_v2')->insert($successLogData);
            }

            $total_count = DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->select('count', 'success_count', 'error_count')->first();
            if(isset($total_count) and $total_count->count == ($total_count->success_count + $total_count->error_count)){
                DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "success"]); 
                DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "success"]);
            } else{
                DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "failed"]);
                DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "failed"]);
            }

            // curl init
            if (!empty($catIds)) {
                $drmIdsStr = json_encode($catIds);
                $user_token = Config('microweber.userToken');
                $pass_token = Config('microweber.userPassToken');
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-category/status/update',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('ids' => $drmIdsStr, 'type' => 'INSERT'),
                    CURLOPT_HTTPHEADER => array(
                        'userPassToken: ' . $pass_token,
                        'userToken: ' . $user_token
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
            }

            // dd($parentIds);
            // $catIds = DB::table('categories')->whereIn('parent_id', array_unique(array_values($parentIds)))->pluck('id', 'drm_ref_id')->toArray();
            // foreach ($catIds as $key => $value) {

            //     DB::table('categories')->where('parent_id', $key)->update(['parent_id' => $value, 'rel_id' => 0]);

            // }
        }

        clearcache();
    }
}
