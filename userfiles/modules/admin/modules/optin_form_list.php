<?php
$modules_options = array();
$modules_options['skip_admin'] = true;
$modules_options['ui'] = true;
$modules = array();
$modules_by_categories = array();
$mod_obj_str = 'modules';
$template_config = mw()->template->get_config();
$show_grouped_by_cats = false;
$hide_dynamic_layouts = false;
$disable_elements = false;


if (isset($template_config['elements_mode']) and $template_config['elements_mode'] == 'disabled') {
    $disable_elements = true;
}

if (isset($params['hide-dynamic']) and $params['hide-dynamic']) {
    $hide_dynamic_layouts = true;
}

if (isset($is_elements) and $is_elements == true) {
    $mod_obj_str = 'elements';
    $el_params = array();
    if (isset($params['layout_type'])) {
        $el_params['layout_type'] = $params['layout_type'];
    }

    $modules = mw()->layouts_manager->get($el_params);
    //$modules = false;

    if ($modules == false) {
        // scan_for_modules($modules_options);
        $el_params['no_cache'] = true;
        mw()->module_manager->scan_for_elements($el_params);
        $modules = mw()->layouts_manager->get($el_params);
    }

    if ($modules == false) {
        $modules = array();
    }

    $elements_from_template = mw()->layouts_manager->get_elements_from_current_site_template();
    if (!empty($elements_from_template)) {
        $modules = array_merge($elements_from_template, $modules);
    }

    if ($disable_elements) {
        $modules = array();
    }

    // REMOVE
    //$modules = array();
    //return;

    // $dynamic_layouts = mw()->layouts_manager->get_all('no_cache=1&get_dynamic_layouts=1');
    $dynamic_layouts = false;
    $module_layouts_skins = false;
    $dynamic_layouts = mw()->layouts_manager->get_all('no_cache=1&get_dynamic_layouts=1');
    $module_layouts_skins = mw()->module_manager->templates('layouts');

    if ($hide_dynamic_layouts) {
        $dynamic_layouts = false;
        $module_layouts_skins = false;
    }


    // $module_layouts_skins_def = mw()->module_manager->templates('layouts',false, false, 'module_dir');
    //$module_layouts_skins_def = mw()->module_manager->templates('layouts',false, false, 'dream');
    //var_dump($module_layouts_skins_def);
    //    if(is_array($module_layouts_skins) and is_arr($module_layouts_skins_def) and ($module_layouts_skins != $module_layouts_skins_def)){
    //        $module_layouts_skins = array_merge($module_layouts_skins,$module_layouts_skins_def);
    //    }
} else {
    $modules = mw()->module_manager->get('installed=1&ui=1');
    $module_layouts = mw()->module_manager->get('installed=1&module=layouts');
    $hide_from_display_list = array('layouts', 'template_settings');
    $sortout_el = array();
    $sortout_mod = array();
    if (!empty($modules)) {
        foreach ($modules as $mod) {
            if (isset($mod['as_element']) and intval($mod['as_element']) == 1) {
                $sortout_el[] = $mod;
            } else {
                $sortout_mod[] = $mod;
            }
        }
        $modules = array_merge($sortout_el, $sortout_mod);
        if ($modules and !empty($module_layouts)) {
            $modules = array_merge($modules, $module_layouts);
        }
    }

    $modules_from_template = mw()->module_manager->get_modules_from_current_site_template();
    if (!empty($modules_from_template)) {
        if (!is_array($modules)) {
            $modules = array();
        }
        foreach ($modules as $module) {
            foreach ($modules_from_template as $k => $module_from_template) {
                if (isset($module['name']) and isset($module_from_template['name'])) {
                    if ($module['name'] == $module_from_template['name']) {
                        unset($modules_from_template[$k]);
                    }
                }
            }
        }
        $modules = array_merge($modules, $modules_from_template);
    }

    $is_shop_disabled = get_option('shop_disabled', 'website') == "y";

    if ($modules) {
        foreach ($modules as $mkey => $module) {
            if (!isset($module['categories']) or !($module['categories'])) {
                $module['categories'] = 'other';
            }
            if (isset($module['categories']) and ($module['categories'])) {
                $mod_cats = explode(',', $module['categories']);

                if ($mod_cats) {
                    $skip_m = false;
                    if ($is_shop_disabled and in_array('online shop', $mod_cats)) {
                        $skip_m = true;
                    }

                    if (!$skip_m) {
                        foreach ($mod_cats as $mod_cat) {
                            $mod_cat = trim($mod_cat);
                            if (!isset($modules_by_categories[$mod_cat])) {
                                $modules_by_categories[$mod_cat] = array();
                            }
                            $modules_by_categories[$mod_cat][] = $module;
                        }
                    } else {
                        unset($modules[$mkey]);
                    }
                }
            }
        }
    }
}


