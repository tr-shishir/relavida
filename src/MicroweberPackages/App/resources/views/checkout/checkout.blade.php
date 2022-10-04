<!DOCTYPE html>
<html>
 <head></head>
 <body>
   <div id="checkout-container-div">
     <!-- checkout iframe will be embedded here -->
   </div>
   <?php
    $mode = get_option('easypay_testmode','payments');

    $domain = 'checkout.dibspayment.eu';
    $baseURI =  ($mode == 'n') ? ('https://' . $domain . '/v1/checkout.js?v=1') : ('https://test.' . $domain . '/v1/checkout.js?v=1');
    $checkoutKey = ($mode == 'n') ? get_option('easypay_checkout_api_key','payments') : get_option('easypay_test_checkout_api_key','payments');
    ?>
   <script
src="<?php print $baseURI ?>"></script>
   <script>

    document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const paymentId = urlParams.get('paymentId');
    if (paymentId) {
        const checkoutOptions = {
        checkoutKey: '<?=$checkoutKey?>', // Replace!
        paymentId: paymentId,
        containerId: "checkout-container-div",
        };
        const checkout = new Dibs.Checkout(checkoutOptions);
        checkout.on('payment-completed', function (response) {
        window.location = "<?php print $_REQUEST['returnUrl']; ?>";
        });
    } else {
        console.log("Expected a paymentId");   // No paymentId provided,
        window.location = 'cart.html';         // go back to cart.html
    }
    });

   </script>
 </body>
</html>
