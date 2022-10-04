<?php

/*

type: layout
content_type: dynamic
name: Shop
is_shop: y
description: Showcase shop items in a sylish grid arrangement.
position: 4
*/


?>
<?php include template_dir() . "header.php"; ?>
<script>
    $(document).ready(function () {
        $('.navigation-holder').addClass('not-transparent');
    })
</script>

<div class="edit" rel="content" field="theplace_content">
    <module type="layouts" template="skin-4"/>
    <module type="layouts" template="skin-22"/>
</div>


<?php include template_dir() . "footer.php"; ?>