if ($modules_by_categories and is_arr($modules_by_categories) and count($modules_by_categories) > 1) {
    $sort_first = array();

    $first_keys = array('recommended', 'media', 'content', 'navigation');
    foreach ($first_keys as $first_key) {
        if (isset($modules_by_categories[$first_key])) {
            $sort_first[$first_key] = $modules_by_categories[$first_key];
            unset($modules_by_categories[$first_key]);
        }
    }
    $modules_by_categories_new = array_merge($sort_first, $modules_by_categories);
    $modules_by_categories = $modules_by_categories_new;
}


if (($modules and !$modules_by_categories) or ($modules and !$show_grouped_by_cats)) {
    $modules_by_categories = array('Modules' => $modules);
}


if (isset($_COOKIE['recommend']) and is_string($_COOKIE['recommend']) and isset($modules) and is_array($modules)) {
    $recommended = json_decode($_COOKIE['recommend'], true);

    if (is_array($recommended) and !empty($recommended)) {
        $position = 9;
        $sorted_modules = array();
        arsort($recommended);
        foreach ($recommended as $key => $value) {
            foreach ($modules as $mod_key => $item) {
                if (isset($item['module']) and isset($item['position']) and $item['position'] > $position) {
                    if ($key == $item['module']) {
                        $sorted_modules[] = $item;
                    }
                }
            }
        }

        if (!empty($sorted_modules)) {
            //arsort( $sorted_modules);
            if (!empty($modules)) {
                $re_sorted_modules = array();
                $temp = array();
                $modules_copy = $modules;
                foreach ($modules_copy as $key => $item) {
                    if (is_array($sorted_modules) and !empty($sorted_modules)) {
                        foreach ($sorted_modules as $key2 => $sorted_module) {
                            if ($sorted_module['module'] == $item['module']) {
                                unset($modules_copy[$key]);
                            }
                        }
                    }
                }
                foreach ($modules_copy as $key => $item) {
                    $re_sorted_modules[] = $item;

                    if (!isset($item['position'])) {
                        $item['position'] = 999;
                    }

                    if ($item['position'] > $position) {
                        if (is_array($sorted_modules) and !empty($sorted_modules)) {
                            foreach ($sorted_modules as $key2 => $sorted_module) {
                                $re_sorted_modules[] = $sorted_module;
                                unset($sorted_modules[$key2]);
                            }
                        }
                    }
                }
                if (!empty($re_sorted_modules)) {
                    $modules = $re_sorted_modules;
                }
            }
        }
    }
}


?> <?php if (!isset($params['clean'])) { ?>
    <script type="text/javascript">
        Modules_List_<?php print $mod_obj_str ?> = {}
        mw.live_edit.registry = mw.live_edit.registry || {}
    </script>

<?php } ?>

