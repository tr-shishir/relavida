<?php include template_dir() . "header.php"; ?>
<?php
$next = next_content();
$prev = prev_content();
?>
<script>
    $(document).ready(function() {
        $('.navigation-holder').addClass('not-transparent');
    })
</script>
<style>
    .shop-inner-page .price label {
        color: #fff;
    }

    .shop-inner-page .mw-gallery-item.active {
        transform: translate(0%, -50%) scale(1);
    }

    span.readmore-btn {
        position: relative;
        cursor: pointer;
        text-decoration: underline;
        font-weight: 600;
    }
    .product-classic-layout .pdc-gallery {
    position: relative;
    width: 48%;
    float: left;
    margin-right: 30px;
    z-index: 1;
}

.shop-inner-page .description .typography-area {
    text-align: justify;
}
.shop-inner-page .product-classic-layout .description p {
   clear: none;
}
[field="products-secondery-descriptions"] .mw-row {
        table-layout: auto;
    }
</style>

<?php $check_value = get_option('classic_layout', 'product_classic_layout') ?? 0; ?>
<?php $check_readmore_value = get_option('readMoreOption', 'product_readmore_layout') ?? 0; ?>
<?php $checkWordLimit_value = get_option('readMoreLimit', 'product_readmore_limit') ?? 0; ?>

<?php

$product_hide_or_not = DB::table('products')->where('content_id',CONTENT_ID)->where('category_hide',0)->first();

if(!isset($product_hide_or_not)){

    return redirect()->to('/new_page')->send();

}

?>

