<?php

use App\Models\Content;

/**
 * Constructor function.
 *
 * @param null $class
 *
 * @return mixed|\MicroweberPackages\Application
 */
function mw($class = null)
{
    return app($class);
}


if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return mixed|\MicroweberPackages\Application
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }

        return empty($parameters)
            ? Container::getInstance()->make($abstract)
            : Container::getInstance()->makeWith($abstract, $parameters);
    }
}

function mw_is_installed()
{
    return Config::get('microweber.is_installed');
}

if (!function_exists('d')) {
    function d($dump)
    {
        var_dump($dump);
    }
}

if (!function_exists('site_url')) {
    function site_url($add_string = false)
    {
        static $site_url;

        if (defined('MW_SITE_URL')) {
            $site_url = MW_SITE_URL;
        }


        if ($site_url == false) {
            $pageURL = 'http';
            if (is_https()) {
                $pageURL .= 's';
            }
            $subdir_append = false;
            if (isset($_SERVER['PATH_INFO'])) {
                // $subdir_append = $_SERVER ['PATH_INFO'];
            } elseif (isset($_SERVER['REDIRECT_URL'])) {
                $subdir_append = $_SERVER['REDIRECT_URL'];
            }

            $pageURL .= '://';

            if (isset($_SERVER['HTTP_HOST'])) {
                $pageURL .= $_SERVER['HTTP_HOST'];
            } elseif (isset($_SERVER['SERVER_NAME']) and isset($_SERVER['SERVER_PORT']) and $_SERVER['SERVER_PORT'] != '80' and $_SERVER['SERVER_PORT'] != '443') {
                $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
            } elseif (isset($_SERVER['SERVER_NAME'])) {
                $pageURL .= $_SERVER['SERVER_NAME'];
            } elseif (isset($_SERVER['HOSTNAME'])) {
                $pageURL .= $_SERVER['HOSTNAME'];
            }
            $pageURL_host = $pageURL;
            $pageURL .= $subdir_append;
            $d = '';
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $d = dirname($_SERVER['SCRIPT_NAME']);
                $d = trim($d, DIRECTORY_SEPARATOR);
            }

            if ($d == '') {
                $pageURL = $pageURL_host;
            } else {
                $pageURL_host = rtrim($pageURL_host, '/') . '/';
                $d = ltrim($d, '/');
                $d = ltrim($d, DIRECTORY_SEPARATOR);
                $pageURL = $pageURL_host . $d;
            }
            if (isset($_SERVER['QUERY_STRING'])) {
                //    $pageURL = str_replace($_SERVER['QUERY_STRING'], '', $pageURL);
            }

            $uz = parse_url($pageURL);
//            if (isset($uz['query'])) {
//                $pageURL = str_replace($uz['query'], '', $pageURL);
//                $pageURL = rtrim($pageURL, '?');
//            }

            $url_segs = explode('/', $pageURL);

            $i = 0;
            $unset = false;
            foreach ($url_segs as $v) {
                if ($unset == true and $d != '') {
                    unset($url_segs[$i]);
                }
                if ($v == $d and $d != '') {
                    $unset = true;
                }

                ++$i;
            }
            $url_segs[] = '';
            $site_url = implode('/', $url_segs);
        }
        if (defined('MW_SITE_URL_PATH_PREFIX')) {
            $site_url .= MW_SITE_URL_PATH_PREFIX;
        }

        if(!$site_url){
            $site_url = 'http://localhost/';
        }

        return $site_url . $add_string;
    }
}

/**
 * Converts a path in the appropriate format for win or linux.
 *
 * @param string $path
 *                         The directory path.
 * @param bool $slash_it
 *                         If true, ads a slash at the end, false by default
 *
 * @return string The formatted string
 */
if (!function_exists('normalize_path')) {
    function normalize_path($path, $slash_it = true)
    {
        $path_original = $path;
        $s = DIRECTORY_SEPARATOR;
        $path = preg_replace('/[\/\\\]/', $s, $path);
        $path = str_replace($s . $s, $s, $path);
        if (strval($path) == '') {
            $path = $path_original;
        }
        if ($slash_it == false) {
            $path = rtrim($path, DIRECTORY_SEPARATOR);
        } else {
            $path .= DIRECTORY_SEPARATOR;
            $path = rtrim($path, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR);
        }
        if (strval(trim($path)) == '' or strval(trim($path)) == '/') {
            $path = $path_original;
        }
        if ($slash_it == false) {
        } else {
            $path = $path . DIRECTORY_SEPARATOR;
            $path = reduce_double_slashes($path);
        }

        return $path;
    }
}

if (!function_exists('reduce_double_slashes')) {
    /**
     * Removes double slashes from sting.
     *
     * @param $str
     *
     * @return string
     */
    function reduce_double_slashes($str)
    {
        return preg_replace('#([^:])//+#', '\\1/', $str);
    }
}

if (!function_exists('lipsum')) {
    function lipsum($number_of_characters = false)
    {
        if ($number_of_characters == false) {
            $number_of_characters = 100;
        }

        $lipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis justo et sapien varius gravida. Fusce porttitor consectetur risus ut tincidunt. Maecenas pellentesque nulla sodales enim consectetur commodo. Aliquam non dui leo, adipiscing posuere metus. Duis adipiscing auctor lorem ut pulvinar. Donec non magna massa, feugiat commodo felis. Donec ut nibh elit. Nulla pellentesque nulla diam, vitae consectetur neque.
        Etiam sed lorem augue. Vivamus varius tristique bibendum. Phasellus vitae tempor augue. Maecenas consequat commodo euismod. Aenean a lorem nec leo dignissim ultricies sed quis nisi. Fusce pellentesque tellus lectus, eu varius felis. Mauris lacinia facilisis metus, sed sollicitudin quam faucibus id.
        Donec ultrices cursus erat, non pulvinar lectus consectetur eu. Proin sodales risus a ante aliquet vel cursus justo viverra. Duis vel leo felis. Praesent hendrerit, sem vitae scelerisque blandit, enim neque pulvinar mi, vel lobortis elit dui vel dui. Donec ac sem sed neque consequat egestas. Curabitur pellentesque consequat ante, quis laoreet enim gravida eu. Donec varius, nisi non bibendum pellentesque, felis metus pretium ipsum, non vulputate eros magna ac sapien. Donec tincidunt porta tortor, et ornare enim facilisis vitae. Nulla facilisi. Cras ut nisi ac dolor lacinia tempus at sed eros. Integer vehicula arcu in augue adipiscing accumsan. Morbi placerat consectetur sapien sed gravida. Sed fringilla elit nisl, nec molestie felis. Nulla aliquet diam vitae diam iaculis porttitor.
        Integer eget tortor nulla, non dapibus erat. Sed ultrices consectetur quam at scelerisque. Nullam varius hendrerit nisl, ac cursus mi bibendum eu. Phasellus varius fermentum massa, sit amet ornare quam malesuada in. Quisque ac massa sem. Nulla eu erat metus, non tincidunt nibh. Nam consequat interdum nulla, at congue libero tincidunt eget. Sed cursus nulla eu felis faucibus porta. Nam sed lacus eros, nec pellentesque lorem. Sed dapibus, sapien mattis sollicitudin bibendum, libero augue dignissim felis, eget elementum felis nulla in velit. Donec varius, lectus non suscipit sollicitudin, urna est hendrerit nulla, vel vehicula arcu sem volutpat sapien. Ut nisi ipsum, accumsan vestibulum pulvinar eu, sodales id lacus. Nulla iaculis eros sit amet lectus tincidunt mattis. Ut eu nisl sit amet eros vestibulum imperdiet ut vel lorem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
        In hac habitasse platea dictumst. Aenean vehicula auctor eros non tincidunt. Donec tempor arcu ac diam sagittis mattis. Aenean eget augue nulla, non volutpat lorem. Praesent ut cursus magna. Mauris consequat suscipit nisi. Integer eu venenatis ligula. Maecenas leo risus, lacinia et auctor aliquet, aliquet in mi.
        Aliquam tincidunt dapibus augue, et vulputate dui aliquet et. Praesent pharetra mauris eu justo dignissim venenatis ornare nec nisl. Aliquam justo quam, varius eget congue vel, congue eget est. Ut nulla felis, luctus imperdiet molestie et, commodo vel nulla. Morbi at nulla dapibus enim bibendum aliquam non et ipsum. Phasellus sed cursus justo. Praesent sit amet metus lorem. Vivamus ut lorem dapibus turpis rhoncus pharetra. Donec in lacus sagittis nisl tempor sagittis quis a orci. Nam volutpat condimentum ante ac facilisis. Cras sem magna, vulputate id consequat rhoncus, suscipit non justo. In fringilla dignissim cursus.
        Nunc fringilla orci tellus, et euismod lorem. Ut quis turpis lacus, ac elementum lorem. Praesent fringilla, metus nec tincidunt consequat, sem sapien hendrerit nisi, nec feugiat libero risus a nisl. Duis arcu magna, ullamcorper et semper vitae, tincidunt nec libero. Etiam sed lacus ante. In imperdiet arcu eget elit commodo ut malesuada sem congue. Quisque porttitor porta sagittis. Nam porta elit sit amet mauris fermentum eu feugiat ipsum pretium. Maecenas sollicitudin aliquam eros, ut pretium nunc faucibus quis. Mauris id metus vitae libero viverra adipiscing quis ut nulla. Pellentesque posuere facilisis nibh, facilisis vehicula felis facilisis nec.
        Etiam pharetra libero nec erat pellentesque laoreet. Sed eu libero nec nisl vehicula convallis nec non orci. Aenean tristique varius nisl. Cras vel urna eget enim placerat vehicula quis sed velit. Quisque lacinia sagittis lectus eget sagittis. Pellentesque cursus suscipit massa vel ultricies. Quisque hendrerit lobortis elit interdum feugiat. Sed posuere volutpat erat vel lobortis. Vivamus laoreet mattis varius. Fusce tincidunt accumsan lorem, in viverra lectus dictum eu. Integer venenatis tristique dolor, ac porta lacus pellentesque pharetra. Suspendisse potenti. Ut dolor dolor, sollicitudin in auctor nec, facilisis non justo. Mauris cursus euismod gravida. In at orci in sapien laoreet euismod.
        Mauris purus urna, vulputate in malesuada ac, varius eget ante. Integer ultricies lacus vel magna dictum sit amet euismod enim dictum. Aliquam iaculis, ipsum at tempor bibendum, dolor tortor eleifend elit, sed fermentum magna nibh a ligula. Phasellus ipsum nisi, porta quis pellentesque sit amet, dignissim vel felis. Quisque condimentum molestie ligula, ac auctor turpis facilisis ac. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent molestie leo velit. Sed sit amet turpis massa. Donec in tortor quis metus cursus iaculis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In hac habitasse platea dictumst. Proin leo nisl, faucibus non sollicitudin et, commodo id diam. Aliquam adipiscing, lorem a fringilla blandit, felis dui tristique ligula, vitae eleifend orci diam eget quam. Aliquam vulputate gravida leo eget eleifend. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
        Etiam et consectetur justo. Integer et ante dui, quis rutrum massa. Fusce nibh nisl, congue sit amet tempor vitae, ornare et nisi. Nulla mattis nisl ut ligula sagittis aliquam. Curabitur ac augue at velit facilisis venenatis quis sit amet erat. Donec lacus elit, auctor sed lobortis aliquet, accumsan nec mi. Quisque non est ante. Morbi vehicula pulvinar magna, quis luctus tortor varius et. Donec hendrerit nulla posuere odio lobortis interdum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dapibus magna id ante sodales tempus. Maecenas at eleifend nulla.
        Sed eget gravida magna. Quisque vulputate diam nec libero faucibus vitae fringilla ligula lobortis. Aenean congue, dolor ut dapibus fermentum, justo lectus luctus sem, et vestibulum lectus orci non mauris. Vivamus interdum mauris at diam scelerisque porta mollis massa hendrerit. Donec condimentum lacinia bibendum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam neque dolor, faucibus sed varius sit amet, vulputate vitae nunc.
        Etiam in lorem congue nunc sollicitudin rhoncus vel in metus. Integer luctus semper sem ut interdum. Sed mattis euismod diam, at porta mauris laoreet quis. Nam pellentesque enim id mi vestibulum gravida in vel libero. Nulla facilisi. Morbi fringilla mollis malesuada. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum sagittis consectetur auctor. Phasellus convallis turpis eget diam tristique feugiat. In consectetur quam faucibus purus suscipit euismod quis sed quam. Curabitur eget sodales dui. Quisque egestas diam quis sapien aliquet tincidunt.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam velit est, imperdiet ac posuere non, dictum et nunc. Duis iaculis lacus in libero lacinia ut consectetur nisi facilisis. Fusce aliquet nisl id eros dapibus viverra. Phasellus eget ultrices nisl. Nullam euismod tortor a metus hendrerit convallis. Donec dolor magna, fringilla in sollicitudin sit amet, tristique eget elit. Praesent adipiscing magna in ipsum vulputate non lacinia metus vestibulum. Aenean dictum suscipit mollis. Nullam tristique commodo dapibus. Fusce in tellus sapien, at vulputate justo. Nam ornare, lorem sit amet condimentum ultrices, ipsum velit tempor urna, tincidunt convallis sapien enim eget leo. Proin ligula tellus, ornare vitae scelerisque vitae, fringilla fermentum sem. Phasellus ornare, diam sed luctus condimentum, nisl felis ultricies tortor, ac tempor quam lacus sit amet lorem. Nunc egestas, nibh ornare dictum iaculis, diam nisl fermentum magna, malesuada vestibulum est mauris quis nisl. Ut vulputate pharetra laoreet.
        Donec mattis mauris et dolor commodo et pellentesque libero congue. Sed tristique bibendum augue sed auctor. Sed in ante enim. In sed lectus massa. Nulla imperdiet nisi at libero faucibus sagittis ac ac lacus. In dui purus, sollicitudin tempor euismod euismod, dapibus vehicula elit. Aliquam vulputate, ligula non dignissim gravida, odio elit ornare risus, a euismod est odio nec ipsum. In hac habitasse platea dictumst. Mauris posuere ultrices mattis. Etiam vitae leo vitae nunc porta egestas at vitae nibh. Sed pharetra, magna nec bibendum aliquam, dolor sapien consequat neque, sit amet euismod orci elit vitae enim. Sed erat metus, laoreet quis posuere id, congue id velit. Mauris ac velit vel ipsum dictum ornare eget vitae arcu. Donec interdum, neque at lacinia imperdiet, ante libero convallis quam, pellentesque faucibus quam dolor id est. Ut cursus facilisis scelerisque. Sed vitae ligula in purus malesuada porta.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vestibulum vestibulum metus. Integer ultrices ultricies pellentesque. Nulla gravida nisl a magna gravida ullamcorper. Vestibulum accumsan eros vel massa euismod in aliquam felis suscipit. Ut et purus enim, id congue ante. Mauris magna lectus, varius porta pellentesque quis, dignissim in est. Nulla facilisi. Nullam in malesuada mauris. Ut fermentum orci neque. Aliquam accumsan justo a lacus vestibulum fermentum. Donec molestie, quam id adipiscing viverra, massa velit aliquam enim, vitae dapibus turpis libero id augue. Quisque mi magna, mollis vel tincidunt nec, adipiscing sed metus. Maecenas tincidunt augue quis felis dapibus nec elementum justo fringilla. Sed eget massa at sapien tincidunt porta eu id sapien.';

        return character_limiter($lipsum, $number_of_characters, '');
    }
}

/**
 * Returns the current microtime.
 *
 * @return bool|string $date The current microtime
 *
 * @category Date
 *
 * @link     http://www.webdesign.org/web-programming/php/script-execution-time.8722.html#ixzz2QKEAC7PG
 */
if (!function_exists('microtime_float')) {
    function microtime_float()
    {
        list($msec, $sec) = explode(' ', microtime());
        $microtime = (float)$msec + (float)$sec;

        return $microtime;
    }
}

/**
 * Limits a string to a number of characters.
 *
 * @param        $str
 * @param int $n
 * @param string $end_char
 *
 * @return string
 *
 * @category Strings
 */
if (!function_exists('character_limiter')) {
    function character_limiter($str, $n = 500, $end_char = '&#8230;')
    {
        if (strlen($str) < $n) {
            return $str;
        }
        $str = strip_tags($str);
        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

        if (strlen($str) <= $n) {
            return $str;
        }

        $out = '';
        foreach (explode(' ', trim($str)) as $val) {
            $out .= $val . ' ';

            if (strlen($out) >= $n) {
                $out = trim($out);

                return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
            }
        }
    }
}



function api_url($str = '')
{
    $str = ltrim($str, '/');

    return site_url('api/' . $str);
}

function api_nosession_url($str = '')
{
    $str = ltrim($str, '/');

    return site_url('api_nosession/' . $str);
}

function auto_link($text)
{
    return mw()->format->auto_link($text);
}

function prep_url($text)
{
    return mw()->format->prep_url($text);
}

function is_arr($var)
{
    return isarr($var);
}

function isarr($var)
{
    if (is_array($var) and !empty($var)) {
        return true;
    } else {
        return false;
    }
}

function array_search_multidimensional($array, $column, $key)
{
    return (array_search($key, array_column($array, $column)));
}

