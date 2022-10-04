<?php
// content
use Illuminate\Support\Facades\DB;

 api_expose('app_token_save');
 function app_token_save($data){

//dd($data);
     $inaray2= array(
         'token' => $data['token'],

     );
     DB::table('tokenurl')->where('id',1)->update(
         array(
             'token' => $data['token']
         )
     );
     return back();



 }

// api_expose('agb');
// function agb($data){


//     $inaray2= array(
//         'term_name' => 'agb',
//         'description' => $data['agb'],

//     );
//     DB::table('legals')->insert($inaray2);
//     return back();




// }
