<?php

/*

type: layout

name: Checkout

description: Checkout

*/


?>
<script type="text/javascript">
    mw.require("<?php print modules_url(); ?>shop/checkout/styles.css", true);
 </script>

<div class="checkout-modal" id="checkout_modal_<?php print $params['id'] ?>">
    <div>
        <?php if ($requires_registration and is_logged() == false): ?>

            <script>
                $(document).ready(function () {

                    if (!!$.fn.selectpicker) {
                        $('#loginModal').modal();
                    }

                })
            </script>


            <a></a>


        <?php else: ?>
            <div class="clear"></div>


            <form class="mw-checkout-form" id="checkout_form_<?php print $params['id'] ?>" method="post">


                <div class="modal-content">

                    <div class="modal-body">
                        <div class="js-step-content js-shopping-cart">


                            <?php $cart_show_enanbled = get_option('data-show-cart', $params['id']); ?>
                            <?php if ($cart_show_enanbled != 'n'): ?>
                                <br/>
                                <module type="shop/cart" template="small-customized" data-checkout-link-enabled="n"
                                        id="cart_checkout_<?php print $params['id'] ?>"/>

                            <?php endif; ?>


                        </div>

                    </div>
                </div>

            </form>
            <div class="mw-checkout-response"></div>


        <?php endif; ?>
    </div>
</div>


<script>


    $(document).ready(function () {

        mw.cart.modal.init('#checkout_modal_<?php print $params['id'] ?>')


        setTimeout(function () {

            $('.step-button:nth-child(1) .js-show-step', '#checkout_modal_<?php print $params['id'] ?>').addClass('active');
            $('.js-step-content:nth-child(1)', '#checkout_modal_<?php print $params['id'] ?>').show();



            <?php  if($payment_success){ ?>
            mw_cart_show_payment_success_tab()

            <?php }  ?>




        }, 500);


        mw.on('mw.cart.checkout.success', function (event, data) {


            if (typeof(data.order_completed) != 'undefined' && data.order_completed) {
                mw_cart_show_payment_success_tab()
            }

        });


    });


    function mw_cart_show_payment_success_tab() {
        $('.js-show-step', '#checkout_modal_<?php print $params['id'] ?>').off('click');

        $('.step-button .js-show-step', '#checkout_modal_<?php print $params['id'] ?>').removeClass('active');
        $('.step-button', '#checkout_modal_<?php print $params['id'] ?>').addClass('muted');
        $('.js-step-content', '#checkout_modal_<?php print $params['id'] ?>').hide();


        $('.step-button:nth-child(4)', '#checkout_modal_<?php print $params['id'] ?>').removeClass('muted');
        $('.step-button:nth-child(4) .js-show-step', '#checkout_modal_<?php print $params['id'] ?>').addClass('active');
        $('.js-step-content:nth-child(4)', '#checkout_modal_<?php print $params['id'] ?>').show();


    }


</script>