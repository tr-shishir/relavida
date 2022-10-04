<?php
$option_group = 'mw-template-' . mw()->template->folder_name();

$sticky_navigation = get_option('sticky_navigation', $option_group);
if ($sticky_navigation == false OR $sticky_navigation == '') {
    $sticky_navigation = '';
}

$shopping_cart = get_option('shopping_cart', $option_group);
if ($shopping_cart == false OR $shopping_cart == '' OR $shopping_cart == 'false') {
    $shopping_cart = 'false';
} else {
    $shopping_cart = 'true';
}

$header_style = get_option('header_style', $option_group);
if ($header_style == false OR $header_style == '' OR $header_style == 'false') {
    $header_style = '';
} elseif ($header_style == 'header-inverse') {
    $header_style = 'header-inverse';
}

$profile_link = get_option('profile_link', $option_group);
if ($profile_link == false OR $profile_link == '' OR $profile_link == 'false') {
    $profile_link = 'false';
} else {
    $profile_link = 'true';
}

$footer = get_option('footer', $option_group);
if ($footer == false OR $footer == '') {
    $footer = 'false';
}