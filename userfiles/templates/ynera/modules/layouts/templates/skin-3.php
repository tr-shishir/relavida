<section class="section nodrop edit" field="layout-product-slider-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="home-product-slider-wrapper">
            <div class="home-product-slider-heading">
                <h3>Products</h3>
            </div>
            <div class="home-product-slider-content">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="home-product-slider-left-image">
                            <img src="<?php print template_url(); ?>assets/image/home-product-slider-image.jpg" alt=""
                                class="hps-bg">
                            <div class="home-product-slider-left-image-content">
                                <h6>Fresh Fruit</h6>
                                <h4>Fresh Summer With</h4>
                                <h4>Just $200.99</h4>
                                <a href="">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <module type="shop/products" template="skin-3" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>