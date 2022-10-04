<?php

/*

type: layout

content_type: dynamic

name: Posts

position: 13

*/

?>
<section class="section safe-mode nodrop" field="layout-shop-main-layout-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="blog-container">
            <div class="row">
                <div class="col-md-12">
                    <module type="posts" />
                </div>
            </div>
        </div>
    </div>
</section>