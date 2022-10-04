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
    <div class="edit about-main-wrapper" rel="content" field="marcando_content">
        <module type="layouts" template="about-us-breadcumb"/>
        <div class="about-wrapper">
            <module type="layouts" template="about-us-top-layout"/>
            <module type="layouts" template="feature-layout"/>
            <module type="layouts" template="testimonial-layout"/>
            <module type="layouts" template="brand-layout"/>
        </div>
    </div>

<?php include template_dir() . "footer.php"; ?>