<?php

/*

type: layout
content_type: dynamic
name: page banner
position: 24
description: Page banner

*/


?>

<style>
.page-banner .banner-bg {
    padding: 100px 0px;
}
</style>


<section class="page-banner bg-cover edit" field="layout-pages-banner<?php print $params['id'] ?>" rel="module">
    <div class="overlay"></div>
    <div class="banner-bg bg-cover"
        style="background-image: url('<?php print template_url(); ?>/assets/images/hero-bg.jpg')">
        <div class="container">
            <div class="banner-content">
                <h1>Page Title</h1>
                <p class="body-text light">
                    füllen Sie bitte das untenstehende Kontaktformular aus. Wir melden uns in
                    Kürze bei Ihnen. Sie erreichen uns auch unter +49 33205-23407.
                </p>
            </div>
        </div>
    </div>
</section>