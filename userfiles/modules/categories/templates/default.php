<?php

/*

type: layout

name: Default

description: List Navigation

*/

?>

<?php
    $params['ul_class'] = 'nav nav-list';
	$params['ul_class_deep'] = 'nav nav-list';

$categorychild = get_categories('is_hidden=1');

if(!empty($categorychild) and $categorychild) {
    print "<style>";
    foreach ($categorychild as $category) {
        if ($category['is_hidden'] == 1) {
            print ".sidebar__widget.categorySideBar .module-categories ul>li[data-category-id='" . $category['id'] . "'] {
                    display:none !important;
                    }
                    ";
        }
    }

    print "</style>";
}
?>

<div class="module-categories module-categories-template-default">
	<div class="well">
        <?php
        // previous category
        //category_tree($params);
        ?>
		<?=  dt_category_tree($params);  ?>
	</div>
</div>


