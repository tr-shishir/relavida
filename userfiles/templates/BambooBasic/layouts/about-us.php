<?php

/*

type: layout
content_type: static
name: About Us

description: About Us layout
position: 7
*/


?>
<?php include template_dir() . "header.php"; ?>
    <script>
        $(document).ready(function () {
            $('.navigation-holder').addClass('not-transparent');
        })
    </script>

    <div class="edit" rel="content" field="bamboo_content">
        <module type="layouts" template="skin-20"/>
    </div>

<?php include template_dir() . "footer.php"; ?>