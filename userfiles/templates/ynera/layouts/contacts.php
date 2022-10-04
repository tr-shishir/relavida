<?php

/*

type: layout
content_type: static
name: Contact Us

description: Contact us layout
position: 7
*/


?>


<?php include template_dir() . "header.php"; ?>

<script>
$(document).ready(function() {
    $('.navigation-holder').addClass('not-transparent');
})
</script>

<div class="edit " rel="content" field="ynera_contentt">
    <module type='layouts' template='page-banner/page-banner' />
    <module type="layouts" template="skin-10" />
    <!-- <module type="contact_form" /> -->
</div>

<?php include template_dir() . "footer.php"; ?>