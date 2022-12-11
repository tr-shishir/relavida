<style>
.bundel-product-admin-header {
    display: flex;
}

p.bundel-product-admin-title {
    width: 80%;
    margin-bottom: 0;
}

p.bundel-product-admin-quantity {
    width: 20%;
    text-align: right;
    margin-bottom: 0;
}

.bundel-product-admin-title-content {
    width: 80%;
}

.bundel-product-admin-body {
    display: flex;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.bundel-product-admin-quantity-content {
    width: 20%;
    text-align: right;
}

.add_form_field {
    margin-bottom: 10px;
}

.products {
    margin-bottom: 20px;
}

.delete {
    margin-top: 5px;
}

.product-with-quantity {
    margin-bottom: 20px;
}

input#discount::-webkit-outer-spin-button,
input#discount::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input#discount {
    -moz-appearance: textfield;
}

.bundel-product-admin-body:last-child {
    border-bottom: 0;
}

.bundle-products-admin-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.bundle-products-admin-header h5 {
    margin-bottom: 0;
    margin-left: 10px;
    color: #074a74;
}

.bundle-products-admin-header i {
    font-size: 18px;
    color: #074a74;
}

.bundle-product-admin-wrapper {
    margin-left: 50px;
    margin-top: 10px;
}

.create-bundle-btn i {
    font-size: 14px;
}

.delete-bundle-btn .edit-bundle-btn {
    padding: 10px;
}

.delete-bundle-btn i,
.edit-bundle-btn i {
    font-size: 10px;
    display: inline-block;
    margin: 0;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #c3c3c3;
    border-bottom: 2px solid #c3c3c3;
}

.input-group-append .quantity {
    height: 31px;
    border-radius: 0;
}

#bundleProductModal label {
    font-weight: 600;
}

tr.bundle-admin-header>th {
    font-weight: 600;
}

.input-group-append {
    margin-left: 0;
    /* width: 20%; */
    /* my added */
    width: 35%;
    display: flex;
    flex-direction: column;
    margin-right: 5px;
}


.sct-tooltip {
    position: relative;
    display: inline-block;
}


.tooltip {
    position: relative;
    z-index: 1;
    display: inline-block;
    line-break: auto;
    opacity: 1;
}

.tooltip:hover {
    z-index: 999;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 380px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 10px;
    position: absolute;
    z-index: 1;
    bottom: 22px;
    right: -26px;
    opacity: 0;
    transition: opacity 0.3s;
    left: unset;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
    transform: rotate(-2deg);
    left: unset;
    right: 28px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

.tooltip i {
    color: #074a74;
    font-size: 12px;
}

.sct-tooltip.rigth-content {
    margin-left: 5px;
}

.sct-tooltip.rigth-content .tooltiptext {
    left: -30px;
    right: unset;
}

.sct-tooltip.rigth-content .tooltip .tooltiptext::after {
    left: 36px;
    right: unset;
}

p.bundel-product-admin-title {
    width: 50%;
}

p.bundel-product-admin-quantity {
    width: 50%;
}


.input-group .input-group-append input {
    height: 35px !important;
    border-radius: 3px !important;
    margin-left: 2px;
}



.input-group select#product {}

.input-group button.btn.dropdown-toggle {
    height: 35px;
    border-radius: 3px !important;
    padding-top: 8px;
}

.sct-tooltip {
    display: inline-block;
}

label.control-label {
    position: relative;
    display: inline-block;
}

#product-with-price .form-group input#product-title-and-price {
    display: inline-block;
    margin-bottom: 5px;
}

#product-with-price .form-group input#product_quantity {
    width: 15%;
    display: inline-block;
}

#product-with-price .form-group button.delete-bundle-btn {
    height: 40px;
    display: inline-block;
    top: -2px;
    position: relative;
    padding-top: 9px;
}

.header-cart-bundle-offer {
    display: flex;
    align-items: center;
    box-shadow: 0 0 2px 1px #ccc;
    padding: 5px;
    margin-top: 10px;
}

.header-cart-bundle-offer h5 {
    margin-bottom: 0;
    margin-right: 10px;
    color: #074a74;
}

input.minimum_p {
    width: 15%;
    display: inline-block;
}