if (!function_exists('is_ajax')) {
    function is_ajax()
    {
        return mw()->url_manager->is_ajax();
    }
}
if (!function_exists('url_current')) {
    function url_current($skip_ajax = false, $no_get = false)
    {
        return mw()->url_manager->current($skip_ajax, $no_get);
    }
}
if (!function_exists('url_segment')) {
    function url_segment($k = -1, $page_url = false)
    {
        return mw()->url_manager->segment($k, $page_url);
    }
}

/**
 * Returns the curent url path, does not include the domain name.
 *
 * @return string the url string
 */
function url_path($skip_ajax = false)
{
    return mw()->url_manager->string($skip_ajax);
}

/**
 * Returns the curent url path, does not include the domain name.
 *
 * @return string the url string
 */
function url_string($skip_ajax = false)
{
    return mw()->url_manager->string($skip_ajax);
}

function url_title($text)
{
    return mw()->url_manager->slug($text);
}

function url_param($param, $skip_ajax = false)
{
    return mw()->url_manager->param($param, $skip_ajax);
}

function url_set_param($param, $value)
{
    return site_url(mw()->url_manager->param_set($param, $value));
}

function url_unset_param($param)
{
    return site_url(mw()->url_manager->param_unset($param));
}

/**
 *  Gets the data from the cache.
 *
 *  If data is not found it return false
 *
 *
 * @example
 * <code>
 *
 * $cache_id = 'my_cache_'.crc32($sql_query_string);
 * $cache_content = cache_get_content($cache_id, 'my_cache_group');
 *
 * </code>
 *
 * @param string $cache_id id of the cache
 * @param string $cache_group (default is 'global') - this is the subfolder in the cache dir.
 * @param bool $expiration_in_seconds You can pass custom cache object or leave false.
 *
 * @return mixed returns array of cached data or false
 */
function cache_get($cache_id, $cache_group = 'global', $expiration = false)
{
    return mw()->cache_manager->get($cache_id, $cache_group, $expiration);
}

/**
 * Stores your data in the cache.
 * It can store any value that can be serialized, such as strings, array, etc.
 *
 * @example
 * <code>
 * //store custom data in cache
 * $data = array('something' => 'some_value');
 * $cache_id = 'my_cache_id';
 * $cache_content = cache_save($data, $cache_id, 'my_cache_group');
 * </code>
 *
 * @param mixed $data_to_cache
 *                                      your data, anything that can be serialized
 * @param string $cache_id
 *                                      id of the cache, you must define it because you will use it later to
 *                                      retrieve the cached content.
 * @param string $cache_group
 *                                      (default is 'global') - this is the subfolder in the cache dir.
 * @param int $expiration_in_seconds
 *
 * @return bool
 */
function cache_save($data_to_cache, $cache_id, $cache_group = 'global', $expiration_in_seconds = false)
{
    return mw()->cache_manager->save($data_to_cache, $cache_id, $cache_group, $expiration_in_seconds);
}

api_expose_admin('clearcache');
/**
 * Clears all cache data.
 *
 * @example
 *          <code>
 *          //delete all cache
 *          clearcache();
 *          </code>
 *
 * @return bool
 */
function clearcache()
{
    mw()->cache_manager->clear();
    mw()->template->clear_cache();
    $empty_folder = userfiles_path() . 'cache' . DS;

    if (is_dir($empty_folder)) {
        rmdir_recursive($empty_folder, true);
    }

    if (!is_dir($empty_folder)) {
        mkdir_recursive($empty_folder);
    }

    $empty_folder = mw_cache_path().'composer';
    if (is_dir($empty_folder)) {
        rmdir_recursive($empty_folder, false);
    }
    if (!is_dir($empty_folder)) {
        mkdir_recursive($empty_folder);
    }

    if (isset($_GET['redirect_to'])) {
        return redirect($_GET['redirect_to']);
    }

    return true;
}

/**
 * Prints cache debug information.
 *
 * @return array
 *
 * @example
 * <code>
 * //get cache items info
 *  $cached_items = cache_debug();
 * print_r($cached_items);
 * </code>
 */
function cache_debug()
{
    return mw()->cache_manager->debug();
}

/**
 * Deletes cache for given $cache_group recursively.
 *
 * @param string $cache_group
 *                            (default is 'global') - this is the subfolder in the cache dir.
 *
 * @return bool
 *
 * @example
 * <code>
 * //delete the cache for the content
 *  cache_clear("content");
 *
 * //delete the cache for the content with id 1
 *  cache_clear("content/1");
 *
 * //delete the cache for users
 *  cache_clear("users");
 *
 * //delete the cache for your custom table eg. my_table
 * cache_clear("my_table");
 * </code>
 */
function cache_clear($cache_group = 'global')
{
    return mw()->cache_manager->delete($cache_group);
}

//same as cache_clear
function cache_delete($cache_group = 'global')
{
    return mw()->cache_manager->delete($cache_group);
}


if (!function_exists('is_cli')) {
    function is_cli()
    {
        static $is;
        if ($is !== null) {
            return $is;
        }
        if (function_exists('php_sapi_name') and
            php_sapi_name() === 'apache2handler'
        ) {
            $is = false;
            return false;
        }


        if (
            defined('STDIN')
            or php_sapi_name() === 'cli'
            or php_sapi_name() === 'cli-server'
            or array_key_exists('SHELL', $_ENV)

        ) {
            $is = true;
            return true;
        }


        $is = false;
        return false;
    }
}


if (!function_exists('is_https')) {
    function is_https()
    {
        if (isset($_SERVER['HTTPS']) and (strtolower($_SERVER['HTTPS']) == 'on')) {
            return true;
        } else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https')) {
            return true;
        }
        return false;
    }
}
if (!function_exists('is_closure')) {
    function is_closure($t)
    {
        return is_object($t) or ($t instanceof \Closure);
    }
}

if (!function_exists('collection_to_array')) {
    function collection_to_array($data)
    {
        if (
            $data instanceof \Illuminate\Database\Eloquent\Collection
            or $data instanceof \Illuminate\Support\Collection
            or $data instanceof \Illuminate\Database\Eloquent\Model
        ) {
            return $data->toArray();
        }
        return $data;

    }
}


function str_replace_bulk($search, $replace, $subject, &$count = null)
{
    // Assumes $search and $replace are equal sized arrays
    $lookup = array_combine($search, $replace);
    $result = preg_replace_callback(
        '/' .
        implode('|', array_map(
            function ($s) {
                return preg_quote($s, '/');
            },
            $search
        )) .
        '/',
        function ($matches) use ($lookup) {
            return $lookup[$matches[0]];
        },
        $subject,
        -1,
        $count
    );
    if (
        $result !== null ||
        count($search) < 2 // avoid infinite recursion on error
    ) {
        return $result;
    }
    // With a large number of replacements (> ~2500?),
    // PHP bails because the regular expression is too large.
    // Split the search and replacements in half and process each separately.
    // NOTE: replacements within replacements may now occur, indeterminately.
    $split = (int)(count($search) / 2);
    $result = str_replace_bulk(
        array_slice($search, $split),
        array_slice($replace, $split),
        str_replace_bulk(
            array_slice($search, 0, $split),
            array_slice($replace, 0, $split),
            $subject,
            $count1
        ),
        $count2
    );
    $count = $count1 + $count2;
    return $result;
}


/**
 * @param $money
 * @return formated_money
 */
function format_money_pdf($money, $currency = null)
{
    if (!$currency) {
        $currency = \MicroweberPackages\Invoice\Currency::findOrFail(\MicroweberPackages\Invoice\CompanySetting::getSetting('currency', 1));
    }

    $format_money = number_format(
        $money,
        $currency->precision,
        $currency->decimal_separator,
        $currency->thousand_separator
    );

    $currency_with_symbol = '';
    if ($currency->swap_currency_symbol) {
        $currency_with_symbol = $format_money.'<span style="font-family: DejaVu Sans;">'.$currency->symbol.'</span>';
    } else {
        $currency_with_symbol = '<span style="font-family: DejaVu Sans;">'.$currency->symbol.'</span>'.$format_money;
    }
    return $currency_with_symbol;
}

if (!function_exists('array_recursive_diff')) {
    function array_recursive_diff($aArray1, $aArray2) {
        $aReturn = array();

        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = array_recursive_diff($mValue, $aArray2[$mKey]);
                    if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
                } else {
                    if ($mValue != $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }
        return $aReturn;
    }
}



function cat_reset_logic(){
    $cats = \App\Models\Category::get();
    if(isset($cats)) {
        foreach ($cats as $cat) {
            $catItem = \App\Models\CategoryItem::where('parent_id', $cat->id)->first();

            if (isset($catItem)) {
                $all_content = DB::table('content')
                ->where('id',$catItem->rel_id)
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->first();

                // if(!isset($all_content)){
                //     $catItem->delete();
                // }
                    if(isset($all_content) && !empty($all_content)){
                        $all_product = DB::table('products')
                        ->where('content_id',$catItem->rel_id)->first();
                        if(!isset($all_product)){
                            products_transfer_from_content();
                        }
                        \App\Models\Category::where('id', $cat->id)->update(['is_hidden' => 0]);
                    }else{
                        \App\Models\Category::where('id', $cat->id)->update(['is_hidden' => 1]);
                    }
            }else{
                \App\Models\Category::where('id', $cat->id)->update(['is_hidden' => 1]);
            }
        }
    }
    category_hide(0);
}


function cat_reset_v2($ids){
    $cats = \App\Models\Category::whereIn('id',$ids)->get();
    if(isset($cats)) {
        foreach ($cats as $cat) {
            $catItem = \App\Models\CategoryItem::where('rel_type','product')->where('parent_id', $cat->id)->first();

            if (isset($catItem)) {
                $all_content = DB::table('product')
                ->where('id',$catItem->rel_id)
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->first();

                // if(!isset($all_content)){
                //     $catItem->delete();
                // }
                    if(isset($all_content) && !empty($all_content)){
                        \App\Models\Category::where('rel_type','product')->where('id', $cat->id)->update(['is_hidden' => 0]);
                    }else{
                        \App\Models\Category::where('rel_type','product')->where('id', $cat->id)->update(['is_hidden' => 1]);
                    }
            }else{
                \App\Models\Category::where('rel_type','product')->where('id', $cat->id)->update(['is_hidden' => 1]);
            }
        }
    }
}

function cat_reset_by_drm($id){
    $catItems = \App\Models\CategoryItem::where('parent_id', $id)->get();
    foreach($catItems as $ci){
        $all_content = DB::table('content')
        ->where('id',$ci->rel_id)
        ->where('is_deleted', 0)
        ->first();
        if(!isset($all_content)){
            \App\Models\CategoryItem::where('id', $ci->id)->delete();
        }
        $count = \App\Models\CategoryItem::where('parent_id', $id)->first();
        if(isset($count) && !empty($count)){
            \App\Models\Category::where('id', $id)->update(['is_hidden' => 0]);
        }else{
            \App\Models\Category::where('id', $id)->update(['is_hidden' => 1]);
        }
    }
}

function cat_product_hide($ids = null){
    if($ids != null){
        $ids = json_decode($ids);
    }else{
        $status = DB::table('categories')->where('status' , 0)->pluck('id')->toArray();
        $ids = [];
        if(isset($status) && !empty($status)){
            $ids = $status;
        }
        // $ids = (json_decode(get_option('category_ids','category_hide')))?json_decode(get_option('category_ids','category_hide')):[];
    }
    DB::table('products')->where('category_hide',1)->update([
        'category_hide' => 0
    ]);
    $content = Content::with('categoryItem')->where('is_deleted',0)->get()->toArray();

    $content = collect($content)
    ->filter(function($q,$key) use ($ids,$content){
        if($q['category_item']){
            $count = count($q['category_item']);
            foreach($q['category_item'] as $cat){

                if(in_array($cat['parent_id'],$ids)){
                    $count--;
                }

            }
            if($count == 0){
                return $q;
            }

        }
    })
    ->pluck('id')->toArray();
    $content = array_values($content);
    DB::table('products')->whereIn('content_id',$content)->update([
        'category_hide' => 1
    ]);

    $hidden_products = DB::table('products')
    ->join('content','content.id','products.content_id')
    ->where('category_hide',1)
    ->select('content.drm_ref_id')
    ->pluck('content.drm_ref_id')
    ->toArray();
    $hidden_products = json_encode($hidden_products);
    try{
        $curl = curl_init();
        $userToken = Config::get('microweber.userToken');
        $userPassToken = Config::get('microweber.userPassToken');
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-set-icon',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('product_ids' => $hidden_products),
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$userToken,
            'userPassToken: '.$userPassToken,
            'Cookie: SameSite=None; SameSite=None'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

    }catch(Exception $e){

    }




    return $content;

}

function category_hide($data){
    if($data == 0){
        $status = DB::table('categories')->where('status' , 0)->pluck('id')->toArray();
        $category_options = [];
        if(isset($status) && !empty($status)){
            $category_options = $status;
        }
        if(!empty($category_options)){
            DB::table('categories')->whereIn('id',$category_options)->update([
                'is_hidden' => 1,
            ]);

        }
        return $category_options;
    }
    $id = (int) $data['id'];
    $cat_ids = [$id];
    $status = DB::table('categories')->where('status' , 0)->pluck('id')->toArray();
    $category_options = [];
    if(isset($status) && !empty($status)){
        $category_options = $status;
    }
    if(in_array($id,$category_options)){

        $categories = collect(mw()->category_manager->get_category_children_recursive($id))->pluck('id')->toArray();
        $cat_ids = array_values(array_unique(array_merge($categories,$cat_ids)));
        foreach($cat_ids as $c_id){
            $category_with_product_check = DB::table('categories_items')->where('parent_id',$c_id)->pluck('rel_id')->toArray();
            //if product is  assign on this category then execute this condition
            if(isset($category_with_product_check) && !empty($category_with_product_check)){
                if (($key = array_search($c_id, $category_options)) !== false) {
                    unset($category_options[$key]);
                }
                $products = DB::table('content')
                ->whereIn('id',$category_with_product_check)
                ->where('is_active',1)
                ->where('is_deleted',0)
                ->select('id')
                ->first();
                if($products){
                    DB::table('categories')->where('id',$c_id)->update([
                        'is_hidden' => 0,
                    ]);
                }
            }else{
                if (($key = array_search($c_id, $category_options)) !== false) {
                    unset($category_options[$key]);
                }
            }
        }

        $category_options = array_values($category_options);
        $cat_ids = $category_options;
        $catagoryIds = json_encode($category_options);

    }else{
        $cat_ids = array_merge(@$category_options??[],$cat_ids);
        $categories = collect(mw()->category_manager->get_category_children_recursive($id))->pluck('id')->toArray();
        $cat_ids = array_values(array_unique(array_merge($categories,$cat_ids)));
        $catagoryIds = json_encode($cat_ids);
        if(!empty($cat_ids)){
            DB::table('categories')->whereIn('id',$cat_ids)->update([
                'is_hidden' => 1,
            ]);

        }
    }

    cat_product_hide($catagoryIds);

    $catagoryIds = json_decode($catagoryIds);
    DB::table('categories')->whereNotIn('id',$catagoryIds)->update([
        'status' => 1,
    ]);
    DB::table('categories')->whereIn('id',$catagoryIds)->update([
        'status' => 0,
    ]);


    return $cat_ids;
}


function abandoned_shopping_carts(){

    $session_id = mw()->user_manager->session_id();
    $user_id = user_id();
    $query = \Illuminate\Support\Facades\DB::table('cart');
    if($user_id){
        $query = $query->where('created_by',$user_id);
    }else{
        $user_id = null;
        $query = $query->where('created_by',null);
    }
    $all = $query->orderBy('created_at', 'desc')->first();
    if(isset($all) and $all->session_id != $session_id){
        $userToken = Config::get('microweber.userToken');
        $userPassToken = Config::get('microweber.userPassToken');
        $drm_auth = array(
            'userToken' => $userToken,
            'userPassToken' => $userPassToken
        );

        $abandoned_carts['userToken'] = $userToken;
        $abandoned_carts['userPassToken'] = $userPassToken;

        $abandoned_carts['results'] = \App\Models\Cart::with(['creator:id,username,email,first_name,middle_name,last_name,phone,role','content:id,content_type,subtype,url,title,parent,description'])->where('order_completed','0')->where('created_by',$user_id)->where('session_id','!=',$session_id)->get(['id','title','rel_id','rel_type','price','session_id','qty','order_completed','created_by']);

        if (count($abandoned_carts['results']) > 0) {
            $userToken = Config::get('microweber.userToken');
            $userPassToken = Config::get('microweber.userPassToken');
            try {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt_abandoned_carts',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('data' => $abandoned_carts),
                    CURLOPT_HTTPHEADER => array(
                        'userToken: '.Config::get('microweber.userToken'),
                        'userPassToken: '.Config::get('microweber.userPassToken'),
                        'Cookie: SameSite=None'                        ),
                ));

                $response = curl_exec($curl);

            }catch (Exception $e){
                return true;

            }
        }

    }


}

