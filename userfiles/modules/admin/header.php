<!DOCTYPE html>
<html <?php print lang_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex">
    <script type="text/javascript">
        if (!window.CanvasRenderingContext2D) {
            var h = "<div id='UnsupportedBrowserMSG'><h1><?php _e("Your a need better browser to run Droptienda>"); ?></h1></div>"
                + "<div id='download_browsers_holder'><h2><?php _e("Update your browser"); ?></h2><p id='choose_browsers'>"
                + "<a id='u__ie' target='_blank' href='http://windows.microsoft.com/en-us/internet-explorer/download-ie'></a>"
                + "<a id='u__ff' target='_blank' href='http://www.mozilla.org/en-US/firefox/new/'></a>"
                + "<a id='u__chr' target='_blank' href='https://www.google.com/intl/en/chrome/'></a>"
                + "<a id='u__sf' target='_blank' href='http://support.apple.com/kb/DL1531'></a>"
                + "</p></div>";
            document.write(h);
            document.body.id = 'UnsupportedBrowser';
            document.body.className = 'UnsupportedBrowser';
        }
        mwAdmin = true;
        admin_url = '<?php print admin_url(); ?>';
    </script>
    <style>
        .heading-style-one .js-hide-when-no-items {
            display: flex;
        }
        .product-details-admin .form-inline{
            flex-wrap:nowrap;
        }
        .main.container{
            max-width:80%;
        }
        @media screen and (max-width: 1600px){
            .main.container {
                max-width: 95%;
            }
        }
        @media screen and (max-width: 1300px){
        .heading-style-one{
            flex-direction:column;
        }
        .av-product{
            margin:10px 0 !important;
        }
        }
        @media screen and (max-width: 767px){
            .product-details-admin{
                flex-direction:column;
            }
            .product-details-admin .js-search-by{
                margin-top:10px;
            }
        }

    .manage-toobar #cartsnav a.active {
        color: #074A74 !important;
        font-weight: bold;
    }
    .mw-ui-btn-info{
        background-color: #074A74;
        border-color: #074A74;
    }
    .mw-ui-link{
        color: #074A74;
    }
    .mw-file-drop-zone{
        border: 2px dashed #074A74;
    }
    #stats_nav .btn-outline-secondary.active{
        background-color: #e1f1fd;
        border-color: #074A74;
    }
    .module-icon-svg-fill{
        color: #074A74;
    }
    .mw-order-item-id a{
        color: #074A74;
    }
    .mw-order-item-id a:hover{
        color: #074A74;
    }
    .form-control:focus{
        border-color: #074A74;
    }
    .module-help-modal-with-button a{
        color: #074A74;
    }
    .bg-primary{
        background-color: #074A74 !important;
    }
    .custom-control-input:checked~.custom-control-label::before{
        background-color: #074A74;
        border-color: #074A74;
    }
    .dropable-zone:hover{
        border-color: #074A74;
    }
    .btn-link{
        color: #074A74;
    }
    .btn-link:hover{
        color: #074A74;
    }
    .page-link{
        color: #074A74;
    }
    .page-link:hover{
        color: #074A74;
    }
    .page-item.active .page-link{
        background-color: #074A74;
        border-color: #074A74;
    }
    .btn-primary{
        background-color: #074A74;
        border-color: #074A74;
    }
    .btn-primary:hover{
        background-color: #074A74;
        border-color: #074A74;
    }
    .btn-outline-primary {
        color: #074A74;
        border-color: #074A74;
    }
    .btn-outline-primary:hover{
        background-color: #074A74;
        border-color: #074A74;
        color: #fff;
    }
    .main aside>ul>li.nav-item.dropdown-no-js.show, .main aside>ul>li.nav-item.dropdown.show{
        background: transparent !important;
        border:0 !important;
    }

    .main aside>ul>li.nav-item.dropdown-no-js.show>a>i, .main aside>ul>li.nav-item.dropdown.show>a>i{
        color: #bcbfc2 !important;
    }
    .main aside>ul .dropdown .dropdown-toggle.active::after, .main aside>ul .dropdown-no-js .dropdown-toggle.active::after{
        background: #074A74 !important;
    }
    .main aside>ul>li.nav-item .dropdown-menu .dropdown-item.active{
        border-left: 5px solid #074A74 !important;
    }
    .main aside>ul>li.nav-item>a.active>i {
        color: #074A74 !important;
    }
    .main aside>ul>li.nav-item>a.active{
        border-left: 5px solid #074A74;
    }
    .text-primary{
        color: #074A74 !important;
    }
    .page-settings .select-settings a:hover .icon-holder{
        background-color: transparent !important;
    }
    .main aside>ul>li.nav-item>a:hover>i{
        color: #074A74 !important;
    }
    .is_admin{
        position: relative;
    }
    .main aside{
        width: 230px;
        height: 100%;
        color: white;
        z-index: 100;
    }
    .admin-sidebar-logo img{
        width: 65%;
        height: 100%;
        object-fit: contain;
    }
    #myModal .modal-content .drm-login-image {
        width: 100%;
        height: 300px;
    }

    .drm-login-image {
        position: relative;
    }

    .image-heading {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    #myModal {
        position: absolute !important;
        overflow: visible !important;
        background: rgba(0, 0, 0, 0.5);
    }
    #drm {
            position: absolute !important;
            overflow: visible !important;
            background: rgba(0, 0, 0, 0.5);
        }

    #myModal .modal-header{
        border-bottom: 0px !important;
    }

    #drm .drm-header {
            border-bottom: 0px !important;
        }
    #myModal .modal-content .checkbox {
        margin-bottom: 10px;
    }

    #myModal .modal-content .checkbox input {
        color: #fff !important;
    }

    #myModal .modal-content .checkbox label input {
        margin-right: 10px;
    }

    #myModal .modal-content .mw-ui-label {}

    #myModal .modal-content::after {
        position: absolute;
        content: "";
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: #000;
        opacity: 0.5;
        z-index: -1;
    }

    .admin_login-btn {
        position: relative;
        display: flex;
        justify-content:center;
        margin-bottom: 10px;
    }

    p#false_txt {
        color: #ff5f5f;
    }

    .tooltiptext {
        visibility: hidden;
        width: 300px;
        background-color: #696969;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: -6px;
        left: 106%;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltiptext::after {
        content: "";
        position: absolute;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
        top: 42%;
        left: -10px;
        transform: rotate(455deg);
    }

    .admin_login-btn:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    .or {
        line-height: 1;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .or span {
        display: inline-block;
        position: relative;
        font-weight: bold;
    }

    .or span:before,
    .or span:after {
        content: "";
        position: absolute;
        height: 13px;
        border-bottom: 1px solid #c3c3c3;
        top: -4px;
        width: 600px;
    }

    .or span:before {
        right: 100%;
        margin-right: 15px;
    }

    .or span:after {
        left: 100%;
        margin-left: 15px;
    }

    .act {
        position: relative;
        margin: 25px 0 20px 0;
        text-align: center;
    }

    .act span {
        font-size: 20px;
        font-weight: bold;
    }
    .btn-custom{
        background-color: #000;
        color: #FCE511;
    }
    .btn-custom:hover{
        color: #FCE511;
    }
    #afterReg .modal-dialog{
        margin-top:100px !important;
    }
    #afterReg {
        background: rgba(0, 0, 0, 0.5);
    }

    @media screen and (max-width: 991px){
        .main .tree.opened {
            left: 225px;
        }
    }

    div#pageloader {
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }
    .pre_loader .logo
    {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pre_loader .logo img {
        max-height: 110px;
        margin-bottom: 10px;
    }
    .pre_loader .logo h2
    {
        font-weight: 900;
        margin: 0;
        font-size: 3rem;
        color: #0078d4;
    }
    .pre_loader .logo img
    {
        height: 5rem;
    }
    .pre_loader .progressbar
    {
        margin-top: 5px;
        height: 0.2rem;
        width: 10rem;
        background: #b3b3b3;
        margin: 0 auto !important;
    }
    .pre_loader .progressbar::after
    {
        content: "";
        width: 3rem;
        height: 0.2rem;
        background: #0078d4;
        display: block;
        border-radius: 0.5rem;
        animation: animation 1.5s cubic-bezier(0.65, 0.05, 0.36, 1) infinite;
    }
    .pre_loader p {
        margin-bottom: 10px;
    }
    .pre_loader h1
    {
        font-size: 1.5rem;
        color: #585858;
        position: absolute;
        bottom: 1rem;
        font-weight: 400;
    }

    @keyframes animation {
        0% {
            transform: translateX(0rem);
        }
        50% {
            transform: translateX(7rem);
        }
        100% {
            transform: translateX(0rem);
        }
    }


    #aftersuccessmodal .modal-dialog{
        max-width:300px !important;
        margin: 0.5rem !important;
        margin-left: 25% !important;
    }

    #aftersuccessmodal .modal-content{
        background-color: #3dc47e !important;
        border-color: #3dc47e;
    }

    #aftersuccessmodal .modal-body{

    }

    #aftersuccessmodal .modal-body p{
        color: #fff;
        font-weight: 600;
    }

    .feature-update{
        margin-left: 20px;
    }

    .globalUpdate-btn, .globalTempUpdate-btn{
        width: 200px !important;
        color: white !important;
        text-align: center !important;
        margin-top: 10px;
        font-size: 12px !important;
    }

    .page-settings .select-settings a .icon-holder{
        background:transparent !important;
    }

    .page-settings .select-settings a:hover .icon-holder i{
        color: #bcbfc2;
    }

    .page-settings .select-settings a .icon-holder img{
        height:30px !important;
        width:30px !important;
    }
    .mw-tree-context-menu-item .fa-trash{
        color:red !important;
    }


    /* Drag and Drop Menu Style */
    #shop-setting-sortable a.ui-sortable-handle,
    #website-setting-sortable a.dropdown-item.ui-sortable-handle {
        flex: 0 0 33.3333333333%;
        max-width: 33.3333333333%;
        color: #074A74 !important;
        font-weight: 700 !important;
        padding-top: 5px;
        position: relative;
        padding-left: 80px;
    }
    #shop-setting-sortable a.ui-sortable-handle:before, #website-setting-sortable a.dropdown-item.ui-sortable-handle:before {
        position: absolute;
        content: "\F0493";
        font: normal normal normal 24px/1 "Material Design Icons";
        font-size: 20px;
        left: 28px;
        color: #bcbfc2;
        top: 15px;
    }


    #shop-setting-sortable a.ui-sortable-handle span.btn.btn-success.btn-rounded.btn-icon.btn-sm.add-new,
    #website-setting-sortable a.dropdown-item.ui-sortable-handle span.btn.btn-success.btn-rounded.btn-icon.btn-sm.add-new {
        display: none;
    }


    #shop-menu-sortable {}

    #website-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle,
    #shop-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle {
        width: 100%;
        flex: 100%;
        max-width: 100%;
    }

    #website-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle .icon-holder,
    #shop-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle .icon-holder {
        display: none;
    }

    #website-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle .info-holder,
    #shop-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle .info-holder {
    }

    #website-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle span.text-primary.font-weight-bold,
    #shop-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle span.text-primary.font-weight-bold {
        color: #000 !important;
        font-weight: 100 !important;
        text-decoration: none !important;
    }

    #website-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle .info-holder small.text-muted,
    #shop-menu-sortable .col-12.col-sm-6.col-lg-4.ui-sortable-handle .info-holder small.text-muted {
        display: none;
    }
     /* Drag and Drop Menu Style End*/

     .mw-admin-post-slug{
         white-space: normal !important;
     }

     #posts-select-tags .mw-select-option span:last-child{
        white-space: break-spaces;
    }
    #posts-select-tags .mw-select .mw-select-options{
        left: auto !important;
        right:0 !important;
    }
    .main main {
        display: flex;
        flex-direction: column;
    }
    html {
        height: 100%;
    }
    body {
        min-height: 100%;
    }
    .copyright{
        flex: 1;
        align-content: flex-end;
    }
    .copyright p {
        margin-bottom: 8px;
    }
    .main{
        padding-bottom:10px;
    }
    .tooltip.show {
        opacity: 0.9;
        z-index: 9999;
    }

    .btn-primary:focus, .btn-primary:active {
        background-color: #074A74 !important;
        border-color: #074A74 !important;
    }


    .bootstrap-select.mw-edit-page-layout-selector .dropdown-menu li a span.text{
        white-space: normal;
    }
    .drm-card-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            min-height: 400px;

        }

        .drm-card-wrapper .card-top {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .drm-card-wrapper .card-top .icon {
            display: inline-block;
            margin-right: 10px;
        }

        .drm-card-wrapper .card-heading {
            font-size: 20px;
            font-weight: 700;
        }

        .drm-card-wrapper .card-links {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .drm-card-wrapper .card-links a {
            text-decoration: none;
            color: #000;
            color: skyblue;
            cursor: pointer;
            text-decoration: underline;
        }

        .drm-card-wrapper .card-links a:not(:last-child) {
            border-right: 1px solid skyblue;
            padding-right: 10px;
            margin-right: 10px;
        }

        .hideWhenClickChangeAC .modal-content {
            position: relative;
            margin-top: 200px;


        }

        .hideWhenClickChangeAC .c-close-btn {
            position: absolute;
            right: 10px;
            top: 0px;
            cursor: pointer;
        }
        .modal-backdrop {
            display: none;
        }
    </style>
    <script type="text/javascript">
        mw.lib.require('jqueryui');
        mw.require("<?php print mw_includes_url(); ?>api/libs/jquery_slimscroll/jquery.slimscroll.min.js");
        mw.require("liveadmin.js");
        mw.require("<?php print mw_includes_url(); ?>css/wysiwyg.css");
        mw.require("<?php print mw_includes_url(); ?>css/components.css");
        mw.require("wysiwyg.js");
        mw.require("url.js");
        mw.require("options.js");
        mw.require("events.js");
        mw.require("admin.js");
        mw.require("editor_externals.js");
        mw.require("keys.js");
        mw.require("css_parser.js");
        mw.require("custom_fields.js");
        mw.require("session.js");
        mw.require("content.js");
        mw.require("upgrades.js");
        mw.require("tree.js");

        mw.lib.require('mwui');
        mw.lib.require('mwui_init');
        mw.lib.require('flag_icons', true);
        mw.require("<?php print mw_includes_url(); ?>css/admin.css", true);

        <?php /*  mw.require("<?php print mw_includes_url(); ?>css/helpinfo.css");
        mw.require("helpinfo.js");*/ ?>
        <?php if(_lang_is_rtl()){ ?>
        mw.require("<?php print mw_includes_url(); ?>css/rtl.css");
        <?php } ?>
    </script>
    <?php if (!isset($_REQUEST['no_toolbar'])): ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.mw-lazy-load-module').reload_module();

                if (self === top) {
                    window.onhashchange = function () {
                        mw.cookie.set('back_to_admin', location.href);
                    }
                    mw.cookie.set('back_to_admin', location.href);
                }

                mw.$("#mw-quick-content,#mw_edit_pages_content,#mw-admin-content").click(function () {
                    if (mw.helpinfo != undefined) {
                        mw.cookie.set('helpinfo', false, 4380);
                        $(".helpinfo_helper").fadeOut();
                    }
                });
            });
            // mw.require("<?php print mw_includes_url(); ?>css/ui.css");
            mw.require("fonts.js");

            $(window).load(function () {
                if ($(".bootstrap3ns").size() > 0) {
                    mw.lib.require("bootstrap3ns");
                }
            });
        </script>
    <?php endif; ?>
    <?php event_trigger('admin_head'); ?>