<ul class="modules-list list-<?php print $mod_obj_str ?>" ocr="off">
    <?php
    $def_icon = modules_path() . 'default.jpg';
    $def_icon = mw()->url_manager->link_to_file($def_icon);


    ?>



    <script>
        $(document).ready(function() {
            $('.mw_module_image img').each(function(index) {
                var img = $(this).data('src');
                $(this).attr('src', img);
            });
        });
    </script>


    <?php

    if (isset($module_layouts_skins) and is_array($module_layouts_skins)) : ?>
        <?php


        $i = 0; ?>

        <?php


        foreach ($module_layouts_skins as $dynamic_layout) :
        if($dynamic_layout['name'] == 'Faq Heading Deafult'){
            continue;
        }?>
            <?php
            $des = isset($dynamic_layout['description']) ? $dynamic_layout['description'] : '';
            if (isset($dynamic_layout['layout_file']) && $des == 'optinform') : ?>
                <li data-module-name="layouts" ondrop="true" template="<?php print $dynamic_layout['layout_file'] ?>" data-filter="<?php print $dynamic_layout['name'] ?>" class="<?php if ($dynamic_layout['name'] == "Contact Form") { ?> hide-li <?php } ?> module-item module-item-layout" unselectable="on">
                    <span class="mw_module_hold">
                        <?php
                        $layout_file = explode("skin-", $dynamic_layout['layout_file']);
                        $layout_file = end($layout_file);
                        $layout_file = explode('.', $layout_file);
                        $template_id = $layout_file[0];

                        if (!isset($dynamic_layout['screenshot'])) : ?>
                            <?php $dynamic_layout['screenshot'] = $def_icon; ?>
                        <?php endif; ?>

                        <a href="https://drm.software/admin/login?redirect_url=<?php echo site_url('webhook_for_optin_form')  ?>&is_default=false&template_id=<?php echo $template_id ?>" class="optin-form-element" target="_blank">
                            <span class="mw_module_image">
                                <span class="mw_module_image_holder">
                                    <img alt="<?php print $dynamic_layout['name'] ?>" title="<?php isset($dynamic_layout['description']) ? print addslashes($dynamic_layout['description']) : print addslashes($dynamic_layout['name']); ?> [<?php print str_replace('.php', '', $dynamic_layout['layout_file']); ?>]" class="module_draggable" data-module-name-enc="layout_<?php print date("YmdHis") . $i++ ?>" data-module-name="layouts" ondrop="true" src="" data-src="<?php print thumbnail($dynamic_layout['screenshot'], 340, 340) ?>" />
                                </span>
                            </span>
                            <span class="module_name" alt="<?php isset($dynamic_layout['description']) ? print addslashes($dynamic_layout['description']) : ''; ?>"><?php print titlelize(_e($dynamic_layout['name'], true)); ?></span>
                        </a>
                    </span>
                </li>
            <?php endif; ?>

        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<style>
    .d-none {
        display: none !important;
    }
</style>
<script>
    $(document).ready(function() {
        // Module remove

        var matches = ["Shop Categories", "Categories", "Categories Images", "Pop-Up", "Posts List", "Checkout Bumbs", "Products", "Shopping Cart", "Add to cart",
            "Pages Menu", "Cancellation policy", "Shipping information", "Impressum", "Theme Market", "DRM All Categories", "Payment information", "Datenschutz ",
            "IT Recht Kanzlei", "Table", "Testimonials", "Tags", "Carousel Grid", "Pagination", "Content", "Agb",
            "Payment information ", "Cancellation policy ","Pricing Card","Sidebar Navigation"
        ];
        $('.list-modules').children('li').each(function() {
            var value = $(this).attr('data-filter');
            for (i = 0; i < matches.length; i++) {
                if (value == matches[i]) {
                    // console.log(matches[i]+'========='+value+';');
                    $(this).addClass('d-none');
                }
            }

        });

        // layout remove
        var matches_layoutData = ["Text under Image", "Features", "Simple Text", "Image Categories Text", "Image Categories Text",
            "Header Image text, newsletter, banners and categories.", "Header Image text, newsletter, banners and categories.",
            "Image, text, categories and banners."
        ];
        $('.modules-list.list-elements').children('li').each(function() {
            var layoutData_filter_value = $(this).attr('data-filter');
            for (j = 0; j < matches_layoutData.length; j++) {
                if (layoutData_filter_value == matches_layoutData[j]) {
                    $(this).addClass('d-none');
                }
            }
            // console.log(layoutData_filter_value);
        });
    });
</script>