function new_wishlists(){

    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $drm_auth = array(
        'userToken' => $userToken,
        'userPassToken' => $userPassToken
    );
    $wishLists['userToken'] = $userToken;
    $wishLists['userPassToken'] = $userPassToken;

    $wishLists['results'] = \App\Models\WishlistSession::with(['user:id,username,email,first_name,middle_name,last_name,phone,role','wlproducts:id,wishlist_id,product_id','wlproducts.product:id,content_type,subtype,url,title,parent,description'])->get(['id','user_id','name']);

    if (count($wishLists['results']) > 0) {
        try {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt_wishlist',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('data' => $wishLists),
                CURLOPT_HTTPHEADER => array(
                    'userToken: '.Config::get('microweber.userToken'),
                    'userPassToken: '.Config::get('microweber.userPassToken'),
                    'Cookie: SameSite=None'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }catch ( Exception $e){
            return true;
        }
    }



}


function blog_word_limit(){
    $limit = Config::get('custom.blog_limit');
    if(!$limit){
        Config::set('custom.blog_limit', 1000);
        Config::save(array('custom'));
    }
    return Config::get('custom.blog_limit');
}

function get_drm_product_limit(){
    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://drm.software/api/drm-product-count?token=dtm3decr435mpdt&userToken='.$userToken.'&userPassToken='.$userPassToken,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response ?? [];
}

function query_modify($data){

    //detect pagination
    $is_paginator = $data instanceof \Illuminate\Pagination\LengthAwarePaginator;
    $collection = $is_paginator ? $data->getCollection() : $data;

    if(!($collection instanceof  \Illuminate\Support\Collection)) return [];

    $taxs = mw()->tax_manager->get();
    $tax_sum = 0;
    $tax_sum =  $taxs[0]['rate'];

    $items = $collection->map(function($item) use ($tax_sum){
        $country_tax = taxRateCountry(@$item->country);
        if(@$country_tax and !empty($country_tax)){
            $tax_sum = $country_tax;
        }
        $country = @$item->country ?? null;
        $carts = $item->carts->map(function ($cart) use ($country,$tax_sum){

            $cart->ean = @$cart->content->first()->ean ?? null;
            $cart->price_with_tax = (function_exists('roundPrice')) ? roundPrice(taxPrice_cart($cart->price,$tax_sum)) : taxPrice_cart($cart->price,$tax_sum);

            return $cart;

        });
//        foreach ($item->carts as $cart){
//            dd();
//        }
        $pay_methode = explode("/",$item->payment_gw);
        $item->payment_gw = end($pay_methode) ?? $item->payment_gw;
        $item->payment_type = $item->payment_gw;
        $item->tax_rate = $tax_sum;
        return $item;
    });



    if($is_paginator){
        $data->setCollection($items);
        return $data;
    }


    return $items;

}

function showCat($data){
    if($data == 'header'){
        $a['header']='show';
        $a['sidebar']='hide';
    }else if($data == 'sidebar'){
        $a['header']='hide';
        $a['sidebar']='show';
    }
    return $a;
}

function taxPrice_cart($price,$tax_rate){

    if(@$price && @$tax_rate){

        $price = $price+($tax_rate*$price)/100;

    }
    return round($price,2);
}

function deletable($id){
    $delete = Config::get('custom.deleteable') ?? [];
    if(in_array($id,@$delete)){
        return false;
    }else {
        return true;
    }

}

//word limit
function limitTextWords($content = false, $limit = false, $stripTags = false, $ellipsis = false)
{
    if ($content && $limit) {
        $content = ($stripTags ? strip_tags($content) : $content);
        $content = explode(' ', trim($content), $limit+1);
        array_pop($content);
        if ($ellipsis) {
            array_push($content, '...');
        }
        $content = implode(' ', $content);
    }
    return $content;
}


//german price to normal
function normalPrice($price){
    if(!empty($price)){
        return str_replace(',','.',$price) ?? $price;
    }
    return $price;
}


function header_cate_status(){
    $header = $GLOBALS['custom_header'];
    $sidebar = $GLOBALS['custom_sidebar'];
    $shop_cat = $GLOBALS['shop_data'][0]['id'];
    $blog_cat = $GLOBALS['blog_data'][0]['id'];
    $active_head_cat = intval($GLOBALS['custom_active_category']);
    if (!@$header and !@$sidebar){
//        Config::set('custom.sidebar', 'sidebar');
        save_option('custom_sidebar', 'sidebar', 'category_customization');

//        if(Config::get('custom.active_category') == null){
        if($GLOBALS['custom_active_category'] == "null"){
//            Config::set('custom.header', null);
            save_option('custom_header', 'null', 'category_customization');

        }
//        Config::save(array('custom'));
    }
//    dd($active_head_cat,$shop_cat,$blog_cat);
    if(empty($active_head_cat) && !isset($active_head_cat)){
        template_head("<script>
        $(window).on('load',function (){
            $('#hide_shop').attr('style','display: none !important;');
            $('#hide_blog').attr('style','display: none !important;');
        });

        		</script>");
    }

    if(isset($_REQUEST['keywords'])){

        template_head("<script>
        $(window).on('load',function (){
            $('#hide_shop').attr('style','display: none !important;');
            $('#hide_blog').attr('style','display: none !important;');
        });
        		</script>");

    }

    template_head("<script>
    $(window).on('load',function (){
        var shop_id = $('#shop_".PAGE_ID."').val();
        var blog_id = $('#blog_".PAGE_ID."').val();
            // console.log(shop_id,blog_id);
            if(".$shop_cat." == '".$active_head_cat."' && typeof shop_id != 'undefined'){
                $('.header-cat').attr('style','display: block;');
            }
            if(typeof blog_id != 'undefined' && ".$blog_cat." == '".$active_head_cat."'){
                $('.header-cat').attr('style','display: block;');
            }
            if(".$shop_cat." == '".$active_head_cat."'){
                $('#hide_blog').attr('style','display: none !important;');
            }
            if(".$blog_cat." == '".$active_head_cat."'){
                $('#hide_shop').attr('style','display: none !important;');
            }
            if('".$active_head_cat."' == null){
                $('#hide_shop').attr('style','display: none !important;');
                $('#hide_blog').attr('style','display: none !important;');

            }
        if(typeof shop_id != 'undefined' && ".$shop_cat." == '".$active_head_cat."'){
            $.post('". url('/') ."/api/v1/save_page_for_cat_header', { shop_id: shop_id }, (res) => {

            });

        }
        if(typeof blog_id != 'undefined' && ".$blog_cat." == '".$active_head_cat."'){
            $.post('" . url('/') . "/api/v1/save_page_for_cat_header', { blog_id: blog_id }, (res) => {

            });
        }

        if(typeof shop_id == 'undefined'){
            $.post('". url('/') ."/api/v1/clear_page_for_cat_header', { shop_id: ".PAGE_ID." }, (res) => {

            });
        }
        if(typeof blog_id == 'undefined'){
            $.post('" . url('/') . "/api/v1/clear_page_for_cat_header', { blog_id: ".PAGE_ID." }, (res) => {

            });
        }

	});
		</script>");
//    if(typeof id == 'undefined'){
//        $.post('". url('/') ."/api/v1/clear_page_for_cat_header', { page_id: ".PAGE_ID." }, (res) => {
//
//        });
//        }


    return category_hide_or_show();
}

function category_hide_or_show(){
    $header = $GLOBALS['custom_header'];
    $sidebar = $GLOBALS['custom_sidebar'];
    $shop_cat = $GLOBALS['shop_data'][0]['id'];
    $blog_cat = $GLOBALS['blog_data'][0]['id'];
    $active_head_cat = intval($GLOBALS['custom_active_category']);
    if($shop_cat == $active_head_cat){
        $showHeader['blog'] = "hide";
    }
    if($blog_cat == $active_head_cat){
        $showHeader['shop'] = "hide";
    }
    if(!isset($active_head_cat) || $active_head_cat == null){
        $showHeader['shop'] = "hide";
        $showHeader['blog'] = "hide";
    }
//    dd(json_decode($GLOBALS['custom_blog_category_header']));
    if($shop_cat == $active_head_cat){
        $cat_array = (array)json_decode($GLOBALS['custom_shop_category_header']) ?? [];
        $cat_array_ignore = (array)json_decode($GLOBALS['custom_shop_category_header_ignore']) ?? [];
    }elseif($blog_cat == $active_head_cat){
        $cat_array = (array)json_decode($GLOBALS['custom_blog_category_header']) ?? [];
        $cat_array_ignore = (array)json_decode($GLOBALS['custom_blog_category_header_ignore']) ?? [];
    }else{
        $cat_array = [];
        $cat_array_ignore = [];
    }
//    dd($sidebar,$header,$cat_array);
    if(@$header == 'header' && in_array(PAGE_ID,@$cat_array) == true && in_array(PAGE_ID,@$cat_array_ignore) != true){
        $showHeader = showCat('header');
    }else if(@$sidebar == 'sidebar'){
        $showHeader = showCat('sidebar');
    }else{
        save_option('custom_sidebar', 'sidebar', 'category_customization');
//        Config::set('custom.sidebar', 'sidebar');
//        Config::save(array('custom'));
    }
//    if(Config::get('custom.active_category') == "null"){
    if($GLOBALS['custom_active_category'] == "null"){
        $showHeader['header']="hide";
    }
    if ((in_array(PAGE_ID,$cat_array) != true && in_array(PAGE_ID,$cat_array_ignore) != true) || $GLOBALS['custom_active_category'] == 'null'){
        $showHeader['button'] = 'hide';
    }
    return $showHeader;

}

function temp_blog_collapse(){
    $header = $GLOBALS['custom_header'];
    $sidebar = $GLOBALS['custom_sidebar'];
//$active = Config::get('custom.active_category');
    $active = $GLOBALS['custom_active_category'];

    if(@$header == 'header'){
        $showHeader = showCat('header');
    }else if(@$sidebar == 'sidebar'){
        $showHeader = showCat('sidebar');
    }

    if($active == get_content('layout_file=layouts__blog.php')[0]['id']){
        $showHeader['sidebar']="hide";
    }else{
        $showHeader['sidebar']="show";
    }

    if($active == "null"){
        $showHeader['header']="hide";
    }
    template_head("<script>
    var shop = $('#all_cat').val();
    var shop_temp = $('#blog_".PAGE_ID."').val();
    if(shop == ".PAGE_ID." && shop_temp == ".PAGE_ID."){
        $('.header-cat').attr('style','display: block !important;');
    }
		</script>");
    return $showHeader;
}

function temp_shop_collapse(){
    $header = $GLOBALS['custom_header'];
    $sidebar = $GLOBALS['custom_sidebar'];
    $active = $GLOBALS['custom_active_category'];

    if(@$header == 'header'){
        $showHeader = showCat('header');
    }else if(@$sidebar == 'sidebar'){
        $showHeader = showCat('sidebar');
    }

    if($active == $GLOBALS['shop_data'][0]['id']){
        $showHeader['sidebar']="hide";
    }else{

        $showHeader['sidebar']="show";

    }

    if($active == "null"){
        $showHeader['header']="hide";
    }
    template_head("<script>
    var shop = $('#shop_cat').val();
    var shop_temp = $('#shop_".PAGE_ID."').val();
    if(shop == ".PAGE_ID." && shop_temp == ".PAGE_ID."){
        $('.header-cat').attr('style','display: block !important;');
    }
		</script>");
    return $showHeader;
}

function hide_delete(){
    return array(
        "vacation","thank-you","search","agb","impressum","datenschutz","versandkosten","widerrufsrecht","imprint","privacy","terms-and-conditions-first","checkout","shop","blog","home"
    );
}

function hide_edite(){
    return array(
        "checkout"
    );
}

function hide_page(){
    return array(
        "checkout"
    );
}

function delivery_bill_url($order_id){
    $userToken = Config::get('microweber.userToken');
    $token = "token=".$userToken."&delivery=".$order_id;
    $ciphering = "AES-128-CTR"; //Cipher method
    $iv_length = openssl_cipher_iv_length($ciphering); // Use OpenSSl Encryption method
    $options = 0;
    $encryption_iv = '1234567891011122'; // Non-NULL Initialization Vector for encryption
    $encryption_key = "trr45fdd4fgy34"; //encryption key

    $key = openssl_encrypt($token, $ciphering, $encryption_key, $options, $encryption_iv);
    $key = base64_encode($key);
    return "https://drm.software/droptienda-delivery-note?token=".$key;
}


// function licence_drm(){
//     try {
//         $curl = curl_init();
//         curl_setopt_array($curl, array(
//             CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-license-check',
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_ENCODING => '',
//             CURLOPT_MAXREDIRS => 10,
//             CURLOPT_TIMEOUT => 0,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//             CURLOPT_CUSTOMREQUEST => 'POST',
//             CURLOPT_HTTPHEADER => array(
//                 'userToken: '.Config::get('microweber.userToken'),
//                 'userPassToken: '.Config::get('microweber.userPassToken'),
//                 'Cookie: SameSite=None'
//             ),
//         ));
//         $response = json_decode(curl_exec($curl));
//     }catch (Exception $e){
//         return false;
//     }
//     if(isset($response->success) && $response->success != false){
//         $string_js = "<script>
//                       window.onUsersnapCXLoad = function(api) {
//                         api.init();
//                       }
//                       var script = document.createElement('script');
//                       script.async = 1;
//                       script.src = 'https://widget.usersnap.com/load/9c33bd00-3564-480d-b89f-b104f6f0fb90?onload=onUsersnapCXLoad';
//                       document.getElementsByTagName('head')[0].appendChild(script);
//                     </script>   ";
//         return $string_js;
//     }
// }

// function rss_pagination($rssoption, $paging_param)
// {

//     $perpage_item  = intval(get_option('rss_page','rss_page')) ?? 6;
//     $perpage_item = $perpage_item == 0 ? 6 : $perpage_item ;
//     if ($perpage_item and $perpage_item != 0 and $rssoption != null and $rssoption != 0) :
//         if (function_exists('total_page')) {
//             $page = total_page();
//         }
//         if ($page != null && $page > 1) :
//             $aaa = "<module type='pagination' template='bootstrap4' pages_count='" . $page . "' paging_param='" . $paging_param . "' />";
//             echo $aaa;
//         endif;
//     endif;
// }



// if (!function_exists('rss_post_pagination')) {
//     function rss_post_pagination($array)
//     {
//         $perpage_item  = intval(get_option('rss_page','rss_page')) ?? 6;
//         $perpage_item = $perpage_item == 0 ? 6 : $perpage_item ;
//         if (isset($perpage_item)) {
//             $url_full = explode('=',url()->full());
//             if(isset($url_full[1]) && count($url_full) <= 2){
//                 if (is_numeric($url_full[1])) {
//                     $current_page = $url_full[1];
//                 } else {
//                     $current_page = 1;
//                 }
//             }else{
//                 $current_page = 1;
//             }
//             $total = count($array);
//             $pagination = $total / $perpage_item;
//             $page = is_int($pagination) ? $pagination : (((int)$pagination) + 1);
//             $GLOBALS['pages'] = $page;
//             $start = ($current_page * $perpage_item) - $perpage_item;
//             $end = $current_page * $perpage_item;
//             $end = ($end <= $total) ? $end : $total;
//             $counter = 0;
//             $item = [];
//             for ($i = $start; $i < $end; $i++) {
//                 $item[$counter] = $array[$i];
//                 $counter++;
//             }
//             return $item;
//         } else {
//             return $array;
//         }
//     }
// }

// if (!function_exists('total_page')) {
//     function total_page()
//     {
//         $perpage_item  = intval(get_option('rss_page','rss_page'));
//         if ($perpage_item) {
//             if (isset($GLOBALS['pages'])) {
//                 return $GLOBALS['pages'];
//             } else {
//                 return 0;
//             }
//         }
//     }
// }

function chat_footer(){
    $chat_modal = '';
    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-chat-question',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'userToken: ' . $userToken,
            'userPassToken: ' . $userPassToken,
            'Cookie: SameSite=None; SameSite=None'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $chat_answers = @json_decode($response, true)['data'] ?? [];

    $all_orders = get_orders('no_limit=true');

    $chat_modal = '';
    if(isset($all_orders) && $all_orders != false) {
        foreach (@$all_orders as $order) {

            $chat_modal .= '<div class="modal chat-modal ordreChat_Modal" id="order-chat-modal-' . $order["id"] . '" data-order-id="' . $order["id"] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="order-header">
                            <h4 class="currentOrderId">Order Id: #<span>00</span></h4>
                            <span class="status_badge">

                            </span>
                        </div>
                        <input type="hidden" name="order_id" id="order_id" value="0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                        <!-- Dt Order Chat Box Style End -->

                        <input class="currentOrderNo" type="hidden" value="" />

                        <div class="order-chat-box-wrapper">

                            <div class="chat-popup" id="chat-popup-' . $order["id"] . '">

                                <div class="chat-area" id="chat-area' . $order["id"] . '">
                                </div>
                                <div class="input-area">
                                    <input type="text" class="ordermsg emojionearea1" placeholder="Type Massage ..." id="emojionearea' . $order["id"] . '">
                                    <button class="submitOrderText btn btn-success" data-id="' . $order["id"] . '" id="submitOrderText' . $order["id"] . '"> Send</button>
                                </div>

                                <div class="question-area pull-right">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton'.$order["id"].'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-question-circle-o"></i>
                                        </button>
                                        <div class="dropdown-menu known-questions" aria-labelledby="dropdownMenuButton'.$order["id"].'">';
                                            foreach ($chat_answers as $key => $answer):
                                                $answer = (object) $answer;
                                                $chat_modal .= "<button type='button' class='dropdown-item'>$answer->question</button>";
                                            endforeach;
                        $chat_modal .= '</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>';

        }
    }
    $chat_modal .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" integrity="sha512-vEia6TQGr3FqC6h55/NdU3QSM5XR6HSl5fW71QTKrgeER98LIMGwymBVM867C1XHIkYD9nMTfWK2A0xcodKHNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .order-header{
            display:flex;
            align-items:center;
        }

        .status_badge {
            background: #fff;
            border-radius: 5px;
            margin-left: 5px;
            padding: 0 2px;
            font-weight:700;
            display:inline-block;
        }
        .status_badge.green{
            color: green;
        }
        .status_badge.red{
            color: red;
        }
        .status_badge i{
            margin-right:5px;
        }
        h4.currentOrderId {
            display: inline-block;
            font-size: 18px;
            margin: 0;
            line-height: 1;
            font-weight: 400;
            text-transform: capitalize;
            letter-spacing: 0;
            color: #fff;
        }
        .ordreChat_Modal .modal-header {
            background: #00a65a;
            padding: 10px;
            color: #fff;
        }
        .emojiPicker nav {
            display: none !important;
        }
        .ordreChat_Modal  .modal-header {
            border-bottom: 3px solid #00a65a;
            padding: 10px;
        }
        .Sentchat_Massage .other-message {
            background: red !important;
        }
        .Sentchat_Massage .message.my-message.float-right,
        .getChat_massage .message.my-message.float-right {
            background: #00a65a;
        }
        .ordreChat_Modal .modal-content {
            border: none !important;
        }

        .ordreChat_Modal .modal-header button>span {
            color: #fff !important;
        }
        .order-new-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }

        .order-chat-option {
            text-align: right;
            margin-bottom: 10px;
        }

        .order-chat-option span {
            font-size: 30px;
            display:inline-block;
        }
        .order-chat-modal{
            z-index: 999999;
        }
        .AKSASGH,
        .AKSASGH .modal.my-orders-modal{
            overflow-y: hidden;
            overflow: hidden !important;
        }

        .my-orders-modal .modal-body{
            max-height: 90vh;
            overflow-y: auto;
        }
        .productOrderTable tr td{
            vertical-align: middle;
        }
        .re-order-btn button{
            width: 83px;
        }


        @media only screen and (max-width: 991px) {
            .my-orders-modal .modal-body {
                padding: 20px ;
            }
            .order-chat-option {
                text-align: center;
                margin-bottom: 0;
            }
            .my-order-status.pull-right {
                float: unset !important;
                text-align: center;
                margin-bottom: 10px;
            }
            .my-orders-modal .modal-body p {
                text-align: center;
            }
            .order-new-info {
                display: block !important;
            }
            .edit[field=order_modal_top] .text>p {
                margin-bottom: 15px;
            }
        }
        @media only screen and (max-width: 991px) and (min-width: 768px) {
            #ordersModal .modal-dialog {
                max-width: 620px;
            }
        }
    </style>
    <style>





        /* ========================\
        Order Chat Style Start
        ======================== */

        .order-chat-box-wrapper {
            position: relative;
            min-height: 300px;
        }

        .order-chat-box-wrapper .chat-btn{
            position: absolute;
            right:50px;
            bottom: 50px;
            background: dodgerblue;
            color: white;
            width:60px;
            height: 60px;
            border-radius: 50%;
            opacity: 0.8;
            transition: opacity 0.3s;
            box-shadow: 0 5px 5px rgba(0,0,0,0.4);
        }

        .order-chat-box-wrapper .chat-btn:hover, .submit:hover, #emoji-btn:hover{
            opacity: 1;
        }
        /*
        .order-chat-box-wrapper .chat-popup{
        display: none;
        position: absolute;
        bottom:80px;
        right:120px;
        height: 400px;
        width: 300px;
        background-color: white;
        / display: flex; /
        flex-direction: column;
        justify-content: space-between;
        padding: 0.75rem;
        box-shadow: 5px 5px 5px rgba(0,0,0,0.4);
        border-radius: 10px;
        } */
        .order-chat-box-wrapper .chat-popup{
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 100%;
            background-color: white;
            justify-content: space-between;
            padding: 0.75rem;
            box-shadow: 5px 5px 5px rgb(0 0 0 / 40%);
            border-radius: 10px;
        }

        .order-chat-box-wrapper .show{
            display: flex;
        }

        .order-chat-box-wrapper .show {
            display: block !important;
        }

        .order-chat-box-wrapper .chat-area{
            height: 82%;
            overflow-y: auto;
            overflow-x: hidden;
            padding-left: 10px;
            padding-right: 10px;
        }
        .order-chat-box-wrapper .chat-area li:nth-child(1) {
            margin-top: 10px;
        }

        .order-chat-box-wrapper .income-msg{
            display: flex;
            align-items: center;
        }

        .order-chat-box-wrapper .avatar{
            width:45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        .order-chat-box-wrapper .income-msg .msg{
            background-color: dodgerblue;
            color: white;
            padding:0.5rem;
            border-radius: 25px;
            margin-left: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.4);
        }

        .order-chat-box-wrapper .badge{
            position: absolute;
            width: 30px;
            height: 30px;
            background-color: red;
            color:white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            top:-10px;
            right: -10px;
        }
        .input-area .emojiPickerIconWrap input {
            width: 100% !important;
            height: 34px !important;
            border-color: #d2d6de !important;
            padding: 6px 37px 6px 12px;
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        .input-area .emojiPickerIconWrap input:focus {
            outline: 0;
            border: 1px solid #3c8dbc !important
        }

        .order-chat-box-wrapper .input-area{
            position: relative;
            display: flex;
            justify-content: center;
            overflow: hidden;
            border-top: 1px solid #eee;
            padding: 10px;
        }
        .emojiPickerIcon.black {
            height: 34px !important;
        }

        .order-chat-box-wrapper input[type="text"]{
            width:100%;
            border: 1px solid #ccc;
            font-size: 1rem;
            border-radius: 5px;
            height: 2.2rem;
        }

        .order-chat-box-wrapper #emoji-btn{
            position: absolute;
            font-size: 1.2rem;
            background: transparent;
            right: 50px;
            top:2px;
            opacity:0.5;
        }

        .order-chat-box-wrapper .submit{
            padding: 0.25rem 0.5rem;
            margin-left: 0.5rem;
            background-color: green;
            color:white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            opacity: 0.7;
        }


        .order-chat-box-wrapper .out-msg{
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .order-chat-box-wrapper .my-msg{
            display: flex;
            justify-content: flex-end;
            margin: 0.75rem;
            padding: 0.5rem;
            background-color: #ddd;
            border-radius: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.4);
            word-break: break-all;
        }

        .message.other-message {
            color: #000 !important;
        }



        .order-chat-box-wrapper .chat-popup.show {
            box-shadow: none;
            border: 1px solid #dee2e6;
            border-radius: 0px;
            border-top: 0px;
            border-bottom: 0px;
            padding-bottom: 0px;
            padding: 0px !important;
        }
        button.submitOrderText i {
            font-size: 18px;
        }
        // button.submitOrderText {
        //     background-color: #000;
        //     color: #fff;
        //     padding: 7px 5px 0px !important;
        //     border: none;
        // }
        button#submitOrderText1 {
            border-radius: 0 !important;
        }
        .emojionearea, .emojionearea.form-control, .order-chat-box-wrapper input[type="text"] {
            border-radius: 0px !important;
        }


        .order-chat-box-wrapper .badge {
            right: 40px;
            top: -40px;
        }
        .chat-modal .modal-body {
            padding: 0px;
        }

        @media (max-width:500px){

            .order-chat-box-wrapper .chat-popup{
                bottom: 120px;
                right:10%;
                width: 80vw;
            }
        }


        .order-outgoing-msg-info {
            position: relative;
        }

        .order-outgoing-msg-info span.message-data-time {
            font-size: 10px;
            line-height: 12px;
            color: #888;
            display: block;
        }

        .order-outgoing-msg-info span.email {
            font-size: 10px;
            color: #9e9e9e;
            position: relative;
            margin-top: -22px;
            display: block;
        }

        .order-outgoing-msg-info span.message-data-time br {}
        .message.other-message{
            position: relative;
            display: inline-block;
            background-color: #3390ff;
            width: auto;
            border-radius: 5px;
            text-align: left;
            padding: 5px 10px;
            color: #fff;
            font-size: 14px;
            line-height: 19px;
            margin-bottom: 10px;
        }
        .message.my-message{
            position: relative;
            display: inline-block;
            background-color: #00a65a;
            width: auto;
            border-radius: 5px;
            text-align: left;
            padding: 5px 10px;
            color: #fff;
            font-size: 14px;
            line-height: 19px;
            margin-bottom: 10px;
        }
        span#my-order-ChatOption {
            cursor: pointer;
        }
        ul, li {
            list-style: none;
        }
        .support-chat-text {
            display: inline-block !important;
            text-align: center !important;
            color: #fff !important;
            position: relative !important;
            margin-bottom:0 !important;
        }
        .modal-header .close:focus {
            outline: 0;
        }
        .order-chat-modal span.badge {
            position: absolute;
            background-color: #f00;
            color: #fff;
            font-size: 10px;
            z-index: 1;
            border-radius: 50%;
            padding: 5px;
            right: -4px;
            top: 5px;
        }

        .order-chat-modal {
            position: relative;
        }
        /* ========================
        Order Chat Style End
        ======================== */
    </style>';
    return $chat_modal;
}



//word count
function random_word_check($data){
    if($data){
        $temp_all_word = explode(' ', $data['text']);
        $replc_all_word = str_replace(".","",$data['text']);
        $replc_all_word = str_replace(",","",$replc_all_word);
        $finl_all_word = explode(' ', $replc_all_word);
        $finl_all_word = array_filter($finl_all_word);

        $word_count = 1;
        $sub_string = null;
        if(@$data['single_word'] && @$data['word_number']){
            $checkword = substr_count($replc_all_word, $data['single_word']);
            if($checkword >= $data['word_number']){
                foreach ($finl_all_word as $key => $single_word){
                    $sub_string = $sub_string.' '.$temp_all_word[$key];
                    if($finl_all_word[$key] == $data['single_word']){
                        if($word_count == $data['word_number']){
                            break;
                        }else{
                            $word_count++;
                        }
                    }

                }

                $sub_string = force_balance_tags($sub_string);

            }else{
                $sub_string = "String not found";
            }
        }else{
            $sub_string = "String not found";
        }

        return $sub_string;
    }
}

function last_word_check($data){

    if($data){
        $temp_all_word = explode(' ', $data);
        $replc_all_word = str_replace(".","",$data);
        $replc_all_word = str_replace(",","",$replc_all_word);
        $finl_all_word = explode(' ', $replc_all_word);
        $finl_all_word = array_filter($finl_all_word);
        $checkword['word_number'] = substr_count($replc_all_word, end($finl_all_word));
        $checkword['single_word'] =  end($finl_all_word);
        return $checkword;
    }
}

function force_balance_tags( $text ) {
    $tagstack  = array();
    $stacksize = 0;
    $tagqueue  = '';
    $newtext   = '';
    // Known single-entity/self-closing tags.
    $single_tags = array( 'area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source' );
    // Tags that can be immediately nested within themselves.
    $nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );

    // WP bug fix for comments - in case you REALLY meant to type '< !--'.
    $text = str_replace( '< !--', '<    !--', $text );
    // WP bug fix for LOVE <3 (and other situations with '<' before a number).
    $text = preg_replace( '#<([0-9]{1})#', '&lt;$1', $text );

    /**
     * Matches supported tags.
     *
     * To get the pattern as a string without the comments paste into a PHP
     * REPL like `php -a`.
     *
     * @see https://html.spec.whatwg.org/#elements-2
     * @see https://w3c.github.io/webcomponents/spec/custom/#valid-custom-element-name
     *
     * @example
     * ~# php -a
     * php > $s = [paste copied contents of expression below including parentheses];
     * php > echo $s;
     */
    $tag_pattern = (
        '#<' . // Start with an opening bracket.
        '(/?)' . // Group 1 - If it's a closing tag it'll have a leading slash.
        '(' . // Group 2 - Tag name.
        // Custom element tags have more lenient rules than HTML tag names.
        '(?:[a-z](?:[a-z0-9._]*)-(?:[a-z0-9._-]+)+)' .
        '|' .
        // Traditional tag rules approximate HTML tag names.
        '(?:[\w:]+)' .
        ')' .
        '(?:' .
        // We either immediately close the tag with its '>' and have nothing here.
        '\s*' .
        '(/?)' . // Group 3 - "attributes" for empty tag.
        '|' .
        // Or we must start with space characters to separate the tag name from the attributes (or whitespace).
        '(\s+)' . // Group 4 - Pre-attribute whitespace.
        '([^>]*)' . // Group 5 - Attributes.
        ')' .
        '>#' // End with a closing bracket.
    );

    while ( preg_match( $tag_pattern, $text, $regex ) ) {
        $full_match        = $regex[0];
        $has_leading_slash = ! empty( $regex[1] );
        $tag_name          = $regex[2];
        $tag               = strtolower( $tag_name );
        $is_single_tag     = in_array( $tag, $single_tags, true );
        $pre_attribute_ws  = isset( $regex[4] ) ? $regex[4] : '';
        $attributes        = trim( isset( $regex[5] ) ? $regex[5] : $regex[3] );
        $has_self_closer   = '/' === substr( $attributes, -1 );

        $newtext .= $tagqueue;

        $i = strpos( $text, $full_match );
        $l = strlen( $full_match );

        // Clear the shifter.
        $tagqueue = '';
        if ( $has_leading_slash ) { // End tag.
            // If too many closing tags.
            if ( $stacksize <= 0 ) {
                $tag = '';
                // Or close to be safe $tag = '/' . $tag.

                // If stacktop value = tag close value, then pop.
            } elseif ( $tagstack[ $stacksize - 1 ] === $tag ) { // Found closing tag.
                $tag = '</' . $tag . '>'; // Close tag.
                array_pop( $tagstack );
                $stacksize--;
            } else { // Closing tag not at top, search for it.
                for ( $j = $stacksize - 1; $j >= 0; $j-- ) {
                    if ( $tagstack[ $j ] === $tag ) {
                        // Add tag to tagqueue.
                        for ( $k = $stacksize - 1; $k >= $j; $k-- ) {
                            $tagqueue .= '</' . array_pop( $tagstack ) . '>';
                            $stacksize--;
                        }
                        break;
                    }
                }
                $tag = '';
            }
        } else { // Begin tag.
            if ( $has_self_closer ) { // If it presents itself as a self-closing tag...
                // ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such
                // and immediately close it with a closing tag (the tag will encapsulate no text as a result).
                if ( ! $is_single_tag ) {
                    $attributes = trim( substr( $attributes, 0, -1 ) ) . "></$tag";
                }
            } elseif ( $is_single_tag ) { // Else if it's a known single-entity tag but it doesn't close itself, do so.
                $pre_attribute_ws = ' ';
                $attributes      .= '/';
            } else { // It's not a single-entity tag.
                // If the top of the stack is the same as the tag we want to push, close previous tag.
                if ( $stacksize > 0 && ! in_array( $tag, $nestable_tags, true ) && $tagstack[ $stacksize - 1 ] === $tag ) {
                    $tagqueue = '</' . array_pop( $tagstack ) . '>';
                    $stacksize--;
                }
                $stacksize = array_push( $tagstack, $tag );
            }

            // Attributes.
            if ( $has_self_closer && $is_single_tag ) {
                // We need some space - avoid <br/> and prefer <br />.
                $pre_attribute_ws = ' ';
            }

            $tag = '<' . $tag . $pre_attribute_ws . $attributes . '>';
            // If already queuing a close tag, then put this tag on too.
            if ( ! empty( $tagqueue ) ) {
                $tagqueue .= $tag;
                $tag       = '';
            }
        }
        $newtext .= substr( $text, 0, $i ) . $tag;
        $text     = substr( $text, $i + $l );
    }

    // Clear tag queue.
    $newtext .= $tagqueue;

    // Add remaining text.
    $newtext .= $text;

    while ( $x = array_pop( $tagstack ) ) {
        $newtext .= '</' . $x . '>'; // Add remaining tags to close.
    }

    // WP fix for the bug with HTML comments.
    $newtext = str_replace( '< !--', '<!--', $newtext );
    $newtext = str_replace( '<    !--', '< !--', $newtext );

    return $newtext;
}

