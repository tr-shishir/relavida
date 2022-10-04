<?php

/*

type: layout

name: Big

description: Full width cart template

*/

?>
<style>
    label {
        display: inline-block;
        margin-bottom: .5rem;
        font-weight: 800;
        font-size: 16px;
    }

    .cell-cart-price-total-total {
        font-weight: bolder;
    }

    .checkout-total-table-row {
        justify-content: flex-end;
    }

    .checkout-total-table td {
        text-align: right;
    }

    .checkout-total-table {
        table-layout: fixed;
    }

    .checkout-total-table label {
        display: block;
        text-align: right;
    }

    .cell-shipping-total,
    .cell-shipping-price {
        text-align: right;
    }

    .total_cost {
        font-weight: normal;
    }

    .checkout-total-table td label,
    .checkout-total-table td {
        font-size: 16px !important;
    }

    .input-group.qtyw {
        position: relative;
        min-width: 150px;
    }

    @media screen and (max-width: 450px) {
        .ch-checkbox {
            flex-direction: column;
            align-items: flex-start !important;
        }
    }
</style>
<div class="mw-cart mw-cart-big mw-cart-<?php print $params['id'] ?> <?php print  $template_css_prefix; ?>">
    <div class="mw-cart-title mw-cart-<?php print $params['id'] ?>">
        <h3 class="">
            Mein Warenkorb
        </h3>
    </div>
    <?php
    $bumbs = true;
    $shop_require_terms = get_option('shop_require_terms', 'website') ?? null;
    if (isset($_GET['slug'])) {

        $pro_ids = DB::table('quick_checkout')->where('slug', '=', $_GET['slug'])->first()->products_id;

        $data = \App\Models\Content::with('media', 'contentData', 'customField', 'categoryItem')
            ->where('content.id', '=', $pro_ids)
            ->first()->toArray();

        //dd($data['media']);
        $price = DB::table('custom_fields')
            ->join('custom_fields_values', 'custom_fields.id', '=', 'custom_fields_values.custom_field_id')
            ->where('custom_fields.rel_id', '=', $pro_ids)
            ->where('custom_fields.rel_type', '=', 'content')
            ->where('custom_fields.type', '=', 'price')
            ->first();
        //        dd($price-);


    }

    $subProduct = null;
    $sub_interval = null;
    $u_id = user_id() ?? 0;
    if (session_id() == '') {
        session_start();
    }
    $u_session = session_id();
    $sub = DB::table('subscription_order_status')->where('order_id', null)->where('user_id', $u_id)->where('session_id', $u_session)->first();
    if ($sub != null  && $data != null) {
        $sub_interval = DB::table('subscription_items')->select('sub_interval')->where('id', $sub->subscription_id)->first();
        // dd($sub_interval->sub_interval);
        foreach ($data as $key) {
            if ($key['rel_id'] == $sub->product_id) {
                $subProduct = get_cart("rel_id=$sub->product_id");
                break;
            }
        }
    }
    if ($subProduct != null) {
        // dd($subProduct);
        $data = $subProduct;
    }
    // dump($data);

    if (is_array($data)) :
        $upsellingCount = DB::table("selected_product_upselling_item")->where('user_id', user_id())->get()->count();
    ?>

        <table class="table <?php if ($upsellingCount <= 0) : ?>upsellingCartTable<?php endif; ?> table-bordered table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table cart-table checkout-page-cart-table">

            <thead>
                <tr>
                    <th style="min-width:70px">Bild</th>
                    <th class="mw-cart-table-product" style="">Produktname</th>
                    <?php if (!isset($_GET['slug'])) { ?>
                        <th style="width:200px">Menge</th>
                    <?php } ?>
                    <th>Preis</th>
                    <?php if ($upsellingCount > 0) : ?>
                        <th>Servicepreis</th>
                    <?php endif; ?>
                    <th>Gesamt</th>
                    <th>Löschen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = cart_sum();
                if (!isset($_GET['slug'])) {
                    // dd($data);
                    // google tracking function is here
                    if (function_exists('dt_google_analytical_checkout')) {
                        dt_google_analytical_checkout($data);
                    }
                    //End google tracking function

                    foreach ($data as $item) :

                        if (DB::table('checkout_bumbs')->where('product_id', $item['rel_id'])->get()->count()) {
                            $bumbs = false;
                        }
                        // dd();
                        // dd(get_content_by_id($item['rel_id']));

                        //$total += $item['price']* $item['qty'];
                ?>
                        <tr class="mw-cart-item mw-cart-item-<?php print $item['id'] ?>">
                            <td><?php if (isset($item['item_image']) and $item['item_image'] != false) : ?>
                                    <?php $p = $item['item_image']; ?>
                                <?php else :

                                    $p = get_picture($item['rel_id']);

                                ?>
                                <?php endif; ?>
                                <?php if ($p != false) : ?>
                                    <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $item['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>" />
                                <?php endif; ?>
                            </td>
                            <td class="mw-cart-table-product">
                                <p style="font-weight:bold;margin-bottom:10px;word-break: break-word;">
                                    <?php print $item['title'] ?>
                                    <?php if (isset($item['custom_fields'])) : ?>
                                        <?php print $item['custom_fields'] ?>
                                    <?php endif ?>

                                </p>
                                <p class="mw-cart-table-product-info">
                                    <span>
                                        <strong>Item Number:</strong> <?php if ($item['rel_id'] != null) {
                                                                            print $item['rel_id'];
                                                                        } else {
                                                                            print "XXX";
                                                                        } ?>
                                    </span>
                                    <span>
                                        <strong>EAN:</strong> <?php if (get_content_by_id($item['rel_id'])['ean'] != null) {
                                                                    print get_content_by_id($item['rel_id'])['ean'];
                                                                } else {
                                                                    print "XXX";
                                                                } ?>
                                    </span>
                                    <!-- <span>
                                    <strong>Brand:</strong> xaoimi
                                </span>
                                <span>
                                    <strong>Color:</strong> Red
                                </span> -->
                                </p>
                            </td>
                            <?php if (!isset($_GET['slug'])) { ?>
                                <input type="hidden" min="1" id="id_val<?= $item['id'] ?>" class="input-mini form-control input-sm" value="<?php print $item['id'] ?>" />

                                <td class="product-quantity_number">
                                    <div class="input-group">
                                        <input type="button" value="-" class="button-minus" data-field="quantity" id="minuss<?= $item['id'] ?>">
                                        <input type="number" step="1" max="" value="<?php print $item['qty'] ?>" name="quantity" id="qty<?= $item['id'] ?>" class="quantity-field" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)">
                                        <input type="button" value="+" class="button-plus" data-field="quantity" id="pluss<?= $item['id'] ?>">
                                    </div>
                                </td>
                            <?php } ?>
                            <?php /* <td><?php print currency_format($item['price']); ?></td> */ ?>

                            <script>
                                $("#pluss<?= $item['id'] ?>").on('click', function(e) {
                                    // console.log("fsdf");
                                    var currentVal = $("#qty<?= $item['id'] ?>").val()
                                    var id = $("#id_val<?= $item['id'] ?>").val();

                                    currentVal = parseInt(currentVal) + 1;
                                    mw.cart.qty(id, currentVal);
                                    $.post("<?= url('/') ?>/api/v1/cart_totals", {
                                         data:$("#country_set").val(),product:$("#p_id_val").val() ,taxr:$("#p_tax").val()
                                    }, (res) => {
                                    if(res.success){
                                        $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                        $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                        $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                        $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                        $('.tax_for_country').html('darin enthalten ' + res.cart_totals.tax_rate.amount + '% USt.');
                                    }
                                    });
                                });
                                $("#minuss<?= $item['id'] ?>").on('click', function(e) {
                                    var currentVal = $("#qty<?= $item['id'] ?>").val()
                                    var id = $("#id_val<?= $item['id'] ?>").val();
                                    currentVal = parseInt(currentVal) - 1;
                                    mw.cart.qty(id, currentVal);
                                    $.post("<?= url('/') ?>/api/v1/cart_totals", {
                                         data:$("#country_set").val(),product:$("#p_id_val").val() ,taxr:$("#p_tax").val()
                                    }, (res) => {
                                    if(res.success){
                                        $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                        $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                        $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                        $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                        $('.tax_for_country').html('darin enthalten ' + res.cart_totals.tax_rate.amount + '% USt.');
                                    }
                                    });
                                });
                            </script>
                            <td class="mw-cart-table-price">
                                <?php

                                $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'])->where('user_id', user_id())->get();
                                $servicePrice = 0;
                                if ($selectedUpselling->count()) {
                                    foreach ($selectedUpselling as $selectValue) {
                                        $servicePrice = $servicePrice + $selectValue->service_price;
                                    }
                                    $servicePrice = $servicePrice + taxPrice($servicePrice);
                                    $item['price'] = $item['price'] + taxPrice($item['price']);
                                } else {
                                    $item['price'] = $item['price'] + taxPrice($item['price']);
                                }

                                ?>
                                <?php print currency_format(roundPrice($item['price'])); ?></td>
                            <?php if (DB::table("selected_product_upselling_item")->where('user_id', user_id())->get()->count() > 0) : ?>
                                <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>
                            <?php endif; ?>

                            <td class="mw-cart-table-price"><?php print currency_format((roundPrice($item['price']) + $servicePrice) * $item['qty']); ?></td>

                            <td><a title="<?php _e("Remove"); ?>" style="color:red;" class="icon-trash" href="javascript:mw.cart.remove('<?php print $item['id'] ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php endforeach;
                } else { ?>


                    <tr class="mw-cart-item mw-cart-item-<?php print $data['id'] ?>">
                        <td><?php if (isset($data['item_image']) and $data['item_image'] != false) : ?>
                                <?php $p = $data['item_image']; ?>
                            <?php else :

                                $p = get_picture($data['id']);
                            ?>
                            <?php endif;
                            //                            @dump($p);
                            ?>
                            <?php if ($p != false) : ?>
                                <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $data['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>" />
                            <?php endif; ?>
                        </td>
                        <td class="mw-cart-table-product"><?php print $data['title'] ?>
                            <?php if (isset($data['custom_fields'])) : ?>
                                <?php print $data['custom_fields'] ?>
                            <?php endif ?></td>



                        <td class="mw-cart-table-price"><?php print currency_format($price->value); ?></td>

                    </tr>

                <?php } ?>

            </tbody>
        </table>

        <div>
            <?php if (DB::table('checkout_bumbs')->where('show_checkout', 1)->get()->count()) : ?>
                <?php if ($bumbs) : ?>
                    <module type="shop/Checkout_Bumbs" template="checkout_bumbs" />
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div style="margin-top:20px; line-height: 20px;" class="checkout-checkbox">
            <?php $terms = true;
            $terms2 = true;
            $terms3 = true; ?>
            <?php if ($terms) : ?>
                <script>
                    $(document).ready(function() {

                        terms('#i_agree_with_terms_1');
                    });

                    function terms(id) {
                        $(id).click(function() {
                            let el = $('#i_agree_with_terms_1');
                            let el2 = $('#i_agree_with_terms_2');
                            let el3 = $('#i_agree_with_terms_3');
                            if (el.is(':checked') && el2.is(':checked')) {
                                $('#complete_order_button').removeAttr('disabled');
                            } else {
                                $('#complete_order_button').attr('disabled', 'disabled');

                            }
                        });
                    }
                </script>
                <style>
                    .mw-link-tip-edit {
                        display: none !important;
                    }
                </style>
                <div style="display:flex;justify-content:flex-end;" id="i_agree_with_terms_row">

                    <div class="ch-checkbox" style="display:flex;align-items:center">
                        <?php if ($shop_require_terms == 1) : ?>
                            <span class="edit" field="content1" rel="page1" style="margin-right: 5px;"><input class="form-check-input" type="checkbox" value="" id="agreeterm"><?php _e('Ich akzeptiere die'); ?></span>
                        <?php endif ?>
                        <div class="edit" field="checkout_term_agb" rel="content">
                            <a href="<?php print site_url('agb') ?>" target="_blank" style="color:#309be3;line-height:20px;">Allgemeinen Geschäftsbedingungen</a>
                        </div>
                    </div>

                </div>
            <?php endif; ?>


            <?php if ($terms2) : ?>
                <script>
                    $(document).ready(function() {
                        terms('#i_agree_with_terms_2');
                    });
                </script>
                <div style="display:flex;margin-top:10px;justify-content:flex-end;" id="i_agree_with_terms_row">
                    <div class="ch-checkbox" style="display:flex;align-items:center">
                        <?php if ($shop_require_terms == 1) : ?>
                            <span class="edit" field="content2" rel="page2" style="margin-right: 5px;"><input class="form-check-input" type="checkbox" value="" id="agreecondition"><?php _e('Ich habe das'); ?></span>
                        <?php endif ?>
                        <div class="edit" field="checkout_term_widerrufsrecht" rel="content">
                            <a href="<?php print site_url('widerrufsrecht') ?>" target="_blank" style="color:#309be3">Widerrufsrecht zur
                                Kenntnis genommen</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- <?php if ($terms3) : ?>
                                                <script>
                                                    $(document).ready(function () {
                                                        terms('#i_agree_with_terms_3');
                                                    });

                                                </script>

                                                <div class="mw-ui-row" id="i_agree_with_terms_row">
                                                    <label class="mw-ui-check">
                                                        <input type="checkbox" name="terms" id="i_agree_with_terms_3" value="1"
                                                            autocomplete="off" />
                                                        <span></span>
                                                        <span>
                                                            <?php _e('I agree with the third'); ?>
                                                            <a href="<?php print site_url('terms-and-condition-three') ?>"
                                                                target="_blank"><?php _e('Terms and Conditions'); ?></a>
                                                        </span>
                                                    </label>
                                                </div>
                                                <?php endif; ?> -->

        </div>

        <?php $shipping_options = mw('shop\shipping\shipping_api')->get_active(); ?>
        <?php

        $show_shipping_info = get_option('show_shipping', $params['id']);

        if ($show_shipping_info === false or $show_shipping_info == 'y') {
            $show_shipping_stuff = true;
        } else {
            $show_shipping_stuff = false;
        }

        if (is_array($shipping_options)) : ?>

            <div class="row checkout-total-table-row">
                <div class="col-lg-6">
                    <h3 class="">
                        Bestellübersicht
                    </h3>
                    <table cellspacing="0" cellpadding="0" class="table table-bordered table-striped mw-cart-table mw-cart-table-medium checkout-total-table" width="100%">
                        <!-- <col width="">
                                    <col width="">
                                    <col width=""> -->
                        <tbody>
                            <!--            <tr --><?php //if (!$show_shipping_stuff) :
                                                    ?>
                            <!-- style="display:none" --><?php //endif;
                                                            ?>
                            <!--                <td class="cell-shipping-country"><label>-->
                            <!--                        --><?php //_e("Versand nach");
                                                            ?>
                            <!--                        :</label></td>-->
                            <!--                <td class="cell-shipping-country">-->
                            <!--                    <module type="shop/shipping" view="select" />-->
                            <!--                </td>-->
                            <!--            </tr>-->
                            <tr>

                            </tr>


                            <?php if ($cart_totals && !isset($_GET['slug'])) { ?>
                                <tr>
                                    <td>
                                        <label for="">
                                            <b>Warengesamtpreis</b>
                                        </label>
                                    </td>
                                    <td class="cell-shipping-price cell-cart-price-total-total">
                                        <?php (is_logged()) ? '' : print str_replace(".", ",", number_format((float)$cart_totals['total']['value'] - (float)@$cart_totals['shipping']['value'], 2)) . "€"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>
                                            <?php _e("Versandkosten"); ?>
                                            :</label></td>
                                    <td class="cell-shipping-price">
                                        <div class="mw-big-cart-shipping-price" style="display:inline-block">
                                            <module type="shop/shipping" view="cost" />
                                        </div>
                                    </td>
                                </tr>

                                <?php if ($sub_interval != null) { ?>
                                    <tr>
                                        <td><label>
                                                <?php _e("Gewünschter Lieferintervall"); ?>
                                                :</label></td>
                                        <td class="cell-shipping-price">
                                            <?php print $sub_interval->sub_interval; ?>
                                        </td>
                                    </tr>
                                <?php } ?>


                                <tr>
                                    <td>
                                        <label for="">
                                            <b>Gesamtpreis</b>
                                        </label>
                                    </td>
                                    <td class="cell-shipping-price cell-cart-price-total-subtotal">
                                        <?php (is_logged()) ? '' : print $cart_totals['total']['amount']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="" class="tax_for_country">
                                            darin enthalten <?php print (is_logged()) ? (int)taxRateCountry(user_id()) . "% USt" : taxRate() . "% USt."; ?>
                                        </label>
                                    </td>
                                    <td class="cell-shipping-price cell-cart-price-total-tax">
                                        <?php (is_logged()) ? '' : print $cart_totals['tax']['amount']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="">
                                            <b>Nettobetrag</b>
                                        </label>
                                    </td>
                                    <td class="cell-shipping-price cell-cart-price-total-netto">
                                        <?php (is_logged()) ? '' : print str_replace(".", ",", number_format((float)round($cart_totals['total']['value'], 2) - (float)round(@$cart_totals['tax']['value'] ?? 0, 2), 2)) . "€"; ?>
                                    </td>
                                </tr>

                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>






        <?php endif;
        ?>
        <?php
        if (!isset($params['checkout-link-enabled'])) {
            $checkout_link_enanbled = get_option('data-checkout-link-enabled', $params['id']);
        } else {
            $checkout_link_enanbled = $params['checkout-link-enabled'];
        }
        ?>
        <?php if ($checkout_link_enanbled != 'n') : ?>
            <?php $checkout_page = get_option('data-checkout-page', $params['id']); ?>
            <?php if ($checkout_page != false and strtolower($checkout_page) != 'default' and intval($checkout_page) > 0) {
                $checkout_page_link = content_link($checkout_page) . '/view:checkout';
            } else {
                $checkout_page_link = site_url('checkout');
            }
            ?>
            <a class="btn  btn-warning pull-right" href="<?php print $checkout_page_link; ?>">
                <?php _e("Checkout"); ?>
            </a>
        <?php endif; ?>
    <?php else : ?>
        <h4 class="alert alert-warning">
            <?php _e("Noch keine Artikel im Warenkorb"); ?>
        </h4>
    <?php endif;
    ?>
</div>
<?php if (isset($_GET['slug'])) { ?>
    <script>
        // if(sessionStorage.getItem("quick_cart") != "cart") {
        $(document).ready(function() {
            var i = 0;
            // const urlParams = new URLSearchParams(window.location.search);
            // console.log(sessionStorage.getItem("quick_cart"))

            mw.cart.add_item('<?php print $data["id"] ?>');
            // sessionStorage.setItem("quick_cart", "cart");

        });
        // }
    </script>
<?php } ?>

<script>
    // Get Checkedbox agreement
    <?php if ($shop_require_terms == 1) : ?>
        $("#complete_order_button").prop("disabled", true);
        $('#agreewarn').show();
        $('#agreeterm').click(function() {
            if ($('#agreecondition').is(":checked")) {
                if ($(this).is(":checked")) {
                    $('#agreewarn').hide();
                    $("#complete_order_button").prop("disabled", false);
                } else if ($(this).is(":not(:checked)")) {
                    $("#complete_order_button").prop("disabled", true);
                    $('#agreewarn').show();

                }
            } else {
                $("#complete_order_button").prop("disabled", true);
                $('#agreewarn').show();
            }
        });
        $('#agreecondition').click(function() {
            if ($('#agreeterm').is(":checked")) {
                if ($(this).is(":checked")) {
                    $('#agreewarn').hide();
                    $("#complete_order_button").prop("disabled", false);
                } else if ($(this).is(":not(:checked)")) {
                    $("#complete_order_button").prop("disabled", true);
                    $('#agreewarn').show();
                }
            } else {
                $("#complete_order_button").prop("disabled", true);
                $('#agreewarn').show();
            }
        });
    <?php else : ?>
        $(document).ready(function() {
            $('#agreewarn').hide();
        });
    <?php endif; ?>
    // End Get Checkedbox agreement
    $('.country-rate').change(function() {
        $.post("<?= url('/') ?>/api/v1/cart_totals", {
            data:$("#country_set").val(),product:$("#p_id_val").val() ,taxr:$("#p_tax").val()
        }, (res) => {
            if(res.success){
                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                $('.tax_for_country').html('darin enthalten ' + res.cart_totals.tax_rate.amount + '% USt.');
            }
        });
    });
</script>
