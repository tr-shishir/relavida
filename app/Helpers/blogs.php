<?php

if (!function_exists('get_first_position_image_from_media')) {
    function get_first_position_image_from_media($content_id) {
        $first_position_image_information = DB::table('media')->where('rel_id',$content_id)->where(function($q) {
            $q->where('position', 0)
              ->orWhere('position', NULL)
              ->orWhere('position',9999999);
        })->first();
        if(isset($first_position_image_information)){
            if(isset($first_position_image_information->webp_image) && !empty($first_position_image_information->webp_image)){
                $first_position_image = $first_position_image_information->webp_image;
            }else{
                $first_position_image = $first_position_image_information->filename;
            }
        }else{
            $first_position_image = null;
        }
        return $first_position_image;
    }
}

if (!function_exists('insert_blog_information')) {
    function insert_blog_information($blog_information) {
        DB::table('blogs')->insert($blog_information);
    }
}

if (!function_exists('update_or_insert_blog_information')) {
    function update_or_insert_blog_information($content_id,$blog_information) {
        DB::table('blogs')->updateOrInsert(
            ['content_id' => $content_id],
            $blog_information
        );
    }
}

if (!function_exists('delete_blog_information')) {
    function delete_blog_information($content_id) {
        DB::table('blogs')->where('content_id',$content_id)->delete(); 
    }
}