<?php

/*
	@Category CRUD api
*/
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Microweber\App\Providers\Illuminate\Support\Facades\Hash;
use QueryPath\Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

api_expose('image_compress');
function image_compress($data){

	$validator = Validator::make($data, [
		'compress' => 'required|integer|between:1,100'
	]);

	if ($validator->fails()) {
		return response()->json(['error' => 'You can not cross the max limit of 100']);
	}

	if($data['id']){
		$v = DB::table('image_optimize')->where('id',$data['id'])->update([
			'compress' => $data['compress'],
		]);
	}else{
		$v = DB::table('image_optimize')->insert([
			'compress'=> $data['compress'],
			'status'  => 1,
		]);
	}
	return response()->json(["message" => $data['compress'] ], 200);
}

api_expose('image_minimum_size');
function image_minimum_size($data){
	
	if($data['minimum_id']){
		$v = DB::table('image_optimize')->where('id',$data['minimum_id'])->update([
			'minimum_size'=> $data['minimum_size'],
		]);
	}else{
		$v = DB::table('image_optimize')->insert([
			'minimum_size'=> $data['minimum_size'],
			'status'      => 2,
		]);
	}

	return response()->json(["message" => $data['minimum_size'] ], 200);
}

api_expose('image_thumbnail');
function image_thumbnail($data){

	if($data['thumbnail_id']){
		$v = DB::table('image_optimize')->where('id',$data['thumbnail_id'])->update([
			'thumbnail_width' => $data['thumbnail_width'],
			// 'thumbnail_height'=> $data['thumbnail_height'],
		]);
	}else{
		$v = DB::table('image_optimize')->insert([
			'thumbnail_width' => $data['thumbnail_width'],
			// 'thumbnail_height'=> $data['thumbnail_height'],
			'status'          => 3,
		]);
	}
	// $jeson_data = array( "thumbnail_width" => $data['thumbnail_width'],"thumbnail_height"=>$data['thumbnail_height'] );
	// return response()->json(["message" => $jeson_data], 200);
	return response()->json(["message" => $data['thumbnail_width'] ], 200);
}

// api_expose('original_thumbnail');
// function original_thumbnail($data){

// 	if($data['original_id']){
// 		$v = DB::table('image_optimize')->where('id',$data['original_id'])->update([
// 			'original_width' => $data['original_width'],
// 			'original_height'=> $data['original_height'],
// 		]);
// 	}else{
// 		$v = DB::table('image_optimize')->insert([
// 			'original_width' => $data['original_width'],
// 			'original_height'=> $data['original_height'],
// 			'status'          => 4,
// 		]);
// 	}
// 	$jeson_data = array( "original_width" => $data['original_width'],"original_height"=>$data['original_height'] );
// 	return response()->json(["message" => $jeson_data], 200);
// }

api_expose('live_edit_image_compress');
function live_edit_image_compress($data){

	$validator = Validator::make($data, [
		'live_edit_compress' => 'required|integer|between:1,100'
	]);

	if ($validator->fails()) {
		return response()->json(['error' => 'You can not cross the max limit of 100']);
	}

	if($data['live_edit_compress_id']){
		$v = DB::table('image_optimize')->where('id',$data['live_edit_compress_id'])->update([
			'live_edit_compress' => $data['live_edit_compress'],
		]);
	}else{
		$v = DB::table('image_optimize')->insert([
			'live_edit_compress' => $data['live_edit_compress'],
			'status'          => 5,
		]);
	}
	return response()->json(["message" => $data['live_edit_compress'] ], 200);
}

api_expose('live_edit_minimum_size');
function live_edit_minimum_size($data){

	if($data['live_edit_minimum_size_id']){
		$v = DB::table('image_optimize')->where('id',$data['live_edit_minimum_size_id'])->update([
			'live_edit_minimum_size' => $data['live_edit_minimum_size'],
		]);
	}else{
		$v = DB::table('image_optimize')->insert([
			'live_edit_minimum_size' => $data['live_edit_minimum_size'],
			'status'          => 6,
		]);
	}
	return response()->json(["message" => $data['live_edit_minimum_size'] ], 200);
}