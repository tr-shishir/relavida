<?php

/*
 * This file is part of Microweber
 *
 * (c) Droptienda CMS LTD
 *
 * For full license information see
 * https://github.com/microweber/microweber/blob/master/LICENSE
 *
 */

namespace MicroweberPackages\Option;

use DB;
use Cache;
use MicroweberPackages\Option\Models\Option;

class OptionManager
{
    public $app;
    public $options_memory = array(); //internal array to hold options in cache
    public $override_memory = array(); //array to hold options values that are not persistent in DB and changed on runtime
    public $tables = array();
    public $table_prefix = false;
    public $adapters_dir = false;

    public function __construct($app = null)
    {
        if (!is_object($this->app)) {
            if (is_object($app)) {
                $this->app = $app;
            } else {
                $this->app = mw();
            }
        }
        $this->set_table_names();
    }

    public function set_table_names($tables = false)
    {
        if (!is_array($tables)) {
            $tables = array();
        }
        if (!isset($tables['content'])) {
            $tables['options'] = 'options';
        }
        $this->tables = $tables;
        if (!defined('MW_DB_TABLE_OPTIONS')) {
            define('MW_DB_TABLE_OPTIONS', $tables['options']);
        }
    }

    public function get_all($params = '')
    {
        if (is_string($params)) {
            $params = parse_str($params, $params2);
            $params = $params2;
        }

        $data = $params;
        $table = $this->tables['options'];
        //  $data['debug'] = 1000;
        if (!isset($data['limit'])) {
            $data['limit'] = 1000;
        }
     //   $data['cache_group'] = 'options/global';
        $data['table'] = $table;

        // dd($data);
        $get = collect($GLOBALS['all_options'])->filter(function($item,$key) use($data){
            if(isset($data['option_group']) && str_starts_with($key,$data['option_group'])){
                return $item;
            }
        })->toArray();
        // $get = $this->app->database_manager->get($data);

        if (!empty($get)) {
            foreach ($get as $key => $value) {
                if (isset($get[$key]['field_values']) and $get[$key]['field_values'] != false) {
                    $get[$key]['field_values'] = unserialize(base64_decode($get[$key]['field_values']));
                }
                if (isset($get[$key]['option_value']) and strval($get[$key]['option_value']) != '') {
                    $get[$key]['option_value'] = $this->app->url_manager->replace_site_url_back($get[$key]['option_value']);
                }
            }
        }

        return $get;
    }

    public function get_groups($is_system = false)
    {
        $table = $this->tables['options'];
        $query = $this->app->database_manager->table($table);
        $query = $query->select('option_group');

        $query = $query->whereNull('module');
        $query = $query->whereNotNull('option_group');
        $query = $query->groupBy('option_group');
        if ($is_system != false) {
            $query = $query->where('is_system', '=', 1);
        } else {
            $query = $query->where('is_system', '=', 0);
            $query = $query->orWhere('is_system', '=', null);
        }

        $res = $query->get();

        if ($res and !empty($res)) {
            $res1 = array();
            foreach ($res as $item) {
                $item = (array)$item;
                $res1[] = $item['option_group'];
            }
        }

        return $res1;
    }

    public function delete($key, $option_group = false, $module_id = false)
    {

        $key = $this->app->database_manager->escape_string($key);
        $table = $this->tables['options'];
        $query = $this->app->database_manager->table($table);
        $query = $query->where('option_key', '=', $key);

        if ($option_group != false) {
            $query = $query->where('option_group', '=', $option_group);
        }

        if ($module_id != false) {
            $query = $query->where('module', '=', $module_id);
        }

        $query = $query->delete();
        $this->override($option_group,$key,false);
        $this->app->cache_manager->delete('options');
        return true;
    }


    public function set_default($data)
    {
        $changes = false;

        if (is_array($data)) {
            if (!isset($data['option_group'])) {
                $data['option_group'] = 'other';
            }
            if (isset($data['option_key'])) {
                $check = $this->get($data['option_key'], $option_group = $data['option_group'], $return_full = false, $orderby = false);
                if ($check == false) {
                    $changes = $this->save($data);
                }
            }
        } else {
            return false;
        }

        return $changes;
    }


    private $is_use = true;
    public function setUseCache($is_use = false){
        $this->is_use = $is_use;
    }

