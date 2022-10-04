<?php
$update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition', 'update_global_bundle_discount_condition') ?? 0;
$is_logged = is_logged();
if (CATEGORY_ID != false) {
    $cat = DB::table('categories')->where('id', CATEGORY_ID)->first();
    $cat_img = array(
        'rel_type'  => "categories",
        'rel_id' => $cat->id
    );
    $media_cat = get_pictures($cat_img);
}
if (isset($_GET['wishlist_id'])) {
    $ids = array(0);
    $pro_ids = DB::table('wishlist_session_products')->where('wishlist_id', '=', $_GET['wishlist_id'])->pluck('product_id')->toArray();


?>

    <form action="<?php print api_url('share_wishlist'); ?>" class="form-inline" id="wishlist_short_url_form">
        <div class="form-group" style="margin-bottom: 20px;">
            <?php foreach ($pro_ids as $pro_id) : ?>
                <input type="hidden" name="products[]" value="<?= $pro_id; ?>">
            <?php endforeach; ?>
            <input type="hidden" name="user_id" value="<?= user_id(); ?>">

            <button type="button" class="btn btn-primary" id="clickBtn">Wunschliste teilen</button>
        </div>
    </form>
    <input onClick="this.select();" type="text" class="form-control share_input-text" id="input_text">


<?php


    //    dd(user_id());

    // $data = collect($data)->whereIn('content_id', $pro_ids)->toArray();
    $data = DB::table('products')->whereIn('content_id',$pro_ids)->get()->toArray();
    //        if(!empty($pro_ids)) {
    //            foreach ($pro_ids as $pid) {
    //                $ids[] = $pid->product_id;
    //            }
    //        }
}

if (isset($_GET['slug'])) {

    $products = DB::table('wishlist_link')->where('slug', $_GET['slug'])->first()->products_id;
    $data = DB::table('products')->whereIn('content_id',$pro_ids)->get()->toArray();
}
?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cat->show_category == null || $cat->show_category == 0 || $cat->show_category == 1 || $cat->show_category == false) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>
<?php if (!empty($data)) :
    $user_country_name = user_country(user_id());
    if ($user_country_name) {
        $tax_rate_list = DB::table('tax_rates')->where('country', 'LIKE', '%' . $user_country_name . '%')->first();
    } else {
        $tax = mw()->tax_manager->get();
        $tax_rate_list = DB::table('tax_rates')->where('country', 'LIKE', '%' . $tax['0']['name'] . '%')->first();
    }
    if (isset($tax_rate_list)) {
        $original_tax = $tax_rate_list->charge;
        $reduced_tax = $tax_rate_list->reduced_charge;
    } else {
        $original_tax = null;
        $reduced_tax = null;
    }