</head>

<body class="is_admin loading view-<?php print mw()->url_manager->param('view'); ?> action-<?php print mw()->url_manager->param('action'); ?>">

<?php $new_version_notifications = mw()->notifications_manager->get('rel_type=update_check&rel_id=updates'); ?>

<?php
$past_page = site_url() . '?editmode=y';

$last_page_front = session_get('last_content_id');
if ($last_page_front == false) {
    if (isset($_COOKIE['last_page'])) {
        $last_page_front = $_COOKIE['last_page'];
    }
}

if ($last_page_front != false) {
    $cont_by_url = mw()->content_manager->get_by_id($last_page_front, true);
    if (isset($cont_by_url) and $cont_by_url == false) {
        $past_page = mw()->content_manager->get("order_by=updated_at asc&limit=1");
        $past_page = mw()->content_manager->link($past_page[0]['id']);
    } else {
        $past_page = mw()->content_manager->link($last_page_front);
    }
} else {
    $past_page = mw()->content_manager->get("order_by=updated_at asc&limit=1");
    if (isset($past_page[0])) {
        $past_page = mw()->content_manager->link($past_page[0]['id']);

    } else {
        $past_page = site_url();
    }
}

$shop_disabled = get_option('shop_disabled', 'website') == 'y';

if (!$shop_disabled) {
    if (!mw()->module_manager->is_installed('shop')) {
        $shop_disabled = true;
    }
}

if (!user_can_view_module(['module' => 'shop'])) {
    $shop_disabled = true;
}
?>