.addProductField .product-with-quantity .dropdown.form-control {
    /* width: 75% !important; */
    display: inline-block;
    /* my added */
    width: 100% !important;
    margin-bottom: 10px;
}

.addProductField .product-with-quantity .input-group {
    /* width: 80%; */
    display: inline-block;
    /* my added */
    width: 100%;
}

.addProductField .product-with-quantity .input-group .input-group-append {
    display: inline-block;
    vertical-align: top;
    /* width: 24%; */
    /* my added */
    width: 35%;
}

.addProductField .product-with-quantity .input-group .input-group-append:not(:last-child) {
    margin-right: 10px;
}

.addProductField .product-with-quantity .input-group-append {
    display: inline-block;
    vertical-align: top;
}

.addProductField .input-group input.minimum_p,
.addProductField .product-with-quantity .input-group-append input.minimum_p {
    height: 36px;
    width: 100% !important;
}

#product-with-price {
    position: relative;
}

#product-with-price .form-group {
    position: relative;
    width: 100%;
}

#product-with-price .form-group .form-group {
    width: 25%;
    display: inline-block;
}

#product-with-price .form-group .form-group input#product_quantity {
    width: 100%;
}

#product-with-price .form-group .form-group input#product_quantity {}

#product-with-price .form-group .form-group input.minimum_p {
    width: 100%;
}

#product-with-price .form-group .form-group label {
    font-size: 12px;
    line-height: 12px;
}

#bundleProductModal .modal-dialog {
    max-width: 700px;
}

#product-with-price>.form-group {
    box-shadow: 0 0 2px 2px #e7e7e7;
    padding: 5px;
}


/* my added */
.dropdown.bootstrap-select.js-search-by-selector.form-control.btn-sm-dropdown {
    min-width: 100%;
    margin-bottom: 10px;
}

