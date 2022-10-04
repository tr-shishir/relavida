<?php
/*
type: layout
name: Checkout
position: 3
description: Checkout
*/
?>
<?php include template_dir() . "header.php"; ?>
    <div class="edit" rel="content" field="snow_content">
        <div class="container nodrop">
            <div class="row">
                <div class="col-lg-12">
                    <module type="shop/checkout" id="cart_checkout"/>
                </div>
            </div>
        </div>
    </div>
<?php include template_dir() . "footer.php"; ?>