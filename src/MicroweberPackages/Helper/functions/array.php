<?php
/**
 * Microweber Helper Functions
 *
 * @author      Microweber Team
 * @author      Peter Ivanov
 * @author      Bozhidar Slaveykov
 *
 * @version     0.1
 *
 * @link        http://droptienda.com
 */


if (!function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return array
     */
    function array_set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }
}

if (!function_exists('array_unique_recursive')) {
    function array_unique_recursive($array)
    {
        $array = array_unique($array, SORT_REGULAR);

        foreach ($array as $key => $elem) {
            if (is_array($elem)) {
                $array[$key] = array_unique_recursive($elem);
            }
        }

        return $array;
    }
}


function roundPrice($price){
    if(is_string($price)){
        $price = floatval($price);
    }
    $roundprice = Config::get('custom.round_amount');
    if(isset($roundprice)){
        if($roundprice >0 && $price > 0){
            if(is_float($price)){
                $price = intval($price)+floatval('.'.strval($roundprice));
            }
        }
    }
    return $price;
}



//this function return the tax rate
function taxRate($product_id=null){
    $tax= mw()->tax_manager->get();
    $country = (user_country()) ? user_country() : $tax['0']['name'];
    $tax_rate = intval(!empty($tax['0']['rate']) ? $tax['0']['rate'] : 0);

    if(!@is_logged() and @mw()->user_manager->session_get("country")){
        $tax_rate_country = @mw()->user_manager->session_get("country");
        $tax_rate = DB::table('tax_rates')
            ->where('country',$tax_rate_country)->first()->charge;
    }

    if($product_id!=null){
        $tax_type = DB::table('product_details')->select('tax_type')->where('rel_id',$product_id)->where('tax_type',2)->first();
        if($tax_type){
            $tax_rate = \Illuminate\Support\Facades\DB::table('tax_rates')->select('charge','reduced_charge')->where('country','LIKE','%'.$country.'%')->first();
            !empty($tax) ? $tax_rate = $tax_rate->reduced_charge : $tax_rate = 0 ;
        }
    }

    return $tax_rate;
}
//this function return the tax rate
function taxRateCountry($country , $product_id = null){
    if(!@is_logged() and @mw()->user_manager->session_get("country")){
        $country = $country ?? @mw()->user_manager->session_get("country");
    }
    if(is_int($country)){
        $tax = $GLOBALS['user_country_tax'];
        if(!@$tax && $tax == null){

            $tax['charge'] = taxRate();
            $tax['reduced_charge'] = taxRate($product_id);
            $tax = (object)$tax;

        }
    }else{
        $tax = \Illuminate\Support\Facades\DB::table('tax_rates')->where('country',$country)->first();
    }
    // dd($tax);
    if(isset($tax->charge)){
        $tax_rate = $tax->charge;
    }

    if($product_id!=null){
        $tax_type = DB::table('product_details')->select('tax_type')->where('rel_id',$product_id)->where('tax_type',2)->first();
        if($tax_type){
            $tax_rate = $tax->reduced_charge;

        }
    }
    return @$tax_rate ?? [];
}


//this function return the tax price

function taxPrice($price,$country=null,$product_id=null,$tax_d=null){

    $user_country_tax = $GLOBALS['user_country_tax'];
    if(@$user_country_tax && $user_country_tax!=null){
        $tax_rate = $user_country_tax;
    }
    if(!@is_logged() and @mw()->user_manager->session_get("country")){
        $country = @mw()->user_manager->session_get("country") ?? null;
    }
    if(@$country && $country != null){
        $tax_rate = \Illuminate\Support\Facades\DB::table('tax_rates')->select('charge','reduced_charge')->where('country',$country)->first();
    }
    $tax= mw()->tax_manager->get();
    if(isset($tax_rate) && $tax_rate != null){
        !empty($tax) ? $taxam = $tax_rate->charge : $taxam = 0 ;
    }else{
        !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
    }
    if($product_id!=null){
        $tax_type = DB::table('product_details')->select('tax_type')->where('rel_id',$product_id)->where('tax_type',2)->first();
        if($tax_type){
            if(!is_logged()){
                $user_country_tax = \Illuminate\Support\Facades\DB::table('tax_rates')->select('charge','reduced_charge')->where('country','LIKE','%'.$tax['0']['name'].'%')->first();
            }
            $taxam = taxRate($product_id);

        }
    }
    if($tax_d){
        $taxam = $tax_d;
    }
    // dd($taxam);.0

    $price = normalPrice($price);
    $tax_price = (($taxam*$price)/100);
    return $tax_price;


}

function single_tax($data){
    $taxrate = taxRate();
    if(isset($data) && !empty($data)){
        $taxrates = array();
        foreach($data as $val){

            $taxrates[] = (is_logged()) ? (int)taxRateCountry(user_id(),$val) : taxRate($val);
            $taxrate = max($taxrates);

        }
        return $taxrate;
    }
}

function product_tax_amount($price,$tax_rate){
    return (($price*$tax_rate)/100);
}
