<?php include template_dir() . "header.php"; ?>
<?php
$next = next_content();
$prev = prev_content();
?>
<style>
    .shop-inner-page .product-gallery a {
        display: none;
    }
    /* .shop-inner-page .product-gallery a:first-child {
        display: block;
    } */

    .shop-inner-page .product-gallery a.showThisVariantImg {
        display: block;
    }

    span.readmore-btn {
        position: relative;
        cursor: pointer;
        text-decoration: underline;
        font-size: 16px;
        font-weight: 600;
    }


    .pdh-image {
        position: relative;
        width: 48%;
        float: left;
        z-index: 1;
        margin-right: 35px;
    }

    .ph-classic {}

    .ph-classic .cpad-0 {
        padding-left: 0px;
    }

    .ph-classic .price {
        text-align: center;
    }

    .price label {
        color: #000;
    }

    .ph-classic .description {
        min-height: 240px;
    }
</style>
<?php

$product_hide_or_not = DB::table('products')->where('content_id',CONTENT_ID)->where('category_hide',0)->first();

if(!isset($product_hide_or_not)){

    return redirect()->to('/new_page')->send();

}

?>

    <?php $classicLayout_value = get_option('classic_layout', 'product_classic_layout') ?? 0; ?>
    <?php $check_readmore_value = get_option('readMoreOption', 'product_readmore_layout') ?? 0; ?>
    <?php $checkWordLimit_value = get_option('readMoreLimit', 'product_readmore_limit') ?? 0; ?>

    <div class="shop-inner-page" id="shop-content-<?php print CONTENT_ID; ?>">
        <section class="p-t-100 p-b-50 fx-particles">
            <div class="container">
                <div class="row breadcrumb-container">
                    <div class="col-md-12">
                        <module type="breadcrumb" />
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-6 col-md-6">
                        <div class="next-previous-content float-right">
                            <?php if ($next != false) { ?>
                                <a href="<?php print $next['url']; ?>" class="next-content tip btn btn-outline-default" data-tip="#next-tip"><i class="fas fa-chevron-left"></i></a>

                                <div id="next-tip" style="display: none">
                                    <div class="next-previous-tip-content text-center">
                                        <img src="<?php print get_picture($next['id']); ?>" alt="" width="90" />

                                        <h6><?php print $next['title']; ?></h6>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($prev != false) { ?>
                                <a href="<?php print content_link($prev['id']); ?>" class="prev-content tip btn btn-outline-default" data-tip="#prev-tip"><i class="fas fa-chevron-right"></i></a>
                                <div id="prev-tip" style="display: none">
                                    <div class="next-previous-tip-content text-center">
                                        <img src="<?php print get_picture($prev['id']); ?>" alt="" width="90" />
                                        <h6><?php print $prev['title']; ?></h6>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="heading">
                    <h1 class="edit mobile-view-title" field="title" rel="content"><?php print content_title(); ?></h1>
                </div>


                <?php  if($classicLayout_value == "1") : ?>
                    <div class="row product-holder ph-classic">
                        <div class="col-md-12">
                            <div class="pdh-image">
                                <module type="pictures" rel="content" template="skin-6"/>
                            </div>

                            <div class="relative product-info-wrapper">
                                <div class="product-info">
                                    <div class="product-info-content">
                                        <div class="box">
                                            <div class="heading mobile-view-hide">
                                                <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-12 cpad-0" style="color:white;">
                                                    <?php
                                                        if(function_exists('category_shop_inner_show')){
                                                        echo category_shop_inner_show(content_id());
                                                        }
                                                    ?>
                                            </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-7 cpad-0">
                                                    <?php $content_data = content_data(CONTENT_ID);
                                                    $in_stock = true;
                                                    if (isset($content_data['qty']) and $content_data['qty'] != 'nolimit' and intval($content_data['qty']) == 0) {
                                                        $in_stock = false;
                                                    }
                                                    ?>

                                                    <?php if (isset($content_data['sku'])): ?>
                                                        <p class="labels"><?php _e("SKU Number") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                                    <?php endif; ?>

                                                    <?php if ($in_stock == true): ?>
                                                        <p class="labels">Availability: <span><?php _e("In Stock") ?></span></p>
                                                    <?php else: ?>
                                                        <p class="labels">Availability: <span><?php _e("Out of Stock") ?></span></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="description  <?php  if($check_readmore_value == "1") { echo "readmore-btn-enabled"; } ?>">
                                                <div class="edit" field="content_body" rel="content">
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                </div>
                                                <?php  if($check_readmore_value == "1") { ?>
                                                    <span class="readmore-btn">read more...</span>
                                                <?php } ?>
                                            </div>

                                            <module type="shop/cart_add"/>

                                        </div>

                                        <module type="comments" template="skin-2"/>
                                    </div>
                                </div>
                            </div>
                            <div class="edit" field="related_products" rel="inherit">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="owl-featured m-b-80 related-product-heading"><strong>Verbunden</strong> Produkte:</h2>
                                        <module type="shop/products" related="true" limit="6" hide_paging="true"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>

                    <div class="row product-holder">
                        <div class="col-12 col-lg-6">
                            <module type="pictures" rel="content" template="skin-6"/>
                        </div>

                        <div class="col-12 col-lg-6 relative product-info-wrapper">
                            <div class="product-info">
                                <div class="product-info-content">
                                    <div class="box">
                                        <div class="heading mobile-view-hide">
                                            <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-12" style="color:white;">
                                                <?php
                                                    if(function_exists('category_shop_inner_show')){
                                                    echo category_shop_inner_show(content_id());
                                                    }
                                                ?>
                                        </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-7">
                                                <?php $content_data = content_data(CONTENT_ID);
                                                $in_stock = true;
                                                if (isset($content_data['qty']) and $content_data['qty'] != 'nolimit' and intval($content_data['qty']) == 0) {
                                                    $in_stock = false;
                                                }
                                                ?>

                                                <?php if (isset($content_data['sku'])): ?>
                                                    <p class="labels"><?php _e("SKU Number") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                                <?php endif; ?>

                                                <?php if ($in_stock == true): ?>
                                                    <p class="labels">Availability: <span><?php _e("In Stock") ?></span></p>
                                                <?php else: ?>
                                                    <p class="labels">Availability: <span><?php _e("Out of Stock") ?></span></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="description  <?php  if($check_readmore_value == "1") { echo "readmore-btn-enabled"; } ?>">
                                            <div class="edit" field="content_body" rel="content">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                            </div>
                                            <?php  if($check_readmore_value == "1") { ?>
                                                <span class="readmore-btn">read more...</span>
                                            <?php } ?>
                                        </div>

                                        <module type="shop/cart_add"/>

                                    </div>

                                    <module type="comments" template="skin-2"/>
                                </div>
                            </div>
                        </div>
                        <div class="edit" field="related_products" rel="inherit">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="owl-featured m-b-80 related-product-heading"><strong>Verbunden</strong> Produkte:</h2>
                                    <module type="shop/products" related="true" limit="6" hide_paging="true"/>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </section>

    </div>

    <script>

        $(window).on("load", function(){
            $(".shop-inner-page .product-gallery a:first-child").addClass("showThisVariantImg");
        });

        $("#varianted_option").on("change", function(){
            var dataid = $("#varianted_option option:selected").attr('data-id');
            // [image-id="5"]
            // $(".shop-inner-page .elevatezoom .elevatezoom-holder img").attr("href", selectedVariantImageURL);
            // $(".shop-inner-page .elevatezoom .elevatezoom-holder img").attr("src", selectedVariantImageURL);
            // $(".zoomWindow").css("background-image", "url('"+selectedVariantImageURL+"')");
            if ($("#varianted_option option:selected").attr('data-id')) {
                // $(".kidShopInnerSlide .item").removeClass("active");
                // var selectedVariantImageURL = $("[image-Slideid='"+dataid+"']").addClass("active");
                $(".product-gallery a").removeClass("showThisVariantImg");
                $(".product-gallery a[image-id='"+dataid+"']").addClass("showThisVariantImg");
            }else {
                console.log("No Image Found Against Of This Variant");
            }
            //alert("Hello");
        });


        var full_text = "";
        $(document).ready(function(){
            //$('.readmore-btn-enabled .typography-area p').contents().unwrap();
            var full_text = $('.readmore-btn-enabled.description>div').html();
            var splittedWord = full_text.split(/\s+/).slice(0,<?php echo $checkWordLimit_value; ?>).join(" ");
            $('.readmore-btn-enabled.description>div').html(splittedWord);


            $(".readmore-btn").on("click", function(){
                $(".description").toggleClass("readmore-btn-enabled");
                if ($(this).text() == "read more...") {
                    $(this).text("read less...");
                    $('.description>div').html(full_text);
                } else {
                    $(this).text("read more...");
                    $('.readmore-btn-enabled.description>div').html(splittedWord);
                };
            });
        });

    </script>

<?php include template_dir() . "footer.php"; ?>