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


class UpdateProductsCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $header;
    public $key;
    public $count;
    public $processing_id;
    public $syncedId;
    public $params;
    public $url;
    public $timeout = 600;
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header, $key, $count, $processing_id, $syncedId, $params, $url)
    {
        $this->data = $data;
        $this->key = $key;
        $this->header = $header;
        $this->count = $count;
        $this->processing_id = $processing_id;
        $this->syncedId = $syncedId;
        $this->params = $params;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        $export = new ExportService($this->data, $this->header, $this->key, $this->count, $this->processing_id, $this->syncedId,$this->params, $this->url);
        $export->executeUpdateProcess();

    }





    //     foreach ($this->data as $value) {
    //         $info = array_combine($this->header, $value);
    //         $info['drm_ref_id'] = $info['id'];
    //         $json = json_encode($info, true);
    //         $file_name = "DRM-Product-sync-" . date("d-m-y") . ".csv";
    //         $path = resource_path('json');
    //         dd($json);
    //         // $DT_sync=file_put_contents("json/{$file_name}",$info);
    //         // // dd("hello_rana");
    //         // $csv_drm = \DB::table('drm_info')->updateOrInsert(
    //         //     ['drm_ref_id' => $info['drm_ref_id']],
    //         //     $info
    //         // );
    //         // dd("Hi");
    //         if (file_put_contents($path. $file_name , $json)) {
    //             dd("hello_rana");
    //         } else {
    //             dd("file not create");
    //         }
    //     }
    // }
}
