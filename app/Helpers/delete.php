<?php 

if (!function_exists('dt_delete_deleteAnyFolder')) {
    function dt_delete_deleteAnyFolder($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if(isset($dir_handle)){
            if (!$dir_handle)
                return false;
            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname."/".$file)){
                        dump('File Name - '.$file);
                        @unlink($dirname."/".$file);
                    }
                    else{
                        dt_delete_deleteAnyFolder($dirname.'/'.$file);
                    }
                }
            }
            closedir($dir_handle);
            @rmdir($dirname);
            return true;
        }
    }
}