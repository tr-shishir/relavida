<?php

$config = array();
$config['name'] = "Emotion Sunshine";
$config['author'] = "Droptienda";
$config['version'] = "1.4.3";
$config['url'] = "#";
$config['standalone_module_skins'] = true;
$config['framework'] = "bootstrap4";
$config['optimized_template'] = "yes";
$config['optimized_blog_module'] = "yes";
$config['is_default'] = 0; //if you set this parameter the template will be selected on the install screen

//Stylesheet Settings / accept type="color" and type="text" and type="title" and type="delimiter"
$config['stylesheet_compiler']['source_file'] = 'assets/css/less/main.less';
$config['stylesheet_compiler']['css_file'] = 'assets/css/main.css';
$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');
$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Default colors');
// $config['stylesheet_compiler']['settings']['default'] = array('type' => 'color', 'default' => '#000000', 'label' => 'Default color');
$config['stylesheet_compiler']['settings']['primary'] = array('type' => 'color', 'default' => '#408bd1', 'label' => 'Primary color');


// Menu Options
// $config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Menu Options');
// $config['stylesheet_compiler']['settings']['menuFontColor'] = array('type' => 'color', 'default' => '#ffff', 'label' => 'Font Color');
// $config['stylesheet_compiler']['settings']['menuFontHoverColor'] = array('type' => 'color', 'default' => '#ffff', 'label' => 'Hover And Active Color');
// $config['stylesheet_compiler']['settings']['menuFontSize'] = array('type' => 'text', 'default' => '22px', 'label' => 'Font Size');


