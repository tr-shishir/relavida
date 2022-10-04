<?php

/*

type: layout

name: Mobile Navbar

description: Navigation bar

*/

?>
<script>

    $(document).ready(function () {
        $('ul.nav .dropdown').hover(function () {
            $(this).find('.dropdown-menu:first', this).stop(true, true).delay(200).fadeIn();
        }, function () {
            $(this).find('.dropdown-menu:first', this).stop(true, true).delay(200).fadeOut();
        });

        $('ul.nk-nav.nk-nav-right.hidden-md-down').attr('data-nav-mobile', '#nk-nav-mobile');
    });

</script>

<?php
$menu_filter['ul_class'] = 'nk-nav';
$menu_filter['ul_class_deep'] = 'dropdown-menu';
$menu_filter['li_class'] = '';
$menu_filter['a_class'] = '';


$mt = menu_tree($menu_filter);

if ($mt != false) {
    print ($mt);
} else {
    print lnotif("There are no items in the menu <b>" . $params['menu-name'] . '</b>');
}
?>
