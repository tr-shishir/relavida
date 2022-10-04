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


class ImageDownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $timeout = 7200;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        foreach($this->data as $key => $image){
            if(isset($image->webp_image)){
                $full_images_data[$key][] = str_replace('{SITE_URL}', site_url(), $image->webp_image);
            } elseif(isset($image->resize_image)){
                $full_images_data[$key][] = str_replace('{SITE_URL}', site_url(), $image->resize_image);
            } else{
                if(strpos($image->filename, '{SITE_URL}') !== false){
                    return str_replace('{SITE_URL}', site_url(), $image->filename);
                } else{
                    $filename = basename($image->filename);
                    dump($filename);
                    $savePath = public_path('userfiles/media/templates.microweber.com/default/'.$filename);
                    try {
                        $new_image = Image::make($image->filename)->save($savePath);
                        DB::table('media')->where('id', $image->id)->update(['filename' => '{SITE_URL}userfiles/media/templates.microweber.com/default/'.$new_image->basename]);
                        $image_name = '{SITE_URL}userfiles/media/templates.microweber.com/default/'.$new_image->basename;
                    }catch(Exception $e){
                        return false;
                    }

                }
            }

        }
    }
}
