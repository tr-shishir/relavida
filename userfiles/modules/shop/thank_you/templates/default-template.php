<?php

/*

type: layout

name: Default new

description: Default

*/
?>
<style>
    .mw-link-tip-edit {
        display: none !important;
    }
    .thank-you-default-header,
    .thank-you-default-button {
        text-align: center;
    }
    .thank-you-default-header p,
    .information p{
        font-size:16px;
    }
    .thank-you-default-button{
        margin:20px 0;
    }
    .information h3,
    .address h3{
        margin-bottom:30px;
    }
    .information{
        display: flex;
        justify-content: flex-end;
    }
    .address span{
        display:block;
    }
    .thank-you-table-product-img{
        width: 100px !important;
        padding: 10px !important;
    }
    .thank-you-table-product-img img{
        height: 80px !important;
        width: 100%;
        object-fit: cover;
        position: relative;
        transition: .5s ease;
    }
    .thank-you-table-product-name p{
        font-size:16px;
    }
    .thank-you-table td{
        vertical-align: middle !important;
        line-height: 20px !important;
    }
    .thank-you-table-product-img:hover img {
        transform: scale(2);
        object-fit: contain;
    }

    .thank-you-table tr:hover {
        position: relative;
        z-index: 9;
    }
    .thankYou-checkout-total-table-row{
        display:flex;
        justify-content:flex-end;
    }

    .thank-you-table-product-name a {
        color: #000;
        text-decoration: none;
    }
    .thank-you-default-button .btn {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    .thank-you-default-button a:first-child {
        position: relative;
        padding-left: 20px;
    }

    .thank-you-default-button a:first-child:before {
        position: absolute;
        content: "\f060";
        top: 50%;
        left: 1px;
        font-family: 'FontAwesome';
        font-weight: bold;
        transform: translateY(-50%);
    }

    .re-order-btn {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 10px;
        border-radius: 5px;
        margin-top: 5px;
        color: #000;
    }

    .re-order-btn i {
        margin-right: 5px;
    }

    td.thank-you-table-product-name {
        display: flex;
        align-items: flex-start;
        border: 0;
        justify-content: space-between;
    }

    td.thank-you-table-product-name h3 {
        margin-right: 10px;
    }

    @media screen and (max-width: 767px){
        .thank-you-table-product-name h3{
            font-size: 16px;
        }
        .thankYou-checkout-total-table-row{
            justify-content:flex-start;
        }
        .information{
            justify-content:center;
            text-align:center;
        }
        .address{
            text-align:center;
            margin-bottom:20px
        }

    }
    span.dl-icon {
        position: relative;
    }

    span.dli-tooltip {
        position: absolute;
        right: -58px;
        top: 25px;
        background-color: #fff;
        border: 1px solid #acacac;
        width: max-content;
        max-width: 232px;
        padding: 8px;
        border-radius: 3px;
        z-index: 2;
        display: none;
        font-size: 13px;
        line-height: 16px;
        text-align: justify;
    }
    span.dl-icon:hover span.dli-tooltip {
        display: block;
    }
    .disable-download-link{
        pointer-events: none;
    }
    @media only screen and (max-width: 768px) {
        .thank-you-table-div{
            max-width: 560px;
            overflow-x: scroll;
        }
    }
</style>
<div class="thank-you-default">
    <div class="thank-you-default-header edit" field="thank-you-default-header_content" rel="content">
        <h2>Vielen Dank für Ihre Bestellung bei uns.</h2>
        <p>Wir haben Ihnen eine Bestellbestätigung per E-Mail geschickt.</p>
        <p>Wir empfehlen die unten aufgeführte Bestellbestätigung auszudrucken.</p>
    </div>
    <?php
    $last_order_information = DB::table('cart_orders')->where('order_completed',1)->get()->last();
    if($last_order_information){
        $name = $last_order_information->first_name.' '.$last_order_information->last_name;
        $address = $last_order_information->address;
        $city_country = $last_order_information->city.', '.$last_order_information->country;
        $order_number = $last_order_information->id;
        $payment_path = explode("/",$last_order_information->payment_gw);
        $payment_method = end($payment_path);
        $total_price = $last_order_information->payment_amount;
        $shipping_cost = $last_order_information->payment_shipping;
        $product_price =  $total_price -  $shipping_cost;
        $discount_price =  $last_order_information->discount_value;
        $tax_amount = $last_order_information->taxes_amount;
        $tax_rate = $last_order_information->tax_rate;
        $total_price_without_tax =  $total_price -  $tax_amount;
        $order_pdf_link = delivery_bill_url($order_number);
    }else{
        $name = NULL;
        $address = NULL;
        $city_country = NULL;
        $order_number = NULL;
        $payment_method = NULL;
        $total_price = NULL;
        $shipping_cost = NULL;
        $product_price =  NULL;
        $discount_price = NULL;
        $tax_amount = NULL;
        $tax_rate= NULL;
        $total_price_without_tax = NULL;
        $order_pdf_link = '#';
    }
    ?>
    <div class="thank-you-default-button">
        <a href="<?php print(site_url()); ?>" class="btn edit" field="thank_you_button_one" rel="content"><?php _e('Return'); ?></a>
        <a href="<?php print  $order_pdf_link; ?>" class="btn edit" field="thank_you_button_two" rel="content"><?php _e('Pdf delivery note'); ?></a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="address">
                <h3 class="edit" field="thankYou_address_heading" rel="content">Address</h3>
                <span><?php print $name; ?></span>
                <span><?php print $address; ?></span>
                <span><?php print $city_country; ?></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="information">
                <div class="information-inner">
                    <h3 class="edit" field="thankYou_info_heading" rel="content">Information</h3>
                    <p><strong><?php _e('Order Number'); ?>:</strong> <?php print $order_number ?></p>
                    <p><strong><?php _e('Payment Method'); ?>:</strong> <?php print  $payment_method; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="" style="margin-top:30px">
        <div class="thank-you-table-div" style="margin-top:30px">
            <table class="table table-bordered table-striped thank-you-table">
                <thead>
                <tr>
                    <th style="min-width:70px">Bild</th>
                    <th>Produktname</th>
                    <th>Menge</th>
                    <th>Gesamt</th>
                </tr>
                </thead>
                <?php
                $ordered_all_product = DB::table('cart')->where('order_id', $order_number)->get();
                ?>
                <tbody>
                <?php if($ordered_all_product):
                    $tax_data=collect($ordered_all_product);

                    $tax_rels = $tax_data->pluck('rel_id');
                    //$tx[] = collect($data)->pluck('rel_id');
                    $default_tax = single_tax($tax_rels);
                    $taxrate = $default_tax;


                    ?>
                    <?php foreach($ordered_all_product as $order_product):  ?>
                    <tr>
                        <?php
                        if(isset(get_content(array("id" => $order_product->rel_id))[0])){
                            $img_link = get_content(array("id" => $order_product->rel_id))[0]['media'][0]['filename'];
                            $product_url = get_content(array("id" => $order_product->rel_id))[0]['url'];


                        }else{
                            $img_link = '#';
                            $product_url = '#';
                        }
                        ?>
                        <td class="thank-you-table-product-img">
                            <img src="<?php print $img_link; ?>" alt="">
                        </td>
                        <td class="thank-you-table-product-name">
                            <h5><b><a href="<?php print  $product_url; ?>" target="_blank"><?php print $order_product->title  ?></a></b></h5>
                            <?php if (isset($order_product->digital_product) && $order_product->digital_product == 1): ?>
                                <?php
                                    if(isset($order_product->download_limit)){
                                        $product_download_limit = $order_product->download_limit;
                                    }else{
                                        $product_download_limit = 0;
                                    }
                                ?>
                                <a class="re-order-btn <?php if(!$product_download_limit > 0): ?> disable-download-link <?php endif; ?>" href="<?= site_url() . 'download_digital_product/' . $order_product->id ?>">
                                    <i class="fas fa-download"></i><?php _e('Download'); ?>
                                    <span class="download-limit"><span class="dl-icon"><i class="fas fa-luggage-cart"></i><span class="dli-tooltip">This number is representing that how many times you can download this product.</span> </span><?php print $product_download_limit; ?> </span>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="thank-you-table-product-quantity">
                            <span><?php print  $order_product->qty  ?></span>
                        </td>
                        <td class="thank-you-table-product-price">
                            <span><?php print currency_format(($order_product->price+taxPrice($order_product->price,null,$order_product->rel_id,$tax_rate))*$order_product->qty);  ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="row thankYou-checkout-total-table-row">
            <div class="col-md-6">
                <table class="table table-bordered table-striped thankYou-checkout-total-table">
                    <tr>
                        <td>
                            Warengesamtpreis
                        </td>
                        <td>
                            <?php print currency_format($product_price); ?>
                        </td>
                    </tr>
                    <?php if($discount_price){?>
                        <tr>
                            <td>
                                <?php _e('Discount'); ?>
                            </td>
                            <td>
                                <?php print currency_format($discount_price); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>
                            Versandkosten
                        </td>
                        <td>
                            <?php print currency_format($shipping_cost); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Gesamtpreis</b>
                        </td>
                        <td>
                            <b><?php print currency_format($total_price); ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        darin enthaltene MwSt. (<?php print $tax_rate .'%)'; ?>
                        </td>
                        <td>
                            <?php print currency_format($tax_amount); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nettobetrag
                        </td>
                        <td>
                            <?php print currency_format($total_price_without_tax); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