.addProductField .btn-danger {
    margin-top: 26px;
    padding: 10px;
}
</style>
<!-- start bundle create modal -->
<div class="modal fade" id="bundleProductModal" tabindex="-1" role="dialog" aria-labelledby="bundleProduct"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bundleProductTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title"><?php _e('Title'); ?></label>
                    <p><?php _e('This title is visible as a bundle name for your customer in the shopping cart as a heading'); ?>.
                    </p>
                    <input type="Text" class="form-control" id="title" placeholder="<?php _e('Title'); ?>">
                </div>
                <div id="product-with-price">

                </div>
                <div class="form-group addProductField">
                    <div style="display: flex;justify-content: space-between;align-items: center;margin-bottom: 10px;">
                        <label for="products"><?php _e('Add Products'); ?></label>
                        <select class="form-control" name="" id="search_by" style="width: 30%;height: 30px;">
                            <option value=""><?php _e('Choose one'); ?></option>
                            <option value="ean"><?php _e('EAN'); ?></option>
                            <option value="sku"><?php _e('Item-Number/SKU'); ?></option>
                            <option value="tag"><?php _e('TAGS'); ?></option>
                        </select>
                    </div>
                    <script>
                    $(document).ready(function() {
                        $("#search_by").on("change", function() {
                            let value = $(this).val();
                            if (value != undefined) {
                                if (value == 'ean') {
                                    var x = jQuery('#all #product :selected').val();
                                    if (!x) {
                                        $("#all").hide();
                                    } else {
                                        $("#all").show();
                                    }
                                    var y = jQuery('#sku #product :selected').val();
                                    if (!y) {
                                        $("#sku").hide();
                                    } else {
                                        $("#sku").show();
                                    }
                                    if (!x && !y) {
                                        if (jQuery('#ean #product :selected').val()) {
                                            $(".add_form_field").click();
                                        } else {
                                            $("#ean").show();
                                        }
                                    } else {
                                        var check = jQuery('.product-with-quantity #product :selected')
                                            .last().val();
                                        if (check != undefined && check) {
                                            $(".add_form_field").click();
                                        } else {
                                            jQuery('.product-with-quantity').last().remove();
                                            $(".add_form_field").click();
                                        }
                                    }
                                    $("#tag").hide();
                                    $(".add_form_field").show();
                                    jQuery('.product-with-quantity').show();
                                } else if (value == 'sku') {
                                    var x = jQuery('#all #product :selected').val();
                                    if (!x) {
                                        $("#all").hide();
                                    } else {
                                        $("#all").show();
                                    }
                                    var y = jQuery('#ean #product :selected').val();
                                    if (!y) {
                                        $("#ean").hide();
                                    } else {
                                        $("#ean").show();
                                    }
                                    if (!x && !y) {
                                        if (jQuery('#sku #product :selected').val()) {
                                            $(".add_form_field").click();
                                        } else {
                                            $("#sku").show();
                                        }
                                    } else {
                                        var check = jQuery('.product-with-quantity #product :selected')
                                            .last().val();
                                        if (check != undefined && check) {
                                            jQuery('.product-with-quantity').hide();
                                            $(".add_form_field").click();
                                        } else {
                                            jQuery('.product-with-quantity').last().remove();
                                            $(".add_form_field").click();
                                        }
                                    }
                                    $("#tag").hide();
                                    $(".add_form_field").show();
                                    jQuery('.product-with-quantity').show();
                                } else if (value == 'tag') {
                                    $("#tag").show();
                                    $("#sku").hide();
                                    $("#ean").hide();
                                    $("#all").hide();
                                    $(".add_form_field").hide();
                                    jQuery('.product-with-quantity').hide();
                                }
                            }
                        });
                    });
                    </script>
                    <div class="container1">
                        <?php

                        $products = DB::table('product')->where('content_type', 'product')->where('is_deleted', 0)->get();
                        //foreach($products as $product){
                        //}
                        $product_tags = product_tagging_tag();
                        $symbol = mw()->shop_manager->currency_symbol();
                        if ($products) : ?>

                        <div class="products" id="ean" style="display: none;">
                            <div class="input-group">
                                <select class="selectpicker js-search-by-selector form-control" name="product[]"
                                    id="product" data-live-search="true" data-width="100%" data-style="btn-sm"
                                    tabindex="-98" aria-label="product slug selected">
                                    <option value=""><?php _e('Choose one'); ?></option>
                                    <?php foreach ($products as $product) :
                                            $price = $product->vk_price ? $product->vk_price : 0;
                                            if($price == 0){
                                                continue;
                                            }
                                            // $all_prices = get_product_prices($product->id, true);
                                        ?>
                                    <option value="<?= $product->id ?>"><?= $product->ean . ' | ' . $product->title; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <label for="" class="mqtylabel">Angebotsmenge</label>
                                    <input type="Text" class="form-control quantity" name="qty[]" id="quantity_ean_1"
                                        placeholder="<?php _e('Quantity'); ?>">
                                </div>
                                <div class="input-group-append">
                                    <label for="" class="qty-label">Mindestbestellmenge</label>
                                    <input type="Text" class="form-control minimum_p" name="minimum_p[]"
                                        id="minimum_p_ean_1" onkeyup="checkMinimumQuantity(this)"
                                        placeholder="<?php _e('Minimum Quantity'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="products" id="sku" style="display: none;">
                            <div class="input-group">
                                <select class="selectpicker js-search-by-selector form-control" name="product[]"
                                    id="product" data-live-search="true" data-width="100%" data-style="btn-sm"
                                    tabindex="-98" aria-label="product slug selected">
                                    <option value=""><?php _e('Choose one'); ?></option>
                                    <?php foreach ($products as $product) :
                                            $price = $product->vk_price ? $product->vk_price : 0;
                                            $sku = $product->sku;
                                            if($price == 0){
                                                continue;
                                            }
                                            // $all_prices = get_product_prices($product->id, true);
                                        ?>
                                    <option value="<?= $product->id ?>">
                                        <?= $sku . ' | ' . $product->title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <label for="" class="mqtylabel">Angebotsmenge</label>
                                    <input type="Text" class="form-control quantity" name="qty[]" id="quantity_sku_1"
                                        placeholder="<?php _e('Quantity'); ?>">
                                </div>
                                <div class="input-group-append">
                                    <label for="" class="qty-label">Mindestbestellmenge</label>
                                    <input type="Text" class="form-control minimum_p" name="minimum_p[]"
                                        id="minimum_p_sku_1" onkeyup="checkMinimumQuantity(this)"
                                        placeholder="<?php _e('Minimum Quantity'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="products" id="tag" style="display: none;">
                            <div class="input-group">
                                <select class="selectpicker js-search-by-selector form-control" name="tag" id="product"
                                    data-live-search="true" data-width="100%" data-style="btn-sm" tabindex="-98"
                                    aria-label="product slug selected">
                                    <option value=""><?php _e('Choose one'); ?></option>
                                    <?php foreach ($product_tags as $tag) :

                                            // $all_prices = get_product_prices($product->id, true);
                                        ?>
                                    <option value="<?= $tag->tag_name ?>"><?= $tag->tag_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="products" id="all" style="">
                            <div class="input-group">
                                <select class="selectpicker js-search-by-selector form-control" name="product[]"
                                    id="product" data-live-search="true" data-width="100%" data-style="btn-sm"
                                    tabindex="-98" aria-label="product slug selected">
                                    <option value=""><?php _e('Choose one'); ?></option>
                                    <?php foreach ($products as $product) :
                                            $price = $product->vk_price ? $product->vk_price : 0;
                                            if($price == 0){
                                                continue;
                                            }
                                            // $all_prices = get_product_prices($product->id, true);
                                        ?>
                                    <option value="<?= $product->id ?>">
                                        <?= $product->title . ' | Preis : ' . $symbol . ' ' . $price; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <label for="" class="mqtylabel">Angebotsmenge</label>
                                    <input type="Text" class="form-control quantity" name="qty[]" id="quantity_all_1"
                                        placeholder="<?php _e('Quantity'); ?>">
                                </div>
                                <div class="input-group-append">
                                    <label for="" class="qty-label">Mindestbestellmenge</label>
                                    <input type="Text" class="form-control minimum_p" name="minimum_p[]"
                                        id="minimum_p_all_1" onkeyup="checkMinimumQuantity(this)"
                                        placeholder="<?php _e('Minimum Quantity'); ?>">
                                </div>
                            </div>
                        </div>
                        <?php else : ?>
                        <div><?php _e('No products found'); ?></div>
                        <?php endif; ?>
                    </div>
                    <button class="add_form_field btn btn-primary"><?php _e('Add another product'); ?> &nbsp;
                        <span style="font-size:16px; font-weight:bold;">+ </span>
                    </button>
                </div>
                <div class="form-group">
                    <label for="discount"><?php _e('Discount'); ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend" style="width: 30%;">
                            <select class="js-search-by-selector form-control" name="discount-tyoe" id="discount-tyoe"
                                data-live-search="true" data-width="100%" data-style="btn-sm" tabindex="-98"
                                aria-label="discount-tyoe selected">
                                <option value="percentage"><?php _e('Percentage'); ?></option>
                                <option value="flat"><?php _e('Flat'); ?></option>
                            </select>
                        </div>
                        <input type="number" class="form-control" id="discount" placeholder="Discount"
                            style="width: 70% !important;">
                    </div>

                </div>
                <div class="form-group">
                    <div>
                        <label class="control-label"><?php _e("Product select/unselect discount condition"); ?> <div
                                class="sct-tooltip">
                                <div class="tooltip"><i class="fa fa-eye"></i>
                                    <span
                                        class="tooltiptext"><?php _e("If you turned on this button then the discount will be applied even if the product will be unselected. Otherwise, the discount won't calculated if the product is unselected"); ?></span>
                                </div>
                            </div></label>

                    </div>
                    <div class="custom-control custom-switch m-0">
                        <input type="checkbox" class="custom-control-input bundle-option" id="bundle-option"
                            data-option-group="bundle" data-value-checked="0" data-value-unchecked="1" />
                        <label class="custom-control-label" for="bundle-option"></label>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Close'); ?></button>
                <div id="bundle-submit-button"></div>
            </div>
        </div>
    </div>
