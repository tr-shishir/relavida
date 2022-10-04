<?php

/*

type: layout
content_type: static
name: Clean
position: 2
is_default: true
description: Clean layout

*/


?>
<?php include template_dir() . "header.php"; ?>

<script>
    $(document).ready(function () {
        $('.navigation-holder').addClass('not-transparent');
    })
</script>

<div class="edit" rel="content" field="bamboo_content">
    <module type="layouts" template="skin-1"/>
</div>

<?php include template_dir() . "footer.php"; ?>
