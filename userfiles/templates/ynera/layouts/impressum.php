<?php
/*
type: layout
name: Impressum
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
        <h2 class="edit" field="impressum_heading" rel="content">Impressum</h2>
    </div>
    <div class="container legalModule-content">
        <div class="row">
            <div class="col-md-12">
                <module type="legals/imprint"/>
            </div>
        </div>
    </div>
</section>

<?php include template_dir() . "footer.php"; ?>