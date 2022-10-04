<?php
set_time_limit(3000);
ini_set('max_execution_time', 3000);
ini_set('memory_limit','500M');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user_details = include("config/microweber.php");

if(isset($_REQUEST['check'])){
    echo "Available";
}

if(@$user_details['userToken'] == $_REQUEST['userToken'] && @$user_details['userPassToken'] == $_REQUEST['userPassToken']){
    if(isset($_REQUEST['backup'])) {
        backup();
    }else if(isset($_REQUEST['delete'])) {
        delete($_REQUEST['file']);
    }else{
        echo install_theme($_REQUEST['download_url']);
    }
}else{
    echo "User token and password not matched";
}


function delete($fileName){
    if(file_exists($fileName)){
        unlink($fileName);
        echo $fileName." deleted successfully";
    }
    return true;
}



function install_theme($data){

    try{


        $download_url = $data;

        if($data){
            $zipFileName = 'update.zip';
            downloadTheme($download_url,$zipFileName);
            extractTheme($zipFileName);
            Config::set('template.'.$data['name'], 0);
            Config::save(array('template'));
            return "successfully";

        }
        else{
            // unlink(base_path('userfiles/templates/electron/.git/config'));
            // exec("rmdir /s /q userfiles/templates/electron/.git");
            return "Error";
        }

    }
    catch (Exception $e) {
        return $e;
    }

}



function downloadTheme($url,$zipFileName){
    return file_put_contents($zipFileName, file_get_contents($url));
}

function extractTheme($zipFileName){
    $zip = new ZipArchive;
    $zip->open($zipFileName);
    $zip->extractTo('./');
    $zip->close();
    unlink(__DIR__.$zipFileName);
}




function backup() {
    $exclude_some_files=array('microweber.php','database.php');
    $new_zip_filename='down_zip_file_'.rand(1,100).'_'.date("Y-m-d").'.zip';
    // Download action
    if(isset($_REQUEST['dir'])){
        $dir=$_REQUEST['dir'];
    }else {
        $dir=__DIR__;
    }
    $za = new ModifiedFlxZipArchive;
    //create an archive
    if  ($za->open($new_zip_filename, ZipArchive::CREATE)) {
        $za->addDirDoo($dir, basename($dir), $exclude_some_files); $za->close();
    }else {die('cantttt');}

    //download archive
    //on the same execution,this made problems in some hostings, so better redirect
    //$za -> downld($new_zip_filename);

    if (isset($_REQUEST['fildown'])){
        // header("location:?fildown=".$new_zip_filename); exit;
        $za -> downld($new_zip_filename);
    }else {
        echo $new_zip_filename;
    }

}





//***************built from https://gist.github.com/ninadsp/6098467 ******
class ModifiedFlxZipArchive extends ZipArchive {
    public function addDirDoo($location, $name , $prohib_filenames=false) {

        if (!file_exists($location)) {  die("maybe file/folder path incorrect");}

        //exlude vendor
        // if (is_dir($location)){
        //         $dir_name=basename($location);
        //         $exclude = array('vendor','.git');
        //         $exclude = implode('|', $exclude);

        //         if(strpos($location,$exclude) !== false){
        //             continue;
        //         };
        // }

        $this->addEmptyDir($name);
        $name .= '/';
        $location.= '/';
        $dir = opendir ($location);   // Read all Files in Dir

        while ($file = readdir($dir)){
            if ($file == '.' || $file == '..') continue;
            if(strpos($file,'.zip') !== false)continue;
            if (!in_array($name.$file,$prohib_filenames)){
                if (filetype( $location . $file) == 'dir'){
                    $this->addDirDoo($location . $file, $name . $file,$prohib_filenames );
                }
                else {
                    $this->addFile($location . $file, $name . $file);
                }
            }
        }
    }

    public function downld($zip_name){
        ob_get_clean();
        header("Pragma: public");   header("Expires: 0");   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);    header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=" . basename($zip_name) . ";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($zip_name));
        readfile($zip_name);
    }
}