function show_email_when_stockout($product_id,$product_url,$product_title,$ean){
    return '<style>
                /* Email Notification Css Start*/

                nav.navbar.navbar-light.bg-light {
                    padding: 0px 11px;
                    margin-bottom: 20px;
                }
                .nav-text i {
                    font-size: 20px;
                    color: #fff;
                    background-color: dodgerblue;
                    padding: 22px 18px;
                    margin-left: -11px;
                    border-radius: 5px;
                }
                .nav-text a {
                    font-size: 15px;
                    margin-left: 13px;
                }

                .shop-modules.text h2 {
                    font-size: 14px;
                    margin-top: 20px;
                    margin-bottom: 35px;
                }
                .input-container {
                    display: flex;
                    width: 100%;
                    margin-bottom: 15px;
                    margin-top: 12px;
                }

                .input-container button {
                    background: dodgerblue !important;
                    color: #fff !important;
                    min-width: 81px !important;
                    text-align: center !important;
                }
                .input-container button:hover {
                    color: #fff;
                    background-color: #222222;

                }
                .email-field {
                    width: 100%;
                    padding: 10px;
                    outline: none;
                    background-color: #FAF9F6;
                    height: 48px;
                }

                /* Email Notification Css End*/
            </style>
            <div class="email_notification">
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <nav class="navbar navbar-light bg-light">
                                    <div class="nav-text">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        <a href="">Benachrichtigen Sie mich, sobald der Artikel lieferbar ist.</a>
                                    </div>
                                </a>
                            </nav>
                            <div class="input-container">
                                <input class="email-field form-control" type="email" placeholder="Ihre E-Mail-Address" name="email" value="'.user_email().'">
                                    <button class="btn mail-in-stockout" type="button" data-id="'.$product_id.'" data-ean="'.$ean.'" data-url="'.url('/')."/".$product_url.'" data-title="'.$product_title.'"><i class="fa fa-envelope icon"></i></button>

                            </div>
                            <div class="shop-modules text">
                                <h2>ich habe die <a href="'.url("/").'/datenschutz">Datenschutzbestimmungen</a> zur Kenntnis genommen</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            $(document).on("click", ".mail-in-stockout", function (){
                let product_id = $(this).data("id");
                let url = $(this).data("url");
                let title = $(this).data("title");
                let ean = $(this).data("ean");
                let email = $(this).parent(".input-container").find(".email-field").val();
                // console.log(email);
                $.post("'.url("/").'/api/v1/send_mail_in_stockout", { id:product_id,url: url,title:title,ean:ean,email:email
            })
            .then((res, err) => {
                if(res.success){
                    mw.notification.success(res.message);
                }else{
                    mw.notification.warning(res.message);

                }
            });
            });
</script>
';
}