?>
    <section id="shop-product-all">
        <div class="row shop-products">
            <?php foreach ($data as $item) :
                $item = collect($item)->toArray();
                if ($item['image']) {
                    $image_link = $item['image'];
                } else {
                    $image_link = '';
                }
                $in_stock = false;
                if ($item['quantity'] > 0 || $item['quantity'] == 'nolimit') {
                    $in_stock = true;
                }

                if ($item['tax_type'] == '2') {
                    $taxrate =  $reduced_tax;
                } else {
                    $taxrate = $original_tax;
                }
            ?>

                <div class="single-wrapper item-<?php print $item['content_id'] ?>" data-masonry-filter="<?php //print $itemCats;
                                                                                                            ?>" itemscope itemtype="<?php //print $schema_org_item_type_tag
                                                                                                                                                            ?>">
                    <div class="single-product">
                        <div class="product">

                            <input type="hidden" name="price" value="<?php print $item['price']; ?>" />
                            <input type="hidden" name="content_id" value="<?php print $item['content_id']; ?>" />

                            <?php if ($show_fields == false or in_array('thumbnail', $show_fields)) : ?>
                                <div class="product-thumb">
                                    <div class="image">
                                        <img class="lazy" src="<?php print $item['image']; ?>" alt="">
                                    </div>
                                    <div class="btn-overlay">
                                    <?php //if ($show_fields == false or ($show_fields != false and in_array('read_more', $show_fields))) : ?>

                                            <a href="<?php print url($item['url']); ?>" class="btn btn-primary product-cart-icon">
                                                Produkt ansehen
                                            </a>

                                    <?php //endif; ?>
                                    <div class="cart-button-thumb-area">
                                            <?php if (!isset($in_stock) or $in_stock == false) : ?>
                                                <a href="javascript:;" title="<?php _e('Out Of Stock'); ?>" class="btn btn-product product-cart-icon disable-btn-cart">
                                                    <span class="material-icons">remove_shopping_cart</span>
                                                </a>
                                            <?php elseif (isset($item['price']) && (floatval($item['price']) > 0)) : ?>
                                                <a href="javascript:;" onclick="<?php if (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) { ?>carttoggole('.shop-products .item-<?php print $item['content_id'] ?>');<?php } else { ?>carttoggolee('.shop-products .item-<?php print $item['content_id'] ?>');<?php } ?>" class="btn btn-product product-cart-icon">
                                                    <span class="material-icons">shopping_cart</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        </div>
                                </div>

                                <div class="product-description">
                                    <div class="product-name">
                                        <a href="<?php print url($item['url']); ?>">
                                            <div class="description">
                                                <?php if ($show_fields == false or in_array('title', $show_fields)) : ?>
                                                    <div class="product-title">
                                                        <h5><?php print $item['title'] ?></h5>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="product-price">
                                        <?php
                                        $offer = \MicroweberPackages\Offer\Models\Offer::getByProductId($item['content_id']);
                                        if (isset($offer['price']['offer_price'])) {
                                            $val4 = normalPrice($item['price']);
                                            if (isset($in_stock) && $in_stock != false) { ?>

                                            <div class="dt-old-price">
                                                <p><?php print currency_format(roundPrice($val4)); ?></p>
                                            </div>

                                        <?php
                                            }
                                        } ?>
                                        <?php if ($show_fields == false or in_array('price', $show_fields)) : ?>
                                            <?php if (isset($item['price'])) : ?>
                                                <div class="price">
                                                    <?php
                                                    if (isset($offer['price']['offer_price'])) {
                                                        $val1 = normalPrice($offer['price']['offer_price']);
                                                        $val1 = $val1 + product_tax_amount($val1, $taxrate);
                                                    } else {
                                                        $val1 = normalPrice($item['price']);
                                                        $val1 = $val1 + product_tax_amount($val1, $taxrate);
                                                    }
                                                    ?>
                                                    <?php if ($val1 > 0) : ?>
                                                        <span><?php print currency_format(roundPrice($val1)); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="ver-text py-2">
                                            <div class="product-tax-text" style="">
                                                <?php if (isset($item['price']) and $item['price'] > 0) :  ?>
                                                    <span class="edit">
                                                        inkl. <?php print $taxrate; ?>% MwSt.
                                                    </span>
                                                    <span data-toggle="modal" data-target="#termModal" style="margin-left:5px;display:inline-block;">
                                                        zzgl. Versand
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="product-cart-btn">

                                            <div class="price-on-req">
                                                <?php if (isset($item['price']) && !(floatval($item['price']) > 0) && $in_stock) : ?>
                                                    <button title="Price On Request" onclick="priceModal(); price_on_request_product_id_get(<?php print $item['content_id']; ?>,'<?php print $item['title']; ?>');" class="btn btn-product product-cart-icon"><?php _e('Price On Request'); ?></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-footer <?php if (!$is_logged) {
                                                                    print('not-logged');
                                                                } ?>">
                                        <?php if ($is_logged) { ?>
                                            <div class="wishlist-wrapper">
                                                <div class="wishlist-icon">
                                                    <?php if (get_option('enable_wishlist', 'shop')) : ?>
                                                        <div class="product-wishlist">
                                                            <span class="material-icons wishlist-logo" id="wishlist-logo-<?= $item['content_id']; ?>">
                                                                favorite
                                                            </span>
                                                            <label for=""></label>
                                                            <select id="" class="wishlist-select-<?= $item['content_id']; ?> js-example-basic-multiple" name="states[]" multiple="multiple">
                                                            </select>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="product-sample-button">
                                            <div class="product-share-btn">
                                                <?php if (is_admin()) : ?>
                                                    <a href="#" class="btn-product copy-url product-quickcheckout-icon" data-id="<?php echo $item['content_id']; ?>" data-lang="<?= url_segment(0); ?>" title="Checkout">
                                                        <button class="btn"><i class="fa fa-link" aria-hidden="true"></i></button>
                                                    </a>
                                                <?php endif; ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?>
                        </div>

                        <?php
                        if (isset($offer['price']['offer_price']) && $offer['price']['expires_at'] != 0) {
                            //                        dd($offer);
                            if (\Carbon\Carbon::now()->diffInSeconds($offer['price']['created_at'], false) > 0) {
                                $remaining = \Carbon\Carbon::parse($offer['price']['created_at'])->diffInSeconds($offer['price']['expires_at'], false);
                            } else {
                                $remaining = \Carbon\Carbon::now()->diffInSeconds($offer['price']['expires_at'], false);
                            }
                            $remaining = $remaining > 0 ? $remaining : 0;
                            $counter = Config::get('custom.counter');
                            if (isset($in_stock) && $in_stock != false) {
                        ?>



                            <div class="dt-countdown-style-<?= $counter ?>">
                                <!-- "dt-countdown-style-1" This Number Will Be Dynamic Based On Select Design From backend -->
                                <div class="dt-cdown-box">
                                    <div class="dt_t_countdown_data" data-end="<?= $remaining ?>"></div>
                                </div>
                            </div>


                        <?php }
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </secttion>
    <?php endif; ?>

    <?php if (isset($pages_count) and $pages_count > 1 and isset($paging_param)) : ?>
        <div class="pagination-container">
            <hr>
            <module type="pagination" template="bootstrap4" pages_count="<?php echo $pages_count; ?>" paging_param="<?php echo $paging_param; ?>" />
        </div>
    <?php endif; ?>
    <?php if (CATEGORY_ID != false) : ?>
        <?php if ($cat->show_category == 2) : ?>
            <module type="category-details" />
        <?php endif; ?>
    <?php endif; ?>


    <script type="text/javascript">
        <?php if ($is_logged) { ?>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
            $(document).ready(() => {
                $.get(`<?= api_url('get_wishlist_sessions'); ?>`, result => {
                    const selected = [];
                    const list = [];
                    if (result != 'false') {
                        result.forEach(function(session) {
                            console.log(session);
                            list.push('<option value=' + session['id'] + '>' + session['name'] +
                                '</option>');

                            session['products'].forEach(function(prod) {
                                if (selected[parseInt(prod['product_id'])] === undefined) {
                                    selected[parseInt(prod['product_id'])] = [];
                                }
                                selected[parseInt(prod['product_id'])].push(session.id.toString())
                            })
                        });
                    }

                    <?php if (!empty($data)) : ?>
                        <?php foreach ($data as $item) :
                            if (!is_array($item)) {
                                $item = (array)$item;
                            }
                        ?>
                            var wishlistProduct = $(".wishlist-select-<?php echo $item['content_id']; ?>");
                            wishlistProduct.empty();
                            wishlistProduct.append('<option disabled value="null"></option>');
                            list.forEach(function(value) {
                                wishlistProduct.append(value);
                            });

                            var didd = <?php echo $item['content_id']; ?>;
                            wishlist_details(didd);

                        <?php endforeach; ?>
                    <?php endif; ?>

                    selected.forEach(function(value, index) {
                        const wishlistProduct2 = $(".wishlist-select-" + index.toString());
                        wishlistProduct2.select2().val(value).trigger("change");
                    });

                    function wishlist_details(didd) {
                        if (selected[didd] && selected[didd].length > 0) {
                            $("#wishlist-logo-" + didd).text("favorite");
                        } else {
                            $("#wishlist-logo-" + didd).text("favorite_border");
                        }
                    }

                });
            });

            <?php if (!empty($data)) : ?>
                <?php foreach ($data as $item) :
                    if (!is_array($item)) {
                        $item = (array)$item;
                    }
                ?>
                    $(".wishlist-select-<?php echo $item['content_id']; ?>").on('select2:unselect', function(e) {
                        removeProduct(<?php echo $item['content_id']; ?>, e.params.data.id)
                        if ($(".wishlist-select-<?php echo $item['content_id']; ?>").val().length == 0) {
                            $("#wishlist-logo-<?php echo $item['content_id']; ?>").text("favorite_border");
                        }
                    });

                    $(".wishlist-select-<?php echo $item['content_id']; ?>").on('select2:select', function(e) {
                        addProduct(<?php echo $item['content_id']; ?>, e.params.data.id)
                        $("#wishlist-logo-<?php echo $item['content_id']; ?>").text("favorite");
                    });

                <?php endforeach; ?>
            <?php endif; ?>

            function removeProduct(productId, sessionId) {
                $.post("<?php print api_url('remove_wishlist_sessions'); ?>", {
                    productId: productId,
                    sessionId: sessionId
                }, () => {});
            }

            function addProduct(productId, sessionId) {
                $.post("<?php print api_url('add_wishlist_sessions'); ?>", {
                    productId: productId,
                    sessionId: sessionId
                }, () => {});
            }
        <?php } ?>

        function wishlist_filter(wId) {
            $.post("<?php print site_url('en/shop'); ?>", {
                wishlist_id: wId
            }, () => {});
        }
        $("#input_text").hide();
        $("#clickBtn").on('click', function() {
            $("#clickBtn").hide();
            $("#clickBtn").parent().hide();
            $("#input_text").show();
            share_wishlist();
        });

        $(document).on('click', '#input_text', function() {
            this.select();
            document.execCommand('copy');
        });

        function share_wishlist() {
            return $.post($('form#wishlist_short_url_form').attr('action'), $('form#wishlist_short_url_form').serialize(), (
                res) => {
                $('#input_text').val(res.url)
            });
        }

        $(document).on('click', '#edit_sss', function() {

            let name = $(this).data('name');

            console.log(name);
            // console.log(id);


            $("#exampleInputEmailedit").val(name);
            $("#exampleInputEmailedithide").val(name);
        });


        $(document).on('click', '#delete_sss', function() {

            let name = $(this).data('name');

            console.log(name);
            // console.log(id);
            $.post("<?php print api_url('delete_wishlist_sessions'); ?>", {
                name: name
            }, function(sessions) {
                if (sessions === 'false') {
                    // emailHelp.show();
                    location.reload();

                } else {
                    location.reload();
                }
            });


        });
    </script>
    <script>
        $(document).ready(function() {

            function copyTextToClipboard(text) {
                var textArea = document.createElement("textarea");

                //
                // *** This styling is an extra step which is likely not required. ***
                //
                // Why is it here? To ensure:
                // 1. the element is able to have focus and selection.
                // 2. if the element was to flash render it has minimal visual impact.
                // 3. less flakyness with selection and copying which **might** occur if
                //    the textarea element is not visible.
                //
                // The likelihood is the element won't even render, not even a
                // flash, so some of these are just precautions. However in
                // Internet Explorer the element is visible whilst the popup
                // box asking the user for permission for the web page to
                // copy to the clipboard.
                //

                // Place in the top-left corner of screen regardless of scroll position.
                textArea.style.position = 'fixed';
                textArea.style.top = 0;
                textArea.style.left = 0;

                // Ensure it has a small width and height. Setting to 1px / 1em
                // doesn't work as this gives a negative w/h on some browsers.
                textArea.style.width = '2em';
                textArea.style.height = '2em';

                // We don't need padding, reducing the size if it does flash render.
                textArea.style.padding = 0;

                // Clean up any borders.
                textArea.style.border = 'none';
                textArea.style.outline = 'none';
                textArea.style.boxShadow = 'none';

                // Avoid flash of the white box if rendered for any reason.
                textArea.style.background = 'transparent';


                textArea.value = text;

                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                document.execCommand('copy');

            }

            function copyClipBoardText(className) {
                /* Get the text field */
                // var copyText = document.getElementsByClassName(class);
                var copyText = document.getElementsByClassName(className);
                // console.log(copyText);
                /* Select the text field */
                copyText[0].select();

                /* Copy the text inside the text field */
                document.execCommand("copy");

                /* Alert the copied text */
                // alert("Copied the text: " + copyText[0].value);
            }
            $(document).on('click', '.copy-url', function() {
                // event.preventDefault();
                let id = $(this).data('id');
                let lang = $(this).data('lang');
                $.ajax({
                    method: 'POST',
                    url: "<?php print api_url('guest_checkout'); ?>",
                    data: {
                        iid: id,
                        lang: lang
                    },
                    success: function(response) {
                        if (response.success) {
                            // $('.clipboard-data-'+id).val(response.url);
                            // console.log(response.url);
                            copyTextToClipboard(response.url);
                            // copyClipBoardText('clipboard-data-'+id);

                        }
                    }
                });
                // $.post("<?php print api_url('guest_checkout'); ?>", {iid: id, lang: lang}, (res) => {
                //     console.log(res);
                // });
            });


            //Update trial clock
            function updateDTTemplateTrialClock(el) {
                let time_interval = setInterval(function() {
                    let total = el.data('end');

                    if (!total) {
                        el.hide();
                        el.html('');
                        clearInterval(time_interval);
                        return;
                    }

                    const seconds = Math.floor(total % 60);
                    const minutes = Math.floor((total / 60) % 60);
                    const hours = Math.floor((total / (60 * 60)) % 24);
                    const days = Math.floor(total / (60 * 60 * 24));
                    --total;

                    el.data('end', total);
                    el.css('padding', '10px 15px');
                    el.html(
                        `<div class="days-wrapper"><p>${days < 10? ' 0'+days : days}</p> <span class="su">Tage</span><span class="su-res">T</span></div> <div class="hours-wrapper"><p>${hours < 10?  '0'+hours : hours}</p><span class="su">Stunden</span><span class="su-res">S</span></div> <div class="minutes-wrapper"><p>${minutes < 10?  '0'+minutes : minutes}</p> <span class="su">Minuten</span><span class="su-res">M</span></div><div class="seconds-wrapper"><p>${seconds < 10?  '0'+seconds : seconds}</p><span class="su">Sekunden</span><span class="su-res">S</span></div>`);

                }, 1000);
            }

            function show_dt_template_trial_countdown() {
                if (!$('.dt_t_countdown_data').length) return;

                $('.dt_t_countdown_data').each(function() {
                    let _st = $(this).data('end');
                    if (_st) {
                        updateDTTemplateTrialClock($(this))
                    }
                });
            }

            $(document).ready(function() {
                show_dt_template_trial_countdown();
            })

        });
    </script>