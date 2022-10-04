<?php

/*

type: layout
name: Hero
position: 20
*/


?>

<style>
.hero-bg-wrapper {
    padding: 160px 0px;
}

.hero-wrapper .button:not(:last-child) {
    margin-bottom: 10px;
}

.hero-wrapper .button .icon {
    color: #fff;
}
</style>


<section class="hero-wrapper edit " field="layout-hero<?php print $params['id'] ?>" rel="module">
    <div class="overlay"></div>
    <div class="bg-cover hero-bg-wrapper"
        style="background-image: url('<?php print template_url(); ?>/assets/images/hero-bg.jpg')">
        <div class="container">
            <div class="hero-content">
                <p class="hero-text">IHR ANBIETER FÜR RASENPFLEGE PRODUKTE</p>
                <h1>YNERA RASEN</h1>
                <h2>FREUDE AM RASEN ERLEBEN</h2>
                <div class="hero-actions">
                    <a href="#" class="button button-primary">
                        JETZT EINKAUFEN
                        <span class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </span>
                    </a>
                    <a href="#" class="button button-secondary">
                        ÜBER UNS
                        <span class="icon">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>