<?php

/*

type: layout

name: Hero Area Category

position: 1

*/

?>

<section class="section nodrop edit" field="layout-home-banner-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="header-banner">
            <div class="row">
                <div class="col-lg-4">
                    <div class="category-list homepageCategoryList">
                        <module type="shop_categories" content-id="<?php print $GLOBALS['shop_data'][0]['id'] ?? PAGE_ID; ?>"/>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="home-banner-wrapper">
                        <div class="home-banner-wrapper-top">
                            <div class="home-banner-wrapper-top-slider">
                                <module type="slider" template="slickslider-skin-4"/>
                            </div>
                            <div class="home-banner-wrapper-top-cat">
                                <div class="home-banner-wrapper-top-cat-sample">
                                    <div class="home-banner-wrapper-top-cat-sample-content">
                                        <h5>Electronics</h5>
                                        <a href="">Shop Now</a>
                                    </div>
                                    <div class="home-banner-wrapper-top-cat-sample-image">
                                        <img src="<?php print template_url(); ?>assets/image/cat.png" alt="">
                                    </div>
                                </div>
                                <div class="home-banner-wrapper-top-cat-sample">
                                    <div class="home-banner-wrapper-top-cat-sample-content">
                                        <h5>Electronics</h5>
                                        <a href="">Shop Now</a>
                                    </div>
                                    <div class="home-banner-wrapper-top-cat-sample-image">
                                        <img src="<?php print template_url(); ?>assets/image/cat.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="home-banner-wrapper-bottom">
                            <div class="home-banner-wrapper-top-cat-sample">
                                <div class="home-banner-wrapper-top-cat-sample-content">
                                    <h5>Electronics</h5>
                                    <a href="">Shop Now</a>
                                </div>
                                <div class="home-banner-wrapper-top-cat-sample-image">
                                    <img src="<?php print template_url(); ?>assets/image/cat.png" alt="">
                                </div>
                            </div>
                            <div class="home-banner-wrapper-top-cat-sample">
                                <div class="home-banner-wrapper-top-cat-sample-content">
                                    <h5>Electronics</h5>
                                    <a href="">Shop Now</a>
                                </div>
                                <div class="home-banner-wrapper-top-cat-sample-image">
                                    <img src="<?php print template_url(); ?>assets/image/cat.png" alt="">
                                </div>
                            </div>
                            <div class="home-banner-wrapper-top-cat-sample">
                                <div class="home-banner-wrapper-top-cat-sample-content">
                                    <h5>Electronics</h5>
                                    <a href="">Shop Now</a>
                                </div>
                                <div class="home-banner-wrapper-top-cat-sample-image">
                                    <img src="<?php print template_url(); ?>assets/image/cat.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    $(window).on('load', function(){
        $('.homepageCategoryList ul.nav li:has(ul)').addClass('has-sub');
        $('.homepageCategoryList .well>ul.nav>li.has-sub>ul').wrap( '<div class="subCatWrapper"></div>');
        $('.homepageCategoryList ul.nav li.has-sub>a').append('<span class="subcat-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>');
    });
</script>