<script>

    $(document).ready(function () {
        $(".mw-admin-mobile-admin-sidebar-toggle").on('click', function () {
            $("#main-bar").toggleClass('mobile-active')
        })
        $("body").on('click', function (e) {
            if (!mw.tools.hasAnyOfClassesOnNodeOrParent(e.target, ['mw-admin-mobile-admin-sidebar-toggle'])) {
                $("#main-bar").removeClass('mobile-active')
            }

        })
    })


    function mw_admin_add_order_popup(ord_id) {

        if (!!ord_id) {
            var modalTitle = '<?php _e('Edit order'); ?>';
        } else {
            var modalTitle = '<?php _e('Add order'); ?>';
        }


        mw_admin_edit_order_item_popup_modal_opened = mw.dialog({
            content: '<div id="mw_admin_edit_order_item_module"></div>',
            title: modalTitle,
            id: 'mw_admin_edit_order_item_popup_modal',
            width: 900
        });

        var params = {}
        params.order_id = ord_id;
        mw.load_module('shop/orders/admin/add_order', '#mw_admin_edit_order_item_module', null, params);
    }

</script>


<?php
if (!is_logged()) {
    return;
}
?>

<?php
$order_notif_html = false;
$new_orders_count = mw()->order_manager->get_count_of_new_orders();
if ($new_orders_count) {
    $order_notif_html = '<span class="badge badge-success badge-pill mr-1 lh-0 d-inline-flex justify-content-center align-items-center" style="font-size: 11px; width: 20px; height:20px;">' . $new_orders_count . '</span>';
}

$comments_notif_html = false;
$new_comments_count = Auth::user()->unreadNotifications()->where('type', 'like', '%Comment%')->count();
if ($new_comments_count) {
    $comments_notif_html = '<span class="badge badge-success badge-pill mr-1 lh-0 d-inline-flex justify-content-center align-items-center" style="font-size: 11px; width: 20px; height:20px;">' . $new_comments_count . '</span>';
}

$notif_html = '';
$notif_count = Auth::user()->unreadNotifications()->count();
if ($notif_count > 0) {
    $notif_html = '<span class="badge badge-success badge-pill mr-1 lh-0 d-inline-flex justify-content-center align-items-center" style="font-size: 11px; width: 20px; height:20px;">' . $notif_count . '</span>';
}
?>

<?php
$user_id = user_id();
$user = get_user_by_id($user_id);
?>


