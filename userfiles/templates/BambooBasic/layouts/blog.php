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
    <script>
        $(document).ready(function () {
            $('.navigation-holder').addClass('not-transparent');
        })
    </script>

    <div class="edit blog-main-page" rel="content" field="bamboo_content">
        <module type="layouts" template="skin-20"/>
        <module type="layouts" template="skin-13"/>
    </div>

<?php include template_dir() . "footer.php"; ?>