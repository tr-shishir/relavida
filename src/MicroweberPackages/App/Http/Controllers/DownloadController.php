<?php

namespace MicroweberPackages\App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class DownloadController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $order_info = DB::table('cart')
                        ->where('id', $request->order_id)
                        ->select('rel_id','download_limit')
                        ->first();
        if(isset($order_info->rel_id) && $order_info->rel_id){
            $product = DB::table('product_details')
                ->where('rel_id', $order_info->rel_id)
                ->select('d_P_download_link','download_limit')
                ->first();
        }

        if (isset($product) && isset($product->d_P_download_link)) {
            $file = Storage::disk('local')->exists($product->d_P_download_link);

            if ($file) {
                $savefile = Storage::download($product->d_P_download_link);
                if(isset($order_info->download_limit) && $order_info->download_limit > 0){
                    $product_dpwnload_limit = $order_info->download_limit - 1;
                    DB::table('cart')->where('id',$request->order_id)->update(['download_limit' => $product_dpwnload_limit]);
                    mw_post_update();
                    return $savefile;
                }
            }
        }
        return redirect()->back();
    }

    public function adminDownload(Request $request)
    {
        $product = DB::table('product_details')
            ->where('rel_id', $request->product_id)
            ->select('d_P_download_link')
            ->first();

        if (isset($product) && isset($product->d_P_download_link)) {
            $file = Storage::disk('local')->exists($product->d_P_download_link);

            if ($file) {
                $savefile = Storage::download($product->d_P_download_link);
                return $savefile;
            }
        }
        return redirect()->back();
    }
}
