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
        width: 48%;
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
        max-width: 400px;
        width: 100%;
        margin: 0px auto;
        display: inline-block;
        text-align: left;
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


            <?php if ($classicLayout_value == "1") : ?>
                <div class="ph-classic">
                    <div class="row product-holder">
                        <div class="col-12 col-lg-6">
                            <div class="heading mb-3 mobile-view-show">
                                <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="pdh-image">
                                <module type="pictures" rel="content" template="skin-6" />
                            </div>
                            <div class="relative product-info-wrapper">
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
                                                <p class="labels"><?php _lang("Artikelnummer") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                            <?php endif; ?>

                                            <?php if ($in_stock == true) : ?>
                                                <p class="labels"><?php _lang("Verfügbarkeit") ?>: <span><?php _lang("Auf Lager") ?></span></p>
                                            <?php else : ?>
                                                <p class="labels"><?php _lang("Verfügbarkeit") ?>: <span><?php _lang("Ausverkauft") ?></span></p>
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

                                            <div class="cbox">
                                                <module type="shop/cart_add" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php else : ?>

                <div class="row product-holder">
                        <div class="col-12 col-lg-6">
                            <div class="heading mb-3 mobile-view-show">
                                <h1 class="edit" field="title" rel="content"><?php print content_title(); ?></h1>
                            </div>
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
                                            <div class="col-12 col-md-12">
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

                                                <?php if (isset($content_data['sku'])) : ?>
                                                    <p class="labels"><?php _lang("Artikelnummer") ?>: <span>#<?php print $content_data['sku']; ?></span></p>
                                                <?php endif; ?>

                                                <?php if ($in_stock == true) : ?>
                                                    <p class="labels"><?php _lang("Verfügbarkeit") ?>: <span><?php _lang("Auf Lager") ?></span></p>
                                                <?php else : ?>
                                                    <p class="labels"><?php _lang("Verfügbarkeit") ?>: <span><?php _lang("Ausverkauft") ?></span></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="description <?php  if($check_readmore_value == "1") { echo "readmore-btn-enabled"; } ?>">
                                                    <div class="edit typography-area" field="content_body" rel="content">
                                                        <p>
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                                    </div>
                                                </div>
                                                <?php  if($check_readmore_value == "1") { ?>
                                                    <span class="readmore-btn">....mehr lesen</span>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <module type="shop/cart_add"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="related-products">
                        <h2>Dies könnte Sie auch interessieren</h2>
                        <module type="shop/products" related="true" limit="6" hide_paging="true" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabs -->
        <!-- <section id="tabs" class="custom-pb shop-inner-tabs">
            <div class="container">
                <div class="row">
                    <div class="col-md-3" style="padding-right:0">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">BESCHREIBUNG</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">ZUSÄTZLICHE INFORMATION</a>
                            </div>
                        </nav>
                    </div>
                    <div class="col-md-9" style="padding-left:0">
                        <div class="tab-content px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active edit" field="tab_content_one-<?php print CONTENT_ID; ?>" rel="content" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <p>
                                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.
                                </p>
                                <h4>
                                    Lorem Ipsum is simply dummy text
                                </h4>
                                <ul>
                                    <li>It is a long established fact that a reader will be distracted by the readable content</li>
                                    <li>There are many variations of passages of Lorem Ipsum available</li>
                                    <li>Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'</li>
                                    <li>Lorem Ipsum is simply dummy text</li>
                                </ul>
                                <br>
                                <br>
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                </p>
                                <h3>Lorem Ipsum is simply dummy text</h3>
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                </p>
                                <br>
                                <img src="<?php print template_url(); ?>assets/image/category-1.jpg" alt="">
                            </div>
                            <div class="tab-pane fade edit" id="nav-profile" role="tabpanel" field="tab_content_two-<?php print CONTENT_ID; ?>" rel="content" aria-labelledby="nav-profile-tab">
                                <h3>Product Information</h3>
                                <br>
                                <table class="table">
                                    <tr>
                                        <td><b>Product info one</b></td>
                                        <td>Product info two</td>
                                    </tr>
                                    <tr>
                                        <td><b>Product info one description</b></td>
                                        <td>Product info two description</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- ./Tabs -->

    </section>

</div>

<script>
    var full_text = "";
    $(document).ready(function(){
        //$('.readmore-btn-enabled .typography-area p').contents().unwrap();
        var full_text = $('.readmore-btn-enabled .typography-area').html();
        var splittedWord = full_text.split(/\s+/).slice(0,<?php echo $checkWordLimit_value; ?>).join(" ");
        $('.readmore-btn-enabled .typography-area').html(splittedWord);


        $(".readmore-btn").on("click", function(){
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