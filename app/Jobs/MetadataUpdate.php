<?php

namespace App\Jobs;

use App\Models\SyncHistory;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Intervention\Image\ImageManagerStatic as Image;


class MetadataUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $optimize_data;
    public $image;
    public $timeout = 600;
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$image = false)
    {
        $this->data = $data;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        $metaData = [];
            if(isset($this->image) && !empty($this->image)){
            foreach($this->data as $key => $value){
                $metaData[] = ['id' => $key, 'images' => $value];
            }
        }else{
            foreach($this->data as $value){
                $metaData[] = ['id' => $value->drm_ref_id, 'url' => $value->url];
            }

        }
        $drmIdsStr = json_encode($metaData);
        $user_token = Config('microweber.userToken');
        $pass_token = Config('microweber.userPassToken');
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/metadata/update',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('data' => $drmIdsStr),
        CURLOPT_HTTPHEADER => array(
            'userPassToken: '.$pass_token,
            'userToken: '.$user_token
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

    }
}