//image resize
//image resize
function resize_image($image, $thumbnail_width, $file_kb_size, $minimum_size, $product = false)
{
    $main_image_path = $image;

    $image_path = explode("?", $main_image_path);
    $insta_image_path = $image_path[0];

    $path = explode("/", $insta_image_path);
    $image_name = end($path);

    $explode_image_name = explode(".", $image_name);
    if (count($explode_image_name) > 2) {
        $remove = array_pop($explode_image_name);
        $explode_image_name = implode(".", $explode_image_name);
    }

    $img_resize['only_image_name'] = @array_shift($explode_image_name) ?? $explode_image_name;
    if($product){
        $img_resize['only_image_name'] = $product->url.'_'.$product->key;
    }
    $img_resize['webp_save_path'] = public_path('userfiles/media/templates.microweber.com/' . $thumbnail_width . '/');
    $img_resize['image_name'] = $image_name;

    $savePath = public_path('userfiles/media/templates.microweber.com/' . $thumbnail_width . '/thumbnails' . '/') . $img_resize['only_image_name'] . '.webp';

    $folder = $savePath;
    $data = explode("/", $folder);
    $removed = array_pop($data);
    $dirname = implode("/", $data);

    if (!file_exists($dirname)) {
        mkdir($dirname, 0777, true);
    }

    $activate_compressor = get_option('img_compressor', 'compressor');
    if (@$activate_compressor == 1 && $activate_compressor != false) {
        if (!empty($minimum_size) && $minimum_size < $file_kb_size) {
            if (!file_exists($savePath)) {
                $img = \Intervention\Image\ImageManagerStatic::make($main_image_path);
                $img->resize($thumbnail_width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp');
                @$img->save($savePath);
            }
        }
    }
    return $img_resize;
}


function exixting_image_compressed($image,$compress_size,$thumbnail_width,$minimum_size,$file_kb_size, $product = false){
    $main_image_path=$image;
    $path = explode("/",$main_image_path);
    $image_name = end($path);

    $explode_image_name = explode(".",$image_name);
    if(count($explode_image_name) > 2){
        $remove = array_pop($explode_image_name);
        $explode_image_name = implode(".",$explode_image_name);
    }

    $img_resize['only_image_name'] = @array_shift($explode_image_name) ?? $explode_image_name;
    if($product){
        $img_resize['only_image_name'] = $product->url.'_'.$product->key;
    }
    $img_resize['webp_save_path'] = public_path('userfiles/media/default/');
    $img_resize['image_name'] = $image_name;

    $savePath= public_path('userfiles/media/default/thumbnails/').$img_resize['only_image_name'].'.webp';
    $folder= $savePath;
    $data=explode("/",$folder);
    $removed = array_pop($data);
    $dirname=implode("/",$data);

    if (!file_exists($dirname)) {
        mkdir($dirname, 0777, true);
    }

    //existing image delete
    if (file_exists($savePath)) {
        unlink($savePath);
    }
    if (file_exists($img_resize['webp_save_path'].$img_resize['only_image_name'].'.webp')) {
        unlink($img_resize['webp_save_path'].$img_resize['only_image_name'].'.webp');
    }

    // Check if you have this file and
    $activate_compressor = get_option('img_compressor' , 'compressor');
    if(@$activate_compressor == 1 && $activate_compressor != false){
        if(!empty($minimum_size) && $minimum_size < $file_kb_size){
            if (!file_exists($savePath)) {
                $img = \Intervention\Image\ImageManagerStatic::make($main_image_path);
                $img->resize($thumbnail_width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp');
                @$img->save($savePath);
            }
        }
    }
    //webp image save
    $webp_image = \Intervention\Image\ImageManagerStatic::make($main_image_path)->encode('webp', 90);
    @$webp_image->save($img_resize['webp_save_path'].$img_resize['only_image_name'].'.webp',$compress_size ? $compress_size : 100);

    return $img_resize;
}

function insert_resized_image($id,$image,$resized_image,$thumbnail_width,$file_kb_size,$minimum_size,$export=false){
    //dd($id,$image,$resized_image,$thumbnail_width);
    $resize_image = '{SITE_URL}userfiles/media/templates.microweber.com/'.$thumbnail_width.'/thumbnails'.'/'.$resized_image['only_image_name'].'.webp';
    $webp_image   = '{SITE_URL}userfiles/media/templates.microweber.com/'.$thumbnail_width.'/'.$resized_image['only_image_name'].'.webp';
    $activate_compressor = get_option('img_compressor' , 'compressor');

    if(@$activate_compressor == 1 && $activate_compressor != false){
        if (!empty($minimum_size) && $minimum_size < $file_kb_size) {
            $insert = DB::table('media')->where('rel_id',$id)->where('filename',$image)->update([
                'resize_image'=>$resize_image,
                'webp_image'=>$webp_image,
            ]);
            if($export == true){
                DB::table('products')->where('content_id',$id)->update([
                    'image'=>$resize_image,
                ]);
            }
        }
    }else{
        $insert = DB::table('media')->where('rel_id',$id)->where('filename',$image)->update([
            'webp_image'=>$webp_image,
        ]);
    }
}

function live_editor_image_compressed($image){
    // Start product image resize code
    $compress_size  = DB::table('image_optimize')->where('status',5)->first();
    $minimum_size   = DB::table('image_optimize')->where('status',6)->first();
    $main_image_path = $image;

    // get image size
    $ch = curl_init($main_image_path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    $msr = curl_exec($ch);
    $file_byte_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $file_kb_size = round($file_byte_size / 1024,4);
    // end get image size

    $main_image_path = $image;
    $path = explode("/",$main_image_path);
    $image_name = end($path);
    $savePath= public_path('userfiles/media/default/').$image_name;

    $folder= $savePath;
    $data=explode("/",$folder);
    $removed = array_pop($data);
    $dirname=implode("/",$data);

    if (!file_exists($dirname)) {
        mkdir($dirname, 0777, true);
    }

    // Start Webp code
    $explode_image_name = explode(".",$image_name);
    $only_image_name = array_shift($explode_image_name);
    $webp_save_path = public_path('userfiles/media/default/');

    $webp_image = \Intervention\Image\ImageManagerStatic::make($main_image_path)->encode('webp', 100);
    @$webp_image->save($webp_save_path.$only_image_name.'.webp',$compress_size ? $compress_size->live_edit_compress : 100);

    $resize_image = url('/').'/userfiles/media/default/'.$only_image_name.'.webp';
    return  $resize_image;

    // end product image resize code
}


function remote_file_exists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if( in_array($httpCode,[404,403]) ){
        return false;
    }else{
        return true;
    }
}

if (!function_exists('form_layout')) {
    function form_layout()
    {
        try {
            $userToken = Config::get('microweber.userToken');
            $userPassToken = Config::get('microweber.userPassToken');

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'userToken' => $userToken,
                'userPassToken' => $userPassToken
            ])->get('https://drm.software/api/droptienda/getTemplates');

            $data = json_decode($response->body(), true);
            $data = $data['data']['default'] ?? null;

            if (isset($data)) {
                return $data;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return [];
        }
    }
}

function product_tagging_tag()
{
    $tags = DB::table('tagging_tagged')
        ->select('tagging_tagged.tag_name','tagging_tags.id')
        ->join('content', 'tagging_tagged.taggable_id', '=', 'content.id')
        ->join('tagging_tags', 'tagging_tagged.tag_name', '=', 'tagging_tags.name')
        ->where('content.content_type','product')
        ->groupBy('tag_name')
        ->get();
    return $tags;
}

function products_transfer_from_content($id=null){

    $products_ids = array();

    if(isset($id) && !empty($id)){
        $products = App\Models\Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])->where('id',$id)->where('is_deleted',0)->get();
        if(isset($products) && !empty($products)){
            foreach($products as $key => $product){
                $medias = $product->media()->where(function($q) {
                    $q->where('position', 0)
                      ->orWhere('position', NULL)
                      ->orWhere('position',9999999);
                })->first();
                $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
                if ($price) {
                    $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
                }else{
                    $price = 0;
                }
                $tax_type = DB::table('product_details')->where('rel_id',$product->id)->first();
                $quantity = $product->contentData->where('field_name', 'qty')->first()->field_value;
                $new_product = DB::table('products')->updateOrInsert(
                    ['content_id' => $product->id],
                    [
                        'title' => @$product->title,
                        'url' => @$product->url,
                        'image' => @$medias->webp_image ?? $medias->filename ?? '',
                        'price' => @$price,
                        // 'offer_price' => @$product->offer_price,
                        'quantity' => @$quantity,
                        'tax_type' => @$tax_type->tax_type ?? 1,
                    ]
                );
                $product->update([
                    'synced' => 1
                ]);
                $products_ids[$key] = array(
                    'content_id' => $product->id,
                );
            }
        }
    }else{
        $products = App\Models\Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])->where('content_type','product')->where('synced',0)->where('is_deleted',0)->get();
        if(isset($products) && !empty($products)){
            foreach($products as $key => $product){
                $medias = $product->media()->where(function($q) {
                    $q->where('position', 0)
                      ->orWhere('position', NULL)
                      ->orWhere('position',9999999);
                })->first();
                $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
                if ($price) {
                    $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
                }else{
                    $price = 0;
                }
                $quantity = $product->contentData->where('field_name', 'qty')->first()->field_value;
                $tax_type = DB::table('product_details')->where('rel_id',$product->id)->first();
                $new_product = DB::table('products')->updateOrInsert(
                    ['content_id' => $product->id],
                    [
                        'title' => @$product->title,
                        'url' => @$product->url,
                        'image' => @$medias->webp_image ?? $medias->filename ?? '',
                        'price' => @$price,
                        // 'offer_price' => @$product->offer_price,
                        'quantity' => @$quantity,
                        'tax_type' => @$tax_type->tax_type ?? 1,
                    ]
                );
                $product->update([
                    'synced' => 1
                ]);
                $products_ids[$key] = array(
                    'content_id' => $product->id,
                );
            }

        }
    }

}

function generate_categories($categories, $shop_url , $rel_id = false,  $parent_id = false)
{
    if ($rel_id) {
        $html = '<ul class="nav nav-list">' . "\n";
        foreach ($categories as $category) {
            if ($category->rel_id != $rel_id) {
                continue;
            }
            $html .= '<li title="' . $category->title . '" data-category-id="' . $category->id . '" ><a href="' . $shop_url . '/' . $category->url . '" data-category-id="' . $category->id . '" title="' . $category->title . '" >' . $category->title . '</a>' . "\n";
            if ($categories->contains('parent_id', $category->id)) {
                $html .= generate_categories($categories, $shop_url, false, $category->id);
            }
            $html .= ' </li>' . "\n";
        }
        $html .= '</ul>' . "\n";
    } elseif ($parent_id) {
        $html = '<ul data-category-id="' . $parent_id . '" class="nav nav-list  category-item-' . $parent_id . '">' . "\n";
        foreach ($categories as $category) {
            if ($category->parent_id != $parent_id) {
                continue;
            }
            $html .= '<li title="' . $category->title . '" data-category-id="' . $category->id . '" data-category-parent-id="' . $parent_id . '"><a href="' . $shop_url . '/' . $category->url . '" data-category-id="' . $category->id . '" data-category-parent-id="' . $parent_id . '" title="' . $category->title . '" >' . $category->title . '</a>' . "\n";
            if ($categories->contains('parent_id', $category->id)) {
                $html .= generate_categories($categories, $shop_url, false, $category->id);
            }
            $html .= ' </li>' . "\n";
        }
        $html .= '</ul>' . "\n";
    }
    return ($html);
}

function generate_categories_admin($categories, $shop_url , $rel_id = false,  $parent_id = false, $dept = 0, $shop, $diableStatus=false)
{
    if ($rel_id) {
        $html = '<ul class="mw-ui-category-tree">' . "\n";
        foreach ($categories as $category) {
            $dept = 0;
            if ($category->rel_id != $rel_id) {
                continue;
            }
            $print = '';
            $value = 0;
            if($category->status == 0){
                $print = 'checked';
                $value = 1;
            }
            $html .= '<li title="'.$category->title.'" data-category-id="' . $category->id . '" class="sub-nav depth-'.$dept.' first sub-nav"><span class="category_element mw-ui-category-tree-row" value="' . $category->id . '"><span value="' . $category->id . '" class="mdi mdi-folder text-muted mdi-18px mr-2" style="cursor: move"></span>&nbsp;'.$category->title.'<span class="btn btn-outline-primary btn-sm" onclick="mw.quick_cat_edit(' . $category->id . ')"><span>Bearbeiten</span> </span> <span class=" mr-1 btn btn-outline-danger btn-sm" onclick="event.stopPropagation();event.preventDefault();mw.quick_cat_delete(' . $category->id . ')">Löschen</span>';
            if($shop == true){
                $html .= '<label class="toggleSwitch german-toggle cat-toggle"><input type="checkbox" onclick="mw.categoryHideOnOff(' . $category->id . ');" class="category_hide_on_off category_hide_on_off' . $category->id . '" ' . $print . ' value="' . $value . '" name="category_hide_on_off" id="category_hide_on_off" data-id="' . $category->id . '"><span class="slider round"></span><span><span>Anzeigen</span><span>Ausblenden</span></span><a></a></label></span>';
            }

            if ($categories->contains('parent_id', $category->id)) {
                $html .= generate_categories_admin($categories, $shop_url, false, $category->id, 0, $shop);
            }
            $html .= ' </li>';
        }
        $html .= '</ul>';
    } elseif ($parent_id) {

        $html = '<ul data-category-id="' . $parent_id . '" class=" depth-'.$dept.' category-item-' . $parent_id . '">';
        foreach ($categories as $category) {
            if ($category->parent_id != $parent_id) {
                continue;
            }
            $print = '';
            $value = 0;
            $disabled = '';
            if($category->status == 0){
                $print = 'checked';
                $value = 1;
                $disabled = 'disabled';
            }
            $html .= '<li title="'.$category->title.'" data-category-id="' . $category->id . '" data-category-parent-id="' . $category->parent_id . '" class="sub-nav depth-'.$dept.' first sub-nav"><span class="category_element mw-ui-category-tree-row" value="' . $category->id . '"><span value="' . $category->id . '" class="mdi mdi-folder text-muted mdi-18px mr-2" style="cursor: move"></span>&nbsp;'.$category->title.'<span class="btn btn-outline-primary btn-sm" onclick="mw.quick_cat_edit(' . $category->id . ')"><span>Bearbeiten</span> </span> <span class=" mr-1 btn btn-outline-danger btn-sm" onclick="event.stopPropagation();event.preventDefault();mw.quick_cat_delete(' . $category->id . ')">Löschen</span>';
            if($shop == true){
                $html .= '<label class="toggleSwitch german-toggle cat-toggle"><input type="checkbox" onclick="mw.categoryHideOnOff(' . $category->id . ');" class="category_hide_on_off category_hide_on_off' . $category->id . '" ' . $print . ' ' . $diableStatus . ' value="' . $value . '"  name="category_hide_on_off" id="category_hide_on_off" data-id="' . $category->id . '"><span class="slider round"></span><span><span>Anzeigen</span><span>Ausblenden</span></span><a></a></label></span>';
            }
            if ($categories->contains('parent_id', $category->id)) {
                $html .= generate_categories_admin($categories, $shop_url, false, $category->id, $dept++, $shop, $disabled);
            }
            $html .= ' </li>';
        }
        $html .= '</ul>';
    }
    return ($html);
}


