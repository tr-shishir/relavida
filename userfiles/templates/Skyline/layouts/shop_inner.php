<?php include template_dir() . "header.php"; ?>
<?php
$next = next_content();
$prev = prev_content();
?>


<style>
    span.readmore-btn {
        position: relative;
        cursor: pointer;
        text-decoration: underline;
        font-size: 16px;
        font-weight: 600;
    }

    .ph-classic {
        position: relative;
    }

    .pdh-image {
        position: relative;
        width: 60%;
        float: left;
        margin-right: 30px;
    }


    .ph-classic .box {
        padding: 0px !important;
    }

    .cbox .price {
        text-align: left;
    }

    .cbox .mw-price-item {
        text-align: left;
    }

    .cbox .item-price {
        text-align: left;
    }

    .cbox .product-tax-text {
        text-align: left;
    }

    .cbox .item-cart {
        align-items: start;
    }

    .cbox {
        position: relative;
        max-width: 300px;
        width: 100%;
        margin: 0px auto;
        display: inline-block;
        text-align: left;
    }


    .ph-classic .product-info {
    display: block;
    position: relative;
    justify-content: unset;
    text-align: center;
}

.ph-classic>.row {
    display: block;
}


.ph-classic .module-shop-cart-add {
    max-width: 385px;
    margin: 35px auto;
    display: inline-block;
}

.ph-classic .product-info .box>span {text-align: left;display: block;}

.ph-classic .product-info .heading {
    text-align: left;
}

.ph-classic .product-info p {
    text-align: left;
}

.ph-classic .product-info .des-c {
    text-align: left;
}
.ph-classic .description p {
    clear: none;
}
[field="products-secondery-descriptions"] .mw-row {
        table-layout: auto;
    }
</style>


<?php
$classicLayout_value = get_option('classic_layout', 'product_classic_layout') ?? 0;
$check_readmore_value = get_option('readMoreOption', 'product_readmore_layout') ?? 0;
$checkWordLimit_value = get_option('readMoreLimit', 'product_readmore_limit') ?? 0;
?>

<?php

$product_hide_or_not = DB::table('products')->where('content_id',CONTENT_ID)->where('category_hide',0)->first();

if(!isset($product_hide_or_not)){

    return redirect()->to('/new_page')->send();

}

?>

<div class="shop-main-inner">
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
        <div class="heading mobile-view-title">
            <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
        </div>


        <?php if ($classicLayout_value == "1") : ?>
            <div class="ph-classic">
                <div class="row">

                    <div class="pdh-image">
                        <module type="pictures" rel="content" template="product_gallery_1" />
                    </div>

                    <div class="product-info">
                        <div class="product-info-content">
                            <div class="box">
                                <div class="heading mobile-view-hide">
                                    <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                                </div>

                                <?php
                                if (function_exists('category_shop_inner_show')) {
                                    echo category_shop_inner_show(content_id());
                                }
                                ?>


                                <?php $content_data = content_data(CONTENT_ID);
                                $in_stock = true;
                                if (isset($content_data['qty']) and $content_data['qty'] != 'nolimit' and intval($content_data['qty']) == 0) {
                                    $in_stock = false;
                                }
                                ?>

                                <?php if (isset($content_data['sku'])) : ?>
                                    <p class="labels"><?php _lang("SKU Number", "templates/bamboo") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                <?php endif; ?>

                                <div class="des-c">
                                    <div class="description <?php if ($check_readmore_value == "1") {
                                                                echo "readmore-btn-enabled";
                                                            } ?>">
                                        <div class="edit typography-area" field="content_body" rel="content">
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        </div>
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
        <?php else : ?>
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <module type="pictures" rel="content" template="product_gallery_1" />
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="product-info">
                        <div class="product-info-content">
                            <div class="box">
                                <div class="heading mobile-view-hide">
                                    <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                                </div>

                                <div class="row">
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
                                            <p class="labels"><?php _lang("SKU Number", "templates/bamboo") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                        <?php endif; ?>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="description <?php if ($check_readmore_value == "1") {
                                                                    echo "readmore-btn-enabled";
                                                                } ?>">
                                            <div class="edit typography-area" field="content_body" rel="content">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                            </div>
                                        </div>

                                        <?php if ($check_readmore_value == "1") { ?>
                                            <span class="readmore-btn">....mehr lesen</span>
                                        <?php } ?>
                                    </div>
                                </div>

                                <module type="shop/cart_add" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>



        <div class="row">
            <div class="col-xs-12">

                <hr>
                <div class="edit" field="related_products" rel="inherit">
                    <h4 class="element wraped sidebar-title">Dies könnte Sie auch interessieren</h4>
                    <module type="shop/products" related="true" />
                    <p class="element">&nbsp;</p>
                </div>
            </div>
        </div>

    </div>
</div>



<script>
    var full_text = "";
    $(document).ready(function() {
        //$('.readmore-btn-enabled .typography-area p').contents().unwrap();
        var full_text = $('.readmore-btn-enabled.description .typography-area').html();
        var splittedWord = full_text.split(/\s+/).slice(0, <?php echo $checkWordLimit_value; ?>).join(" ");
        $('.readmore-btn-enabled.description .typography-area').html(splittedWord);


        $(".readmore-btn").on("click", function() {
            $(".description").toggleClass("readmore-btn-enabled");
            if ($(this).text() == "....mehr lesen") {
                $(this).text("... Ansicht minimieren");
                $('.description .typography-area').html(full_text);
            } else {
                $(this).text("....mehr lesen");
                $('.readmore-btn-enabled.description .typography-area').html(splittedWord);
            };
        });
    });
</script>

<?php include template_dir() . "footer.php"; ?>