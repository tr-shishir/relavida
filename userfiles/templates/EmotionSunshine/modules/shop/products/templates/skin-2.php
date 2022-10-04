<?php
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

            <button type="button" class="btn btn-primary" id="clickBtn">Share Wishlist</button>
        </div>
    </form>
    <input onClick="this.select();" type="text" class="form-control share_input-text" id="input_text">


<?php


    //    dd(user_id());

    $data = collect($data)->whereIn('content_id', $pro_ids)->toArray();
    //        if(!empty($pro_ids)) {
    //            foreach ($pro_ids as $pid) {
    //                $ids[] = $pid->product_id;
    //            }
    //        }
}

if (isset($_GET['slug'])) {

    $products = DB::table('wishlist_link')->where('slug', $_GET['slug'])->first()->products_id;
    //        dd($products);
    $data = collect($data)->whereIn('content_id', explode(',', $products))->toArray();
}

?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cat->show_category == null || $cat->show_category == 0 || $cat->show_category == 1 || $cat->show_category == false) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>
<?php if (!empty($data)) : ?>
    <div class="row shop-products">
        <!-- Hit Section Start -->
        <section id="hit-section" style="width:100%">
            <div class="container">
                <div class="hit-products-wrapper">
                    <div class="hit-top">
                        <div class="hit-top-text edit" field="home_new_hit_heading" rel="content">
                            <h4>Neue Hits</h4>
                        </div>
                        <div class="divider"></div>
                    </div>
                    <div class="owl-carousel owl-theme hit-carousel">
                        <?php foreach ($data as $item) :
                            $item = collect($item)->toArray();
                            if ($item['image']) {
                                $image_link = $item['image'];
                            } else {
                                $image_link = '';
                            }
                        ?>
                            <div class="item hit-single">
                                <div class="hit-single-product">
                                    <div class="hit-product-img">
                                        <a href="<?php print url($item['url']); ?>">
                                            <div class="image">
                                                <img class="lazy" src="<?php print $item['image']; ?>" alt="">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="hit-product-name">
                                        <p><a href="<?php print url($item['url']); ?>"><?php print $item['title'] ?></a></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <!-- Hit Section End -->
    </div>
<?php endif; ?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cat->show_category == 2) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>