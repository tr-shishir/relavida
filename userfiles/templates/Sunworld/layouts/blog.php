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

    <div class="edit blog-main-page" rel="content" field="active_content">
        <module type="layouts" template="skin-32"/>
        <module type="layouts" template="skin-13"/>
        <module type="layouts" template="skin-18"/>
    </div>

<?php include template_dir() . "footer.php"; ?>