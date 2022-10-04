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


class ImageCompressJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $optimize_data;
    public $timeout = 7200;
    public $url;
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$optimize_data,$url)
    {
        $this->data = $data;
        $this->optimize_data = $optimize_data;
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
        $imageMeta = array();
        foreach($this->data as $key => $image){
            try{
                $compress_size   = $this->optimize_data[1]->compress ?? 50;
                $minimum_size    = $this->optimize_data[2]->minimum_size ?? 50;
                $thumbnail_width = $this->optimize_data[3]->thumbnail_width ?? 150;
                if(str_starts_with($image->filename,'{SITE_URL}')){
                    $image->filename = str_replace('{SITE_URL}',$this->url.'/',  $image->filename);
                }
                if(getimagesize($image->filename) !== false){
                    // Start product image resize code
                    if($thumbnail_width == null){
                        $thumbnail_width = Image::make($image->filename)->width();
                    }
                    $main_image_path = $image->filename;
                    // get image size
                    $ch = curl_init($main_image_path);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, TRUE);
                    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
                    $msr = curl_exec($ch);
                    $file_byte_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                    $file_kb_size = round($file_byte_size / 1024,4);
                    $resized_image = resize_image($image->filename,$thumbnail_width,$file_kb_size,$minimum_size);
                    $webp_image = Image::make($image->filename)->encode('webp', 90);
                    @$webp_image->save($resized_image['webp_save_path'].$resized_image['only_image_name'].'.webp',$compress_size ? $compress_size : 100);
                    insert_resized_image($image->rel_id, $image->filename,$resized_image,$thumbnail_width,$file_kb_size,$minimum_size,true);
                    $imageMeta[$image->image_id] = array_merge(
                    [$this->url.'/userfiles/media/templates.microweber.com/'.$thumbnail_width.'/'.$resized_image['only_image_name'].'.webp'],
                    $imageMeta[$image->image_id]??[]
                );
                }else{
                    dump(false);
                    continue;
                }

            }catch(Exception $e){
                continue;
            }
        }
        $chunks = collect($imageMeta)->chunk(1000);
        if (isset($chunks) && !empty($chunks)) {
            foreach ($chunks as $key => $chunk) {
                $chunk = $chunk->toArray();
                // $chunk = array_map(function($chunk) { return str_getcsv($chunk,"|");},$chunk);

                // try{
                    \App\Jobs\MetadataUpdate::dispatch($chunk,true)->onQueue("high");

                // }catch(Exception $e){
                //     echo $e;
                // }
            }
        }

    }
}