<div id="mw-admin-container">
    <header class="position-sticky sticky-top bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-1">
                <ul class="nav">
                    <li class="mx-1 mobile-toggle">
                        <button type="button" class="js-toggle-mobile-nav"><i class="mdi mdi-menu"></i></button>
                    </li>

                    <li class="mx-1 logo d-none d-md-block">
                        <!-- <a href="<?php print admin_url('view:dashboard'); ?>">
                            <h5 class="text-white mr-3 d-flex align-items-center h-100">
                                <?php if (mw()->ui->admin_logo != false): ?>
                                    <img src="<?php print mw()->ui->admin_logo ?>" class="logo svg" style="height: 40px;"/>
                                <?php elseif (mw()->ui->admin_logo_login() != false): ?>
                                    <img src="<?php print modules_url(); ?>microweber/images/admin-logo.png" class="logo svg" style="height: 40px;"/>
                                <?php else: ?>
                                    <img src="<?php print modules_url(); ?>microweber/api/libs/mw-ui/assets/img/logo.svg" class="logo svg" style="height: 40px;"/>
                                <?php endif; ?>
                            </h5>
                            <script>mw.lib.require('mwui_init')</script>
                            <script>SVGtoCode();</script>
                        </a> -->
                    </li>

                    <?php
                    if (user_can_access('module.content.edit')):
                        ?>
                        <li class="mx-1 d-none d-md-block">
                            <button type="button" class="btn btn-rounded btn-sm-only-icon" style="background-color:#FAE112;" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-plus"></i> <span class="d-none d-md-block"><?php _e("Add New"); ?></span>
                            </button>


                            <div class="dropdown-menu ">
                                <?php $custom_view = url_param('view'); ?>
                                <?php $custom_action = url_param('action'); ?>
                                <?php event_trigger('content.create.menu'); ?>
                                <?php $create_content_menu = mw()->module_manager->ui('content.create.menu'); ?>
                                <?php if (!empty($create_content_menu)): ?>
                                    <?php foreach ($create_content_menu as $type => $item): ?>
                                        <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
                                        <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
                                        <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
                                        <?php $type = (isset($item['content_type'])) ? ($item['content_type']) : false; ?>
                                        <?php $subtype = (isset($item['subtype'])) ? ($item['subtype']) : false; ?>
                                        <?php $base_url = (isset($item['base_url'])) ? ($item['base_url']) : false; ?>
                                        <?php
                                        if ($base_url == false) {
                                            $base_url = admin_url('view:content');
                                            if ($custom_action != false) {
                                                if ($custom_action == 'pages' or $custom_action == 'posts' or $custom_action == 'products') {
                                                    $base_url = $base_url . '/action:' . $custom_action;
                                                }
                                            }
                                        }
                                        ?>
                                        <a class="dropdown-item" href="<?php print $base_url; ?>#action=new:<?php print $type; ?><?php if ($subtype != false): ?>.<?php print $subtype; ?><?php endif; ?>"><span class="<?php print $class; ?>"></span> <?php print $title; ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endif; ?>

                </ul>


                <!-- <ul class="nav"> -->
                <!--                    <li class="mx-1 logo d-block d-md-none">-->
                <!--                        <a class="mw-admin-logo" href="--><?php //print admin_url('view:dashboard'); ?><!--">-->
                <!--                            <h5 class="text-white mr-md-3">-->
                <!--                                --><?php //if (mw()->ui->logo_live_edit != false): ?>
                <!--                                    <img src="--><?php //print mw()->ui->logo_live_edit; ?><!--" style="height: 40px;"/>-->
                <!--                                --><?php //elseif (mw()->ui->admin_logo_login() != false): ?>
                <!--                                    <img src="--><?php //print mw()->ui->admin_logo_login(); ?><!--" style="height: 40px;"/>-->
                <!--                                --><?php //else: ?>
                <!--                                    <img src="--><?php //print modules_url(); ?><!--microweber/api/libs/mw-ui/assets/img/logo-mobile.svg" style="height: 40px;"/>-->
                <!--                                --><?php //endif; ?>
                <!--                            </h5>-->
                <!--                        </a>-->
                <!--                    </li>-->

                <!-- <?php if ($new_orders_count != ''): ?>
                        <li class="mx-2">
                            <a href="<?php print admin_url(); ?>view:shop/action:orders" class="btn btn-link btn-rounded icon-left text-dark px-0">
                                <?php print $order_notif_html; ?>
                                <i class="mdi mdi-shopping text-muted m-0"></i>
                                <span class="d-none d-md-block">
                                    <?php if ($new_orders_count == 1): ?>
                                        <?php _e("New order"); ?>
                                    <?php elseif ($new_orders_count > 1): ?>
                                        <?php _e("New orders"); ?>
                                    <?php endif; ?>
                                </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="mx-2">
                        <a href="<?php print admin_url(); ?>view:modules/load_module:comments" class="btn btn-link btn-rounded icon-left text-dark px-0">
                            <?php print $comments_notif_html; ?>&nbsp;
                            <i class="mdi mdi-comment-account text-muted m-0"></i>
                            <span class="d-none d-md-block">
                                <?php if ($new_comments_count == 1): ?>
                                    <?php _e("New comment"); ?>
                                <?php elseif ($new_comments_count > 1): ?>
                                    <?php _e("New comments"); ?>
                                <?php else: ?>
                                    <?php _e("Comments"); ?>
                                <?php endif; ?>
                            </span>
                        </a>
                    </li>

                    <li class="mx-2">
                        <a href="<?php echo route('admin.notification.index'); ?>" class="btn btn-link btn-rounded icon-left text-dark px-0">
                            <?php print $notif_html; ?>
                            <i class="mdi mdi-newspaper-variant-multiple text-muted m-0"></i>
                            <span class="notif-label">
                                <?php if ($notif_count == 1): ?>
                                    <?php _e("New notification"); ?>
                                <?php elseif ($notif_count > 1): ?>
                                    <?php _e("New notifications"); ?>
                                <?php else: ?>
                                    <?php _e("Notifications"); ?>
                                <?php endif; ?>
                            </span>
                        </a>
                    </li> -->
                <!-- </ul> -->

                <?php event_trigger('mw.admin.header.toolbar'); ?>

                <ul class="nav">
                    <?php if (user_can_access('module.content.edit')): ?>
                        <?php $vacation_mode_check = get_option('vacation_mode', 'website') ?? 'no';
                        if($vacation_mode_check == 'yes'):?>
                        <li class="mx-1">
                            <a href="<?php echo site_url('vacation?editmode=y'); ?>" class="btn btn-rounded btn-sm-only-icon go-live-edit-href-set" style="background-color:#074A74;color:#fff;" target="_blank">
                                <i class="mdi mdi-eye-outline"></i><span class="d-none d-md-block ml-1"><?php _e("Vacation active"); ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="mx-1">
                            <a href="<?php print $past_page ?>?editmode=n" class="btn btn-outline-success btn-rounded btn-sm-only-icon go-live-edit-href-set" target="_blank">
                                <i class="mdi mdi-earth"></i><span class="d-none d-md-block ml-1"><?php _e("View"); ?></span>
                            </a>
                        </li>
                        <li class="mx-1">
                            <a href="<?php print $past_page ?>?editmode=y" class="btn btn-rounded btn-sm-only-icon go-live-edit-href-set" style="background-color:#074A74;color:#fff;" target="_blank">
                                <i class="mdi mdi-eye-outline"></i><span class="d-none d-md-block ml-1"><?php _e("Live Edit"); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="mx-1">
                        <a href="<?php print api_url('logout'); ?>" class="btn btn-rounded btn-sm-only-icon btn-outline-danger">
                            <i class="mdi mdi-power"></i> <?php _e("Log out"); ?>
                        </a>
                    </li>
                    <?php event_trigger('mw.admin.header.toolbar.ul'); ?>
                </ul>
            </div>
        </div>
    </header>
    <?php if (url_param('view')): ?>
        <script>
            $(document).ready(function () {
                if ($('body').find('.main-toolbar').length == 0) {
                    $('main').prepend('<div id="info-toolbar" type="admin/modules/info" history_back="true"></div>');
                    mw.reload_module('#info-toolbar');
                }
            })
        </script>
    <?php endif; ?>

    <div class="main container my-3">
        <aside>
            <?php $view = url_param('view'); ?>
            <?php $action = url_param('action'); ?>
            <?php $load_module = url_param('load_module'); ?>

            <?php if (empty($view)) {
                $view = Request::segment(2);
            }
            ?>

            <?php
            $website_class = '';
            if ($view == 'content' and $action == false) {
                $website_class = 'active';
            } else if ($view == 'content' and $action != false) {
                $website_class = 'active';
            }

            $shop_class = '';
            if ($view == 'shop' and $action == false) {
                $shop_class = "active";
            } elseif ($view == 'shop' and $action != false) {
                $shop_class = "active";
            } elseif ($view == 'modules' and $load_module == 'shop__coupons') {
                $shop_class = "active";
            } elseif ($view == 'shop' AND $action == 'products' OR $action == 'orders' OR $action == 'clients' OR $action == 'options') {
                $shop_class = "active";
            } elseif ($view == 'invoices') {
                $shop_class = "active";
            } elseif ($view == 'customers') {
                $shop_class = "active";
            }

            $template_class='';
            if ($view == 'template' OR $view == 'packages') {
                $template_class = "active";
            }
            ?>

            <ul class="nav flex-column" id="mw-admin-main-navigation">
                <li class="nav-item">
                    <a href="<?php print admin_url(); ?>" class="nav-link <?php if (!$view): ?> active <?php endif; ?>">
                        <i class="mdi mdi-view-dashboard"></i> <?php _e("Dashboard"); ?>
                    </a>
                </li>

                <li><?php event_trigger('mw.admin.sidebar.li.first'); ?></li>
                <script>
                    //shop setting position
                    $(function() {
                        $( "#website-setting-sortable" ).sortable({
                            connectWith: "#website-menu-sortable",
                            update: function(event, ui){
                                websiteItemSortablePosition(0, `#website-setting-sortable>.ui-sortable-handle`)
                                $('.empty-website-setting-menu').hide();
                            },

                            recieve: function(event, x, y, z) {
                                console.log('receive', event, x, y, z)
                            }
                        });
                    });

                    $(function() {
                        $( "#website-menu-sortable" ).sortable({
                            connectWith: "#website-setting-sortable",
                            update: function(event, ui){
                                websiteItemSortablePosition(1, `#website-menu-sortable>.ui-sortable-handle`)
                                $('.empty-website-menu').hide();
                            },
                            recieve: function(event, x, y, z) {
                                console.log('receive', event, x, y, z)
                            }
                        });

                    });

                    //Collect item positions
                    function websiteItemSortablePosition(menutype, el_selector){
                        let positions = [];
                        $(el_selector).each(function(i, el){
                            positions[i] = $(el).data('index')
                        })

                        console.log(positions);

                        if(positions.length) {
                            $.ajax({
                                type: "POST",
                                url: "<?=api_url('update_sortable_website_menu')?>",
                                data:{ positions, menutype},
                                success: function(response) {
                                    console.log(response.message);
                                },
                                error: function(response){
                                    console.log(response.responseJSON.message);
                                }
                            });
                        }
                    }

                    function connectDRM(){
                        $('#drm').show();
                        $('#drm .drm-header').html("<button type='button' class='close'><span>&times;</span></button>");
                        $('#drm .drm-header .close').on('click', function() {
                            $('#drm').hide();
                        });
                    }

                </script>
                <?php if (user_can_view_module(['module' => 'content'])): ?>
                <li class="nav-item dropdown-no-js <?php echo $website_class; ?>">
                    <a href="<?php print admin_url(); ?>view:content" class="nav-link dropdown-toggle  <?php echo $website_class; ?>">
                        <i class="mdi mdi-earth"></i>
                        <span class="badge-holder"><?php _e('Website Settings'); ?></span>
                    </a>

                    <div class="dropdown-menu">
                        <?php
                          if(Schema::hasTable('admin_website_menu')){
                            $website_menus = DB::table('admin_website_menu')->where('shortcut', 1)->orderBy('position', 'asc')->get()->toArray();
                          }else{
                            $website_menus = [];
                          }
                        ?>
                        <div id="website-menu-sortable" class="" data-type="1">
                            <?php foreach($website_menus as $website_menu):  ?>
                                <?php
                                    if($website_menu->link){
                                        $website_menu_link = $website_menu->link;
                                    }else if($website_menu->mw_link){
                                        $website_menu_link = '?'.$website_menu->mw_link;
                                    }else if($website_menu->dt_link){
                                        $website_menu_link = admin_url().$website_menu->dt_link;
                                    }else if($website_menu->dt_temp_link){
                                        $website_menu_link = site_url().$website_menu->dt_temp_link;
                                    }else{
                                        $website_menu_link = "#";
                                        if($website_menu->onclick){
                                            $onclicklink = $website_menu->onclick;
                                        }else{
                                            $onclicklink = "";
                                        }
                                    }

                                    if($website_menu->data_link){
                                        $data_link = admin_url().$website_menu->data_link;
                                    }else{
                                        $data_link = "";
                                    }

                                    if(isset($_GET['group']) and $_GET['group']){
                                        $action = $_GET['group'];
                                    }elseif($load_module){
                                        $action = $load_module;
                                    }
                                ?>

                                <?php if($website_menu->name): ?>
                                    <a class="dropdown-item <?php if ($action == $website_menu->active_name): ?> active  <?php endif; ?>" href="<?php print $website_menu_link; ?>" data-position="<?php print $website_menu->position ?>" data-index="<?php print $website_menu->id ?>" <?php if($website_menu->onclick){ print  $onclicklink; } ?>>
                                        <?php _e($website_menu->name); ?>
                                        <?php if($website_menu->data_link): ?>
                                            <span class="btn btn-success btn-rounded btn-icon btn-sm add-new" data-href="<?php print  $data_link; ?>" data-toggle="tooltip" title="<?php _e($website_menu->data_title) ?>"><i class="mdi mdi-plus"></i></span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>

                            <?php endforeach; ?>
                            <?php if(isset($website_menus) && empty($website_menus)): ?>
                                <div class="empty-website-menu"> <?php _e("Empty Website Menu"); ?> </div>
                            <?php endif; ?>
                        </div>

                        <a class="dropdown-item <?php if ($action == 'settings'): ?> active <?php endif; ?>" href="<?php print admin_url(); ?>view:content/action:settings">
                            <?php _e("Settings"); ?>
                        </a>

                    </div>
                </li>
                <?php endif; ?>
                <script>
                    //shop setting position
                    $(function() {
                        $( "#shop-setting-sortable" ).sortable({
                            connectWith: "#shop-menu-sortable",
                            update: function(event, ui){
                                shopItemSortablePosition(0, `#shop-setting-sortable>.ui-sortable-handle`)
                                $('.empty-shop-setting-menu').hide();
                            },

                            recieve: function(event, x, y, z) {
                                console.log('receive', event, x, y, z)
                            }
                        });
                    });

                    $(function() {
                        $( "#shop-menu-sortable" ).sortable({
                            connectWith: "#shop-setting-sortable",
                            update: function(event, ui){
                                shopItemSortablePosition(1, `#shop-menu-sortable>.ui-sortable-handle`)
                                $('.empty-shop-menu').hide();
                            },
                            recieve: function(event, x, y, z) {
                                console.log('receive', event, x, y, z)
                            }
                        });

                    });

                    //Collect item positions
                    function shopItemSortablePosition(menutype, el_selector){
                        let positions = [];
                        $(el_selector).each(function(i, el){
                            positions[i] = $(el).data('index')
                        })

                        console.log(positions);

                        if(positions.length) {
                            $.ajax({
                                type: "POST",
                                url: "<?=api_url('update_sortable_shop_menu')?>",
                                data:{ positions, menutype},
                                success: function(response) {
                                    console.log(response.message);
                                },
                                error: function(response){
                                    console.log(response.responseJSON.message);
                                }
                            });
                        }
                    }
                </script>
                <?php if ($shop_disabled == false AND mw()->module_manager->is_installed('shop') == true): ?>
                <li class="nav-item dropdown-no-js <?php echo $shop_class; ?>">
                    <a href="<?php print admin_url(); ?>view:shop" class="nav-link dropdown-toggle <?php echo $shop_class; ?>">
                        <img src="<?php print modules_url(); ?>dropmatix.png" style="height:20px;width:20px;margin-right:10px;" alt="">
                        <span class="badge-holder"><?php _e('Online store'); ?><?php if ($view != 'shop' and $notif_count > 0): ?><?php print $order_notif_html; ?><?php endif; ?></span>
                    </a>
                    <div class="dropdown-menu">
                    <?php
                         if (Schema::hasTable('admin_shop_menu')) {
                             $shop_manus = DB::table('admin_shop_menu')->where('shortcut', 1)->orderBy('position', 'asc')->get()->toArray();
                         }else{
                            $shop_manus = [];
                         }

                        ?>
                        <div id="shop-menu-sortable" class="" data-type="1">
                            <?php foreach($shop_manus as $shop_manu):  ?>
                                <?php
                                    if($shop_manu->link){
                                        $shop_menu_link = $shop_manu->link;
                                    }else if($shop_manu->mw_link){
                                        $shop_menu_link = '?'.$shop_manu->mw_link;
                                    }else if($shop_manu->dt_link){
                                        $shop_menu_link = admin_url().$shop_manu->dt_link;
                                    }else if($shop_manu->dt_temp_link){
                                        $shop_menu_link = site_url().$shop_manu->dt_temp_link;
                                    }else{
                                        $menu_link = "#";
                                    }

                                    if($shop_manu->name  == "Orders"){
                                        $data_link = $shop_manu->data_link;
                                    }else {
                                        $data_link = admin_url().$shop_manu->data_link;
                                    }

                                    if(isset($_GET['group']) and $_GET['group']){
                                        $action = $_GET['group'];
                                    }elseif($load_module){
                                        $action = $load_module;
                                    }
                                ?>

                                <?php if($shop_manu->module_name): ?>
                                    <?php if (user_can_view_module(['module' => $shop_manu->module_name])): ?>
                                        <a href="<?php print $shop_menu_link; ?>" id="<?php print $shop_manu->active_name ?>" class="dropdown-item <?php if ($action == $shop_manu->active_name): ?> active <?php endif; ?>" data-position="<?php print $shop_manu->position; ?>" data-index="<?php print $shop_manu->id ?>">
                                            <?php _e($shop_manu->name); ?>
                                            <?php if($shop_manu->data_link): ?>
                                                <span data-href="<?php print  $data_link; ?>" class="btn btn-success btn-rounded btn-icon btn-sm add-new" data-toggle="tooltip" title="<?php _e($shop_manu->data_title) ?>"><i class="mdi mdi-plus"></i></span>
                                            <?php endif; ?>
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a class="dropdown-item <?php if ($action == $shop_manu->active_name): ?> active  <?php endif; ?>" id="<?php print $shop_manu->active_name ?>" href="<?php print $shop_menu_link; ?>" data-position="<?php print $shop_manu->position ?>" data-index="<?php print $shop_manu->id ?>">
                                        <?php _e($shop_manu->name); ?>
                                        <?php if($shop_manu->data_link): ?>
                                            <span class="btn btn-success btn-rounded btn-icon btn-sm add-new" data-href="<?php print  $data_link; ?>" data-toggle="tooltip" title="<?php _e($shop_manu->data_title) ?>"><i class="mdi mdi-plus"></i></span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>

                            <?php endforeach; ?>
                            <?php if(isset($shop_manus) && empty($shop_manus)): ?>
                                <div class="empty-shop-menu"> <?php _e("Empty Shop Menu"); ?> </div>
                            <?php endif; ?>
                        </div>

                        <a href="<?php print admin_url(); ?>view:shop/action:options/" class="dropdown-item <?php if ($action == 'options'): ?> active <?php endif; ?>">
                            <?php _e("Settings"); ?>
                        </a>
                    </div>
                </li>
                <?php endif; ?>
                <!-- <?php if (user_can_access('module.modules.index')): ?>
                    <li class="nav-item">
                        <?php
                    if (($view == 'modules' AND $load_module != 'users' AND $load_module != 'shop__coupons')) {
                        $modules_class = 'active';
                    } else {
                        $modules_class = '';
                    }
                    ?>
                        <a href="<?php print admin_url(); ?>view:modules" class="nav-link <?php echo $modules_class; ?>"><i class="mdi mdi-view-grid-plus"></i> <?php _e("Modules"); ?> </a>
                    </li>
                <?php endif; ?> -->
                <?php //if(is_admin()): ?>
                <!-- <li class="nav-item dropdown dropdown-no-js <?php //echo $template_class; ?>">
                    <a href="#" class="nav-link dropdown-toggle <?php //echo $template_class; ?>">
                        <img src="<?php //print modules_url(); ?>dropmatix.png" style="height:20px;width:20px;margin-right:10px;" alt="">
                        <span class="badge-holder" style="white-space: break-spaces;"><?php //_e('Template'); ?></span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="<?php //print admin_url(); ?>view:packages" class="dropdown-item <?php //if ($view == 'packages'): ?>active<?php //endif; ?>">
                            <?php //_e("Templateverwaltung"); ?>
                        </a>
                        <a href="<?php //print admin_url(); ?>view:template" class="dropdown-item <?php //if ($view == 'template'): ?> active <?php //endif; ?>">
                            <?php //_e("Template Settings"); ?>
                        </a>
                    </div>
                </li> -->
                <?php //endif; ?>


                <!-- Profile and teriff management menu item here -->
                <?php 
                    $profile='';
                    if ($view == 'profile') {
                        $profile = "active";
                    }
                ?>
                <?php if(is_admin()): ?>
                <li class="nav-item dropdown-no-js <?php echo $profile; ?>">
                    <a href="<?php print admin_url(); ?>view:profile/action:profile" class="nav-link dropdown-toggle <?php echo $profile; ?>">
                        <i class="mdi mdi-account"></i>
                        <span class="badge-holder" style="white-space: break-spaces;"><?php _e('Account'); ?></span>
                    </a>
                    <div class="dropdown-menu">
                        <a href="<?php print admin_url(); ?>view:profile/action:profile" class="dropdown-item <?php if ($view == 'profile' and $action == 'profile'): ?>active<?php endif; ?>">
                            <?php _e('Profile Data'); ?>
                        </a>
                        <a href="<?php print admin_url(); ?>view:profile/action:invoices" class="dropdown-item <?php if ($view == 'profile' and $action == 'invoices'): ?>active<?php endif; ?>">
                            <?php _e('Invoices'); ?>
                        </a>
                        <a href="<?php print admin_url(); ?>view:profile/action:password" class="dropdown-item <?php if ($view == 'profile' and $action == 'password'): ?>active<?php endif; ?>">
                            <?php _e('Change Password'); ?>
                        </a>
                        <a href="<?php print admin_url(); ?>view:profile/action:language" class="dropdown-item <?php if ($view == 'profile' and $action == 'language'): ?>active<?php endif; ?>">
                            <?php _e('Language'); ?>
                        </a>
                        <a href="#" onclick="connectDRM()" class="dropdown-item">
                            <?php _e('Connect to DRM'); ?>
                        </a>
                        <!-- <a href="<?php //print admin_url(); ?>view:profile/action:dns" class="dropdown-item <?php //if ($view == 'profile' and $action == 'dns'): ?>active<?php //endif; ?>">
                            <?php //_e('DNS management'); ?>
                        </a> -->
                        <a href="<?php print admin_url(); ?>view:profile/action:templates" class="dropdown-item <?php if ($view == 'profile' and $action == 'templates'): ?>active<?php endif; ?>">
                            <?php _e('Templates'); ?>
                        </a>
                        <!-- <a href="<?php //print admin_url(); ?>view:profile/action:tariff" class="dropdown-item <?php //if ($view == 'profile' and $action == 'tariff'): ?>active<?php //endif; ?>">
                            <?php //_e('Tariff management'); ?>
                        </a> -->
                    </div>
                </li>
                <?php endif; ?>

                <!-- End Profile and teriff management menu item -->


                <li class="nav-item">
                    <a href="https://www.youtube.com/channel/UCwIT78TfHENKEIZ6aZoPXxw" class="nav-link" target="_blank" style="display: flex;align-items:center">
                        <img src="<?php print modules_url(); ?>video-player.png" style="height:20px;width:20px;margin-right:10px;" alt="">
                        <span><?php _e("Tutorials"); ?></span>
                    </a>
                </li>
                <?php /*
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php if (!url_param('has_core_update') and ($view == 'settings')): ?> active <?php endif; ?>" href="<?php print admin_url(); ?>view:settings#option_group=website">
                        <i class="mdi mdi-cog"></i>
                        <span class="badge-holder"><?php _e("Settings"); ?></span>
                    </a>
                    <div class="dropdown-menu">

                        <a class="item-website dropdown-item" href="<?php print admin_url(); ?>view:settings#option_group=website">
                            <span class="mai-website"></span><strong><?php _e("Website"); ?></strong>
                        </a>

                        <a class="item-template dropdown-item" href="<?php print admin_url(); ?>view:settings#option_group=template">
                            <span class="mai-templates"></span><strong><?php _e("Template"); ?></strong>
                        </a>

                        <a class="item-users dropdown-item" href="<?php print admin_url(); ?>view:settings#option_group=users">
                            <span class="mai-login"></span><strong><?php _e("Login & Register"); ?></strong>
                        </a>

                        <a class="item-email dropdown-item" href="<?php print admin_url(); ?>view:settings#option_group=email">
                            <span class="mai-mail"></span><strong><?php _e("Email"); ?></strong>
                        </a>


                        <?php event_trigger('mw_admin_settings_menu'); ?>
                        <?php $settings_menu = mw()->module_manager->ui('admin.settings.menu'); ?>
                        <?php if (is_array($settings_menu) and !empty($settings_menu)): ?>
                            <?php foreach ($settings_menu as $item): ?>
                                <?php $module = (isset($item['module'])) ? module_name_encode($item['module']) : false; ?>
                                <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
                                <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
                                <?php if ($module != 'admin') { ?>
                                    <a onclick="mw.url.windowHashParam('option_group', '<?php print $module ?>');return false;" class="dropdown-item <?php print $class ?>" href="#option_group=<?php print $module ?>">
                                        <span class="<?php print isset($item['icon']) ? $item['icon'] : ''; ?>"></span>
                                        <strong><?php print $title ?></strong>
                                    </a>
                                <?php } ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <a onclick="mw.url.windowHashParam('option_group', 'advanced');return false;" class="dropdown-item item-advanced" href="#option_group=advanced">
                            <span class="mai-options"></span>
                            <stong><?php _e("Advanced"); ?></stong>
                        </a>

                        <a onclick="mw.url.windowHashParam('option_group', 'language');return false;" class="dropdown-item item-language" href="#option_group=language">
                            <span class="mai-languages"></span>
                            <strong><?php _e("Language"); ?></strong>
                        </a>
                    </div>
                </li>
                */ ?>

                <?php $load_module = url_param('load_module'); ?>
                <!-- <li <?php print 'class="nav-item dropdown ' . ($load_module == 'users' ? 'active' : '') . '"'; ?>>
                    <a class="nav-link <?php print ($load_module == 'users' OR $view == 'roles') ? 'active' : ''; ?>" href="<?php print admin_url('view:modules/load_module:users/action:profile'); ?>">
                        <i class="mdi mdi-account-multiple"></i> <?php _e("Users"); ?>
                    </a>

                    <?php if (mw()->ui->enable_service_links): ?>
                        <?php if (mw()->ui->custom_support_url): ?>
                                                       <a class="dropdown-item" href="<?php print mw()->ui->custom_support_url ?><!--"><strong>--><?php _e("Support"); ?></strong></a>
                <?php else: ?>
                <a class="dropdown-item" href="javascript:;" onmousedown="mw.contactForm();"><strong><?php _e("Support"); ?></strong></a>
                <?php endif; ?>
                <?php endif; ?>
                <a href="<?php print site_url(); ?>?editmode=y" class="go-live-edit-href-set dropdown-item"><?php _e("View Website"); ?></a>
                </li> -->

                <li><?php event_trigger('mw.admin.sidebar.li.last'); ?></li>


            </ul>
            <div class="admin-sidebar-logo">
                <a href="">
                    <img src="<?php print modules_url(); ?>microweber/images/admin-logo.png" alt="">

                </a>
            </div>
            <!-- <div class="update-btn-show">
                <button type="button" data-toggle="modal" data-target="#adminupdatepopup"  class="btn btn-secondary  globalUpdate-btn" ><?php //_e("Shop-Update verfügbar"); ?></button>
                <button type="button" data-toggle="modal" data-target="#activeTemplateUpdatePopup"  class="btn btn-secondary  globalTempUpdate-btn" ><?php //_e("Template-Update verfügbar"); ?></button>
            </div> -->

            <script>
                $(document).ready(function () {
                    mw.$('.go-live-edit-href-set').each(function () {
                        var el = $(this);
                        var href = el.attr('href');
                        if (href.indexOf("editmode") === -1) {
                            href = href + ((href.indexOf('?') === -1 ? '?' : '&') + 'editmode:y');
                        }
                        el.attr('href', href);
                    }).on('click', function (e){

                    });
                });
            </script>
        </aside>



 <!-- start admin panel update process -->

        <!-- start template install pageloader modal -->
        <div class="modal" id="adminupdateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php _e("Updating the Admin"); ?> </h5>
                    </div>
                    <div class="modal-body">
                        <div class="pre_loader" id="pageloader" >
                            <div class="logo">
                                <img src="https://i.postimg.cc/xdrXJZ40/admin-logo.png" alt="prelaoder">
                            </div>
                            <p><?php _e("Updating"); ?>......</p>
                            <div class="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end template install pageloader modal -->

        <div class="modal" id="aftersuccessmodal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p id="updateMessage" style="margin:0"></p>
                    </div>

                </div>
            </div>
        </div>
        <?php  $updateV = null; ?>
        <script>


                $(window).on('load', function(){

                    var pathname = window.location.pathname;
                    if(pathname == "/admin/view:modules/load_module:newsletter"){
                        window.location.href = "https://drm.software/admin/email_marketings";
                    }
                    <?php

                    $data = array(
                        'version' => Config::get('app.adminTemplateVersion'),
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"https://packages.droptienda-templates.com/api/admin_update");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                    $response = curl_exec($ch);

                    curl_close($ch);
                    $link = json_decode($response, true);
                    // dd($link);
                    $availableUpdate = @$link['update_available'];
                    if(@$link['newdata']){
                        $updateinfo = $link['newdata'];
                    }else{
                        $updateinfo = [];
                    }

                    // dd($updateinfo);
                    if($availableUpdate){
                        $info = $link['data']['info'];
                        $updateV = $link['data']['version'];
                    }

                    ?>
                    <?php if($availableUpdate):?>
                    $("#updateinfo").html('<?php print  $info; ?>');
                    $("#updateversion").html('Droptienda® Update Version <?php print  $updateV; ?>');
                    <?php endif;?>

                    temp = '<?php echo $availableUpdate; ?>';
                    console.log("<?php echo Config::get('app.adminTemplateVersion'); ?>");
                    console.log(temp);
                    if(temp){
                        $(".globalUpdate-btn").css("background-color", "green");
                    }else{
                        $(".globalUpdate-btn").html("KEIN Shop update verfügbar");
                        $(".globalUpdate-btn").css("background-color", "gray");
                        $(".globalUpdate-btn").attr("disabled","disabled");
                    }
                });
        </script>

              <!-- start admin Update  modal -->
        <div class="modal " tabindex="-1" id="adminupdatepopup" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="text-muted small" id="updateversion"></p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body">
                        <p>Ein neues Update ist verfügbar. Du kannst es jetzt kostenfrei installieren. Sichere zuvor deine Daten, damit du sie jederzeit wiederherstellen kannst.</p>
                        <p>Das Update beinhaltet folgende Neuerungen:</p>
                        <div>
                            <?php foreach($updateinfo as $uinfo):  ?>
                            <div class="tab">
                             <p><?php _e("Information of update version"); ?> <?php print $uinfo['version']; ?> </p>
                                <ul class="feature-update">
                                    <li ><?php print($uinfo['info']); ?></li>
                                </ul>
                            </div>
                            <?php endforeach; ?>
                            <div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                        <p class="text-muted small" ><?php _e("Droptienda® Current Version"); ?> <?php print(Config::get('app.adminTemplateVersion')); ?></p>
                        <div>
                            <button type="button" id="prevBtn" class="btn btn-secondary" onclick="nextPrev(-1)">zurück</button>
                            <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">weiter</button>
                            <button type="button" id="updateAdminBtn" onclick="updateAdminPanel()" class="btn btn-success">Update starten</button>
                        </div>
                    </div>
                </div>
            </div>
            <input id="mw_curr_theme_val1" name="current_template" class="mw_option_field mw-ui-field" type="hidden" option-group="template" value="<?=template_name()?>" />
        </div>
        <!-- end admin Update  modal -->

        <script>
            function updateAdminPanel(){
                // console.log($name);
                <?php
                $currentVersionOfAdmin = Config::get('app.adminTemplateVersion');
                if(!isset($updateV) && empty($updateV)){
                    $updateV = $currentVersionOfAdmin;
                }
                ?>
                var version = '<?php echo $currentVersionOfAdmin; ?>';
                var update_version = '<?php echo $updateV; ?>';
                $.ajax({
                    type: "POST",
                    url: "<?=api_url('updateAdmintheme')?>",
                    data:{version : version, update_version :  update_version},
                    beforeSend: function(){
                        $("#adminupdatepopup").hide();
                        $("#adminupdateModal").show();
                    },
                    success: function(response) {
                        console.log(response.message);
                        $("#aftersuccessmodal").show();
                        $("#updateMessage").html(response.message);
                        setTimeout(function () {
                            location.reload(true);
                        }, 2500);
                    },
                    error: function(response){
                        $("#updateMessage").html(response.responseJSON.message);

                    },
                    complete: function(){
                        $("#adminupdateModal").hide();
                        $.ajax({
                            url: "<?=api_url('admin_shop_menu_update')?>"
                        });

                        $.ajax({
                            url: "<?=api_url('admin_website_menu_update')?>"
                        });
                    }
                });
            }
            $( document ).ready(function() {

                $.ajax({
                    type: "POST",
                    url: "<?=api_url('checkParchase')?>",
                    data:{ name : $("#mw_curr_theme_val1").val()},
                    success: function(response) {
                        console.log(response.message);


                    },
                    error: function(response){
                        console.log(response.responseJSON.message);
                        $(".btn-purchaselink").attr("href", response.responseJSON.message);
                        $('#checkPurchasePopup2').modal('show');
                        $('#checkPurchasePopup2').modal({
                            backdrop: 'static',
                            keyboard: false
                        })


                    }

                });

            });

        </script>
    <?php if($availableUpdate): ?>
        <script type="text/javascript">
            $(".tab").css("display", "none");
            var currentTab = 0; // Current tab is set to be the first tab (0)
            showTab(currentTab); // Display the current tab

            function showTab(n) {
            // This function will display the specified tab of the form ...
                var x = document.getElementsByClassName("tab");
                console.log(x);
                x[n].style.display = "block";
                // ... and fix the Previous/Next buttons:
                if (n == 0) {
                    document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevBtn").style.display = "inline";
                }

                if (n == (x.length - 1)) {
                    $("#nextBtn").css("display", "none");
                    $("#updateAdminBtn").css("display", "inline");
                }else{
                    $("#nextBtn").css("display", "inline");
                    $("#updateAdminBtn").css("display", "none");
                }
                // ... and run a function that displays the correct step indicator:
            }

            function nextPrev(n) {
                // This function will figure out which tab to display
                var x = document.getElementsByClassName("tab");
                // Exit the function if any field in the current tab is invalid:
                // Hide the current tab:
                x[currentTab].style.display = "none";
                // Increase or decrease the current tab by 1:
                currentTab = currentTab + n;
                // Otherwise, display the correct tab:
                showTab(currentTab);
            }
        </script>
    <?php endif; ?>
 <!-- end admin panel update process -->

        <style>
            .btn-purchaselink{
                background-color: #F26522;
                color: #fff;
            }
            #checkPurchasePopup2 .modal-dialog {
                top: 50% !important;
                transform: translateY(-50%) !important;
            }
        </style>

        <div class="modal fade" id="checkPurchasePopup2" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <p><?php _e("You template's trial time is expired. Please continue with purchase the template or Accept the Default template as your Shop template"); ?> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="change_to_default()" data-dismiss="modal"><?php _e('Accept'); ?></button>
                        <a href="" class="btn btn-purchaselink" target="_blank"><?php _e('Testen & Kaufen'); ?></a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <script>
            function change_to_default(){
                var confirm = true;
                $.post("<?= url('/') ?>/api/v1/change_to_default", { confirm: confirm }, (res) => {

                    if(res.success){
                        location.reload();
                    }

                });


            }
        </script>


