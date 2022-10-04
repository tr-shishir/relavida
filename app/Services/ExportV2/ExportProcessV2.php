<?php
namespace App\Services\ExportV2;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\Export\ExportService;
use Symfony\Component\HttpFoundation\Request;
use League\Csv\Reader;
use Illuminate\Support\LazyCollection;


class ExportProcessV2
{
    public $user_token = null;
    public $pass_token = null;
    public $sync_id;
    public $old_sync_id;
    public function __construct($data, $sync_id, $old_sync_id)
    {
        if(isset($data['userToken']) && isset($data['userPassToken'])){
            $this->user_token = $data['userToken'];
            $this->pass_token = $data['userPassToken'];
        }
        $this->sync_id = $sync_id;
        $this->old_sync_id = $old_sync_id;
    }

    public function index(){
        if (($this->user_token == Config('microweber.userToken')) && ($this->pass_token == Config('microweber.userPassToken'))) {
            $sync_item = DB::table('product_sync_history_v2')->where('sync_id', $this->sync_id)->first();
            if(isset($sync_item) and $sync_item->data_type== 'products'){
                if($sync_item->action == "CREATE") $this->insert_product_process($sync_item);
                else if($sync_item->action == "UPDATE") $this->update_product_process($sync_item);
                else if($sync_item->action == "DELETE") $this->delete_product_process($sync_item);
                else if($sync_item->action == "REPAIR") $this->repair_product_process($sync_item);
                else if($sync_item->action == "RESTART") $this->restart_product_process($sync_item);
            }else if(isset($sync_item) and $sync_item->data_type== 'categories'){
                if($sync_item->action == "CREATE") $this->insert_category_process($sync_item);
                else if($sync_item->action == "UPDATE") $this->update_category_process($sync_item);
                else if($sync_item->action == "DELETE") $this->delete_category_process($sync_item);
                else if($sync_item->action == "REPAIR") $this->repair_category_process($sync_item);
                else if($sync_item->action == "RESTART") $this->restart_category_process($sync_item);
            }
        }
    }



