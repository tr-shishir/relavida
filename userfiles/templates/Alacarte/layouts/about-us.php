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

    <div class="edit" rel="content" field="theplace_content">
          <module type="layouts" template="skin-3"/>
          <module type="layouts" template="skin-8"/>
    </div>

<?php include template_dir() . "footer.php"; ?>