<?php
/*
type: layout
name: Checkout
position: 3
description: Checkout
*/
?>

<?php include template_dir() . "header.php"; ?>

<div class="edit" rel="content" field="bamboo_content_checkout">
    <module type="layouts" template="skin-17"/>
</div>


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