</div>
<!-- start bundle create modal -->

<div class="bundle-product-admin-wrapper">
    <div class="">
        <div class="bundle-products-admin-header">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <h5><?php _e('Bundle Products'); ?></h5>
        </div>
        <button type="button" class="btn btn-primary create-bundle-btn" onclick="create_new_bundel_modal()"><i
                class="fa fa-plus" aria-hidden="true"></i><?php _e('Create new bundle'); ?></button>
    </div>
    <div class="header-cart-bundle-offer">
        <h5><?php _e('Offer condition for cart modal'); ?>:</h5>
        <?php $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0; ?>
        <div class="custom-control custom-switch m-0">
            <input type="checkbox" class="custom-control-input" id="bundle_settings_for_all" data-option-group="shop"
                data-value-checked="0" data-value-unchecked="1"
                <?php if ($update_global_bundle_discount_condition == 0) : ?>checked<?php endif; ?> />
            <label class="custom-control-label" for="bundle_settings_for_all"></label>
        </div>
        <div class="sct-tooltip rigth-content">
            <div class="tooltip"><i class="fa fa-eye"></i>
                <span
                    class="tooltiptext"><?php _e('If you turned off this button then the discount will be applied even if any products will be added or removed from the cart. Otherwise, the discount won\'t calculated if any products is added or removed'); ?></span>
            </div>
        </div>
    </div>
    <div class="">
        <table class="table table-bordered mt-3">
            <thead style="background: #e7e7e7;">
                <tr class="bundle-admin-header">
                    <?php
                    use App\Models\Bundle;
                    $bundles = Bundle::with('bundle_products')->orderBy('id', 'DESC')->get();
                    if ($bundles->toArray()) : ?>

                    <th scope="col">#</th>
                    <th scope="col" style="min-width: 210px;">
                        <?php _e('Offer condition for layout'); ?>
                        <div class="sct-tooltip rigth-content">
                            <div class="tooltip"><i class="fa fa-eye"></i>
                                <span
                                    class="tooltiptext"><?php _e("If you turned off this button then the discount will be applied even if the product will be unselected. Otherwise, the discount won't calculated if the product is unselected"); ?></span>
                            </div>
                        </div>
                    </th>
                    <th scope="col"><?php _e('Title'); ?></th>
                    <th scope="col">
                        <div class="bundel-product-admin-header">
                            <p class="bundel-product-admin-title"><?php _e('Product'); ?></p>
                            <p class="bundel-product-admin-quantity"><?php _e('Minimum Quantity'); ?></p>
                        </div>
                    </th>
                    <th scope="col" style="text-align: center;"><?php _e('Discount'); ?></th>
                    <th scope="col" style="text-align: center;min-width: 180px;"><?php _e('Action'); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($bundles) : $i = 1; ?>
                <?php foreach ($bundles as $bundle) : ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td scope="row" style="text-align: center;">
                        <div class="custom-control custom-switch m-0">
                            <input type="checkbox" class="custom-control-input bundle-selected-option"
                                id="bundle-selected-option-<?= $i; ?>" data-option-group="shop" data-value-checked="0"
                                data-value-unchecked="1"
                                <?php if ($bundle->bundle_option == 0) : ?>checked<?php endif; ?> />
                            <label class="custom-control-label" for="bundle-selected-option-<?= $i; ?>"></label>
                            <input type="hidden" id="bundle_id" name="bundle_id" value="<?= $bundle->id; ?>">
                        </div>
                    </td>
                    <td><?= $bundle->title ?></td>
                    <td style="padding: 0;">
                        <?php foreach ($bundle->bundle_products as $bundle_product) : ?>
                        <div class="bundel-product-admin-body"
                            id="<?php echo  "bundle_{$bundle->id}_{$bundle_product->product_id}"; ?>">

                            <div class="bundel-product-admin-title-content">
                                <?php
                                            $pro = $products->where('id', $bundle_product->product_id)->first();
                                            if(!$pro){ continue; }
                                            $stock_qty = $pro->quantity ? $pro->quantity : 0;
                                            // $key = $pro->keys();
                                            $product_prices = $pro->vk_price ? $pro->vk_price : 0;

                                            print $pro->title . ' | Preis : ' . $symbol . ' ' . $product_prices . ' | Verfügbarer Lagerbestand : ' . $stock_qty;
                                            ?>
                            </div>
                            <div class="bundel-product-admin-quantity-content"
                                id="<?php echo "bundle_quantity_{$bundle->id}_{$bundle_product->product_id}"; ?>">
                                <?= $bundle_product->minimum_p; ?>
                            </div>
                        </div>

                        <?php endforeach; ?>
                    </td>
                    <td style="text-align: center;font-weight: 700;">
                        <?php print $bundle->discount;
                                if ($bundle->discount_type == "percentage") {
                                    print ' %';
                                } else {
                                    print ' ' . $symbol;
                                } ?>
                    </td>
                    <td style="text-align:center">
                        <button type="button" class="btn btn-primary edit-bundle-btn" value="<?= $bundle->id ?>"
                            onclick="edit_bundle_product(this.value)"><i class="fa fa-edit"
                                aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger delete-bundle-btn" value="<?= $bundle->id ?>"
                            onclick="delete_bundle_product(this.value)"><i class="fa fa-trash"
                                aria-hidden="true"></i></button>
                    </td>
                </tr>
                <?php $i++;
                    endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    var wrapper = $(".container1");
    var add_button = $(".add_form_field");
    let i = 1;

    $(add_button).click(function(e) {
        i++;
        e.preventDefault();
        let check_value = $("#search_by").val();
        var select_type;
        if (check_value) {
            select_type = check_value;
        } else {
            select_type = 'all';
        }
        var html = '<div class="product-with-quantity">';
        html +=
            '<div class="input-group"><select class="selectpicker js-search-by-selector form-control" name="product[]" id="product"  data-live-search="true" data-width="100%" data-style="btn-sm" tabindex="-98" aria-label="product slug selected">';
        html += '<option value=""><?php _e('Choose one'); ?></option>';
        <?php foreach ($products as $product) :
                $price = $product->vk_price ? $product->vk_price : 0;
                $sku = $product->sku ? $product->sku : 0;
                if($price == 0){
                    continue;
                } ?>

        if (check_value == 'ean') {
            html +=
                `<option value = '<?= $product->id ?>' > <?= $product->ean . ' | ' . $product->title; ?> </option>`
        } else if (check_value == 'sku') {
            html +=
                `<option value = '<?= $product->id ?>' > <?= $sku . ' | ' . $product->title; ?> </option>`
        } else if (check_value == 'tag') {
            html +=
                `<option value = '<?= $product->id ?>' > <?= $product->title . ' | Preis : ' . mw()->shop_manager->currency_symbol() . ' ' . $price; ?> </option>`
        } else {
            html +=
                `<option value = '<?= $product->id ?>' > <?= $product->title . ' | Preis : ' . mw()->shop_manager->currency_symbol() . ' ' . $price; ?> </option>`
        }

        <?php endforeach; ?>
        html += '</select>';
        html +=
            '<div class="input-group-append"> <label for="" class="mqtylabel">Angebotsmenge</label> <input type="Text" class="form-control quantity" name="qty[]" id="quantity_' +
            select_type + '_' + i + '" placeholder="<?php _e("Quantity"); ?>"></div>';
        html +=
            '<div class="input-group-append"><label for="" class="qty-label">Mindestbestellmenge</label><input type="Text" class="form-control minimum_p" name="minimum_p[]" id="minimum_p_' +
            select_type + '_' + i +
            '" onkeyup="checkMinimumQuantity(this)" placeholder="<?php _e("Minimum Quantity"); ?>"></div>';
        html += '<a href="#" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></a></div>';

        $(wrapper).append(html);
        $('.selectpicker').selectpicker('render');
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
    })

    $('.bundle-selected-option').click(function() {
        var bundle_id = $(this).siblings('#bundle_id').val();
        var bundle_option = 1;
        if ($(this).prop("checked") == true) {
            bundle_option = 0;
        }
        $.post("<?= api_url('update_bundle_discount_condition') ?>", {
            bundle_id: bundle_id,
            bundle_option: bundle_option
        }).then((res, err) => {
            mw.notification.success(res);
        });
    });

    $('#bundle_settings_for_all').click(function() {
        var bundle_option = 1;
        if ($(this).prop("checked") == true) {
            bundle_option = 0;
            sessionStorage.setItem('cart_update_for_bundle_product', 'false');
        }
        $.post("<?= api_url('update_global_bundle_discount_condition') ?>", {
            bundle_setting_option: bundle_option
        }).then((res, err) => {
            mw.notification.success(res);
        });
    });
});