<!-- start active  template update process -->

        <script>
            $(window).on('load', function(){
                <?php
                $get_config_temp = new App\Models\CustomField();
                $active_temp_version = $get_config_temp->get_a_config(template_name())['version'];
                $temp_data = array(
                    'name' =>  $get_config_temp->get_a_config(template_name())['name'],
                    'version' =>  $active_temp_version
                );


                $temp_ch = curl_init();
                curl_setopt($temp_ch, CURLOPT_URL,"https://packages.droptienda-templates.com/api/template_verison");
                curl_setopt($temp_ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($temp_ch, CURLOPT_POSTFIELDS, $temp_data);

                $temp_response = curl_exec($temp_ch);

                curl_close($temp_ch);
                $activeTemplateInfo = json_decode($temp_response, true);
                $temp_update_check = false;
                if(isset($activeTemplateInfo['newdata'])){
                    foreach($activeTemplateInfo['newdata'] as $temp_item){
                        if(  $active_temp_version < $temp_item['version']){
                            $temp_update_check = true;
                        }
                    }
                }


                // dd($activeTemplateInfo);
                ?>
                var temp_update_check = '<?php print  $temp_update_check; ?>';
                if(temp_update_check){
                    $(".globalTempUpdate-btn").css("background-color", "green");
                }else{
                    $(".globalTempUpdate-btn").html("KEIN Template update verfügbar");
                    $(".globalTempUpdate-btn").css("background-color", "gray");
                    $(".globalTempUpdate-btn").attr("disabled","disabled");
                }
            });
        </script>

        <!-- start template Update  modal -->
        <div class="modal fade" tabindex="-1" id="activeTemplateUpdatePopup" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <p class="text-muted small" ><?php _e("Template  update version"); ?> <?php if(@end($activeTemplateInfo['newdata'])['version']){ print end($activeTemplateInfo['newdata'])['version']; } ?>  </p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body">
                        <p>Ein neues Update ist verfugbar. Du kannst es jetzt kostenfrei installieren. Sichere zuvor deine Daten, damit du sie jederzeit wiederherstellen kannst.</p>
                        <p>Das Update beinhaltet folgende Neuerungen:</p>
                        <?php
                        if(isset($activeTemplateInfo['newdata'])){
                            foreach($activeTemplateInfo['newdata'] as $atinfo):  ?>
                            <?php if(@$active_temp_version && $active_temp_version < $atinfo['version'] ): ?>
                                <div class="active_tab">
                                    <p><?php _e("Information of update version"); ?> <?php print $atinfo['version'] ?> </p>
                                    <ul class="feature-update">
                                        <li ><?php print $atinfo['info'] ?></li>
                                    </ul>
                                    </div>
                            <?php endif; ?>
                            <?php endforeach;
                        }?>
                    </div>
                    <div class="modal-footer"  style="justify-content: space-between;">
                        <p class="text-muted small"  ><?php _e("Template  Current Version"); ?> <?php if(@$active_temp_version){ print $active_temp_version; } ?></p>
                        <div>
                            <button type="button" id="active_prevBtn" class="btn btn-secondary" onclick="active_nextPrev(-1)">zurück</button>
                            <button type="button" id="active_nextBtn" class="btn btn-primary" onclick="active_nextPrev(1)">weiter</button>
                            <button type="button" id="activeTemplateUpdateBtn" onclick="activeThemeUpdate('<?php print  $temp_data['name'] ?>','<?php if(@end($activeTemplateInfo['newdata'])['version']){ print end($activeTemplateInfo['newdata'])['version']; }  ?>')"  class="btn btn-success">Update starten</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        <!-- end template Update  modal -->
    <?php if(@$temp_update_check && $temp_update_check): ?>
        <script type="text/javascript">
            $(".active_tab").css("display", "none");
            var active_currentTab = 0; // Current tab is set to be the first tab (0)
            active_showTab(active_currentTab); // Display the current tab

            function active_showTab(active_n) {
            // This function will display the specified tab of the form ...
                var active_x = document.getElementsByClassName("active_tab");
                console.log(active_x);
                active_x[active_n].style.display = "block";
                // ... and fix the Previous/Next buttons:
                if (active_n == 0) {
                    document.getElementById("active_prevBtn").style.display = "none";
                } else {
                    document.getElementById("active_prevBtn").style.display = "inline";
                }

                if (active_n == (active_x.length - 1)) {
                    $("#active_nextBtn").css("display", "none");
                    $("#activeTemplateUpdateBtn").css("display", "inline");
                }else{
                    $("#active_nextBtn").css("display", "inline");
                    $("#activeTemplateUpdateBtn").css("display", "none");
                }
                // ... and run a function that displays the correct step indicator:
            }

            function active_nextPrev(active_n) {
                // This function will figure out which tab to display
                var active_x = document.getElementsByClassName("active_tab");
                // Exit the function if any field in the current tab is invalid:
                // Hide the current tab:
                active_x[active_currentTab].style.display = "none";
                // Increase or decrease the current tab by 1:
                active_currentTab = active_currentTab + active_n;
                // Otherwise, display the correct tab:
                active_showTab(active_currentTab);
            }
        </script>
    <?php endif; ?>


    <!-- start active template Update pageloader modal -->
    <div class="modal" id="activeTempupdateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php _e("Updating the Template"); ?></h5>
            </div>
            <div class="modal-body">
                <div class="pre_loader" id="pageloader" >
                    <div class="logo">
                        <img src="https://i.postimg.cc/xdrXJZ40/admin-logo.png" alt="prelaoder">
                    </div>
                    <p><?php _e("Updating"); ?>......</p>
                    <div class="progressbar"></div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- end active template Update pageloader modal -->


    <script>
        function activeThemeUpdate(name,version){

        console.log(name,version);
        $.ajax({
            type: "POST",
            url: "<?=api_url('install_theme')?>",
            data:{ name : name, version : version },
            beforeSend: function(){
                $("#activeTemplateUpdatePopup").hide();
                $("#activeTempupdateModal").show();

            },
            success: function(response) {
                console.log(response.message);
                $("#aftersuccessmodal").show();
                $("#updateMessage").html(response.message);
                setTimeout(function () {
                    location.reload(true);
                }, 2500);
            },
            error: function(response){
                $("#updateMessage").html(response.responseJSON.message);

            },
            complete: function(){
                $("#activeTempupdateModal").hide();

            }
        });

        }
    </script>
<!-- end active  template update process -->
        <!--instagram image modal for admin-->

        <style>
            .instragram-gallery-item{
                position: relative;
                height: 100%;
                overflow: hidden;
            }

            .instragram-gallery-item img {
                height: 100%;
                object-fit: cover;
            }

            .instragram-gallery .col-md-3 {
                margin-bottom: 20px;
            }

            .instragram-gallery-item-hover {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                opacity: 0;
                visibility: hidden;
                transition: .3s ease all;
            }

            .instragram-gallery-item:hover .instragram-gallery-item-hover{
                opacity: 1;
                visibility: visible;
            }

            p.instragram-feed {
                font-size: 12px;
                padding: 0 8px;
                text-align: center;
            }

            .instragram-gallery-item-hover-content {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 999;
                width:100%;
            }

            .instragram-gallery-item-hover-content p:first-child {
                color: #fff;
                text-align: center;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                height:74px;
            }
            .instragram-gallery-item-hover-content p {
                border: 0px !important;
                box-shadow: unset !important;
            }
            .instragram-gallery-item-hover::after {
                content:'';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height:100%;
                background-color: #0000003d;
                z-index: 0;
            }

            #instragram-gallery-modal .modal-dialog {
                margin-top: 100px;
                max-width: 1000px;
            }

            .instagram-gallery-pagination {
                text-align: right;
            }

            .preloader-whirlpool {
                position: absolute;
                height: 100%;
                width: 100%;
            }

            .preloader-whirlpool:before {
                position: absolute;
                content:'';
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color:#cccccc;
                opacity: .7;
            }
        </style>
        <style>
            .preloader-whirlpool .whirlpool {
                position: absolute;
                top: 50%;
                left: 50%;
                border: 1px solid #cccccc;
                border-left-color: black;
                border-radius: 974px;
                -o-border-radius: 974px;
                -ms-border-radius: 974px;
                -webkit-border-radius: 974px;
                -moz-border-radius: 974px;
                margin: -24px 0 0 -24px;
                height: 49px;
                width: 49px;
                animation: cssload-rotate 1150ms linear infinite;
                -o-animation: cssload-rotate 1150ms linear infinite;
                -ms-animation: cssload-rotate 1150ms linear infinite;
                -webkit-animation: cssload-rotate 1150ms linear infinite;
                -moz-animation: cssload-rotate 1150ms linear infinite;
            }
            .preloader-whirlpool .whirlpool::before, .preloader-whirlpool .whirlpool::after {
                position: absolute;
                top: 50%;
                left: 50%;
                border: 1px solid #cccccc;
                border-left-color: black;
                border-radius: 974px;
                -o-border-radius: 974px;
                -ms-border-radius: 974px;
                -webkit-border-radius: 974px;
                -moz-border-radius: 974px;
            }
            .preloader-whirlpool .whirlpool::before {
                content: "";
                margin: -22px 0 0 -22px;
                height: 43px;
                width: 43px;
                animation: cssload-rotate 1150ms linear infinite;
                -o-animation: cssload-rotate 1150ms linear infinite;
                -ms-animation: cssload-rotate 1150ms linear infinite;
                -webkit-animation: cssload-rotate 1150ms linear infinite;
                -moz-animation: cssload-rotate 1150ms linear infinite;
            }
            .preloader-whirlpool .whirlpool::after {
                content: "";
                margin: -28px 0 0 -28px;
                height: 55px;
                width: 55px;
                animation: cssload-rotate 2300ms linear infinite;
                -o-animation: cssload-rotate 2300ms linear infinite;
                -ms-animation: cssload-rotate 2300ms linear infinite;
                -webkit-animation: cssload-rotate 2300ms linear infinite;
                -moz-animation: cssload-rotate 2300ms linear infinite;
            }

            @keyframes cssload-rotate {
                100% {
                    transform: rotate(360deg);
                }
            }
            @-webkit-keyframes cssload-rotate {
                100% {
                    -webkit-transform: rotate(360deg);
                }
            }
            .timer{
                display: flex;
                text-align: center;
                flex-direction: row;
                justify-content: space-between;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .days{
                padding: 11px;
                font-size: 22px;
            }


            .hours{
                padding: 11px;
                font-size: 22px;
            }
            .mins{
                padding: 11px;
                font-size: 22px;
            }

            .secs{
                padding: 11px;
                font-size: 22px;
            }

            .timer-countdown{
                display: flex;
                text-align: center;
                flex-direction: row;
                margin-left: 5px;
                padding: 0 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .offer{
                flex-basis: 6rem;
            }
            .timer_title {
                font-size: 14px;
                display: block;
                font-weight: 700;
            }
            .timer-box{
                display: flex;
                align-items: center;
                padding: 5px;
                margin-right: 8px;
            }
            #insta_details p {
                margin-bottom: 0px;
                /* display: block; */
                padding: 10px;
                border: 1px solid #e8e8e8;
                border-radius: 5px;
                box-shadow: 0 0 2px 2px #eee;
                font-weight: 600;
                text-transform: capitalize;
            }

            #insta_details {
                justify-content: center;
            }
        </style>

        <div class="modal" id="instragram-gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="preloader-whirlpool">
                        <div class="whirlpool"></div>
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="instragram-gallery">
                            <div class="row" id="insta_details">

                            </div>
                            <div class="row">
                                <div class="col-md-6">
