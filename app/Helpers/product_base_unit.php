<?php


if (!function_exists('product_unit_productBasePrice')) {
    function product_unit_productBasePrice($item_weight,$item_price,$item_unit,$base_unit_limit) {
        $base_unit_price = ($item_price/$item_weight)*$base_unit_limit;
        $final_base_price = "Content: ".$item_weight." ".$item_unit." | Base price: ".$base_unit_limit." ".$item_unit." = ".currency_format($base_unit_price);
        return $final_base_price;
    }
}