    /**
     * Getting options from the database.
     *
     * @param $key array|string - if array it will replace the db params
     * @param $option_group string - your option group
     * @param $return_full bool - if true it will return the whole db row as array rather then just the value
     * @param $module string - if set it will store option for module
     * Example usage:
     * $this->get('my_key', 'my_group');
     */
    public function get($key, $option_group = false, $return_full = false, $orderby = false, $module = false)
    {
        if ($option_group != false) {
            $cache_group = 'options/' . $option_group;
        } else {
            $cache_group = 'options/global';
        }
        if ($this->options_memory == null) {
            $this->options_memory = array();
        }

        if ($this->is_use and isset($this->override_memory[$option_group]) and isset($this->override_memory[$option_group][$key])) {
            return $this->override_memory[$option_group][$key];
        }

        if(!$key){
            return;
        }

        $function_cache_id = false;

        $args = func_get_args();

        foreach ($args as $k => $v) {
            $function_cache_id = $function_cache_id . serialize($k) . serialize($v);
        }

        $function_cache_id = 'option_' . __FUNCTION__ . '_' . $option_group . '_' . crc32($function_cache_id);
        if ($this->is_use and isset($this->options_memory[$function_cache_id])) {
            return $this->options_memory[$function_cache_id];
        }

        $table = $this->tables['options'];

        $data = array();

        if (is_array($key)) {
            $data = $key;
        } else {
            $data['option_key'] = $key;
        }
        $option_key_1 = '';
        $option_key_2 = '';
        if ($option_group != false) {
            $option_group = $this->app->database_manager->escape_string($option_group);
            $data['option_group'] = $option_group;
        }

        if ($module != false) {
            $module = $this->app->database_manager->escape_string($module);
            $data['module'] = $module;
        }




       // $ok = $this->app->database_manager->escape_string($data['option_key']);

        // set limit
        if (!isset($data['limit'])) {
            $data['limit'] = 1;
        }



        $filter = array();

        if(!$this->is_use){
         $filter['no_cache'] = 1;
        }
     //   $filter['limit'] = 1;
        $filter['option_key'] = $key;
        if ($option_group != false) {
            $filter['option_group'] = $option_group;
        }

        if ($module != false) {
            $filter['module'] = $module;
        }
        $filter['table'] = $table;
        if (isset($data['limit'])) {
            $filter['limit'] = $data['limit'];
        }




        // if($option_group){
        //     $get_all = Option::where('option_group',$option_group)->get()->toArray();

        //    } else {
            if(isset($GLOBALS['all_options'])){
                if(isset($GLOBALS['all_options'][$filter['option_group'].'--'.$filter['option_key']])){
                    $optionData[] = (array)$GLOBALS['all_options'][$filter['option_group'].'--'.$filter['option_key']];
                }else{
                    $optionData = false;
                }
                $get_all = $optionData;
            }else{
                $get_all = mw()->database_manager->get($filter);
            }
        // }
            // dd($GLOBALS);

//        $get_all = cache()->remember($table.'full_cache_table'.$option_group, 1000000, function () use ($option_group) {
//            if($option_group){
//                return Option::where('option_group',$option_group)->get()->toArray();
//            } else {
//                return Option::get()->toArray();
//            }
//
//
//        }) ;
   //     $get_all = mw()->database_manager->get($filter);
        if (!is_array($get_all)) {
            return false;
        }

        $get = array();
        foreach ($get_all as $get_opt) {
            if ($key == $get_opt['option_key']) { //  && $get_opt['option_group'] == $option_group && $get_opt['module'] == $module
/*
                $override = $this->app->event_manager->trigger('option.after.get', $get_opt);
                if (is_array($override) && isset($override[0])) {
                    $get_opt = $override[0];
                }*/

                if ($option_group != false) {
                    if ($option_group == $get_opt['option_group']) {
                        $get[] = $get_opt;
                    }
                } else {
                    $get[] = $get_opt;

                }
            }
        }

        if (!empty($get)) {
            if ($return_full == false) {
                if (!is_array($get)) {
                    return false;
                }

                $get = $get[0]['option_value'];
                if (isset($get['option_value']) and strval($get['option_value']) != '') {
                    $get['option_value'] = $this->app->url_manager->replace_site_url_back($get['option_value']);
                }

                $this->options_memory[$function_cache_id] = $get;

                return $get;
            } else {
                $get = $get[0];

                if (isset($get['option_value']) and strval($get['option_value']) != '') {
                    $get['option_value'] = $this->app->url_manager->replace_site_url_back($get['option_value']);
                }

                if (isset($get['field_values']) and $get['field_values'] != false) {
                    $get['field_values'] = unserialize(base64_decode($get['field_values']));
                }
                $this->options_memory[$function_cache_id] = $get;

                return $get;
            }
        } else {
            $this->options_memory[$function_cache_id] = false;

            return false;
        }
    }

