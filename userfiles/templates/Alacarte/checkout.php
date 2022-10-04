<?php
/*
type: layout
name: Checkout
position: 3
description: Checkout
*/
?>

<?php include template_dir() . "header.php"; ?>

<script>
    $(document).ready(function () {
        $('.navigation-holder').addClass('not-transparent');
    })
</script>

<section>
    <div class="container checkout-modal">
        <div class="row">
            <div class="col-12 ">
                <module type="shop/checkout" id="cart_checkout"/>
            </div>
        </div>
    </div>
</section>

<?php include template_dir() . "footer.php"; ?>


