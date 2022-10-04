<?php

/*

type: layout

name: Default

description: Default cart template

*/

?>

<style>
    .checkout-checkbox .tm-checkbox {
        width: 28px !important;
    }

    [id*="module-settings-one-product-checkout-"] .mw-dialog-holder {
        width: 800px !important;
    }

    .one-product-checkout-hide-elements .main div[field='bamboo_content'] >div:not(.one-product-checkout-wrapper) {
        display: none;
    }
    .one-product-checkout-wrapper {
        margin-top: 100px;
    }

    .op-checkout-step-btn {
        margin-top: 20px;
    }

    @media(min-width: 992px) {
        .payment-holder-wrapper {
            position: relative;
        }

        input#act_button {
            margin-bottom: 0px;
        }
    }
</style>

<?php if ($requires_registration and is_logged() == false) : ?>
    <module type="users/register" />
<?php else : ?>
    <?php if ($payment_success == false) : ?>

        <form class="mw-checkout-form" id="checkout_form_<?php print $params['id'] ?>" method="post" action="<?php print api_link('checkout') ?>">
            <?php $cart_show_enanbled = get_option('data-show-cart', $params['id']); ?>
            <?php if ($cart_show_enanbled != 'n') : ?>
                <br />
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-stepper">
                                <form id="msform">

                                    <?php $single_product = DB::table('single_checkout_products')->where('module_id', $params['id'])->first();
                                    if (!$single_product) : ?>
                                        <?php if(is_admin()) : ?>
                                            <div id="one-product-alert" class="alert alert-danger" role="alert">
                                                <p class="text-center">Please add a product from edit option for one product checkout!</p>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <ul id="progressbar">
                                        <li class="active">
                                            <span class="previous">Bestellabwicklung</span>
                                        </li>
                                        <li>
                                            <span>Bestellung pr&uuml;fen</span>
                                        </li>
                                    </ul>

                                    <fieldset class="fieldset" id="first-fld">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php include(__DIR__ . '/partials/shipping-and-payment.php'); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="payment-holder-wrapper">
                                                <?php if ($cart_show_payments != 'n') : ?>
                                                    <div class="mw-shop-checkout-payments-holder">
                                                        <?php
                                                        $u_id = user_id();
                                                        if (session_id() == '') {
                                                            session_start();
                                                        }
                                                        $get_session = get_option('session_id', 'user_session');
                                                        $u_session = session_id();
                                                        $sub = DB::table('subscription_order_status')->where('order_id', null)->where('user_id', $u_id)->where('session_id', $u_session)->orderBy('id', 'desc')->first();
                                                        $sub1 = DB::table('subscription_order_status')->where('order_id', null)->where('user_id', $u_id)->where('session_id', $get_session)->orderBy('id', 'desc')->first();
                                                        if ($sub == null and $sub1 == null) { ?>
                                                            <module type="shop/payments" />
                                                        <?php } else { ?>
                                                            <module type="shop/payments/gateways/subscription" />
                                                        <?php } ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="op-checkout-step-btn" style="text-align:right">
                                                    <input type="button" name="next" class="next action-button btn btn-success" onclick="oneproductcart('<?= $params['id'] ?>')" id="act_button" value="<?php _e("Weiter zur Bestell&uuml;bersicht"); ?>" />
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset class="fieldset" id="second-fld">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <module type="shop/cart" template="big" id="cart_checkout_<?php print $params['id'] ?>" data-checkout-link-enabled="n" />

                                                </div>
                                                <?php $terms = true;
                                                $terms2 = true;
                                                $terms3 = true; ?>
                                                <div class="checkout-button" style="">

                                                    <?php $shop_page = $GLOBALS['shop_data']; ?>


                                                    <?php
                                                    if (get_cart() || isset($_GET['slug'])) {
                                                        $tk = site_url('thank-you');
                                                    } else {
                                                        $tk = site_url('checkout');
                                                    }
                                                    ?>
                                                    <?php
                                                    if (get_option('shop_require_terms', 'website') == 1) {

                                                    ?>

                                                        <script>
                                                            $(document).ready(function() {

                                                                $("#complete_order_button").prop("disabled", true);

                                                                $('#myCheck').click(function() {
                                                                    if ($(this).is(":checked")) {
                                                                        $("#complete_order_button").prop("disabled", false);
                                                                    } else if ($(this).is(":not(:checked)")) {
                                                                        $("#complete_order_button").prop("disabled", true);
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                    <?php
                                                    }

                                                    ?>
                                                    <span class="text-danger pull-right" id="agreewarn"><?php _e("You must check &quotIch akzeptiere die...&quot and &quotIch habe das...&quot") ?></span></br>
                                                    <button class="btn btn-warning pull-right mw-checkout-btn" onclick="mw.cart.checkout('#checkout_form_<?php print $params['id'] ?>', '<?= $tk ?>');" type="button" id="complete_order_button">
                                                        <?php _e("Zahlungspflichtig bestellen"); ?>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="alert hide">

            </div>
        </form>
        <div class="mw-checkout-responce"></div>
    <?php else : ?>
        <h2>
            <?php _e("Your payment was successfull."); ?>
        </h2>
    <?php endif; ?>
<?php endif; ?>


<script type="text/javascript">
    function changeBtnStatus(status, country) {
        if (status && country) {
            $('#act_button').removeAttr('disabled');

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


        } else {
            $('#act_button').prop('disabled', true);
        }
    }
    (function() {
        let isEmpty = false;
        let country = false;
        let status = false;
        $(document).on('keyup', '.input-required', function() {
            country = $('.countrySelectBox').find(":selected").val() ? true : false;
            $(document).find('.input-required').each(function() {
                if ($(this).val().trim().length > 0) {
                    isEmpty = true;
                } else {
                    return isEmpty = false;
                }
            });
            // console.log(isEmpty);
            // console.log(country);
            changeBtnStatus(isEmpty, country);
        });
        $(document).on('change', '.countrySelectBox', function() {
            country = $('.countrySelectBox').find(":selected").val() ? true : false;
            $(document).find('.input-required').each(function() {
                if ($(this).val().trim().length > 0) {
                    isEmpty = true;
                } else {
                    return isEmpty = false;
                }
            });
            changeBtnStatus(isEmpty, country);
        });
    })()
    $(document).ready(function() {

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

        //jQuery time
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches

        $("#second-fld").css("display", "none");

        $(".next").click(function() {
            $(".module-one-product-checkout[data-type='one_product_checkout']").addClass("one-product-checkout-wrapper");
            $("body").addClass("one-product-checkout-hide-elements");
            if (animating) return false;
            animating = true;

            current_fs = $(this).parents('.fieldset');
            next_fs = $(this).parents('.fieldset').next();

            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50) + "%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(' + scale + ')'
                    });
                    next_fs.css({
                        'left': left,
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function() {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".previous").click(function() {
            $("body").removeClass("one-product-checkout-hide-elements");
            // console.log("aaaa");
            if (animating) return false;
            animating = true;

            current_fs = $("#second-fld");
            previous_fs = $("#first-fld");

            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'left': left
                    });
                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function() {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

    });

    $("#act_button").on('click', function() {
        var data = {
            'first_name': $("#first_name").val(),
            'last_name': $("#last_name").val(),
            'email': $("#email").val(),
            'phone': $("#phone").val(),
            'country': $("#country_set").val(),
            'zip': $("#zip").val(),
            'city': $("#city").val(),
            'address': $("#address").val(),
        }
        $.post("<?= url('/') ?>/api/v1/checkout_contents", {
            all_info: data
        }, (res) => {
            if (res.success) {
                mw.reload_module('shop/cart')
            }
        });

    });

    $(window).load(function() {
        var checkoutAddress = $("#address").val();
        if (checkoutAddress) {
            $('#act_button').removeAttr('disabled');
        }
    });

    function oneproductcart(value) {
        $("#empty-cart-alert").css("display", "none");
        $.post("<?= api_url('single_product_id') ?>", {
            module_id: value,
        }).then((res, err) => {
            if (res.status) {
                mw.cart.add_item(res.product_id);
            } else {
                mw.notification.warning(res.message);
            }
        });
    }
    $(document).ready(function() {
        $(".previous").on('click',function(){
            $('html, body').scrollTop($('#first-fld').offset().top-300);
        });
    });
</script>
