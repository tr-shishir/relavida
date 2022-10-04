<?php
$from_live_edit = false;
if (isset($params["live_edit"]) and $params["live_edit"]) {
    $from_live_edit = $params["live_edit"];
}
?>

<style>
    .checkout-slugadd .bootstrap-select.js-search-by-selector {
        width: 100% !important;
        height: 40px;
    }

    .checkout-slugadd .bootstrap-select.js-search-by-selector button.btn.dropdown-toggle {
        height: 40px;
        padding-top: 10px;
    }
</style>

<?php if (isset($params['backend'])) : ?>
    <module type="admin/modules/info" />
<?php endif; ?>

<div class="card style-1 mb-3 <?php if ($from_live_edit) : ?>card-in-live-edit<?php endif; ?>">
    <div class="card-header">
        <?php $module_info = module_info($params['module']); ?>
        <h5>
            <img src="<?php echo $module_info['icon']; ?>" class="module-icon-svg-fill" /> <strong><?php echo $module_info['name']; ?></strong>
        </h5>
    </div>

    <div class="card-body pt-3">
        <nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
            <a class="btn btn-outline-secondary justify-content-center active" data-toggle="tab" href="#settings"><i class="mdi mdi-cog-outline mr-1"></i> <?php print _e('Settings'); ?></a>
            <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#templates"><i class="mdi mdi-pencil-ruler mr-1"></i> <?php print _e('Templates'); ?></a>
        </nav>

        <div class="tab-content py-3">
            <div class="tab-pane fade show active" id="settings">
                <script type="text/javascript">
                    mw.require('options.js');
                </script>

                <script type="text/javascript">
                    __checkout_options_save_msg = function() {
                        if (mw.notification != undefined) {
                            mw.notification.success('Checkout updated!');
                        }

                        if (window.parent.mw != undefined && window.parent.mw.reload_module != undefined) {

                            window.parent.mw.reload_module("#<?php print $params['id'] ?>");
                        }
                    }

                    $(document).ready(function() {
                        mw.options.form('.mw-set-checkout-options-swticher', __checkout_options_save_msg);
                    });

                    function productId(product_id) {
                        product_id = product_id.value;
                        if (product_id) {
                            $.post("<?= api_url('product_id_store') ?>", {
                                module_id: '<?= $params['id'] ?>',
                                product_id: product_id
                            }).then((res, err) => {
                                mw.notification.success(res);
                            });
                        }
                        mw.reload_module_parent("#<?= $params['id'] ?>");
                    }
                </script>
                <!-- Settings Content -->
                <div class="module-live-edit-settings module-shop-checkout-settings">
                    <div class="mw-set-checkout-options-swticher">
                        <div class="form-group">
                            <label class="control-label d-block"><?php _e("Show shopping cart in checkout?"); ?></label>

                            <?php $cart_show_enanbled = get_option('data-show-cart', $params['id']); ?>
                            <select name="data-show-cart" class="mw_option_field selectpicker" data-width="100%">
                                <option value="y" <?php if (('n' != strval($cart_show_enanbled))) : ?> selected="selected" <?php endif; ?>><?php _e("Yes"); ?></option>
                                <option value="n" <?php if (('n' == strval($cart_show_enanbled))) : ?> selected="selected" <?php endif; ?>><?php _e("No"); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label d-block"><?php _e("Show shipping?"); ?></label>

                            <?php $cart_show_enanbled = get_option('data-show-shipping', $params['id']); ?>
                            <select name="data-show-shipping" class="mw_option_field selectpicker" data-width="100%">
                                <option value="y" <?php if (('n' != strval($cart_show_enanbled))) : ?> selected="selected" <?php endif; ?>>
                                    <?php _e("Yes"); ?>
                                </option>
                                <option value="n" <?php if (('n' == strval($cart_show_enanbled))) : ?> selected="selected" <?php endif; ?>>
                                    <?php _e("No"); ?>
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label d-block"><?php _e("Show payments?"); ?></label>

                            <?php $cart_show_enanbled = get_option('data-show-payments', $params['id']); ?>
                            <select name="data-show-payments" class="mw_option_field selectpicker" data-width="100%">
                                <option value="y" <?php if (('n' != strval($cart_show_enanbled))) : ?> selected="selected" <?php endif; ?>><?php _e("Yes"); ?></option>
                                <option value="n" <?php if (('n' == strval($cart_show_enanbled))) : ?> selected="selected" <?php endif; ?>><?php _e("No"); ?></option>
                            </select>
                        </div>

                        <div class="form-group checkout-slugadd">
                            <?php
                            $single_product = DB::table('single_checkout_products')->where('module_id', $params['id'])->first();
                            $product_id = "";
                            if ($single_product) {
                                $product_id = $single_product->product_id;
                            }
                            $select_option_products = DB::table('content')->where('content_type', 'product')->where('is_deleted', 0)->get();
                            ?>
                            <label class="control-label d-block"><?php _e("Add Product for checkout"); ?></label>
                            <select class="selectpicker js-search-by-selector form-control" data-live-search="true" onchange="productId(this)" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="product slug selected">
                                <?php if ($select_option_products) : ?>
                                    <?php if ($product_id == "") : ?>
                                        <option value=""><?php _e('choose one'); ?></option>
                                    <?php endif; ?>
                                    <?php foreach ($select_option_products as $select_option_product) :
                                        $all_prices = get_product_prices($select_option_product->id, true);
                                    ?>

                                        <?php if ($select_option_product->id == $product_id) : ?>
                                            <option value="<?= $select_option_product->id ?>" selected="selected"><?= $select_option_product->title . ' | ' . $all_prices[0]['name']  . ' : ' . mw()->shop_manager->currency_symbol() . ' ' . $all_prices[0]['value_plain'];  ?></option>
                                        <?php else : ?>
                                            <option value="<?= $select_option_product->id ?>"><?= $select_option_product->title . ' | ' . $all_prices[0]['name']  . ' : ' . mw()->shop_manager->currency_symbol() . ' ' . $all_prices[0]['value_plain']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="">No products found</option>
                                <?php endif; ?>
                            </select>
                        </div>

                    </div>
                    <!-- Settings Content - End -->
                </div>

                <div class="tab-pane fade" id="templates">
                    <module type="admin/modules/templates" />
                </div>
            </div>
        </div>
    </div>