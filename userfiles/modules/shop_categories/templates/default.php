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

<?php if(CATEGORY_ID != false){ ?>
    <script>
        $(window).on("load", function(){
            //alert("<?php echo CATEGORY_ID; ?>");
            $('.module-categories>.well>ul.nav li a[data-category-id="<?php echo CATEGORY_ID; ?>"]').addClass("currentActiveCategory");
            $(".currentActiveCategory").parentsUntil('.module-categories').addClass('currentParents');
        });
    </script>
    <style>
        .categorySideBar .module-categories>.well>ul.nav li.active-parent.hasSubMenu>ul {
            display: block !important;
            opacity: 1;
            height: auto;
            left: 0%;
            padding-left: 20px;
        }

        .categorySideBar .module-categories>.well>ul.nav li.active-parent.hasSubMenu>span.hs-toggle:after {
            content: "-";
        }

        .categorySideBar .module-categories>.well>ul.nav li>a.currentActiveCategory {
            font-weight: bolder;
            font-size: 16px;
        }

        .module-categories-template-default li.active-parent>ul {
            display: block !important;
        }
        .module-categories-template-default li.active-parent>ul {
            display: block !important;
            height: auto !important;
            left: 0% !important;
        }


        .categorySideBar .module-categories>.well>ul.nav li.hasSubMenu.currentParents>ul {
            left: 0% !important;
            display: block !important;
            opacity: 1 !important;
            height: auto !important;
            padding-left: 10px;
        }

        .categorySideBar .module-categories>.well>ul.nav li.hasSubMenu.currentParents>span.hs-toggle:after {
            content: "-";
        }

        .categorySideBar .module-categories>.well>ul.nav li>a.currentActiveCategory + ul.nav {
            display: none !important;
        }

        .categorySideBar .module-categories>.well>ul.nav li>a.currentActiveCategory ~ span.hs-toggle:after {
            content: "+" !important;
        }


        .categorySideBar .module-categories>.well>ul.nav li.active.active-parent.active.active-parent.first.currentParents.hasSubMenu.showThisSub>ul.nav {
            display: block !important;
        }

        .categorySideBar .module-categories>.well>ul.nav li.active.active-parent.active.active-parent.first.currentParents.hasSubMenu.showThisSub>span.hs-toggle:after {
            content: "-" !important;
        }

        .categorySideBar .module-categories>.well>ul.nav li.showThisSub>a.currentActiveCategory + ul.nav {
            display: block !important;
        }

        .categorySideBar .module-categories>.well>ul.nav li.showThisSub>a.currentActiveCategory ~ span.hs-toggle:after {
            content: "-" !important;
        }
    </style>

<?php } ?>