function generate_shop_categories_admin($categories, $shop_url , $rel_id = false,  $parent_id = false, $dept = 0, $shop, $diableStatus=false)
{
    if ($rel_id) {
        $html = '<ul class="mw-ui-category-tree">' . "\n";
        foreach ($categories as $category) {
            $dept = 0;
            if ($category->rel_id != $rel_id) {
                continue;
            }
            $print = '';
            $value = 0;
            if($category->status == 0){
                $print = 'checked';
                $value = 1;
            }
            $has_child = DB::table('categories')
                        ->where('is_deleted',0)
                        ->whereNotNull('title')
                        ->where('parent_id', $category->id)
                        ->first();
            if(isset($has_child)){
                $icon = '<span><i class="fa fa-plus-square mr-2" aria-hidden="true" onclick="child_category(' . $category->id . ')" id="expand-cat-' . $category->id . '"></i></span>';
            } else{
                $icon = '<span><i class="fa fa-plus-square mr-2 invisible" aria-hidden="true" onclick="child_category(' . $category->id . ')" id="expand-cat-' . $category->id . '"></i></span>';
            }
            $html .= '<li title="'.$category->title.'" data-category-id="' . $category->id . '" class="sub-nav depth-'.$dept.' first sub-nav '. $category->id . '"><span class="category_element mw-ui-category-tree-row" value="' . $category->id . '">' . $icon . '<span value="' . $category->id . '" class="mdi mdi-folder text-muted mdi-18px mr-2" style="cursor: move"></span>&nbsp;'.$category->title.'<span class="btn btn-outline-primary btn-sm" onclick="mw.quick_cat_edit(' . $category->id . ',true)"><span>Bearbeiten</span> </span> <span class=" mr-1 btn btn-outline-danger btn-sm" onclick="event.stopPropagation();event.preventDefault();mw.quick_cat_delete(' . $category->id . ')">Löschen</span>';
            if($shop == true){
                $html .= '<label class="toggleSwitch german-toggle cat-toggle"><input type="checkbox" onclick="mw.categoryHideOnOff(' . $category->id . ');" class="category_hide_on_off category_hide_on_off' . $category->id . '" ' . $print . ' value="' . $value . '" name="category_hide_on_off" id="category_hide_on_off" data-id="' . $category->id . '"><span class="slider round"></span><span><span>Anzeigen</span><span>Ausblenden</span></span><a></a></label></span>';
            }

            $html .= ' </li>';
        }
        $html .= '</ul>';
    }
    elseif ($parent_id) {
        $html = '<ul data-category-id="' . $parent_id . '" class=" depth-'.$dept.' category-item-' . $parent_id . '">';
        foreach ($categories as $category) {
            if ($category->parent_id != $parent_id) {
                continue;
            }
            $print = '';
            $value = 0;
            $disabled = '';
            if($category->status == 0){
                $print = 'checked';
                $value = 1;
                $disabled = 'disabled';
            }
            $has_child = DB::table('categories')
                        ->where('is_deleted',0)
                        ->whereNotNull('title')
                        ->where('parent_id', $category->id)
                        ->first();
            if(isset($has_child)){
                $icon = '<span><i class="fa fa-plus-square mr-2" aria-hidden="true" onclick="child_category(' . $category->id . ')" id="expand-cat-' . $category->id . '"></i></span>';
            } else{
                $icon = '<span><i class="fa fa-plus-square mr-2 invisible" aria-hidden="true" onclick="child_category(' . $category->id . ')" id="expand-cat-' . $category->id . '"></i></span>';
            }
            $html .= '<li title="'.$category->title.'" data-category-id="' . $category->id . '" data-category-parent-id="' . $category->parent_id . '" class="sub-nav depth-'.$dept.' first sub-nav '. $category->id . '"><span class="category_element mw-ui-category-tree-row" value="' . $category->id . '">' . $icon . '<span value="' . $category->id . '" class="mdi mdi-folder text-muted mdi-18px mr-2" style="cursor: move"></span>&nbsp;'.$category->title.'<span class="btn btn-outline-primary btn-sm" onclick="mw.quick_cat_edit(' . $category->id . ',true)"><span>Bearbeiten</span> </span> <span class=" mr-1 btn btn-outline-danger btn-sm" onclick="event.stopPropagation();event.preventDefault();mw.quick_cat_delete(' . $category->id . ')">Löschen</span>';
            if($shop == true){
                $html .= '<label class="toggleSwitch german-toggle cat-toggle"><input type="checkbox" onclick="mw.categoryHideOnOff(' . $category->id . ');" class="category_hide_on_off category_hide_on_off' . $category->id . '" ' . $print . ' ' . $diableStatus . ' value="' . $value . '"  name="category_hide_on_off" id="category_hide_on_off" data-id="' . $category->id . '"><span class="slider round"></span><span><span>Anzeigen</span><span>Ausblenden</span></span><a></a></label></span>';
            }
            $html .= ' </li>';
        }
        $html .= '</ul>';
    }
    return ($html);
}

function faq_new_page($page_id){

    $faq_id = mt_rand(10000000,99999999999);

    $content_field = array(
        [
            "updated_at" => "2019-08-27 07:54:31",
            "created_at" => "2019-08-27 07:54:31",
            "created_by" => "1",
            "edited_by" => "1",
            "rel_type" => "content",
            "rel_id" => $page_id,
            "field" => "sidebar_navigation_page",
            "value" => " <module class=\"module module-layouts\" id=\"module-layouts-$page_id\" data-mw-title=\"Layouts\" template=\"faq-heading-default\" data-type=\"layouts\" parent-module=\"layouts\" parent-module-id=\"module-layouts-$page_id\"></module>\r\n\r\n"
        ],
        [
            "updated_at" => "2019-08-27 07:54:31",
            "created_at" => "2019-08-27 07:54:31",
            "created_by" => "1",
            "edited_by" => "1",
            "rel_type" => "module",
            "rel_id" => "0",
            "field" => "layout-faq-heading-default-module-layouts-".$page_id,
            "value" => "\r\n<div class=\"container element\" id=\"element_1645357259378\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"faq-heading-wrapper element\" id=\"element_1645357259401\">\r\n                    <div class=\"faq-heading-header element\" id=\"element_1645357259370\">\r\n                        <h3 class=\"element\" id=\"element_1645357259418\">HIER KANNST DU EINEN TITEL (PASSEND ZUM THEMA EINGEBEN)</h3>\r\n                    </div>\r\n                    <div class=\"faq-heading-image element\" id=\"element_1645357259527\">\r\n                        <img src=\"{SITE_URL}userfiles/elements/images/faq-heading.jpg\" alt=\"\">\r\n</div>\r\n                </div>\r\n\r\n                <div class=\"faq-heading-content element\" id=\"element_1645357259557\">\r\n                    <p class=\"element\" id=\"element_1645357259372\">\r\n                    Hier kannst du noch eine passende Beschreibung eingeben.\r\n                    <br>\r\n                    Diese kannst du auch oben im Werkzeugkasten bearbeiten.\r\n                    </p>\r\n<module class=\"module module-faq\" data-mw-title=\"FAQ\" data-type=\"faq\" id=\"faq-$faq_id\" parent-module=\"faq\" parent-module-id=\"faq-$faq_id\"></module>\r\n</div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n"
        ]
    );

    DB::table('content_fields')->insert($content_field);


    $module_id = 'faq-'.$faq_id;
    $faq_all_questions = (get_option('settings',$module_id)) ? get_option('settings',$module_id) : get_option('settings','faq');
    if($faq_all_questions){
        $json = json_decode($faq_all_questions);
    }else{
        $json = [];
    }

    $newd = "[{\"question\":\"Hier kannst du deine 1. Frage eingeben\",\"answer\":\"Hier kannst du deine 1. Antwort eingeben\",\"page_id\":\"$page_id\",\"module_id\":\"$module_id\"},{\"question\":\"Hier kannst du deine 2. Frage eingeben\",\"answer\":\"Hier kannst du deine 2. Anttwort eingeben\",\"page_id\":\"$page_id\",\"module_id\":\"$module_id\"},{\"question\":\"Hier kannst du deine 3. Frage eingeben\",\"answer\":\"Hier kannst du deine 3. Antwort eingeben\",\"page_id\":\"$page_id\",\"module_id\":\"$module_id\"}]";
    $new_data = json_decode($newd);

    $json = json_encode(array_merge($json,$new_data));
    $options = array(
        [
            "option_key" => "settings",
            "option_value" => $json,
            "option_group" => "faq-".$faq_id,
            "module" => "faq",
        ],
        [
            "option_key" => "module-layouts-".$page_id,
            "option_value" => "HIER KANNST DU EINEN TITEL (PASSEND ZUM THEMA EINGEBEN)",
            "option_group" => "sidebar-nav-module-list-".$page_id,
            "module" => "",

        ]
    );

    DB::table('options')->insert($options);
    DB::table('options')
    ->updateOrInsert(
        [
            "option_group" => "faq",
            "module" => "faq"
        ],
        [
            "option_key" => "settings",
            "option_value" => $json,
            "option_group" => "faq",
            "module" => "faq",
        ]);

        mw()->update->post_update();
}

function reorder_existing_position(){

    $existing_positions = DB::table('content')->select('id','position')->get();
    foreach($existing_positions as $pos){
        if(isset($pos->position)){
            $existing_positions = DB::table('content')->select('position','id')->where('content_type','product')->where('position',$pos->position)->get();
            if($existing_positions->count() > 1){
                foreach($existing_positions as $pos){
                    $new_position = DB::table('content')->max('position')+1;
                    DB::table('content')->where('id',$pos->id)->update(
                        [
                            'position' => $new_position,
                        ]
                    );
                }
            }
        }else{
            $new_position = DB::table('content')->max('position')+1;

            DB::table('content')->where('id',$pos->id)->update(
                [
                    'position' => $new_position,
                ]
            );
        }
    }
}

