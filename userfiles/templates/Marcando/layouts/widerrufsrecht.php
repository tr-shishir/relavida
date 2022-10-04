<?php
/*
type: layout
name: Widerrufsrecht
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

<style>
    
    .legalModule-heading {
        position: relative;
    }

    .legalModule-heading .breadcumb-bg-for-legal-page {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
    }

    .legalModule-heading .breadcumb-bg-for-legal-page img.legal_page_bg {
        height: 100% !important;
        width: 100%;
        object-fit: cover;
        object-position: center center;
    }

    .legalModule-heading h2 {
        position: relative;
        z-index: 1;
    }
</style>

<section>
    <div class="legalModule-heading edit" field="agbModule_legal_heading_widerrufsrecht" rel="content">
        <div class="breadcumb-bg-for-legal-page">
            <img src="<?php print template_url(); ?>assets/image/shop-breadcrumb.jpg" alt="" class="legal_page_bg" >
        </div>
        <h2 class="edit" field="legalCancellation_heading" rel="content">Widerrufsrecht</h2>
    </div>
    <div class="container legalModule-content">
        <div class="row">
            <div class="col-md-12">
                <module type="legals/cancellation-policy"/>
            </div>
        </div>
    </div>
</section>

<?php include template_dir() . "footer.php"; ?>