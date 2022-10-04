<?php
$option_group = 'mw-template-' . mw()->template->folder_name();

$sticky_navigation = get_option('sticky_navigation', $option_group);
if ($sticky_navigation == false OR $sticky_navigation == '') {
    $sticky_navigation = '';
}

$member_navigation_style = get_option('member_navigation_style', $option_group);
if ($member_navigation_style == false OR $member_navigation_style == '') {
    $member_navigation_style = '';
}

$titles_inverse = get_option('titles_inverse', $option_group);
if ($titles_inverse == false OR $titles_inverse == '') {
    $titles_inverse = '';
}

$buttons_style = get_option('buttons_style', $option_group);
if ($buttons_style == false OR $buttons_style == '') {
    $buttons_style = '';
}

$shopping_cart = get_option('shopping_cart', $option_group);
if ($shopping_cart == false OR $shopping_cart == '' OR $shopping_cart == 'false') {
    $shopping_cart = 'false';
} else {
    $shopping_cart = 'true';
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