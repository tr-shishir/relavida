<?php

/*

type: layout

name: Latest Blog Posts

position: 3

*/

?>

<div class="nk-box bg-gray-1 nodrop edit safe-mode" field="layout-skin-3-<?php print $params['id'] ?>" rel="module" id="blog">
    <div class="nk-gap-4 mt-5"></div>

    <h2 class="text-xs-center display-4">Latest Blog</h2>

    <div class="nk-gap mnt-6"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 allow-drop">
                <div class="text-xs-center">Donec orci sem, pretium ac dolor et, faucibus faucibus mauris. Etiam,pellentesque faucibus. Vestibulum gravida volutpat ipsum non ultrices.
                </div>
            </div>
        </div>
    </div>

    <div class="nk-gap-2 mt-12"></div>
    <div class="container">
        <module type="posts" />
    </div>
    <div class="nk-gap-5 mt-20"></div>
</div>
