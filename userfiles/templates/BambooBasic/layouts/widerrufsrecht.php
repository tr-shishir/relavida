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



<section>
    <div class="legalModule-heading">
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