<div class="shop-inner-page" id="shop-content-<?php print CONTENT_ID; ?>">
    <section class="p-t-100 p-b-50 fx-particles">
        <div class="container">
            <module type="breadcrumb" />
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

            <div class="product-title-for-mobile">
                <div class="heading">
                    <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                </div>
            </div>
            <style>
                    .shop-inner-page .item-cart {
                        text-align: left;
                    }

                    .shop-inner-page .item-cart-button {
                        float: left;
                        text-align: left;
                    }

                    .shop-inner-page .item-cart-button button {
                        margin: 0px;
                    }
                </style>
            <?php if ($check_value == "1") : ?>
                <div class="row product-holder product-classic-layout">
                    <style>
                        .module-shop-cart-add {
                            background-color: #202020;
                            width: 45%;
                            display: inline-block;
                            text-align: left;
                        }

                        .shop-inner-page .item-cart {
                            text-align: left;
                        }

                        .item-cart .item-cart-button {
                            float: left;
                        }

                        button#addCartBtn {}

                        .shop-inner-page .item-cart-button button {
                            margin: 0px;
                        }

                        .shop-innercategory {}

                        .shop-innercategory .col-12 {
                            padding: 0px;
                        }

                        .product-info-content {}

                        .product-info-content .col-12 {
                            padding: 0px;
                        }
                    </style>
                    <div class="col-md-12">
                        <div class="pdc-gallery">
                            <module type="pictures" rel="content" template="skin-2" />
                        </div>
                        <div class="relative product-info-wrapper">
                        <div class="product-info">
                            <div class="product-info-content">
                                <div class="box">
                                    <div class="heading">
                                        <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                                    </div>

                                    <div class="row shop-innercategory">
                                        <div class="col-12 col-md-12">
                                            <?php
                                            if (function_exists('category_shop_inner_show')) {
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

                                            <?php if (isset($content_data['sku'])) : ?>
                                                <p class="labels"><?php _lang("SKU Number", "templates/theplace") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                            <?php endif; ?>

                                            <?php if ($in_stock == true) : ?>
                                                <p class="labels"><?php _lang("Verfügbarkeit", "templates/theplace") ?>: <span><?php _lang("Auf Lager", "templates/theplace") ?></span></p>
                                            <?php else : ?>
                                                <p class="labels"><?php _lang("Verfügbarkeit", "templates/theplace") ?>: <span><?php _lang("Ausverkauft", "templates/theplace") ?></span></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="description <?php if ($check_readmore_value == "1") {
                                                                        echo "readmore-btn-enabled";
                                                                    } ?>">
                                                <div class="edit typography-area" field="content_body" rel="content">
                                                    <h3><?php print _lang('Beschreibung', 'templates/theplace'); ?></h3>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>

                                                    <h3><?php print _lang('Materialien', 'templates/theplace'); ?></h3>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                </div>
                                                <?php if ($check_readmore_value == "1") { ?>
                                                    <span class="readmore-btn">....mehr lesen</span>
                                                <?php } ?>
                                            </div>

                                    <module type="shop/cart_add" />


                                </div>
                            </div>
                        </div>
                    </div>
                    </div>


                </div>
            <?php else : ?>
                <div class="row product-holder">
                    <div class="col-12 col-lg-6">
                        <module type="pictures" rel="content" template="skin-2" />
                    </div>
                <style>
                    .shop-inner-page .item-cart {
                        text-align: left;
                    }

                    .shop-inner-page .item-cart-button {
                        float: left;
                        text-align: left;
                    }

                    .shop-inner-page .item-cart-button button {
                        margin: 0px;
                    }
                </style>
                    <div class="col-12 col-lg-6 relative product-info-wrapper">
                        <div class="product-info">
                            <div class="product-info-content">
                                <div class="box">
                                    <div class="heading">
                                        <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                                    </div>

                                    <div class="row shop-innercategory">
                                        <div class="col-12 col-md-12">
                                            <?php
                                            if (function_exists('category_shop_inner_show')) {
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

                                            <?php if (isset($content_data['sku'])) : ?>
                                                <p class="labels"><?php _lang("SKU Number", "templates/theplace") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                            <?php endif; ?>

                                            <?php if ($in_stock == true) : ?>
                                                <p class="labels"><?php _lang("Verfügbarkeit", "templates/theplace") ?>: <span><?php _lang("Auf Lager", "templates/theplace") ?></span></p>
                                            <?php else : ?>
                                                <p class="labels"><?php _lang("Verfügbarkeit", "templates/theplace") ?>: <span><?php _lang("Ausverkauft", "templates/theplace") ?></span></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">

                                            <div class="description <?php if ($check_readmore_value == "1") {
                                                                        echo "readmore-btn-enabled";
                                                                    } ?>">
                                                <div class="edit typography-area" field="content_body" rel="content">
                                                    <h3><?php print _lang('Beschreibung', 'templates/theplace'); ?></h3>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>

                                                    <h3><?php print _lang('Materialien', 'templates/theplace'); ?></h3>
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                </div>
                                                <?php if ($check_readmore_value == "1") { ?>
                                                    <span class="readmore-btn">....mehr lesen</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                    <module type="shop/cart_add" />


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="edit" field="related_products" rel="inherit">
                <div class="row">
                    <div class="col-12">
                        <h2 class="owl-featured m-b-80"><strong>Dies könnte Sie auch interessieren</strong></h2>
                        <module type="shop/products" related="true" limit="6" hide_paging="true" />
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>



<script>
    var full_text = "";
    $(document).ready(function() {
        //$('.readmore-btn-enabled .typography-area p').contents().unwrap();
        var full_text = $('.readmore-btn-enabled .typography-area').html();
        var splittedWord = full_text.split(/\s+/).slice(0, <?php echo $checkWordLimit_value; ?>).join(" ");
        $('.readmore-btn-enabled .typography-area').html(splittedWord);


        $(".readmore-btn").on("click", function() {
            $(".description").toggleClass("readmore-btn-enabled");
            if ($(this).text() == "....mehr lesen") {
                $(this).text("... Ansicht minimieren");
                $('.description .typography-area').html(full_text);
            } else {
                $(this).text("....mehr lesen");
                $('.readmore-btn-enabled .typography-area').html(splittedWord);
            };
        });
    });
</script>

<?php include template_dir() . "footer.php"; ?>