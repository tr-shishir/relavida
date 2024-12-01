<?php

/*

type: layout
content_type: dynamic
name: Blog
position: 3
description: Blog 2

*/


?>
<?php include template_dir() . "header.php"; ?>

<div class="edit blog-main-wrapper" rel="content" field="marcando_content">
    <module type="layouts" template="blog-breadcumb"/>
    <module type="layouts" template="blog-main-layout"/>
</div>

<?php include template_dir() . "footer.php"; ?>