function store_bundle_product() {
    var title = $('#title').val();
    var discount = $('#discount').val();
    var discount_type = $('#discount-tyoe').val();
    var bundle_option = 1;
    if ($('#bundle-option').prop("checked") == true) {
        bundle_option = 0;
    }
    var qty = [];
    $('input[name^="qty"]').each(function() {
        qty.push($(this).val());
    });

    var product_ids = [];
    $('select[name="product[]"]').each(function() {
        product_ids.push($(this).val());
    });

    var minimum_p = [];
    $('input[name^="minimum_p[]"]').each(function() {
        minimum_p.push($(this).val());
    });
    var tags;
    if (product_ids) {
        tags = $('select[name="tag"]').val();
    }

    var data = {
        title: title,
        qty: qty,
        discount: discount,
        discount_type: discount_type,
        minimum_p: minimum_p,
        tag: tags,
        product_ids: product_ids,
        bundle_option: bundle_option
    };

    if (!title || discount <= 0) {

        mw.notification.warning("Please provide all the information!");
    } else {
        $.post("<?= api_url('store_bundle_product') ?>", data).then((res, err) => {
            if (res[0]) {
                mw.notification.success(res[1]);
                location.reload();
            } else {
                mw.notification.warning(res[1]);
            }
        });
    }
}

