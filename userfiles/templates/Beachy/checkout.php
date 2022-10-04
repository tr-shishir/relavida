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

<div class="edit" rel="content" field="new-world_content">
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


