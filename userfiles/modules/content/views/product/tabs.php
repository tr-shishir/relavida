<?php
$product = [];
$product['id'] = 0;
$productPrice = 0;
$productEkPrice = 0;
$contentData = \MicroweberPackages\Product\Models\Product::$contentDataDefault;
$customFields = \MicroweberPackages\Product\Models\Product::$customFields;

if ($data['id'] > 0) {
    $product = \MicroweberPackages\Product\Models\Product::find($data['id']);
    $contentData = @$product->getContentData() ?? [];
    $productPrice = $product->price;
    $productEkPrice = $product->ek_price ?? 0;

}
?>

<?php include_once __DIR__ .'/pricing.php'; ?>
<?php include_once __DIR__ .'/inventory.php'; ?>
<!-- <?php // include_once __DIR__ .'/shipping.php'; ?> -->