function edit_bundle_product(id) {
    $("#tag").hide();
    $("#sku").hide();
    $("#ean").hide();
    $("#all").hide();
    jQuery('.product-with-quantity').remove();
    var bundle_id = id;
    $.post("<?= api_url('edit_bundle_product') ?>", {
        bundle_id: bundle_id,
    }).then((res, err) => {
        $('#bundleProductTitle').html('<?php _e("Edit Bundle"); ?>');
        $('#title').val(res[0]);
        $('#product-with-price').html(res[1]);
        $('#discount-tyoe').val(res[2]).attr("selected", "selected");
        $('#discount').val(res[3]);

        if (res[4] == '0') {
            $("#bundle-option").prop("checked", true);
        } else {
            $("#bundle-option").prop("checked", false);
        }

        var submit_button =
            '<button type="button" class="btn btn-primary update_bundle_btn" onclick="update_bundle_product(';
        submit_button += res[5];
        submit_button += ')"><?php _e("Update"); ?></button>';
        $('#bundle-submit-button').html(submit_button);

        $('#bundleProductModal').modal('show');
    });
}

function create_new_bundel_modal() {
    $("#tag").hide();
    $("#sku").hide();
    $("#ean").hide();
    jQuery('.product-with-quantity').remove();
    $("#all").show();
    $('#bundleProductTitle').html('<?php _e('Create Bundle'); ?>');
    $('#title').val('');
    $('#product-with-price').html('');
    $('#discount-tyoe').val('percentage').attr("selected", "selected");
    $('#search_by').val('').attr("selected", "selected");
    $('#product').val('').attr("selected", "selected");
    $('#discount').val('');
    $('#quantity_all_1').val('');
    $('#minimum_p_all_1').val('');
    $("#bundle-option").prop("checked", false);

    var submit_button =
        '<button type="button" class="btn btn-primary add_bundle_btn" onclick="store_bundle_product()"><?php _e("Save"); ?></button>';

    $('#bundle-submit-button').html(submit_button);

    $('#bundleProductModal').modal('show');
}

