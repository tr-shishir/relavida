<?php

namespace MicroweberPackages\Install;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\DB;
use MicroweberPackages\Database\Utils as DbUtils;
use Illuminate\Support\Facades\Schema as DbSchema;
use Illuminate\Database\QueryException;
use Cache;

class DbInstaller
{
    public $logger = null;

    public function run()
    {
        Cache::flush();
        try {
            $this->createSchema();

        } catch (\Illuminate\Database\QueryException $e) {
            $this->log('Error in database schema: ' . $e->getMessage());
        }

        $this->alter_table();
        $this->seed();
        Cache::flush();
//        $this->log('Installing modules');
//
//        mw()->module_manager->install();
    }

    private function getMigrationClassNameByFilename($filename)
    {
        $className = '';
        $words = explode('_',  $filename);
        foreach ($words as $word) {
            $word = str_replace('.php', false, $word);
            if (is_numeric($word)) {
                continue;
            }
            if (is_string($word)) {
                $className .= ucfirst($word);
            }
        }
        if (empty($className)) {
            return false;
        }

        return $className;
    }

    public function getVendorSchemas()
    {
        $repos = [];
        foreach (app()->migrator->paths() as $migrationPath) {
            if (is_dir($migrationPath)) {
                if ($dhMigration = opendir($migrationPath)) {
                    while (($migrationFile = readdir($dhMigration)) !== false) {
                        if (strpos( $migrationFile,'.php') !== false) {
                            $migrationClassName = $this->getMigrationClassNameByFilename($migrationFile);
                            if ($migrationClassName) {
                                $migrationFilePath = normalize_path($migrationPath  . DIRECTORY_SEPARATOR . $migrationFile, false);
                              //  $migrationContent = file_get_contents($migrationFilePath);
                                include_once $migrationFilePath;
                                if (!class_exists($migrationClassName)) {
                                    continue;
                                }
                                $instanceMigration = new $migrationClassName;
                                if (method_exists($instanceMigration,'getSchema')) {
                                    $migrationSchema = $instanceMigration->getSchema();
                                    if (!empty($migrationSchema)) {
                                        $repos[] = $instanceMigration;
                                    }
                                }
                                if (method_exists($instanceMigration,'up')) {
                                    $repos[] = $instanceMigration;
                                }
                                if (method_exists($instanceMigration,'get')) {
                                    $repos[] = $instanceMigration;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $repos;
    }

    public function getSystemSchemas()
    {
        $system =  [
            new Schema\Base(),
            new Schema\Comments(),
            new Schema\Tags(),
            new Schema\JobsQueue(),
            new Schema\PasswordResetsTable(),
            new Schema\Updates(),
        	new Schema\MailSubscribe(),
        	new Schema\MailTemplates(),
            new Schema\Droptienda(),
        ];

      //  $all = array_merge($system, $this->getVendorSchemas());

        return $system;
    }

    public function createSchema()
    {
        if (!DbSchema::hasTable('sessions')) {
            try {
                DbSchema::create('sessions', function ($table) {
                    $table->string('id')->unique();
                    $table->longText('payload');
                    $table->integer('last_activity');
                });
            } catch (QueryException $e) {

            }
        }

        if (DbSchema::hasTable('migrations')) {
            if (DbSchema::hasColumn('migrations', 'hash')) {
                DbSchema::table('migrations', function ($table) {
                    $table->dropColumn('hash');
                });
            }
        }

        if (!DbSchema::hasTable('migrations')) {
            try {
                DbSchema::create('migrations', function ($table) {
                    $table->increments('id');
                    $table->string('migration');
                    $table->integer('batch');
                });
            } catch (QueryException $e) {

            }
        }

        $exec = $this->getSystemSchemas();
        $builder = new DbUtils();
        $schemaArray = array();

        $migrator = app()->mw_migrator->run(app()->migrator->paths());

        foreach ($exec as $data) {
            if (method_exists($data, 'get')) {
                $schemaArray = $data->get();
                if (is_array($schemaArray)) {
                    foreach ($schemaArray as $table => $columns) {
                        $this->log('Setting up table "' . $table . '"');
                        $builder->build_table($table, $columns);
                    }
                }
            }
        }

    }

    public function seed()
    {
        $exec = $this->getSystemSchemas();
        foreach ($exec as $data) {

            if (method_exists($data, 'seed')) {
                $this->log('Seeding ' . get_class($data));

                $data->seed();
            }
        }
    }

    public function log($text)
    {
        if (is_object($this->logger) and method_exists($this->logger, 'log')) {
            $this->logger->log($text);
        }
    }

    public function alter_table(){

        if(!DbSchema::hasTable('product_sync_history_v2')){
            DbSchema::create('product_sync_history_v2', function ($table) {
                $table->id();
                $table->longText('data');
                $table->enum('type', ['url', 'ids', 'json']);
                $table->string('count');
                $table->enum('action', ['CREATE', 'UPDATE', 'DELETE', 'RESTART', 'REPAIR']);
                $table->string('sync_id');
                $table->enum('status', ['pending', 'processing', 'failed', 'delete', 'success']);
                $table->string('drm_status');
                $table->string('old_sync_id');
                $table->enum('data_type', ['products', 'categories']);
                $table->timestamps();
            });
        }

        if(!DbSchema::hasTable('sync_processing_history_v2')){
            DbSchema::create('sync_processing_history_v2', function ($table) {
                $table->id();
                $table->longText('source');
                $table->string('sync_id');
                $table->bigInteger('count');
                $table->bigInteger('success_count');
                $table->bigInteger('error_count');
                $table->enum('sync_status',['processing', 'success', 'failed']);
                $table->string('delete_from');
                $table->timestamps();
            });
        }

        if(!DbSchema::hasTable('sync_processing_data_status_v2')){
            DbSchema::create('sync_processing_data_status_v2', function ($table) {
                $table->id();
                $table->bigInteger('processing_id')->nullable();
                $table->bigInteger('content_id')->nullable();
                $table->bigInteger('drm_ref_id')->nullable();
                $table->text('msg')->nullable();
                $table->boolean('is_success')->default(0);
                $table->timestamps();
            });
        }
    }


}
