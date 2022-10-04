<?php
$config = array();
$config['name'] = "A la carte";
$config['author'] = "Droptienda";
$config['version'] = "2.2";
$config['url'] = "http://droptienda.com";
$config['standalone_module_skins'] = true;
$config['framework'] = "bootstrap4";
$config['optimized_template'] = "yes";
$config['optimized_blog_module'] = "yes";

$config['is_default'] = 0; //if you set this parameter the template will be selected on the install screen

//Stylesheet Settings / accept type="color" and type="text" and type="title" and type="delimiter"
$config['stylesheet_compiler']['source_file'] = 'assets/css/less/main.less';
$config['stylesheet_compiler']['css_file'] = 'assets/css/main.css';


$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Default colors');
$config['stylesheet_compiler']['settings']['primaryColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Primary color');
// $config['stylesheet_compiler']['settings']['secondaryColor'] = array('type' => 'color', 'default' => '#202020', 'label' => 'Secondary color');

// Menu Options
$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Menu Options');
$config['stylesheet_compiler']['settings']['menuFontColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Font Color');
$config['stylesheet_compiler']['settings']['menuFontHoverColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Hover And Active Color');


$config['stylesheet_compiler']['settings']['submenuContainerBackground'] = array('type' => 'color', 'default' => '#a9a6a6', 'label' => 'Submenu Background');
$config['stylesheet_compiler']['settings']['submenuColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Submenu Color');
$config['stylesheet_compiler']['settings']['submenuHoverColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Submenu Hover Color');
$config['stylesheet_compiler']['settings']['submenuHoverBgColor'] = array('type' => 'color', 'default' => '#a9a6a6', 'label' => 'Submenu Hover BG Color');
$config['stylesheet_compiler']['settings']['menuFontSize'] = array('type' => 'text', 'default' => '16px', 'label' => 'Font Size');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Footer Menu Options');
$config['stylesheet_compiler']['settings']['footerMenuColor'] = array('type' => 'color', 'default' => '#f5f5f5', 'label' => 'Footer Menu Color');
$config['stylesheet_compiler']['settings']['footerMenuHoverColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Footer Menu Hover Color');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');


// Category
$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Category');
$config['stylesheet_compiler']['settings']['categoryBgColor'] = array('type' => 'color', 'default' => '#f5f5f5', 'label' => 'Background Color');
$config['stylesheet_compiler']['settings']['categoryTextColor'] = array('type' => 'color', 'default' => '#222', 'label' => 'Text Color');
$config['stylesheet_compiler']['settings']['categoryBgHoverColor'] = array('type' => 'color', 'default' => '#d6d6d6', 'label' => 'Background Hover Color');
$config['stylesheet_compiler']['settings']['categoryTextHoverColor'] = array('type' => 'color', 'default' => '#222', 'label' => 'Text Hover Color');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');
//Stylesheet Settings / accept type="dropdown" and type="text" and type="title" and type="delimiter"

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Search Box colors');
$config['stylesheet_compiler']['settings']['searchBoxBg'] = array('type' => 'color', 'default' => '#a9a6a6', 'label' => 'Search Box Background');
$config['stylesheet_compiler']['settings']['searchInputFieldBg'] = array('type' => 'color', 'default' => '#555', 'label' => 'Search Input Field Background');
$config['stylesheet_compiler']['settings']['searchInputFieldColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Search Input Field Color');
$config['stylesheet_compiler']['settings']['searchButtonBg'] = array('type' => 'color', 'default' => '#000', 'label' => 'Search Button Background');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');


