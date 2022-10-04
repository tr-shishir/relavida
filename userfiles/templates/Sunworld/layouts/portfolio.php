<?php

/*

type: layout
content_type: dynamic
name: Portfolio
position: 3
description: Portfolio

*/


?>
<?php include template_dir() . "header.php"; ?>

    <div class="edit" rel="content" field="active_content">

        <section class="section-9 p-t-50 p-b-0 safe-mode nodrop">
            <div class="container allow-drop">
                <h2>Portfolio</h2>
                <h3>Take a look our outstanding project we are make.</h3>
                <p>This is our special portfolio and we are proud to share it.</p>
            </div>
        </section>

        <section class="section projects p-t-20 p-b-50">
            <div class="container">
                <div class="masonry-gallery">
                    <module type="categories" template="skin-1" max_level="1"/>
                    <module type="posts" template="skin-2"/>
                </div>
            </div>
        </section>
    </div>

<?php include template_dir() . "footer.php"; ?>