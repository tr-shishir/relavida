<?php

/*

type: layout

name: Home Banner

position: 0

*/

?>

<section class="sec-padd-50 edit" field="layout-home-banner-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="home-banner-inner" style="background:url('<?php print template_url(); ?>assets/image/home-banner.jpg');background-size:cover;background-position:center;">
                    <div class="home-banner-content">
                        <a href=""><h2>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h2></a>
                        <p>Lorem Ipsum | 15. Februar 2021 | Uncategorized | 0 Kommentieren</p>
                        <p>
                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'
                        </p>
                        <module type="btn" template="bootstrap" button_style="btn-home-banner" text="Lesen Sie mehr"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