function update_product_table($p_id){
    if(isset($p_id) && !empty($p_id)){
        $products = App\Models\Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])->where('id',$p_id)->where('is_deleted',0)->get();
        if(isset($products) && !empty($products)){
            foreach($products as $key => $product){
                $medias = $product->media()->where(function($q) {
                    $q->where('position', 0)
                      ->orWhere('position', NULL)
                      ->orWhere('position',9999999);
                })->first();
                $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
                if ($price) {
                    $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
                }else{
                    $price = 0;
                }
                $tax_type = DB::table('product_details')->where('rel_id',$product->id)->first();
                $quantity = $product->contentData->where('field_name', 'qty')->first()->field_value;
                DB::table('products')->updateOrInsert(
                    ['content_id' => $product->id],
                    [
                        'title' => @$product->title,
                        'url' => @$product->url,
                        'image' => @$medias->webp_image ?? $medias->filename ?? '',
                        'price' => @$price,
                        // 'offer_price' => @$product->offer_price,
                        'quantity' => @$quantity,
                        'tax_type' => @$tax_type->tax_type ?? 1,
                    ]
                );
                $product->update([
                    'synced' => 1
                ]);
                $products_ids[$key] = array(
                    'content_id' => $product->id,
                );
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }
}
function deleteDir($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDir($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

function CssElementKeys($attribute, $str=null){
    if($str==null){
        $active_site_template = mw()->app->option_manager->get('current_template', 'template');
        $live_edit_css_folder = userfiles_path().'css'.DS.$active_site_template;
        $custom_live_edit = $live_edit_css_folder.DS.'live_edit.css';
        if (file_exists($custom_live_edit)) {
            $str = trim(file_get_contents($custom_live_edit));
        }else{
            $str = '';
        }

    }
    $substring = string_between_two_string($str, $attribute, "}");
    $selector = 'default';
    if($substring){
        $newSub = explode('{',$substring);
        if(!empty($newSub)){
            $selector = trim($newSub[0]);
            if(!$selector){
                $selector = 'default';
            }
            $substring = $newSub[1];
        }
    }
    $elements = explode(";",trim($substring));
    $elements['selector'] = $selector;
    return array_filter($elements);
}

function string_between_two_string($str, $starting_word, $ending_word){
	$arr = explode($starting_word, $str);
	if (isset($arr[1])){
		$arr = explode($ending_word, $arr[1]);
		return $arr[0];
	}
	return '';
}

function cssToArray($str){
    $index = array();
    $value = array();
    $str = trim($str);
    $newStr = preg_replace(['/\s\s+/', '/\n/'], '',$str);
    $elementArray = array_filter(explode('}',$newStr));
    foreach($elementArray as $ele){
        $first = strtok($ele, '{');
        $index[] = $first;
        $cssElementStr = str_replace($first.'{','',$ele);
        $eleArray = array_filter(explode(';',$cssElementStr));
        $attr = array();
        $val = array();
        foreach($eleArray as $newEle){
            $attrVal = explode(':',$newEle);
            $attr[] = $attrVal[0];
            $val[$attrVal[0]] = $attrVal[1];
            if(is_countable($attrVal) && count($attrVal)>2){
                $val[$attrVal[0]] =implode(':', array_slice($attrVal, 1));
            }
        }
        if(!isset($value[$first])){
            $value[$first] = $val;
        }
    }
    return ['indexs' => $index, 'values' => $value];
}

function generateNewCSS($oldCSS, $newCSS){
    $newCSS = cssToArray($newCSS)['values'];
    $oldCSS = cssToArray($oldCSS)['values'];
    $mergerdCss = array_diff_key($oldCSS,$newCSS);
    if(!empty($mergerdCss)){
        $newCSS = array_merge($newCSS,$mergerdCss);
    }
    $styleSheet = '';
    foreach($newCSS as $key => $css){
        $str = '';
        if(isset($newCSS[$key]) && isset($oldCSS[$key])){
            $diff = array_diff_key($oldCSS[$key],$newCSS[$key]);
            if(!empty($diff)){
                $newCSS[$key] = array_merge($diff,$newCSS[$key]);
                foreach($newCSS[$key] as $strKey => $strAdd){
                    $str .= "\t".$strKey.':'.$strAdd.';'."\n";
                }
            }else{
                foreach($newCSS[$key] as $strKey => $strAdd){
                    $str .= "\t".$strKey.':'.$strAdd.';'."\n";
                }
            }
        }else if(isset($newCSS[$key])){
            foreach($newCSS[$key] as $strKey => $strAdd){
                $str .= "\t".$strKey.':'.$strAdd.';'."\n";
            }
        }
        $styleSheet .= $key.'{'."\n".$str."\n".'}'."\n";


    }
    // dd($styleSheet);
    return $styleSheet;
}

function pricingCardString($params,$interval_information,$card_limit_quantity,$active_card_number,$table_limit_quantity,$table_readmore_limit){
    if(is_admin()){
        cache_delete('pricingCardString');

        $strForCache = '';

        $strForCache .= '<div class="">';
        $strForCache .= '<div class="row">';
        $strForCache .= '<div class="col-xl-12">';
        $strForCache .= '<div class="row text-center">';
        $strForCache .= '<div class="col-12 edit allow-drop " field="pricing_card_heading_title_'.$params["id"].'" rel="content" >';
        $strForCache .= '<h2 class="hr">See our plans</h2>';
        $strForCache .= '</div>';
        $strForCache .= '</div>';
        $strForCache .= '<div class="container">';
        $strForCache .= '<div class="row">';
        $strForCache .= '<div class="col-md-12">';
        $strForCache .= '<div class="pricing-radio-top">';
        $strForCache .= '<ul class="pricing-ultra-colloction">';
        if(get_option('initial_intervel_on_off','pricing_interval_'.$params['id']) == 'on'):
            $strForCache .= '<li class="pricing-collection-item">';
            $strForCache .= '<div class="edit allow-drop " field="initial_interval_'.$params['id'].'" rel="content" >';
            $strForCache .= '<label for="Zahlungsintervall">Zahlungsintervall</label><br>';
            $strForCache .= '</div>';
            $strForCache .= '</li>';
        endif;
        if($interval_information):
            foreach($interval_information as $single_interval):
                $strForCache .= '<li class="pricing-collection-item">';
                $strForCache .= '<input type="radio" id="step-'.$single_interval->option_key.'-btn-'.$params['id'].'" name="pricing-step-'.$params['id'].'" value="step_'.$single_interval->option_key.'">';
                $strForCache .= '<div class="plan-card-titile">';
                $strForCache .= '<div>';
                $strForCache .= '<label for="Jahreszahlung">'.$single_interval->option_value;
                $strForCache .= '</label>';
                if($single_interval->option_value2):
                    $strForCache .= '<div class="pricing-perc">';
                    $strForCache .= '<span> -'.$single_interval->option_value2.'%</span>';
                    $strForCache .= '</div>';
                endif;
                $strForCache .= '</div>';
                $strForCache .= '</div>';
                $strForCache .= '<br>';
                $strForCache .= '</li>';
            endforeach;
        endif;
        $strForCache .= '</ul>';
        $strForCache .= '</div>';
        $strForCache .= '</div>';
        $strForCache .= '</div>';
        $strForCache .= '</div>';
        $strForCache .= '</div>';
        $strForCache .= '</div>';
        if($interval_information):
            foreach($interval_information as $single_interval):
                $i = $single_interval->option_key;
                $interval_discount_value = (isset($single_interval->option_value2) && $single_interval->option_value2 != "") ? $single_interval->option_value2 : 0;
                $discount_price = 10 - ((10*$interval_discount_value)/100);
                $strForCache .= '<div class="step-'.$i.'-div-'.$params['id'].'" style="display:none;">';
                $strForCache .= '<div class="row">';
                $strForCache .= '<div class="col-xl-12">';
                $strForCache .= '<div class="row pricing-list-new d-flex justify-content-center pricing-card">';
                if($card_limit_quantity):
                    for($k=1; $k <=$card_limit_quantity; $k++):
                        $strForCache .= '<div class="col-sm-6 col-lg-3 allow-drop">';
                        $pricing_card_active_color = '';
                        if($active_card_number == $k):
                            $pricing_card_active_color = 'pricing-card-active-color';
                        endif;
                        $strForCache .= '<div class="plan '.$pricing_card_active_color.'">';
                        $strForCache .= '<div class="heading edit  allow-drop  parent-heading parent-heading-'.$i.$k.'" data-id="'.$i.$k.'" field="card_heading_'.$i.$k.'_'.$params['id'].'" rel="content">';
                        $strForCache .= '<p class="">Early Bird</p>';
                        $strForCache .= '<div class="price">';
                        $strForCache .= '<h1 class="sum ">'.$discount_price.'</h1>';
                        $strForCache .= '<h3 class="period ">EUR/Per month</h3>';
                        $strForCache .= '</div>';
                        $strForCache .= '<div class="element button-holder">';
                        $strForCache .= '<module type="btn" template="bootstrap" button_style="btn-outline-primary" button_size="btn-sm btn-block" class="" button_text="Purchase Now"/>';
                        $strForCache .= '</div>';
                        $strForCache .= '</div>';
                        $strForCache .= '<div class="description edit allow-drop" field="card_description_'.$i.$k.'_'.$params['id'].'" rel="content">';
                        $strForCache .= '<p>It is a long established fact that a reader will be distracted by the readable content of a page when.</p>';
                        $strForCache .= '</div>';
                        $strForCache .= '</div>';
                        $strForCache .= '</div>';
                    endfor;
                endif;
                $strForCache .= '</div>';
                $strForCache .= '</div>';
                $strForCache .= '</div>';
                $strForCache .= '</div>';
            endforeach;

            $strForCache .= '<div class="ultra-accordio-section">';
            $strForCache .= '<div class="row">';
            if($card_limit_quantity):
                $strForCache .= '<div class="col-md-12">';
                $strForCache .= '<div class="ultra-acc-top">';
                $strForCache .= '<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>';
                $strForCache .= '<h2 class="edit " id="ultra-toggle-btn-'.$params['id'].'" field="ultra_toggle_btn_'.$params['id'].'" rel="content"> Merkmale für alle Pläne ausblenden</h2>';
                $strForCache .= '</div>';
                $strForCache .= '<div class="pricing-table-wrapper" id="ultra-toggle-table-'.$params['id'].'" style="display:none;">';
                $strForCache .= '<div class="main-table">';
                $strForCache .= '<table class="marketing-table">';
                $strForCache .= '<thead>';
                if($interval_information):
                    foreach($interval_information as $single_interval):
                        $interval_discount_value = (isset($single_interval->option_value2) && $single_interval->option_value2 != "") ? $single_interval->option_value2 : 0;
                        $discount_price = 10 - ((10*$interval_discount_value)/100);
                        $i = $single_interval->option_key;
                        $strForCache .= '<tr class="first-tr step-'.$i.'-div-'.$params['id'].'" style="display:none;">';
                        $strForCache .= '<th class="ultra-th ultra-th-empty"></th>';
                        for($k=1; $k <=$card_limit_quantity; $k++):
                            $pricing_card_active_color = '';
                            if($active_card_number == $k):
                                $pricing_card_active_color = 'pricing-card-active-color';
                            endif;
                            $strForCache .= '<th class="ultra-th allow-drop '.$pricing_card_active_color.'">';
                            $strForCache .= '<div class="col-12 allow-drop">';
                            $strForCache .= '<div class="plan">';
                            $strForCache .= '<div class="heading edit allow-drop child-heading child-heading-'.$i.$k.'" data-id="'.$i.$k.'" field="card_heading_'.$i.$k.'_'.$params['id'].'" rel="content">';
                            $strForCache .= '<p class="">Early Bird</p>';
                            $strForCache .= '<div class="price">';
                            $strForCache .= '<h1 class="sum ">'.$discount_price.'</h1>';
                            $strForCache .= '<h3 class="period ">EUR/Per month</h3>';
                            $strForCache .= '</div>';
                            $strForCache .= '<div class="element button-holder">';
                            $strForCache .= '<module type="btn" template="bootstrap" button_style="btn-outline-primary" button_size="btn-sm btn-block" class="" button_text="Purchase Now"/>';
                            $strForCache .= '</div>';
                            $strForCache .= '</div>';
                            $strForCache .= '</div>';
                            $strForCache .= '</div>';
                            $strForCache .= '</th>';
                        endfor;
                        $strForCache .= '</tr>';
                    endforeach;
                endif;
                $strForCache .= '</thead>';
                if($table_limit_quantity):
                    $column_default_value = "Test Content";
                    for($i=1; $i <= $table_limit_quantity; $i++):
                        $table_row_limit_quantity = get_option('table_'.$i.'_'.$params['id'],'pricing_table_row_limit_quantity');
                        $tr_serial_array=[];
                        if($i){
                            $dataSerial = DB::table('pricing_table_serial')->where('table_serial',$i)->where('table_layouts',$params['id'])->first();
                            if($dataSerial != null){
                                $dataSerial = json_decode($dataSerial->table_data);
                                foreach($dataSerial as $data){
                                    $tr_serial = explode("_",$data);
                                    $tr_serial_array[] = (int)$tr_serial[1];
                                }
                            }

                        }
                        if($table_row_limit_quantity):
                            $strForCache .= '<tr class="pricing-table-heading-tr">';
                            $strForCache .= '<td class="pricing-table-heading" colspan="'.($card_limit_quantity+1).'">';
                            $strForCache .= '<div class="edit allow-drop" field="table_heading_'.$i.'_'.$params['id'].'" rel="content">';
                            $strForCache .= '<h4 class="tr-highlight">TSE / KassenSichV (pro POS-Standort)</h4>';
                            $strForCache .= '<p>OnlineshopEinschließlich E-Commerce-Website und Blog.</p>';
                            $strForCache .= '</div>';
                            $strForCache .= '</td>';
                            $strForCache .= '</tr>';
                            $strForCache .= '<tbody class="pricing-table-body pricing-table-body-'.$i.'">';
                            $total_row = range(1, $table_row_limit_quantity);
                            uksort($total_row,function ($a, $b) use ($tr_serial_array) {
                            foreach($tr_serial_array as $key => $value){
                                if($a==$value){
                                    return 0;
                                    break;
                                }
                                if($b==$value){
                                    return 1;
                                    break;
                                    }
                                }
                            });


                            // for($j=1;$j<=$table_row_limit_quantity;$j++):
                            foreach($total_row  as $key =>$value) { $j=$key;
                                $class = '';
                                if($j>$table_readmore_limit && $table_readmore_limit != 'off'):
                                    $class = 'class="tbl_row_4 table-row-hide-'.$i.'" style="display:none"';
                                endif;

                                $strForCache .= '<tr '.$class.' data-serial="'.$i.'_'.$j.'_'.$params["id"].'">';
                                $strForCache .= '<td class="sort-icon-wrapper">';
                                $strForCache .= '<div class="row-heading">';
                                $strForCache .= '<div class="row-description edit allow-drop" field="table_row_heading_'.$i.$j.'_'.$params['id'].'" rel="module">';
                                $strForCache .= '<p>Unbegrenzte Produkte</p>';
                                $strForCache .= '</div>';
                                $strForCache .= '<div class="row-icon">';
                                $description_popup_id = 'row_description_'.$i.$j.'_'.$params['id'];
                                if(get_option('row_popup_on_off',$description_popup_id) == 'on'):
                                    $strForCache .= '<i class="fa fa-info-circle row-icon-des-info" onclick="description_show_modal(`'.$description_popup_id.'`);"> </i>';
                                endif;
                                if(is_live_edit()):
                                    $strForCache .= '<span class="layout-edit-icon" onclick="description_set_modal(`'.$description_popup_id.'`)">Description Popup <i class="fa fa-pencil-square" aria-hidden="true"></i></span>';
                                endif;
                                $strForCache .= '</div>';
                                $strForCache .= '</div>';
                                $strForCache .= '<span class="sort-icon">';
                                $strForCache .= '<i class="fa fa-arrows" aria-hidden="true"></i>';
                                $strForCache .= '</span>';
                                $strForCache .= '</td>';
                                if($card_limit_quantity):
                                    for($k=1; $k <=$card_limit_quantity; $k++):
                                        $strForCache .= '<td class="td-check">';
                                        $strForCache .= '<div class="edit allow-drop" field="table_specific_column_serial_'.$i.$j.$k.'_'.$params['id'].'" rel="content">';
                                        $strForCache .= '<p>'.$column_default_value.'</p>';
                                        $strForCache .= '</div>';
                                        $strForCache .= '</td>';
                                    endfor;
                                endif;
                                $strForCache .= '</tr>';
                            }
                            $strForCache .= '</tbody>';
                            if($table_readmore_limit && $table_row_limit_quantity > $table_readmore_limit):
                                $strForCache .= '<tr class="readmore-td">';
                                $strForCache .= '<td colspan="'.($card_limit_quantity+1).'">';
                                $strForCache .= '<div class="readmore-icon" onclick="table_row_readmore_option('.$i.');">';
                                $strForCache .= '<div class="readmore-icon-show-'.$i.'">';
                                $strForCache .= '<span class="readmore-icon-text">'._e(`Read More`,true).'</span>';
                                $strForCache .= '<i class="fa fa-angle-double-down" aria-hidden="true"></i>';
                                $strForCache .= '</div>';
                                $strForCache .= '<div class="readless-icon-show-'.$i.'" style="display:none;">';
                                $strForCache .= '<span class="readmore-icon-text">'._e(`Read More`,true).'</span>';
                                $strForCache .= '<i class="fa fa-angle-double-up" aria-hidden="true"></i>';
                                $strForCache .= '</div>';
                                $strForCache .= '</div>';
                                $strForCache .= '</td>';
                                $strForCache .= '</tr>';
                            endif;
                        endif;
                        $strForCache .= '<script>function table_row_readmore_option(index_number){if ($("tbody.table-row-allShow.pricing-table-body-"+index_number).length > 0) {$("tbody.pricing-table-body-"+index_number).removeClass("table-row-allShow");$(".readmore-icon-show-"+index_number).show();$(".readless-icon-show-"+index_number).hide();}else{$("tbody.pricing-table-body-"+index_number).addClass("table-row-allShow");$(".readmore-icon-show-"+index_number).hide();$(".readless-icon-show-"+index_number).show();}}</script>';
                    endfor;
                    $pricing_card_table_row_description_value = api_url("pricing_card_table_row_description_value");
                    $strForCache .= <<<EOD
                                    <script>
                                    function description_set_modal(row_description_id){
                                        $("#description_popup_id").val(row_description_id);
                                        $.ajax({
                                            type: "POST",
                                            url: "$pricing_card_table_row_description_value",
                                            data:{ row_description_id },
                                            success: function(response) {
                                                if(response.message["on_off"] == "on"){
                                                    $("#pricing-card-table-row-description-show-hide").prop("checked",true);
                                                    CKEDITOR.instances.row_description.setData(response.message["value"]);
                                                    $("#pricing_card_description_add_for_table_row").modal("show");
                                                }else{
                                                    $("#pricing-card-table-row-description-show-hide").prop("checked",false);
                                                    CKEDITOR.instances.row_description.setData(" ");
                                                    $("#pricing_card_description_add_for_table_row").modal("show");
                                                }
                                            }
                                        });
                                    }
                                    function description_show_modal(row_description_id){
                                        $.ajax({
                                            type: "POST",
                                            url: "$pricing_card_table_row_description_value",
                                            data:{ row_description_id },
                                            success: function(response) {
                                                $("#row_description_value").html(response.message["value"]);
                                                $("#pricing_card_row_description_show").modal("show");
                                            }
                                        });
                                    }
                                    </script>
                                    EOD;
                endif;
                $strForCache .= '</table>';
                $strForCache .= '</div>';
                $strForCache .= '</div>';
                if($table_readmore_limit != 'off'):
                    $strForCache .= '<style>tbody.pricing-table-body tr {display: none !important;}';
                    for($i=1; $i <=$table_readmore_limit; $i++):
                        $strForCache .= 'tbody.pricing-table-body tr:nth-child('.$i.') {display: table-row !important;}';
                    endfor;
                    $strForCache .= 'tbody.pricing-table-body.table-row-allShow tr {display: table-row !important;}';
                    $strForCache .= '</style>';
                endif;
                $strForCache .= '</div>';
            else:
                $strForCache .= '<div class="col-md-12">';
                $strForCache .= '<div class="pricing-layout-alert">';
                $strForCache .= '<h2>'._e("Please add pricing plans from pricing card edit",true).'!</h2>';
                $strForCache .= '</div>';
                $strForCache .= '</div>';
            endif;
            $strForCache .= '</div>';
            $strForCache .= '</div>';
        else:
            $strForCache .= '<div class="col-md-12">';
            $strForCache .= '<div class="pricing-layout-alert">';
            $strForCache .= '<h2>'. _e("Please add pricing card interval and pricing plans from pricing card edit",true).'!</h2>';
            $strForCache .= '</div>';
            $strForCache .= '</div>';
        endif;

        $strForCache .= '</div>';
        cache_save(str_replace('Description Popup <i class="fa fa-pencil-square" aria-hidden="true"></i>','',$strForCache), 'pricingCardString', 'pricingCardString');
    }else{
        $strForCache = cache_get('pricingCardString', 'pricingCardString');
        if(!$strForCache){
            $strForCache = '';

            $strForCache .= '<div class="">';
            $strForCache .= '<div class="row">';
            $strForCache .= '<div class="col-xl-12">';
            $strForCache .= '<div class="row text-center">';
            $strForCache .= '<div class="col-12 edit allow-drop " field="pricing_card_heading_title_'.$params["id"].'" rel="content" >';
            $strForCache .= '<h2 class="hr">See our plans</h2>';
            $strForCache .= '</div>';
            $strForCache .= '</div>';
            $strForCache .= '<div class="container">';
            $strForCache .= '<div class="row">';
            $strForCache .= '<div class="col-md-12">';
            $strForCache .= '<div class="pricing-radio-top">';
            $strForCache .= '<ul class="pricing-ultra-colloction">';
            if(get_option('initial_intervel_on_off','pricing_interval_'.$params['id']) == 'on'):
                $strForCache .= '<li class="pricing-collection-item">';
                $strForCache .= '<div class="edit allow-drop " field="initial_interval_'.$params['id'].'" rel="content" >';
                $strForCache .= '<label for="Zahlungsintervall">Zahlungsintervall</label><br>';
                $strForCache .= '</div>';
                $strForCache .= '</li>';
            endif;
            if($interval_information):
                foreach($interval_information as $single_interval):
                    $strForCache .= '<li class="pricing-collection-item">';
                    $strForCache .= '<input type="radio" id="step-'.$single_interval->option_key.'-btn-'.$params['id'].'" name="pricing-step-'.$params['id'].'" value="step_'.$single_interval->option_key.'">';
                    $strForCache .= '<div class="plan-card-titile">';
                    $strForCache .= '<div>';
                    $strForCache .= '<label for="Jahreszahlung">'.$single_interval->option_value;
                    $strForCache .= '</label>';
                    if($single_interval->option_value2):
                        $strForCache .= '<div class="pricing-perc">';
                        $strForCache .= '<span> -'.$single_interval->option_value2.'%</span>';
                        $strForCache .= '</div>';
                    endif;
                    $strForCache .= '</div>';
                    $strForCache .= '</div>';
                    $strForCache .= '<br>';
                    $strForCache .= '</li>';
                endforeach;
            endif;
            $strForCache .= '</ul>';
            $strForCache .= '</div>';
            $strForCache .= '</div>';
            $strForCache .= '</div>';
            $strForCache .= '</div>';
            $strForCache .= '</div>';
            $strForCache .= '</div>';
            if($interval_information):
                foreach($interval_information as $single_interval):
                    $i = $single_interval->option_key;
                    $interval_discount_value = (isset($single_interval->option_value2) && $single_interval->option_value2 != "") ? $single_interval->option_value2 : 0;
                    $discount_price = 10 - ((10*$interval_discount_value)/100);
                    $strForCache .= '<div class="step-'.$i.'-div-'.$params['id'].'" style="display:none;">';
                    $strForCache .= '<div class="row">';
                    $strForCache .= '<div class="col-xl-12">';
                    $strForCache .= '<div class="row pricing-list-new d-flex justify-content-center pricing-card">';
                    if($card_limit_quantity):
                        for($k=1; $k <=$card_limit_quantity; $k++):
                            $strForCache .= '<div class="col-sm-6 col-lg-3 allow-drop">';
                            $pricing_card_active_color = '';
                            if($active_card_number == $k):
                                $pricing_card_active_color = 'pricing-card-active-color';
                            endif;
                            $strForCache .= '<div class="plan '.$pricing_card_active_color.'">';
                            $strForCache .= '<div class="heading edit  allow-drop  parent-heading parent-heading-'.$i.$k.'" data-id="'.$i.$k.'" field="card_heading_'.$i.$k.'_'.$params['id'].'" rel="content">';
                            $strForCache .= '<p class="">Early Bird</p>';
                            $strForCache .= '<div class="price">';
                            $strForCache .= '<h1 class="sum ">'.$discount_price.'</h1>';
                            $strForCache .= '<h3 class="period ">EUR/Per month</h3>';
                            $strForCache .= '</div>';
                            $strForCache .= '<div class="element button-holder">';
                            $strForCache .= '<module type="btn" template="bootstrap" button_style="btn-outline-primary" button_size="btn-sm btn-block" class="" button_text="Purchase Now"/>';
                            $strForCache .= '</div>';
                            $strForCache .= '</div>';
                            $strForCache .= '<div class="description edit allow-drop" field="card_description_'.$i.$k.'_'.$params['id'].'" rel="content">';
                            $strForCache .= '<p>It is a long established fact that a reader will be distracted by the readable content of a page when.</p>';
                            $strForCache .= '</div>';
                            $strForCache .= '</div>';
                            $strForCache .= '</div>';
                        endfor;
                    endif;
                    $strForCache .= '</div>';
                    $strForCache .= '</div>';
                    $strForCache .= '</div>';
                    $strForCache .= '</div>';
                endforeach;

                $strForCache .= '<div class="ultra-accordio-section">';
                $strForCache .= '<div class="row">';
                if($card_limit_quantity):
                    $strForCache .= '<div class="col-md-12">';
                    $strForCache .= '<div class="ultra-acc-top">';
                    $strForCache .= '<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>';
                    $strForCache .= '<h2 class="edit " id="ultra-toggle-btn-'.$params['id'].'" field="ultra_toggle_btn_'.$params['id'].'" rel="content"> Merkmale für alle Pläne ausblenden</h2>';
                    $strForCache .= '</div>';
                    $strForCache .= '<div class="pricing-table-wrapper" id="ultra-toggle-table-'.$params['id'].'" style="display:none;">';
                    $strForCache .= '<div class="main-table">';
                    $strForCache .= '<table class="marketing-table">';
                    $strForCache .= '<thead>';
                    if($interval_information):
                        foreach($interval_information as $single_interval):
                            $interval_discount_value = (isset($single_interval->option_value2) && $single_interval->option_value2 != "") ? $single_interval->option_value2 : 0;
                            $discount_price = 10 - ((10*$interval_discount_value)/100);
                            $i = $single_interval->option_key;
                            $strForCache .= '<tr class="first-tr step-'.$i.'-div-'.$params['id'].'" style="display:none;">';
                            $strForCache .= '<th class="ultra-th ultra-th-empty"></th>';
                            for($k=1; $k <=$card_limit_quantity; $k++):
                                $pricing_card_active_color = '';
                                if($active_card_number == $k):
                                    $pricing_card_active_color = 'pricing-card-active-color';
                                endif;
                                $strForCache .= '<th class="ultra-th allow-drop '.$pricing_card_active_color.'">';
                                $strForCache .= '<div class="col-12 allow-drop">';
                                $strForCache .= '<div class="plan">';
                                $strForCache .= '<div class="heading edit allow-drop child-heading child-heading-'.$i.$k.'" data-id="'.$i.$k.'" field="card_heading_'.$i.$k.'_'.$params['id'].'" rel="content">';
                                $strForCache .= '<p class="">Early Bird</p>';
                                $strForCache .= '<div class="price">';
                                $strForCache .= '<h1 class="sum ">'.$discount_price.'</h1>';
                                $strForCache .= '<h3 class="period ">EUR/Per month</h3>';
                                $strForCache .= '</div>';
                                $strForCache .= '<div class="element button-holder">';
                                $strForCache .= '<module type="btn" template="bootstrap" button_style="btn-outline-primary" button_size="btn-sm btn-block" class="" button_text="Purchase Now"/>';
                                $strForCache .= '</div>';
                                $strForCache .= '</div>';
                                $strForCache .= '</div>';
                                $strForCache .= '</div>';
                                $strForCache .= '</th>';
                            endfor;
                            $strForCache .= '</tr>';
                        endforeach;
                    endif;
                    $strForCache .= '</thead>';
                    if($table_limit_quantity):
                        $column_default_value = "Test Content";
                        for($i=1; $i <= $table_limit_quantity; $i++):
                            $table_row_limit_quantity = get_option('table_'.$i.'_'.$params['id'],'pricing_table_row_limit_quantity');
                            $tr_serial_array=[];
                            if($i){
                                $dataSerial = DB::table('pricing_table_serial')->where('table_serial',$i)->where('table_layouts',$params['id'])->first();
                                if($dataSerial != null){
                                    $dataSerial = json_decode($dataSerial->table_data);
                                    foreach($dataSerial as $data){
                                        $tr_serial = explode("_",$data);
                                        $tr_serial_array[] = (int)$tr_serial[1];
                                    }
                                }

                            }
                            if($table_row_limit_quantity):
                                $strForCache .= '<tr class="pricing-table-heading-tr">';
                                $strForCache .= '<td class="pricing-table-heading" colspan="'.($card_limit_quantity+1).'">';
                                $strForCache .= '<div class="edit allow-drop" field="table_heading_'.$i.'_'.$params['id'].'" rel="content">';
                                $strForCache .= '<h4 class="tr-highlight">TSE / KassenSichV (pro POS-Standort)</h4>';
                                $strForCache .= '<p>OnlineshopEinschließlich E-Commerce-Website und Blog.</p>';
                                $strForCache .= '</div>';
                                $strForCache .= '</td>';
                                $strForCache .= '</tr>';
                                $strForCache .= '<tbody class="pricing-table-body pricing-table-body-'.$i.'">';
                                $total_row = range(1, $table_row_limit_quantity);
                                uksort($total_row,function ($a, $b) use ($tr_serial_array) {
                                foreach($tr_serial_array as $key => $value){
                                    if($a==$value){
                                        return 0;
                                        break;
                                    }
                                    if($b==$value){
                                        return 1;
                                        break;
                                        }
                                    }
                                });


                                // for($j=1;$j<=$table_row_limit_quantity;$j++):
                                foreach($total_row  as $key =>$value) { $j=$key;
                                    $class = '';
                                    if($j>$table_readmore_limit && $table_readmore_limit != 'off'):
                                        $class = 'class="tbl_row_4 table-row-hide-'.$i.'" style="display:none"';
                                    endif;

                                    $strForCache .= '<tr '.$class.' data-serial="'.$i.'_'.$j.'_'.$params["id"].'">';
                                    $strForCache .= '<td class="sort-icon-wrapper">';
                                    $strForCache .= '<div class="row-heading">';
                                    $strForCache .= '<div class="row-description edit allow-drop" field="table_row_heading_'.$i.$j.'_'.$params['id'].'" rel="module">';
                                    $strForCache .= '<p>Unbegrenzte Produkte</p>';
                                    $strForCache .= '</div>';
                                    $strForCache .= '<div class="row-icon">';
                                    $description_popup_id = 'row_description_'.$i.$j.'_'.$params['id'];
                                    if(get_option('row_popup_on_off',$description_popup_id) == 'on'):
                                        $strForCache .= '<i class="fa fa-info-circle row-icon-des-info" onclick="description_show_modal(`'.$description_popup_id.'`);"> </i>';
                                    endif;
                                    if(is_live_edit()):
                                        $strForCache .= '<span class="layout-edit-icon" onclick="description_set_modal(`'.$description_popup_id.'`)">Description Popup <i class="fa fa-pencil-square" aria-hidden="true"></i></span>';
                                    endif;
                                    $strForCache .= '</div>';
                                    $strForCache .= '</div>';
                                    $strForCache .= '<span class="sort-icon">';
                                    $strForCache .= '<i class="fa fa-arrows" aria-hidden="true"></i>';
                                    $strForCache .= '</span>';
                                    $strForCache .= '</td>';
                                    if($card_limit_quantity):
                                        for($k=1; $k <=$card_limit_quantity; $k++):
                                            $strForCache .= '<td class="td-check">';
                                            $strForCache .= '<div class="edit allow-drop" field="table_specific_column_serial_'.$i.$j.$k.'_'.$params['id'].'" rel="content">';
                                            $strForCache .= '<p>'.$column_default_value.'</p>';
                                            $strForCache .= '</div>';
                                            $strForCache .= '</td>';
                                        endfor;
                                    endif;
                                    $strForCache .= '</tr>';
                                }
                                $strForCache .= '</tbody>';
                                if($table_readmore_limit && $table_row_limit_quantity > $table_readmore_limit):
                                    $strForCache .= '<tr class="readmore-td">';
                                    $strForCache .= '<td colspan="'.($card_limit_quantity+1).'">';
                                    $strForCache .= '<div class="readmore-icon" onclick="table_row_readmore_option('.$i.');">';
                                    $strForCache .= '<div class="readmore-icon-show-'.$i.'">';
                                    $strForCache .= '<span class="readmore-icon-text">'._e(`Read More`,true).'</span>';
                                    $strForCache .= '<i class="fa fa-angle-double-down" aria-hidden="true"></i>';
                                    $strForCache .= '</div>';
                                    $strForCache .= '<div class="readless-icon-show-'.$i.'" style="display:none;">';
                                    $strForCache .= '<span class="readmore-icon-text">'._e(`Read More`,true).'</span>';
                                    $strForCache .= '<i class="fa fa-angle-double-up" aria-hidden="true"></i>';
                                    $strForCache .= '</div>';
                                    $strForCache .= '</div>';
                                    $strForCache .= '</td>';
                                    $strForCache .= '</tr>';
                                endif;
                            endif;
                            $strForCache .= '<script>function table_row_readmore_option(index_number){if ($("tbody.table-row-allShow.pricing-table-body-"+index_number).length > 0) {$("tbody.pricing-table-body-"+index_number).removeClass("table-row-allShow");$(".readmore-icon-show-"+index_number).show();$(".readless-icon-show-"+index_number).hide();}else{$("tbody.pricing-table-body-"+index_number).addClass("table-row-allShow");$(".readmore-icon-show-"+index_number).hide();$(".readless-icon-show-"+index_number).show();}}</script>';
                        endfor;
                        $pricing_card_table_row_description_value = api_url("pricing_card_table_row_description_value");
                        $strForCache .= <<<EOD
                                        <script>
                                        function description_set_modal(row_description_id){
                                            $("#description_popup_id").val(row_description_id);
                                            $.ajax({
                                                type: "POST",
                                                url: "$pricing_card_table_row_description_value",
                                                data:{ row_description_id },
                                                success: function(response) {
                                                    if(response.message["on_off"] == "on"){
                                                        $("#pricing-card-table-row-description-show-hide").prop("checked",true);
                                                        CKEDITOR.instances.row_description.setData(response.message["value"]);
                                                        $("#pricing_card_description_add_for_table_row").modal("show");
                                                    }else{
                                                        $("#pricing-card-table-row-description-show-hide").prop("checked",false);
                                                        CKEDITOR.instances.row_description.setData(" ");
                                                        $("#pricing_card_description_add_for_table_row").modal("show");
                                                    }
                                                }
                                            });
                                        }
                                        function description_show_modal(row_description_id){
                                            $.ajax({
                                                type: "POST",
                                                url: "$pricing_card_table_row_description_value",
                                                data:{ row_description_id },
                                                success: function(response) {
                                                    $("#row_description_value").html(response.message["value"]);
                                                    $("#pricing_card_row_description_show").modal("show");
                                                }
                                            });
                                        }
                                        </script>
                                        EOD;                    endif;
                    $strForCache .= '</table>';
                    $strForCache .= '</div>';
                    $strForCache .= '</div>';
                    if($table_readmore_limit != 'off'):
                        $strForCache .= '<style>tbody.pricing-table-body tr {display: none !important;}';
                        for($i=1; $i <=$table_readmore_limit; $i++):
                            $strForCache .= 'tbody.pricing-table-body tr:nth-child('.$i.') {display: table-row !important;}';
                        endfor;
                        $strForCache .= 'tbody.pricing-table-body.table-row-allShow tr {display: table-row !important;}';
                        $strForCache .= '</style>';
                    endif;
                    $strForCache .= '</div>';
                else:
                    $strForCache .= '<div class="col-md-12">';
                    $strForCache .= '<div class="pricing-layout-alert">';
                    $strForCache .= '<h2>'._e("Please add pricing plans from pricing card edit",true).'!</h2>';
                    $strForCache .= '</div>';
                    $strForCache .= '</div>';
                endif;
                $strForCache .= '</div>';
                $strForCache .= '</div>';
            else:
                $strForCache .= '<div class="col-md-12">';
                $strForCache .= '<div class="pricing-layout-alert">';
                $strForCache .= '<h2>'. _e("Please add pricing card interval and pricing plans from pricing card edit",true).'!</h2>';
                $strForCache .= '</div>';
                $strForCache .= '</div>';
            endif;

            $strForCache .= '</div>';
            cache_save(str_replace('Description Popup <i class="fa fa-pencil-square" aria-hidden="true"></i>','',$strForCache), 'pricingCardString', 'pricingCardString');
        }
    }
    return $strForCache;
}

if (!function_exists('change_content_value')) {
    function change_content_value($htmlContent){
        $html = $htmlContent;
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(utf8_decode($html));
        $nodes = array();
        $nodes = $dom->getElementsByTagName("div");
        foreach ($nodes as $element)
        {
            $element = cleanDomData($element);
        }
        $save_html = $dom->saveHTML();
        $extra_tag_remove = array(
            'tag-1' =>  '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">',
            'tag-2' => '<html><body>',
            'tag-3' => '</body></html>'
        );
        $new_string = str_replace($extra_tag_remove,'', $save_html);
        $new_string = html_entity_decode($new_string);
        return $new_string;
    }
}

function cleanDomData($element){
    if ($element->hasAttributes()) {
        $removeAttr = array();
        foreach ($element->attributes as $attr) {

            $name = $attr->nodeName;
            $value = $attr->nodeValue;
            if(empty($value)){
                $removeAttr[] = $name;
            }
        }
        if(!empty($removeAttr)){
            foreach($removeAttr as $atr){
                $element->removeAttribute($atr);
            }
        }
    }
    if($element->hasChildNodes()){

        foreach($element->childNodes as $child){
            cleanDomData($child);
        }

    }
    return $element;
}

function deleteAllContentDetails($dt_shop_ids , $rollback = false){
    if(!empty($dt_shop_ids)){
        if($rollback == true){
            DB::table('offers')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('bundle_products')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('categories_items')->whereIn('rel_id', $dt_shop_ids)->delete();
            DB::table('tagging_tagged')->whereIn('taggable_id', $dt_shop_ids)->delete();
            DB::table('product_upselling_item')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('product_details')->whereIn('rel_id', $dt_shop_ids)->delete();
            DB::table('products')->whereIn('content_id', $dt_shop_ids)->delete();
            DB::table('media')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
            DB::table('content_data')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
            DB::table('content')->whereIn('id', $dt_shop_ids)->where('content_type', 'product')->delete();
            $custom_value_id = DB::table('custom_fields')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->pluck('id')->toArray();
            if(isset($custom_value_id) and !empty($custom_value_id)){
                DB::table('custom_fields')->whereIn('id', $custom_value_id)->delete();
                DB::table('custom_fields_values')->whereIn('custom_field_id', $custom_value_id)->delete();
            }
        }else{
            $content = DB::table('content')->where('drm_ref_id', $dt_shop_ids)->first();
            if(isset($content) && !empty($content)){
                $dt_shop_ids = $content->id;
                DB::table('offers')->where('product_id', $dt_shop_ids)->delete();
                DB::table('bundle_products')->where('product_id', $dt_shop_ids)->delete();
                DB::table('categories_items')->where('rel_id', $dt_shop_ids)->delete();
                DB::table('tagging_tagged')->where('taggable_id', $dt_shop_ids)->delete();
                DB::table('product_upselling_item')->where('product_id', $dt_shop_ids)->delete();
                DB::table('product_details')->where('rel_id', $dt_shop_ids)->delete();
                DB::table('products')->where('content_id', $dt_shop_ids)->delete();
                DB::table('media')->where('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
                DB::table('content_data')->where('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
                DB::table('content')->where('id', $dt_shop_ids)->where('content_type', 'product')->delete();
                $custom_value_id = DB::table('custom_fields')->where('rel_id', $dt_shop_ids)->where('rel_type', 'content')->pluck('id')->toArray();
                if(isset($custom_value_id) and !empty($custom_value_id)){
                    DB::table('custom_fields')->whereIn('id', $custom_value_id)->delete();
                    DB::table('custom_fields_values')->whereIn('custom_field_id', $custom_value_id)->delete();
                }
            }
        }
    }
}

function getProductModuleSettings($moduleId){

    $settings = DB::table('product_module_setting')->where('module_id',$moduleId)->get()->keyBy('key');

    return $settings;


}
