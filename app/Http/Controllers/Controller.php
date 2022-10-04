<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
}
