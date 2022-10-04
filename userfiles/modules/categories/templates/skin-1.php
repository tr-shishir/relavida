<?php

/*

type: layout

name: Horizontal - List 1

description: List Navigation

*/

?>


<?php

use App\Models\Category;
use App\Models\CategoryItem;

$params['ul_class'] = 'mw-cats-menu';
$params['ul_class_deep'] = 'nav nav-list';
$categories = get_categories('rel_type=content');
$cat_manager = app()->category_manager;
if(!empty($categories)) {
    print "<style>";
    foreach ($categories as $category) {
        if ($category['is_hidden'] == 1) {
             print "[data-category-id='" . $category['id'] . "'] {
                    display:none !important;
                    }
                    ";
        }

    }
    print "</style>";

}
?>


<div class="module-categories module-categories-template-horizontal-list-1">
    <?php category_tree($params); ?>
</div>


