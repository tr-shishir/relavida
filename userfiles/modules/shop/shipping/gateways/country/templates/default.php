<?php

/*

type: layout

name: Default

description: Default

*/
?>

<div class="<?php print $config['module_class'] ?>">
    <div id="<?php print $rand; ?>">
        <label>
            <?php _e("Land auswählen"); ?><span style="color: red;">*</span>
        </label>
        <!-- <span style="color: red;">*</span> -->

        <?php
        // $selected_country = $tax = DB::table('users')
        //     ->select('tax_rates.charge','users.country')
        //     ->join('tax_rates','tax_rates.country','=','users.country')
        //     ->where('users.id',user_id())->first();

        // if(!@$selected_country){
        //     $selected_country  = $tax =  DB::table('tax_rates')->where('is_default',1)->first();
        // }
        // if(!@is_logged() and @mw()->user_manager->session_get("country")){
        //     $selected_country->country = @mw()->user_manager->session_get("country") ?? null;
        // }
        ?>

        <?php if(is_logged()):  ?>
            <?php
                $user_profile_country = user_country(user_id());
                if(!$user_profile_country){
                    $tax= mw()->tax_manager->get();
                    $user_profile_country = $tax['0']['name'];
                }
            ?>
            <select name="country" class="field-full form-control countrySelectBox country-rate" id="country_set"  style="pointer-events: none !important;" required>
                <option value="<?php print $user_profile_country; ?>"   selected="selected"><?php print $user_profile_country; ?></option>
            </select>
        <?php else: ?>
            <?php
                $allowedShipping =  DB::table('cart_shipping')->where('is_active',1)->where('shipping_country', 'like', '%Worldwide%')->get()->toArray();

                if(!empty($allowedShipping)){
                    $data = DB::table('tax_rates')->orderBy('country','asc')->get()->toArray();
                } else{
                    $data = DB::table('tax_rates')
                            ->join('cart_shipping', 'tax_rates.country', '=', 'cart_shipping.shipping_country')
                            ->select('tax_rates.*')
                            ->get()
                            ->toArray();
                    $shipping_country = $this->app->user_manager->session_get('shipping_country');
                }
                 ?>
            <select name="country" class="field-full form-control countrySelectBox country-rate" id="country_set" required>
                <?php if(isset($data)): ?>
                    <?php foreach($data  as $item): ?>
                        <option value="<?php print $item->country ?>" <?php if((isset($shipping_country) and $shipping_country == $item->country)): ?>selected<?php elseif(!isset($shipping_country) and $item->is_default == 1): ?> selected <?php endif; ?>><?php print $item->country ?></option>
                    <?php endforeach ; ?>
                <?php endif; ?>
            </select>
        <?php endif; ?>
    </div>

    <module type="custom_fields" template="bootstrap3" id="shipping-info-address-<?php print $params['id'] ?>" data-for="module"  default-fields="address" input-class="field-full form-control" data-skip-fields="country"   />

</div>