<!--                                    <div class="instragram-gallery-countdown">-->
<!--                                        <div class="timer">-->
<!--                                            <div class="days timer-box">-->
<!--                                                <span class="timer_title">Days</span>-->
<!--                                                <span class="timer-countdown" id="days_left"> 0</span>-->
<!---->
<!--                                            </div>-->
<!--                                            <div class="hours timer-box">-->
<!--                                                <span class="timer_title">Hours</span>-->
<!--                                                <span class="timer-countdown" id="hours_left"> 0 </span>-->
<!---->
<!--                                            </div>-->
<!--                                            <div class="mins timer-box">-->
<!--                                                <span class="timer_title">Mins</span>-->
<!--                                                <span class="timer-countdown" id="mins_left"> 0 </span>-->
<!---->
<!--                                            </div>-->
<!--                                            <div class="secs timer-box">-->
<!--                                                <span class="timer_title">Secs</span>-->
<!--                                                <span class="timer-countdown" id="secs_left"> 0 </span>-->
<!---->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                </div>
                                <div class="col-md-6">
                                    <div class="instagram-gallery-pagination" id="pagination_btn">
                                        <button id="previous_url" data-url="" class="btn btn-primary paging hide">Prev</button>
                                        <button id="next_url" data-url="" class="btn btn-primary paging hide">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