function update_bundle_product(bundle_id) {
    var bundle_id = bundle_id;
    var title = $('#title').val();
    var discount = $('#discount').val();
    var discount_type = $('#discount-tyoe').val();
    var bundle_option = 1;
    if ($('#bundle-option').prop("checked") == true) {
        bundle_option = 0;
    }
    var qty = [];
    $('input[name^="qty"]').each(function() {
        qty.push($(this).val());
    });

    var product_ids = [];
    $('select[name="product[]"]').each(function() {
        product_ids.push($(this).val());
    });

    var minimum_p = [];
    $('input[name^="minimum_p[]"]').each(function() {
        minimum_p.push($(this).val());
    });
    var tags;
    if (product_ids) {
        tags = $('select[name="tag"]').val();
    }

    var data = {
        title: title,
        qty: qty,
        discount: discount,
        discount_type: discount_type,
        tag: tags,
        product_ids: product_ids,
        minimum_p: minimum_p,
        bundle_option: bundle_option,
        bundle_id: bundle_id
    };

    if (!title || discount <= 0) {

        mw.notification.warning("Please provide all the information!");
    } else {
        $.post("<?= api_url('update_bundle_product') ?>", data).then((res, err) => {
            mw.notification.success(res);
            location.reload();
        });
    }
}