// Menu Options
$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Menu Options');
$config['stylesheet_compiler']['settings']['menuTextColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Font Color');
$config['stylesheet_compiler']['settings']['menuTextHoverColor'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Hover And Active Color');
$config['stylesheet_compiler']['settings']['menuTextSize'] = array('type' => 'text', 'default' => '14px', 'label' => 'Font Size');



$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Footer Menu Options');
$config['stylesheet_compiler']['settings']['footerMenuColor'] = array('type' => 'color', 'default' => '#666', 'label' => 'Footer Menu Color');
$config['stylesheet_compiler']['settings']['footerMenuHoverColor'] = array('type' => 'color', 'default' => '#232323', 'label' => 'Footer Menu Hover Color');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');
// Category
$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Category');
$config['stylesheet_compiler']['settings']['categoryBgColor'] = array('type' => 'color', 'default' => '#d5ecff', 'label' => 'Background Color');
$config['stylesheet_compiler']['settings']['categoryBgHoverColor'] = array('type' => 'color', 'default' => '#bde1ff', 'label' => 'Background Hover Color');
$config['stylesheet_compiler']['settings']['categoryTextColor'] = array('type' => 'color', 'default' => '#696969', 'label' => 'Text Color');
$config['stylesheet_compiler']['settings']['categoryTextHoverColor'] = array('type' => 'color', 'default' => '#696969', 'label' => 'Text Hover Color');

// Tax color
$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');
$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Others Color');
$config['stylesheet_compiler']['settings']['taxTextColor'] = array('type' => 'color', 'default' => '#000', 'label' => 'Tax Text Color');
$config['stylesheet_compiler']['settings']['settingsHeaderBg'] = array('type' => 'color', 'default' => '#4592ff', 'label' => 'Settings Module Header BG');
$config['stylesheet_compiler']['settings']['offCanvasMenuLeftBg'] = array('type' => 'color', 'default' => '#000000', 'label' => 'Off canvas menu left background');
$config['stylesheet_compiler']['settings']['offCanvasMenuRightBg'] = array('type' => 'color', 'default' => '#111111', 'label' => 'Off canvas menu right background');


$config['stylesheet_compiler']['settings']['allFontColor'] = array('type' => 'color', 'default' => ' ', 'label' => 'Font color for everything except product text');
$config['stylesheet_compiler']['settings']['productTextFontColor'] = array('type' => 'color', 'default' => ' ', 'label' => 'Font color for Product texts');
$config['stylesheet_compiler']['settings']['nexPrevtipbgColor'] = array('type' => 'color', 'default' => '#000', 'label' => 'Product Next Prev Tooltip Background');



$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Search Box colors');
$config['stylesheet_compiler']['settings']['searchBoxColor'] = array('type' => 'color', 'default' => '#c0c0c0', 'label' => 'Search Box Color');

$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Pricing Table Colors');
$config['stylesheet_compiler']['settings']['pricingtableHoverBgColor'] = array('type' => 'color', 'default' => '#f0f1f2', 'label' => 'Row Hover Color');
$config['stylesheet_compiler']['settings']['pricingtableHeadingTd'] = array('type' => 'color', 'default' => '#e2e2e2', 'label' => 'Heading Row Background');
$config['stylesheet_compiler']['settings']['pricingtableHeadingTdColor'] = array('type' => 'color', 'default' => '#6b7177', 'label' => 'Heading Row Text Color');
$config['stylesheet_compiler']['settings']['pricingtableTd'] = array('type' => 'color', 'default' => '#fff', 'label' => 'Row Background');
$config['stylesheet_compiler']['settings']['pricingtableTdColor'] = array('type' => 'color', 'default' => '#212529', 'label' => 'Row Text Color');


$config['stylesheet_compiler']['settings'][] = array('type' => 'delimiter');

$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Breadcumb colors');
$config['stylesheet_compiler']['settings']['breadcumbHyperlinkColor'] = array('type' => 'color', 'default' => '#007bff', 'label' => 'Breadcumb Hyperlink Color');
$config['stylesheet_compiler']['settings']['breadcumbTextColor'] = array('type' => 'color', 'default' => '#6c757d', 'label' => 'Breadcumb Text Color');
// Image Opacity
$config['stylesheet_compiler']['settings'][] = array('type' => 'title', 'label' => 'Image Opacity');
$config['stylesheet_compiler']['settings']['blogImgOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Blog Image');
$config['stylesheet_compiler']['settings']['blogInnerImgOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Blog Inner Image');
$config['stylesheet_compiler']['settings']['productImgOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Product Image');
$config['stylesheet_compiler']['settings']['productInnerImageOpacity'] = array('type' => 'sliderRange', 'default' => '99', 'label' => 'Product Inner Image');





//Stylesheet Settings / accept type="dropdown" and type="text" and type="title" and type="delimiter"
$config['template_settings'][] = array('type' => 'title', 'label' => 'Header Options');

$config['template_settings']['sticky_navigation'] = array('type' => 'dropdown', 'default' => 'sticky-nav', 'label' => 'Sticky Sidebar');
$config['template_settings']['sticky_navigation']['options'] = array('sticky-nav' => 'Yes', '' => 'No');

$config['template_settings']['header_style'] = array('type' => 'dropdown', 'default' => 'header-inverse', 'label' => 'Header Style');
$config['template_settings']['header_style']['options'] = array('header-inverse' => 'Black');

$config['template_settings']['shopping_cart'] = array('type' => 'dropdown', 'default' => 'true', 'label' => 'Show shopping cart in header');
$config['template_settings']['shopping_cart']['options'] = array('true' => 'Yes', 'false' => 'No');

$config['template_settings']['profile_link'] = array('type' => 'dropdown', 'default' => 'false', 'label' => 'Show Profile link in header');
$config['template_settings']['profile_link']['options'] = array('false' => 'No');

//$config['template_settings']['preloader'] = array('type' => 'dropdown', 'default' => 'true', 'label' => 'Turn on preloader');
//$config['template_settings']['preloader']['options'] = array('true' => 'Yes', 'false' => 'No');

//$config['template_settings'][] = array('type' => 'delimiter');

//$config['template_settings'][] = array('type' => 'title', 'label' => 'Footer Options');

$config['template_settings']['footer'] = array('type' => 'dropdown', 'default' => 'true', 'label' => 'Turn on Footer for the website', 'help' => 'You can hide the footer from your website');
$config['template_settings']['footer']['options'] = array('true' => 'Yes', 'false' => 'No');


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
