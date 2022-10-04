<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $content = DB::table('content')->where('is_deleted' , 1)->get();

            foreach($content as $data){
                $date = \Carbon::parse($data->updated_at);
                $now = \Carbon::now();
                $diff = $date->diffInDays($now);
                if($diff <= 30 ){
                    $leftDate = 30-$diff;
                }else{
                    $leftDate = 0;
                }
                if(!isset($leftDate) || $leftDate <= 0){
                    DB::table('offers')->where('product_id', $data->id)->delete();
                    DB::table('bundle_products')->where('product_id', $data->id)->delete();
                    DB::table('categories_items')->where('rel_id', $data->id)->delete();
                    DB::table('tagging_tagged')->where('taggable_id', $data->id)->delete();
                    DB::table('product_upselling_item')->where('product_id', $data->id)->delete();
                    DB::table('product_details')->where('rel_id', $data->id)->delete();
                    DB::table('products')->where('content_id', $data->id)->delete();
                    DB::table('media')->where('rel_id', $data->id)->where('rel_type', 'content')->delete();
                    DB::table('content_data')->where('rel_id', $data->id)->where('rel_type', 'content')->delete();
                    DB::table('content')->where('id', $data->id)->where('content_type', 'product')->delete();
                    $custom_value_id = DB::table('custom_fields')->where('rel_id', $data->id)->where('rel_type', 'content')->pluck('id')->toArray();
                    if(isset($custom_value_id) and !empty($custom_value_id)){
                        DB::table('custom_fields')->whereIn('id', $custom_value_id)->delete();
                        DB::table('custom_fields_values')->whereIn('custom_field_id', $custom_value_id)->delete();
                    }
                }
            }
        })->daily();
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

    }
}
