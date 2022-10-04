<?php

/*

type: layout

name: Portfolio With Categories

position: 10

*/

?>


<div class="nodrop edit safe-mode" field="layout-skin-10-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br/>
                <br/>
                <module type="categories" template="default" content_id="<?php print PAGE_ID; ?>"/>

                <module type="posts" template="skin-2"/>
            </div>
        </div>

        <div class="nk-gap-4"></div>

    </div>
</div>