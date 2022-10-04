

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-70';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-70';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="edit sec-padd-50 safe-mode nodrop" field="layout-skin-20-<?php print $params['id'] ?>" rel="module">

    <div class="" id="ab-hero-section" class="custom-mt container">
        <div class="ab-hero-wrapper">
            <div class="ab-hero-banner">
                <img src="<?php print template_url(); ?>assets/image/about_bg.jpg">
                <div class="ab-banner-text">
                    <h1><?php print _lang('Emotion Sunshine', 'templates/bamboo'); ?></h1>
                    <p><?php print _lang('Alles über uns', 'templates/bamboo'); ?></p>
                </div>
            </div>
            <div class="container">
                <div class="row ab-hero-content">
                    <div class="col-md-6">
                        <div class="ab-hero-content-left">
                            <h4>Über unseren Shop</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <span>Emotion Sunshine</span>
                        </div>
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="ab-hero-content-right">
                            <img src="<?php print template_url(); ?>assets/image/person_1.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ab-hero-content-left resp-content">
        <h4>Über unseren Shop</h4>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <span>Emotion Sunshine</span>
    </div>

    <!-- About Us Section Start -->
    <div id="about-us" class="custom-pb">
        <div class="about-top">
            <div class="about-top-text">
                <h4>About Us</h4>
            </div>
            <div class="shop-divider"></div>
        </div>
        <div class="container">
            <div class="row about-wrapper">
                <div class="col-md-6 about-left">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        <br><br>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        <br><br>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        <br><br>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        <br><br>
                        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
                </div>
                <div class="col-md-6 about-right">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="about-single">
                                <div class="about-single-top">
                                    <i class="far fa-star"></i>
                                    <h5>Instagram</h5>
                                </div>
                                <div class="about-divider"></div>
                                <div class="about-single-text">
                                    <p>Share our products in your home</p>
                                </div>
                            </div>
                            <div class="about-single">
                                <div class="about-single-top">
                                    <i class="fas fa-dollar-sign"></i>
                                    <h5>Secure payment</h5>
                                </div>
                                <div class="about-divider"></div>
                                <div class="about-single-text">
                                    <p>Gladly k each rehearsal with us in installments to pay by card or PayPal.
                                        <br><br>
                                        We guarantee the highest level of security and data protection through SSL
                                        encryption</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-single">
                                <div class="about-single-top">
                                    <i class="fas fa-globe"></i>
                                    <h5>Facebook</h5>
                                </div>
                                <div class="about-divider"></div>
                                <div class="about-single-text">
                                    <p>Follow us on Facebook so you don't miss any news</p>
                                </div>
                            </div>
                            <div class="about-single">
                                <div class="about-single-top">
                                    <i class="far fa-lightbulb"></i>
                                    <h5>Free delivery and return</h5>
                                </div>
                                <div class="about-divider"></div>
                                <div class="about-single-text">
                                    <p>Fill out the return slip, create and print out the label online and stick it on
                                        the package.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Section End -->
    <!-- Discount Section Start -->
    <div id="discount-section" class="custom-pb">
        <div class="container">
            <div class="discount-main">
                <img src="<?php print template_url(); ?>assets/image/newsletter_bg_1.jpg">
                <div class="discount-text">
                    <h4>GET A 15% DISCOUNT ON YOUR FIRST ORDER</h4>
                    <p>Register here to receive our newsletter.</p>
                    <span>[caldera_form id="CF59c8d8a75c5cd"]</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Discount Section End -->

    <!-- About Brand Section Start -->
    <div id="ab-brand" class="custom-pb">
        <div class="ab-brand-top">
            <div class="about-brand-top-text">
                <h4>Our Brands</h4>
            </div>
            <div class="shop-divider"></div>
        </div>
        <div class="container">
            <div class="row ab-brand">
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand2.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand3.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand4.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand5.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand6.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand7.png" alt="">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 ab-brand-single">
                    <div class="ab-brand-img">
                        <img src="<?php print template_url(); ?>assets/image/brand8.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Brand Section End -->
</section>