    /**
     * You can use this function to store options in the database.
     *
     * @param $data array|string
     * Example usage:
     *
     * $option = array();
     * $option['option_value'] = 'my value';
     * $option['option_key'] = 'my_option';
     * $option['option_group'] = 'my_option_group';
     * mw()->option_manager->save($option);
     */
    public function save($data)
    {
        if (defined('MW_API_CALL')) {
            $is_admin = $this->app->user_manager->is_admin();
            if ($is_admin == false) {
                return false;
            }
        }

        if (is_string($data)) {
            $data = parse_params($data);
        }

        $this->clear_memory();

        $option_group = false;
        if (is_array($data)) {
            if (strval($data['option_key']) != '') {
                if (strstr($data['option_key'], '|for_module|')) {
                    $option_key_1 = explode('|for_module|', $data['option_key']);
                    if (isset($option_key_1[0])) {
                        $data['option_key'] = $option_key_1[0];
                    }
                    if (isset($option_key_1[1])) {
                        $data['module'] = $option_key_1[1];
                        if (isset($data['id']) and intval($data['id']) > 0) {
                            $chck = $this->get('limit=1&module=' . $data['module'] . '&option_key=' . $data['option_key']);
                            if (isset($chck[0]) and isset($chck[0]['id'])) {
                                $data['id'] = $chck[0]['id'];
                            } else {
                                $table = $this->tables['options'];
                                $copy = $this->app->database_manager->copy_row_by_id($table, $data['id']);
                                $data['id'] = $copy;
                            }
                        }
                    }
                }
            }

            $delete_content_cache = false;
            if (!isset($data['id']) or intval($data['id']) == 0) {
                if (isset($data['option_key']) and isset($data['option_group']) and trim($data['option_group']) != '') {
                    $option_group = $data['option_group'];

                    $existing = $this->get($data['option_key'], $data['option_group'], $return_full = true);

                    if ($existing == false) {
                        //
                    } elseif (isset($existing['id'])) {
                        $data['id'] = $existing['id'];
                    }
                }
            }

            $table = $this->tables['options'];
            if (isset($data['field_values']) and $data['field_values'] != false) {
                $data['field_values'] = base64_encode(serialize($data['field_values']));
            }
            if (isset($data['module'])) {
                $data['module'] = str_ireplace('/admin', '', $data['module']);
            }

            if (strval($data['option_key']) != '') {
                if ($data['option_key'] == 'current_template') {
                    $delete_content_cache = true;
                }
                if (isset($data['option_group']) and strval($data['option_group']) == '') {
                    unset($data['option_group']);
                }

                if (isset($data['option_value']) and $data['option_value'] != false) {
                    $data['option_value'] = $this->app->url_manager->replace_site_url($data['option_value']);
                }

                $data['allow_html'] = true;
                $data['allow_scripts'] = true;
                $data['table'] = $this->tables['options'];

                // $this->app->event_manager->trigger('option.before.save', $data);
                $save = $this->app->database_manager->save($data);

                if ($option_group != false) {
                    $cache_group = 'options/' . $option_group;
                    $this->app->cache_manager->delete($cache_group);
                } else {
                    $cache_group = 'options/' . 'global';
                    $this->app->cache_manager->delete($cache_group);
                }
                if ($save != false) {
                    $cache_group = 'options/' . $save;
                    $this->app->cache_manager->delete($cache_group);
                }

                if ($delete_content_cache != false) {
                    $cache_group = 'content/global';
                    $this->app->cache_manager->delete($cache_group);
                }

                if (isset($data['id']) and intval($data['id']) > 0) {
                    $opt = $this->get_by_id($data['id']);
                    if (isset($opt['option_group'])) {
                        $cache_group = 'options/' . $opt['option_group'];
                        $this->app->cache_manager->delete($cache_group);
                    }
                    $cache_group = 'options/' . intval($data['id']);
                    $this->app->cache_manager->delete($cache_group);
                }

                $this->app->cache_manager->delete('options');

                return $save;
            }
        }
    }

    public function get_by_id($id)
    {
        $id = intval($id);
        if ($id == 0) {
            return false;
        }

        $params = array();
        $params['id'] = $id;
        $params['single'] = true;

        return $this->get_all($params);
    }

    public function get_items_per_page($group = 'website')
    {
        if (!isset($this->options_memory['items_per_page'])) {
            $this->options_memory = array();
        }
        if (isset($this->options_memory['items_per_page'][$group])) {
            return $this->options_memory['items_per_page'][$group];
        }

        if (mw_is_installed() == true) {
            $table = $this->tables['options'];
            $ttl = now()->addYear(1);

            $cache_key = $table . '_items_per_page_' . $group;
            $items_per_page = Cache::tags($table)->remember($cache_key, $ttl, function () use ($table, $group) {
                $items_per_page = DB::table($table)->where('option_key', 'items_per_page')
                    ->where('option_group', $group)
                    ->first();

                return $items_per_page;
            });

            if (!empty($items_per_page)) {
                $items_per_page = (array)$items_per_page;
                if (isset($items_per_page['option_value'])) {
                    $result = $items_per_page['option_value'];
                    $this->options_memory['items_per_page'][$group] = $result;

                    return $result;
                }
            }
        }
    }


    public function override($option_group, $key, $value)
    {
        if (!isset($this->override_memory[$option_group])) {
            $this->override_memory[$option_group] = array();
        }
        $this->override_memory[$option_group][$key] = $value;
    }

    public function clear_memory()
    {
        $this->options_memory = array();
        $this->override_memory = array();
    }
}
