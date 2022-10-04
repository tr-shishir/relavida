<?php include template_dir() . "header.php"; ?>

<?php
$content_data = content_data(CONTENT_ID);
$in_stock = true;
if (isset($content_data['qty']) and $content_data['qty'] != 'nolimit' and intval($content_data['qty']) == 0) {
    $in_stock = false;
}

if (isset($content_data['qty']) and $content_data['qty'] == 'nolimit') {
    $available_qty = '';
} elseif (isset($content_data['qty']) and $content_data['qty'] != 0) {
    $available_qty = $content_data['qty'];
} else {
    $available_qty = 0;
}

$item = get_content_by_id(CONTENT_ID);
$itemData = content_data($content['id']);
$itemTags = content_tags($content['id']);

if (!isset($itemData['label'])) {
    $itemData['label'] = '';
}
if (!isset($itemData['label-color'])) {
    $itemData['label-color'] = '';
}

$next = next_content();
$prev = prev_content();

?>
<style>
    .mw-rotator .mw-rotator-slide.active {
        transform: translate(0%, -50%) scale(1);
    }
    .pdclassic-img {
    margin-right: 15px;
}
    span.readmore-btn {
        position: relative;
        cursor: pointer;
        text-decoration: underline;
        font-weight: 600;
    }

    .pdclassic-img {
        position: relative;
        width: 45%;
        float: left;
        z-index: 1;
        background-color: #fff;
    }

    .product-inner-classic {
        position: relative;
        justify-content: unset !important;
    }

    .product-inner-classic {
        min-height: 750px;
    }

    .product-inner-classic .col {
        padding: 0px;
    }

    .product-inner-classic .col-12 {
        padding: 0px;
    }
    .shop-inner-page .product-inner-classic .description p {
        clear: none;
    }
    [field="products-secondery-descriptions"] .mw-row {
        table-layout: auto;
    }
    .shop-inner-page .heading h1 {
        display: block !important;
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
            <div class="row">
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
            <!-- start -->
            <div class="product-info mobile-view-title">
                <div class="product-info-content">
                    <div class="heading">
                        <h1 class="edit d-inline-block" field="title" rel="content"><?php print content_title(); ?></h1>
                    </div>
                </div>
            </div>
            <!-- end -->



            <div class="row">
                <div class="col-xl-12">




                    <?php if ($check_value == "1") : ?>
                        <div class="product-holder justify-content-xl-between product-inner-classic">
                            <div class="pdclassic-img">
                                <module type="pictures" rel="content" template="skin-6" />
                            </div>

                            <div class="product-info-wrapper">
                                <div class="product-info">
                                    <div class="product-info-content">
                                        <div class="heading mobile-view-hide">
                                            <h1 class="edit d-inline-block" field="title" rel="content">
                                                <?php print content_title(); ?></h1>
                                        </div>

                                       <div class="shopinner-cat">
                                       <?php
                                            if (function_exists('category_shop_inner_show')) {
                                                echo category_shop_inner_show(content_id());
                                            }
                                        ?>
                                       </div>

                                            <div class="bold">
                                                <span class="count"><?php echo get_comments('content_id=' . $content['id'] . '&count=1'); ?></span>
                                                <?php if (get_comments('content_id=' . $content['id'] . '&count=1') == 1) : ?>Rezension<?php else : ?>Bewertungen<?php endif; ?>
                                            </div>

                                            <div class="text-right bold">
                                                <span class="">Eine Rezension schreiben</span>
                                            </div>

                                            <?php if (isset($content_data['sku'])) : ?>
                                                <p>
                                                    <?php _e("SKU Number") ?>
                                                    <span>#<?php print $content_data['sku']; ?></span>
                                                </p>
                                            <?php endif; ?>

                                        <div class="description <?php if ($check_readmore_value == "1") {
                                                                    echo "readmore-btn-enabled";
                                                                } ?>">
                                            <div class="edit typography-area" field="content_body" rel="content">
                                                <p>There are many variations of passages of Lorem Ipsum available,
                                                    but the majority have suffered alteration in some form, by
                                                    injected humour, or randomised words which don't look even
                                                    slightly believable. </p>
                                            </div>
                                            <?php if ($check_readmore_value == "1") { ?>
                                                <span class="readmore-btn">....mehr lesen</span>
                                            <?php } ?>
                                        </div>


                                        <div class="row m-t-20">
                                            <div class="col-6">
                                                <h5><?php _e("Optionen") ?></h5>
                                            </div>

                                            <div class="col-6 text-right">
                                                <div class="availability">
                                                    <?php if ($in_stock == true) : ?>
                                                        <span class="text-success"><i class="fas fa-circle" style="font-size: 8px;"></i> <?php _e("Auf Lager") ?></span>
                                                        <span class="text-muted"><?php if ($available_qty != '') : ?>(<?php echo $available_qty; ?>)<?php endif; ?></span>
                                                    <?php else : ?>
                                                        <span class="text-danger"><i class="fas fa-circle" style="font-size: 8px;"></i>
                                                            <?php _e("Nicht vorrätig") ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <module type="shop/cart_add" />
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row product-holder justify-content-xl-between">
                            <div class="col-12 col-md-6 col-xl-6">
                                <module type="pictures" rel="content" template="skin-6" />
                            </div>

                            <div class="col-12 col-md-6 col-xl-6 relative product-info-wrapper">
                                <div class="product-info">
                                    <div class="product-info-content">
                                        <div class="heading mobile-view-hide">
                                            <h1 class="edit d-inline-block" field="title" rel="content">
                                                <?php print content_title(); ?></h1>
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
                                            <div class="col bold">
                                                <span class="count"><?php echo get_comments('content_id=' . $content['id'] . '&count=1'); ?></span>
                                                <?php if (get_comments('content_id=' . $content['id'] . '&count=1') == 1) : ?>Rezension<?php else : ?>Bewertungen<?php endif; ?>
                                            </div>

                                            <div class="col text-right bold">
                                                <span class="">Eine Rezension schreiben</span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <?php if (isset($content_data['sku'])) : ?>
                                                    <p>
                                                        <?php _e("SKU Number") ?>
                                                        <span>#<?php print $content_data['sku']; ?></span>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="description <?php if ($check_readmore_value == "1") {
                                                                            echo "readmore-btn-enabled";
                                                                        } ?>">
                                                    <div class="edit typography-area" field="content_body" rel="content">
                                                        <p>There are many variations of passages of Lorem Ipsum available,
                                                            but the majority have suffered alteration in some form, by
                                                            injected humour, or randomised words which don't look even
                                                            slightly believable. </p>
                                                    </div>
                                                    <?php if ($check_readmore_value == "1") { ?>
                                                        <span class="readmore-btn">....mehr lesen</span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row m-t-20">
                                            <div class="col-6">
                                                <h5><?php //_e("Optionen") ?></h5>
                                            </div>

                                            <div class="col-6 text-right">
                                                <div class="availability">
                                                    <?php //if ($in_stock == true) : ?>
                                                        <span class="text-success"><i class="fas fa-circle" style="font-size: 8px;"></i> <?php //_e("Auf Lager") ?></span>
                                                        <span class="text-muted"><?php //if ($available_qty != '') : ?>(<?php //echo $available_qty; ?>)<?php //endif; ?></span>
                                                    <?php //else : ?>
                                                        <span class="text-danger"><i class="fas fa-circle" style="font-size: 8px;"></i>
                                                            <?php //_e("Nicht vorrätig") ?></span>
                                                    <?php //endif; ?>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="bold">
                                            <module type="shop/cart_add" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <div class="row m-t-20">
                        <div class="col-12 text-left">
                            <h5 class="hr">Rezensionen</h5>
                        </div>
                    </div>

                    <div class="bg-silver p-30 m-b-20">
                        <module type="comments" template="skin-1" />
                    </div>


                    <div class="safe-mode nodrop m-t-40">
                        <div class="row m-t-20">
                            <div class="col-12 text-left">
                                <h5 class="hr">Dies könnte Sie auch interessieren</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <module type="shop/products" related="true" limit="4" hide_paging="true" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<script>
    $("#varianted_option").on("change", function() {
        var dataid = $("#varianted_option option:selected").attr('data-id');
        var selectedVariantImageURL = $("[image-id='" + dataid + "']").attr("href");
        $(".shop-inner-page .elevatezoom .elevatezoom-holder img").attr("href", selectedVariantImageURL);
        $(".shop-inner-page .elevatezoom .elevatezoom-holder img").attr("src", selectedVariantImageURL);
        $(".zoomWindow").css("background-image", "url('" + selectedVariantImageURL + "')");
    });

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
