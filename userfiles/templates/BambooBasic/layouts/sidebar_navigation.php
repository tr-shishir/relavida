<?php

/*

type: layout
content_type: dynamic
name: FAQ Page
position: 3
description: Sidebar Navigation Page

*/


?>

<?php include template_dir() . "header.php"; ?>
<script>
    $(document).ready(function () {
        $('.navigation-holder').addClass('not-transparent');
    })
</script>
<div class="fullwidth-with-sidebar">
    <div class="fwidht-sidebar">
        <div class="fw-sidebar-box">
            <module type="sidebar_navigation"/>
        </div>
    </div>
    <div class="fwidth-content edit" rel="content" field="sidebar_navigation_page">
        <module type="layouts" template="faq-heading-default"/>
    </div>
</div>

<?php include template_dir() . "footer.php"; ?>

<!-- This two file for sidebar navigation module -->
<?php include modules_path() . "sidebar_navigation/modal.php"; ?>
<?php include modules_path() . "sidebar_navigation/sidebar_nav_script.php"; ?>
