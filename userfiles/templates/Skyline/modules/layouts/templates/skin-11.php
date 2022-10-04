<?php



?>


<div class="nodrop edit safe-mode" field="layout-skin-11-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br/>
                <br/>
                <module type="categories" content_id="<?php print PAGE_ID; ?>" template="horizontal-list-1"/>

                <module type="shop/products" limit="18" template="list-1" description-length="70"/>
            </div>
        </div>
    </div>
</div>