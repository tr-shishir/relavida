<script type="text/javascript">
    mw.require("shop.js", true);
    mw.require("events.js", true);
</script>
<script type="text/javascript">
    $(document).ready(function () {
        mw.on.moduleReload('cart_fields_<?php print $params['id'] ?>', function () {
            mw.reload_module('#<?php print $params['id'] ?>');
        });
    })

</script>

<?php


/*<script>mw.moduleCSS("<?php print modules_url(); ?>shop/cart_add/styles.css"); </script>
*/
template_stack_add(modules_url()."shop/cart_add_V2/styles.css");

?>

<?php
$for_id = false;
$for = 'product';
if (isset($params['product-id'])) {
    $params['content-id'] = $params['product-id'];
}

$module_template = get_option('data-template', $params['id']);
if ($module_template == false and isset($params['template'])) {
    $module_template = $params['template'];
}


if ($module_template != false and $module_template != 'none') {
    $template_file = module_templates($config['module'], $module_template);

} else {
    $template_file = module_templates($config['module'], 'default');

}
if (isset($params['content-id'])) {
    $for_id = $params['content-id'];
}


if (isset($params['for'])) {
    $for = $params['for'];
}
if (isset($params['button_text'])) {
    $button_text = $params['button_text'];
} else {
    $button_text = false;
}
$content_data = false;
if(isset($params['product-id'])){
    $data = DB::table('product')
            ->where('id', $params['product-id'])
            ->where('is_active', 1)
            ->select('id', 'url', 'title','content_body', 'quantity', 'sku', 'vk_price as price', 'drm_ref_id', 'ean', 'item_unit', 'item_weight', 'delivery_days', 'created_by', 'created_at', 'item_size')
            ->first();
    $content_data = (array)$data;
}
$in_stock = true;


if (isset($content_data['quantity']) and $content_data['quantity'] != 'nolimit' and intval($content_data['quantity']) == 0) {

    $in_stock = false;
}

$data = false;
$offer = DB::table('offers')
            ->where('product_id', $params['product-id'])
            ->where('is_active', 1)
            ->select('id', 'offer_price','created_at', 'expires_at')
            ->first();

$data['price'] = $content_data['price'];
if(isset($offer) and !empty($offer)){
    $offer = (array)$offer;
    $data['price'] = $offer['offer_price'];
    $offer['price'] = $content_data['price'];
}
$prices_includes_taxes = false;
$ex_tax = '';
$taxes_enabled = get_option('enable_taxes', 'shop');

if (isset($for_id) !== false and isset($for) !== false): ?>

    <div class="mw-add-to-cart-holder mw-add-to-cart-<?php print $params['id'] ?>">
        <?php //$data = get_custom_fields("field_type=price&for={$for}&for_id=" . $for_id . ""); ?>
        <?php if (is_array($data) == true): ?>
            <input type="hidden" name="for" value="<?php print $for ?>"/>
            <input type="hidden" name="for_id" value="<?php print $for_id ?>"/>
        <?php endif; ?>

        <?php if (isset($template_file) and is_file($template_file) != false) : ?>
            <?php include($template_file); ?>
        <?php else: ?>
            <?php print lnotif('No default template for ' . $config['module'] . ' is found'); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