    // Export to DT Insert process
    public function insert_product_process($data, $params = false){

        if(isset($data) and !empty($data) and $data->type == "url"){
            $source = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $total_process = count($source);
            if($params){
                $counts_total = 0;
            }else{
                $counts_total = json_decode($data->count, true);
            }
            $header = [];
            for($i =0; $i< $total_process; $i++){
                if($params){
                    //if this repair request
                    $processing_id = $data->processing_id;
                    $reader = Reader::createFromString(file_get_contents($source[$i]));
                    $reader->setDelimiter('|');
                    $csv_data = $reader->setHeaderOffset(0);

                    $header = $csv_data->getHeader();
                    $records = $csv_data->getRecords();

                    $values = collect($records)->toArray();
                    $chunks = array_chunk($values, 1000);
                } else{
                    //if this create request
                    $insert_data = ['source' => $source[$i],
                                    'sync_id' => $data->sync_id,
                                    'count' => $counts_total[$i],
                                    'success_count' => 0,
                                    'error_count' => 0,
                                    'sync_status' => 'processing',
                                    ];
                    $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);

                    // $dataCsv = file($source[$i]);
                    // $chunks = array_chunk($dataCsv, 1000);
                    ini_set('memory_limit', '-1');

                    // $reader = Reader::createFromString(file_get_contents($source[$i]));

                    // $reader->setDelimiter('|');
                    // $csv_data = $reader->setHeaderOffset(0);

                    // $header = $csv_data->getHeader();
                    // $records = $csv_data->getRecords();
                    // $values = collect($records)->toArray();
                    $nSourch = $source[$i];
                    $chunks = LazyCollection::make(function () use ($nSourch){
                        // project.csv  with 300.000 rows
                        $filePath = $nSourch;
                        $handle = fopen($filePath, 'r');
                        while ($line = fgetcsv($handle,0,'|')) {
                            yield $line;
                        }
                    })
                        ->chunk(1000);
                    // $chunks = array_chunk($values, 1000);

                }
                $count = count($chunks);
                if (isset($chunks) && !empty($chunks)) {
                    foreach ($chunks as $key => $chunk) {
                        $chunk = $chunk->toArray();
                        // $chunk = array_map(function($chunk) { return str_getcsv($chunk,"|");},$chunk);

                        if ($key == 0) {
                            $header = $chunk[0];
                            unset($chunk[0]);
                        }
                        // try{
                            \App\Jobs\SyncProductsCsv::dispatch($chunk, $header, $key, $count, $processing_id, $data->sync_id, $params, url('/'))->onQueue('high');

                        // }catch(Exception $e){
                        //     echo $e;
                        // }
                    }
                }

            }

        } elseif(isset($data) and !empty($data) and $data->type == "json"){
            $source = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $counts_total = json_decode($data->count, true);
            $header = [];
            //if this create request
            $insert_data = ['source' => $data->data,
                            'sync_id' => $data->sync_id,
                            'count' => $counts_total[0],
                            'success_count' => 0,
                            'error_count' => 0,
                            'sync_status' => 'processing',
                            ];
            $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);
            $header = array_keys($source[0]);
            $chunks = array_chunk($source, 1);
            $count = count($chunks);
            if (isset($chunks) && !empty($chunks)) {
                foreach ($chunks as $key => $chunk) {
                    // $chunk = array_map(function($chunk) { return str_getcsv($chunk,"|");},$chunk);

                    // if ($key == 0) {
                    //     $header = $chunk[0];
                    //     unset($chunk[0]);
                    // }
                    // try{
                        \App\Jobs\SyncProductsCsv::dispatch($chunk, $header, $key, $count, $processing_id, $data->sync_id, $params)->onQueue('high');

                    // }catch(Exception $e){
                    //     echo $e;
                    // }
                }
            }
        } elseif(isset($data) and !empty($data) and $data->type == "resolve"){
            $dataToExport = json_decode($data->data, true);
            $chunk = array(array_values($dataToExport));
            $header = array_keys($dataToExport);
            $processing_id = $data->proccessing_id;
            $export = new ExportService($chunk, $header, 0, 1, $processing_id, $data->sync_id,true);
            $export->executeProcess();
        }
    }



    // Export to DT update process
    public function update_product_process($data, $params = false){

        if(isset($data) and !empty($data) and $data->type == "url"){
            $source = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $total_process = count($source);
            if($params){
                $counts_total = 0;
            }else{
                $counts_total = json_decode($data->count, true);
            }
            $header = [];
            for($i =0; $i< $total_process; $i++){
                    //if this create request
                $insert_data = ['source' => $source[$i],
                                'sync_id' => $data->sync_id,
                                'count' => $counts_total[$i],
                                'success_count' => 0,
                                'error_count' => 0,
                                'sync_status' => 'processing',
                                ];
                $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);

                ini_set('memory_limit', '-1');


                $nSourch = $source[$i];
                $chunks = LazyCollection::make(function () use ($nSourch){
                    $filePath = $nSourch;
                    $handle = fopen($filePath, 'r');
                    while ($line = fgetcsv($handle,0,'|')) {
                        yield $line;
                    }
                })
                    ->chunk(1000);

            $count = count($chunks);
            if (isset($chunks) && !empty($chunks)) {
                foreach ($chunks as $key => $chunk) {
                    $chunk = $chunk->toArray();

                    if ($key == 0) {
                        $header = $chunk[0];
                        unset($chunk[0]);
                    }
                        \App\Jobs\UpdateProductsCsv::dispatch($chunk, $header, $key, $count, $processing_id, $data->sync_id, $params, url('/'))->onQueue('high');

                }
            }

            }

        } elseif(isset($data) and !empty($data) and $data->type == "json"){
            $source = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $counts_total = json_decode($data->count, true);
            $header = [];
            //if this create request
            $insert_data = ['source' => $data->data,
                            'sync_id' => $data->sync_id,
                            'count' => $counts_total[0],
                            'success_count' => 0,
                            'error_count' => 0,
                            'sync_status' => 'processing',
                            ];
            $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);
            $header = array_keys($source[0]);
            $chunks = array_chunk($source, 1);
            // dd($header,$chunks);
            $count = count($chunks);
            if (isset($chunks) && !empty($chunks)) {
                foreach ($chunks as $key => $chunk) {

                    $export = new ExportService($chunk, $header, $key, $count, $processing_id, $data->sync_id,false, url('/'));
                    $export->executeUpdateProcess();

                }
            }
        }
    }


    // Export to DT Delete process
    public function delete_product_process($data){
        if(isset($data) and !empty($data) and $data->type == "ids"){
            $ids = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $insert_data = ['source' => $data->data,
                            'sync_id' => $data->sync_id,
                            'count' => json_decode($data->count, true)[0],
                            'success_count' => 0,
                            'error_count' => 0,
                            'sync_status' => 'processing',
                    ];
            $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);
            // $dataCsv = file($source[$i]);
                // $data = Reader::createFromPath('15_test_DRM.csv');
                $chunks = array_chunk($ids, 500);
                // dd($chunks);
                $count = count($chunks);
                $is_channel = $data->delete_from ?? false;
                if (isset($chunks) && !empty($chunks)) {
                    foreach ($chunks as $key => $chunk) {

                        \App\Jobs\DeleteProductCsv::dispatch($chunk, $key, $count, $processing_id, $data->sync_id, $is_channel)->onQueue('high');
                    }

                }



            // cat_reset_logic();
            return json_encode(json_encode(['status' => 200]));
        }
    }



    // Export to DT Repair process
    public function repair_product_process($data){
        dd("hello from repair_product_process");
    }



    // Export to DT Restart process
    public function restart_product_process($data){
        dd("hello from restart_product_process");
    }


    // category function

    // Export to DT Insert process
    public function insert_category_process($data){
        if(isset($data) and !empty($data) and $data->type == "url"){
            $source = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $total_process = count($source);
            $counts_total = json_decode($data->count, true);
            for($i =0; $i< $total_process; $i++){

                $insert_data = ['source' => $source[$i],
                                'sync_id' => $data->sync_id,
                                'count' => $counts_total[$i],
                                'success_count' => 0,
                                'error_count' => 0,
                                'sync_status' => 'processing',
                                ];
                $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);
                $dataCsv = file($source[$i]);
                $chunks = array_chunk($dataCsv, 1000);
                $count = count($chunks);
                // dd($count);
                $header = [];
                if (isset($chunks) && !empty($chunks)) {
                    foreach ($chunks as $key => $chunk) {
                        $chunk = array_map(function ($chunk) {
                            return str_getcsv($chunk, "|");
                        }, $chunk);
                        if ($key == 0) {
                            $header = $chunk[0];
                            unset($chunk[0]);
                        }
                        \App\Jobs\SyncCategorysCsv::dispatch($chunk, $header, $key, $count, $processing_id,$data->sync_id)->onQueue('high');
                    }
                }
            }

            }

    }


    // Export to DT update process
    public function update_category_process($data){
        if (isset($data) and !empty($data) and $data->type == "json") {
            $source = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $counts_total = json_decode($data->count, true);
            //if this create request
            $insert_data = ['source' => $data->data,
                            'sync_id' => $data->sync_id,
                            'count' => $counts_total[0],
                            'success_count' => 0,
                            'error_count' => 0,
                            'sync_status' => 'processing',
                            ];
            $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);
            $chunks = array_chunk($source, 1);
            $logData = [];
            $successCount = $errorCount = 0; 
            if (isset($chunks) && !empty($chunks)) {
                foreach ($chunks as $key => $chunk) {
                    $parentCategoryId = 0;
                    $hasCategory = DB::table('categories')->where('drm_ref_id', $chunk[$key]['id'])->first();
                    if($hasCategory){
                        if(isset($chunk[$key]['parent']) and $chunk[$key]['parent']!= null and $chunk[$key]['parent']!= 0){
                            $parentCategoryId = DB::table('categories')->where('drm_ref_id', $chunk[$key]['parent'])->pluck('id')->toArray();
                            $parentCategoryId = $parentCategoryId[0] ?? 0;
                        }
                        DB::table('categories')->where('drm_ref_id', $chunk[$key]['id'])->update([
                            'title' => $chunk[$key]['category_name'],
                            'parent_id' => $parentCategoryId
                        ]);
                        $successCount++;
                        $logData[] = [
                            'processing_id' => $processing_id,
                            'msg' => json_encode($chunk),
                            'drm_ref_id' => $chunk[$key]['id'],
                            'is_success' => 1
                        ];
                    } else{
                        $errorCount++;
                        $logData[] = [
                            'processing_id' => $processing_id,
                            'msg' => "This category isn't found in DT shop",
                            'drm_ref_id' => $chunk[$key]['id']
                        ];
                    }
                }
                if (isset($logData) && !empty($logData)) {
                    DB::table('sync_processing_data_status_v2')->insert($logData);
                }
                if($counts_total[0] == ($successCount + $errorCount)){
                    DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => "success"]); 
                    DB::table('sync_processing_history_v2')->where('sync_id', $data->sync_id)->update(['sync_status' => "success", 'success_count' => $successCount, 'error_count' => $errorCount]);
                } else{
                    DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => "failed"]); 
                    DB::table('sync_processing_history_v2')->where('sync_id', $data->sync_id)->update(['sync_status' => "failed", 'success_count' => $successCount, 'error_count' => $errorCount]);
                }
            }
            clearcache();
        }
    }

    // Export to DT delete process
    public function delete_category_process($data){
        if (isset($data) and !empty($data) and $data->type == "ids") {
            $ids = json_decode($data->data, true);
            DB::table('product_sync_history_v2')->where('sync_id', $data->sync_id)->update(['status' => 'processing']);
            $insert_data = [
                'source' => $data->data,
                'sync_id' => $data->sync_id,
                'count' => json_decode($data->count, true)[0],
                'success_count' => 0,
                'error_count' => 0,
                'sync_status' => 'processing',
            ];
            $processing_id = DB::table('sync_processing_history_v2')->insertGetId($insert_data);
            $chunks = array_chunk($ids, 1000);
            $count =count($chunks);
            if (isset($chunks) && !empty($chunks)) {
                foreach ($chunks as $key => $chunk) {

                    // dd($chunk,$key,$count,$processing_id, $data->sync_id);
                    \App\Jobs\DeleteCategorysCsv::dispatch($chunk,$key,$count,$processing_id, $data->sync_id)->onQueue('high');
                }
            }
        }
    }

    // Export to DT Repair process
    public function repair_category_process($data){
        dd("hello from repair_product_process");
    }



    // Export to DT Restart process
    public function restart_category_process($data){
        dd("hello from restart_product_process");
    }



}
