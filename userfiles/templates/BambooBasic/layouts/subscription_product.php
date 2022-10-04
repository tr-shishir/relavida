<?php

/*

type: layout
content_type: static
name: subscription product

description: subscription product layout
position: 7
*/


?>
<?php include template_dir() . "header.php"; ?>
    <script>
        $(document).ready(function () {
            $('.navigation-holder').addClass('not-transparent');
        })
    </script>
    <?php if(isset($_REQUEST['id'])): ?>
        <div class="container subscription-container">
            <module type="shop/subscriptionProduct/template/manage"/>
        </div>
    <?php else : ?>
        <div class="container subscription-container">
            <module type="shop/subscriptionProduct/template/default"/>
        </div>
    <?php endif; ?>

<?php include template_dir() . "footer.php"; ?>