function delete_bundle_product(id) {
    var bundle_id = id;
    $.post("<?= api_url('delete_bundle_product') ?>", {
        bundle_id: bundle_id,
    }).then((res, err) => {
        mw.notification.success(res);
        location.reload();
    });
}

function update_product_qty_from_bundle(product_id, bundle_id, previous_qty, updated_qty) {
    if (updated_qty != 0) {
        $.post("<?= api_url('update_product_qty_from_bundle') ?>", {
            product_id: product_id,
            bundle_id: bundle_id,
            previous_qty: previous_qty,
            updated_qty: updated_qty,
        }).then((res, err) => {
            mw.notification.success("<?php _e('Your product quantity updated successfully'); ?>");
        });
    }
}

function update_m_product_qty_from_bundle(product_id, bundle_id, previous_m_qty, updated_m_qty, field_id) {
    var number = field_id.split('_').pop();
    var min_q = jQuery('#' + field_id).val();
    var q = jQuery('#product_quantity_edit_' + number).val();
    if (parseInt(q) >= parseInt(min_q)) {
        jQuery('#' + field_id).css('border', '1px solid #cfcfcf');
        if (updated_m_qty != 0) {
            $.post("<?= api_url('update_m_product_qty_from_bundle') ?>", {
                product_id: product_id,
                bundle_id: bundle_id,
                previous_m_qty: previous_m_qty,
                updated_m_qty: updated_m_qty,
            }).then((res, err) => {
                $('#bundle_quantity_' + bundle_id + '_' + product_id).text(updated_m_qty);
                mw.notification.success("<?php _e('Your product quantity updated successfully'); ?>");
            });
        }
        jQuery('.update_bundle_btn').attr('onclick', 'update_bundle_product(' + bundle_id + ')');
    } else {
        jQuery('#' + field_id).css('border', '1px solid red');
        mw.notification.error("<?php _e('The minimum order quantity must not be greater than the oﬀer quantity'); ?>");
        jQuery('.update_bundle_btn').removeAttr('onclick');
        jQuery('.update_bundle_btn').attr('onclick',
            'mw.notification.error(`Please provide all information correctly!`)');
    }
}

function delete_product_from_bundle(product_id, product_qty, bundle_id) {
    $.post("<?= api_url('delete_product_from_bundle') ?>", {
        product_id: product_id,
        product_qty: product_qty,
        bundle_id: bundle_id,
    }).then((res, err) => {
        mw.notification.success(res[0]);
        $("." + res[1]).hide();
        $("#bundle_" + bundle_id + "_" + product_id).remove();
    });

}

function checkMinimumQuantity(data) {
    var min_id = data.id;
    var arr_data = min_id.split("_");
    var number = arr_data.pop();
    var type = arr_data.pop();
    var min_q = jQuery('#' + min_id).val();
    var q = jQuery('#quantity_' + type + '_' + number).val();
    if (parseInt(q) >= parseInt(min_q)) {
        jQuery('#' + min_id).css('border', '1px solid #cfcfcf');
        jQuery('.add_bundle_btn').attr('onclick', 'store_bundle_product()');
    } else {
        jQuery('#' + min_id).css('border', '1px solid red');
        mw.notification.error("<?php _e('The minimum order quantity must not be greater than the oﬀer quantity'); ?>");
        jQuery('.add_bundle_btn').removeAttr('onclick');
        jQuery('.add_bundle_btn').attr('onclick', 'mw.notification.error(`Please provide all information correctly!`)');
    }
}
</script>