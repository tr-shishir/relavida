<?php

/*

type: layout

name: Blog with sidebar

position: 8

*/

?>
<section class="section safe-mode nodrop" field="layout-bolg-with-sidebar-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include TEMPLATE_DIR . 'layouts' . DS . "blog_sidebar.php" ?>
            </div>
            <div class="<?php if($GLOBALS['custom_active_category'] == get_content('layout_file=layouts__blog.php')[0]['id']) {
                print "col-md-12" ;
            } else{
                print "col-md-9" ;
            } ?>">
                <module type="posts" />
            </div>
        </div>
    </div>
</section>