$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Pricing Table Colors');
$config['stylesheet_compiler']['settings']['pricingCardBg'] = array('type' => 'color', 'default' => '#007bff', 'label' => 'Pricing Active Card Background');
$config['stylesheet_compiler']['settings']['pricingtableHoverBgColor'] = array('type' => 'color', 'default' => '#f0f1f2', 'label' => 'Row Hover Color');
$config['stylesheet_compiler']['settings']['pricingtableHeadingTd'] = array('type' => 'color', 'default' => '#e2e2e2', 'label' => 'Heading Row Background');
$config['stylesheet_compiler']['settings']['pricingtableHeadingTdColor'] = array('type' => 'color', 'default' => '#6b7177', 'label' => 'Heading Row Text Color');
$config['stylesheet_compiler']['settings']['pricingtableTd'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Row Background');
$config['stylesheet_compiler']['settings']['pricingtableTdColor'] = array('type' => 'color', 'default' => '#212529', 'label' => 'Row Text Color');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');


$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Others Color');
$config['stylesheet_compiler']['settings']['taxTextColor'] = array('type' => 'color', 'default' => '#000', 'label' => 'Tax Text Color');
$config['stylesheet_compiler']['settings']['settingsHeaderBg'] = array('type' => 'color', 'default' => '#4592ff', 'label' => 'Settings Module Header BG');
$config['stylesheet_compiler']['settings']['nextContentColor'] = array('type' => 'color', 'default' => '#202020', 'label' => 'Prev,Next Content Color');

$config['stylesheet_compiler']['settings']['allFontColor'] = array('type' => 'color', 'default' => ' ', 'label' => 'Font color for everything except product text');
$config['stylesheet_compiler']['settings']['productTextFontColor'] = array('type' => 'color', 'default' => ' ', 'label' => 'Font color for Product texts');
$config['stylesheet_compiler']['settings']['nexPrevtipbgColor'] = array('type' => 'color', 'default' => '#000', 'label' => 'Product Next Prev Tooltip Background');
$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Image Opacity');
$config['stylesheet_compiler']['settings']['blogImgOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Blog Image');
$config['stylesheet_compiler']['settings']['blogInnerImgOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Blog Inner Image');
$config['stylesheet_compiler']['settings']['productImgOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Product Image');
$config['stylesheet_compiler']['settings']['productInnerImageOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Product Inner Image');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Breadcumb colors');
$config['stylesheet_compiler']['settings']['breadcumbHyperlinkColor'] = array('type' => 'color', 'default' => '#007bff', 'label' => 'Breadcumb Hyperlink Color');
$config['stylesheet_compiler']['settings']['breadcumbTextColor'] = array('type' => 'color', 'default' => '#6c757d', 'label' => 'Breadcumb Text Color');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['template_settings'][] = array('type' => 'delimiter');




//Layouts Padding Top & Bottom classes definiton
$config['layouts_css_classes'] = [];
$config['layouts_css_classes']['padding-top']['none'] = 'p-t-0';
$config['layouts_css_classes']['padding-top'][1] = 'p-t-10';
$config['layouts_css_classes']['padding-top'][2] = 'p-t-20';
$config['layouts_css_classes']['padding-top'][3] = 'p-t-30';
$config['layouts_css_classes']['padding-top'][4] = 'p-t-40';
$config['layouts_css_classes']['padding-top'][5] = 'p-t-50';
$config['layouts_css_classes']['padding-top'][6] = 'p-t-60';
$config['layouts_css_classes']['padding-top'][7] = 'p-t-70';
$config['layouts_css_classes']['padding-top'][8] = 'p-t-80';
$config['layouts_css_classes']['padding-top'][9] = 'p-t-90';
$config['layouts_css_classes']['padding-top'][10] = 'p-t-100';
$config['layouts_css_classes']['padding-top'][15] = 'p-t-150';
$config['layouts_css_classes']['padding-top'][20] = 'p-t-200';

$config['layouts_css_classes']['padding-bottom']['none'] = 'p-b-0';
$config['layouts_css_classes']['padding-bottom'][1] = 'p-b-10';
$config['layouts_css_classes']['padding-bottom'][2] = 'p-b-20';
$config['layouts_css_classes']['padding-bottom'][3] = 'p-b-30';
$config['layouts_css_classes']['padding-bottom'][4] = 'p-b-40';
$config['layouts_css_classes']['padding-bottom'][5] = 'p-b-50';
$config['layouts_css_classes']['padding-bottom'][6] = 'p-b-60';
$config['layouts_css_classes']['padding-bottom'][7] = 'p-b-70';
$config['layouts_css_classes']['padding-bottom'][8] = 'p-b-80';
$config['layouts_css_classes']['padding-bottom'][9] = 'p-b-90';
$config['layouts_css_classes']['padding-bottom'][10] = 'p-b-100';
$config['layouts_css_classes']['padding-bottom'][15] = 'p-b-150';
$config['layouts_css_classes']['padding-bottom'][20] = 'p-b-200';
