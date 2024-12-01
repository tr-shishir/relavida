<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function favoriteDrink()
    {
        $drinks = ['water', 'soda', 'beer', 'coffee'];
        $randKey = array_rand($drinks);

        return view('favorite-drink', ['drink' => $drinks[$randKey]]);
    }
    public function drm_token_get(){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://eu-dropshipping.com/api/v1/droptienda-activation',
        array(
            'form_params' => array(
            'email'=> $_REQUEST['installUserName'],
            'password'=> $_REQUEST['installUserPass'],
            'url' => url('/')
            )
            )
        );



        echo $res->getBody();
        // {"type":"User"...'
            dd(json_decode($res->getBody()));
        // Send an asynchronous request.
        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'I completed! ' . $response->getBody();
        });
        $promise->wait();
        dd($_REQUEST);
    }

    public function shop(){

        if (!isset($post_params['data-limit'])) {
            $posts_limit = 6;
        }
        $data = DB::table('products')
            ->select('products.title','products.url','products.price','products.content_id','products.quantity','products.tax_type','products.image')
            ->where('category_hide',0)
            ->paginate($posts_limit);
            $show_fields = [];

            return view('shop', ['data' => $data,'show_fields'=>$show_fields]);
    }
}
