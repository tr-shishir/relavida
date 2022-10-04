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
  .product-holder.product-classic {
        position: relative;
        min-height: 660px;
        display: contents!important;
    }

    .product-holder.product-classic .product-info-wrapper {
        position: relative;
        display: inline;
    }

    .product-holder.product-classic .product-classic-slider {
        float: left;
        display: inline-block;
        margin-right: 30px;
    }

    .product-holder.product-classic .product-gallery {
        position: relative;
        float: left;
        margin-right: 40px;
        margin-bottom: 30px;
    }

    .product-holder.product-classic .product-info-wrapper .box {}

    .product-holder.product-classic .product-info-wrapper  .row {
        display: block !important;
    }
    .product-gallery-with-description {
        display: block !important;
    }
    .product-gallery {
        width: 50%;
        background-color: #fff;
    }
    span.readmore-btn {
        position: relative;
        cursor: pointer;
        text-decoration: underline;
        font-size: 16px;
        font-weight: 600;
    }

    .readmore-btn-enabled .typography-area {
        position: relative;
       
    }
    .readmore-btn-enabled .module-shop-cart-add {

        float: left;
    }
    .relatedpr {
        position: relative;
        display: block;
        width: 100%;
    }

    .relatedpr>.row {
        display: block;
    }

    .readmore-btn-enabled {}

    .product-holder.product-classic .module-shop-cart-add,
    .readmore-btn-enabled+.module-shop-cart-add {
        min-width: 46%;
        display: inline-block;
        margin: 10px auto;
    }
    .container.sipc {
        overflow: hidden;
        margin-bottom: 70px;
    }


    .product-holder.product-classic .product-info-wrapper .box {
        position: relative;
        text-align: center;
    }

    .description.readmore-btn-enabled {
    }

    .product-holder.product-classic .description {
        text-align: left;
    }
    .product-gallery-with-description {
    position: relative;
    z-index: 9;
}

.produkt-meta {
    text-align: left;
}

.product-holder.product-classic .product-info-wrapper .box {
    text-align: left;
}
.product-classic .description p {
    clear: none;
}
[field="products-secondery-descriptions"] .mw-row {
        table-layout: auto;
    }



@media (max-width: 991px) {
    .product-holder.product-classic {
        display: block !important;
    }
}
</style>

<div class="shop-inner-page inner-page" id="shop-content-<?php print CONTENT_ID; ?>">
    <section class="p-t-100 p-b-50 fx-particles">
        <module type="breadcrumb" />
        <div class="container">
            <div class="row">
                <div class="offset-md-6 col-md-6">
                    <div class="next-previous-content float-right">
                        <?php if ($next != false) { ?>
                        <a href="<?php print $next['url']; ?>" class="next-content tip btn btn-outline-default"
                            data-tip="#next-tip"><i class="fas fa-chevron-left"></i><?php _e('Prev'); ?></a>

                        <div id="next-tip" style="display: none">
                            <div class="next-previous-tip-content text-center">
                                <img src="<?php print get_picture($next['id']); ?>" alt="" width="90" />

                                <h6><?php print $next['title']; ?></h6>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ($prev != false) { ?>
                        <a href="<?php print content_link($prev['id']); ?>"
                            class="prev-content tip btn btn-outline-default" data-tip="#prev-tip"><?php _e('Next'); ?><i
                                class="fas fa-chevron-right"></i></a>
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
        </div>
        <div class="container sipc">
            <div class="heading mobile-view-title">
                <h2 class="edit" field="title" rel="content"><?php print content_title(); ?></h2>
            </div>


            <?php $check_value = get_option('classic_layout', 'product_classic_layout') ?? 0; ?>
            <?php $check_readmore_value = get_option('readMoreOption', 'product_readmore_layout') ?? 0; ?>

            <?php $checkWordLimit_value = get_option('readMoreLimit', 'product_readmore_limit') ?? 0; ?>

            <div class="row product-holder <?php  if($check_value == "1") { echo "product-classic"; } ?>">
                <div class="col-12 col-lg-6 product-classic-slider">
                    <module type="pictures" rel="content" template="skin-6" />
                </div>

                <div class="col-12 col-lg-6 relative product-info-wrapper">
                    <div class="product-info">
                        <div class="product-info-content">
                            <div class="box">
                                <div class="heading mobile-view-hide">
                                    <h2 class="edit" field="title" rel="content"><?php print content_title(); ?></h2>
                                </div>
                                <div class="">
                                    <?php
                                        if (function_exists('category_shop_inner_show')) {
                                            echo category_shop_inner_show(content_id());
                                        }
                                        ?>
                                </div>
                                <div class="pi-info-stock">
                                    <?php $content_data = content_data(CONTENT_ID);
                                            $in_stock = true;
                                            if (isset($content_data['qty']) and $content_data['qty'] != 'nolimit' and intval($content_data['qty']) == 0) {
                                                $in_stock = false;
                                            }
                                            ?>

                                    <?php if (isset($content_data['sku'])) : ?>
                                    <p class="labels"><?php _lang("SKU Number") ?>:
                                        <span>#<?php print $content_data['sku']; ?></span>
                                    </p>
                                    <?php endif; ?>

                                    <?php if ($in_stock == true) : ?>
                                    <p class="labels"><b><?php _lang("Verfügbarkeit") ?>:</b>
                                        <span><?php _lang("Auf Lager") ?></span>
                                    </p>
                                    <?php else : ?>
                                    <p class="labels"><b><?php _lang("Verfügbarkeit") ?>:</b>
                                        <span><?php _lang("Ausverkauft") ?></span>
                                    </p>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div
                                            class="description <?php  if($check_readmore_value == "1") { echo "readmore-btn-enabled"; } ?>">
                                            <div class="edit typography-area" field="content_body" rel="content">
                                                <h3><?php print _lang('Beschreibung', 'templates/bamboo'); ?></h3>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s.</p>

                                                <h3><?php print _lang('Materialien', 'templates/bamboo'); ?></h3>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever since the 1500s.</p>
                                            </div>
                                            <?php  if($check_readmore_value == "1") { ?>
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







        </div>
        <div class="container">
            <div class="relatedpr">
                <div class="row">
                    <div class="col-12">
                        <h2 class="owl-featured m-b-80 mb-4"><strong>Dies könnte Sie auch interessieren</strong></h2>
                        <module type="shop/products" related="true" limit="6" hide_paging="true" />
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