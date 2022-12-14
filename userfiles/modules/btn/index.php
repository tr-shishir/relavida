<?php
$btn_id = 'btn-' . $params['id'];
$style = get_option('button_style', $params['id']);
$size = get_option('button_size', $params['id']);
$action = get_option('button_action', $params['id']);
$action_content = get_option('popupcontent', $params['id']);
$url = get_option('url', $params['id']);
$blank = get_option('url_blank', $params['id']) == 'y';
$text = get_option('text', $params['id']);
if (get_option('icon', $params['id'])) {
    $icon = get_option('icon', $params['id']);
} elseif (isset($params['icon'])) {
    $icon = $params['icon'];
} else {
    $icon = '';
}

if (isset($params['button_id'])) {
    $btn_id = $params['button_id'];
}

$attributes = '';
if (isset($params['button_onclick'])) {
    $attributes .= 'onclick="'.$params['button_onclick'].'"';
}

if (isset($params['button_text']) && !empty($params['button_text']) && empty($text)) {
	$text = $params['button_text'];
}

$popup_function_id = 'btn_popup' . uniqid();
if ($text == false and isset($params['text'])) {
    $text = $params['text'];
} elseif ($text == '') {
    $text = lang('Button', 'templates/dream/modules/btn');
}
if($icon){
    $text = $icon . '&nbsp;' . $text;
}

if ($url == false and isset($params['url'])) {
    $url = $params['url'];
} elseif ($url == '') {
    $url = '#';
}



$link_to_content_by_id = 'content:';
$link_to_category_by_id = 'category:';


$url_display = false;
if (substr($url, 0, strlen($link_to_content_by_id)) === $link_to_content_by_id) {
    $link_to_content_by_id = substr($url, strlen($link_to_content_by_id));
    if ($link_to_content_by_id) {
        $url_display = content_link($link_to_content_by_id);
    }
} else if (substr($url, 0, strlen($link_to_category_by_id)) === $link_to_category_by_id) {
    $link_to_category_by_id = substr($url, strlen($link_to_category_by_id));

    if ($link_to_category_by_id) {
        $url_display = category_link($link_to_category_by_id);
    }
}

if($url_display){
    $url = $url_display;
}




if ($style == false and isset($params['button_style'])) {
    $style = $params['button_style'];
}
if ($style == '') {
    $style = 'btn-default';
}

if ($action == false and isset($params['button_action'])) {
    $action = $params['button_action'];
}

if ($size == false and isset($params['button_size'])) {
    $size = $params['button_size'];
}


if ($action == 'popup') {
    $url = 'javascript:' . $popup_function_id . '()';
}





?>


<?php

$module_template = get_option('data-template', $params['id']);
if ($module_template == false and isset($params['template'])) {
    $module_template = $params['template'];
}
if ($module_template != false) {
    $template_file = module_templates($config['module'], $module_template);
} else {
    $template_file = module_templates($config['module'], 'default');
}


if (is_file($template_file) != false) {
    include($template_file);
} else {
    print lnotif("No template found. Please choose template.");
}
?>

<?php if ($action == 'popup') { ?>

    <div id="area<?php print $btn_id; ?>" style="display:none;">
        <?php print html_entity_decode($action_content); ?>
    </div>

    <script>
        function <?php print $popup_function_id ?>() {
            mw.dialog({
                name: 'frame<?php print $btn_id; ?>',
                content: $(mwd.getElementById('area<?php print $btn_id; ?>')).html(),
                template: 'basic',
                title: "<?php print addslashes ($text); ?>"
            });
        }
    </script>
<?php } ?>
