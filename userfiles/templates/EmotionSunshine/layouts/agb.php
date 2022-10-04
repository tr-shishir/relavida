<?php
/*
type: layout
name: Agb
position: 3
description: Checkout
*/
?>
<?php include template_dir() . "header.php"; ?>

<section>
    <div class="legalModule-heading">
        <h2 class="edit" field="agbModule_heading" rel="content">Agb</h2>
    </div>
    <div class="container legalModule-content">
        <div class="row">
            <div class="col-md-12">
                <module type="legals/agb"/>
            </div>
        </div>
    </div>
</section>

<?php include template_dir() . "footer.php"; ?>