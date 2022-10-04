<?php

/*

  type: layout
  content_type: static
  name: vacation

*/

?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" <?php print lang_attributes(); ?>>

<head>

    <title>{content_meta_title}</title>
    <?php if(Config::get('custom.disableGoggleIndex') == 1): ?>
        <meta name="robots" content="noimageindex,nomediaindex"/>
    <?php endif; ?>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <meta property="og:title" content="{content_meta_title}"/>
    <meta name="keywords" content="{content_meta_keywords}"/>
    <meta name="description" content="{content_meta_description}"/>
    <meta property="og:type" content="{og_type}"/>
    <meta property="og:url" content="{content_url}"/>
    <meta property="og:image" content="{content_image}"/>
    <meta property="og:description" content="{og_description}"/>
    <meta property="og:site_name" content="{og_site_name}"/>
    <script>mw.lib.require('material_icons');</script>

    <script>
        mw.require('icon_selector.js');

        mw.lib.require('bootstrap4');
        mw.lib.require('bootstrap_select');

        mw.iconLoader()
            .addIconSet('fontAwesome')
            .addIconSet('iconsMindLine')
            .addIconSet('iconsMindSolid')
            .addIconSet('mwIcons');
    </script>

    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
        });
    </script>
    <?php
    //Seo data for google anaylytical
        print (template_head(true));
        $is_installed_status = Config::get('microweber.is_installed');
        if(!empty($is_installed_status)){
            if(function_exists('basicGoogleAnalytical')){
                basicGoogleAnalytical();
            }
        }
        //end code
    ?>


    <!-- Plugins Styles -->
    <link rel="stylesheet" type="text/css" href="<?php print template_url(); ?>assets/plugins/slick/slick.css"/>
    <link href="<?php print template_url(); ?>assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet"/>
    <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet"/>
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/> -->
    <link href="<?php print template_url(); ?>assets/js/libs/swiper/css/swiper.min.css" rel="stylesheet"/>




    <link href="<?php print template_url(); ?>assets/css/custom.css" rel="stylesheet"/>

    <link href="<?php print template_url(); ?>assets/css/style.css" rel="stylesheet"/>
    <link href="<?php print template_url(); ?>assets/css/responsive.css" rel="stylesheet"/>
    <?php print get_template_stylesheet(); ?>
    <link href="<?php print template_url(); ?>assets/css/typography.css" rel="stylesheet"/>
    <script src="<?php print template_url(); ?>assets/js/jquery.smartmenus.min.js"></script>
    <script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/meanmenu/jquery.meanmenu.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.0.2/jquery.smartmenus.min.js" integrity="sha512-CSUXmy4S0ZDItjtZL/SuwFlkMFhBqRVtA0Wlbvx3vbGT3Z7sw1VYHlwQlmhlr7az3bslzSubg6IW5edrtdqx3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <link href="<?php print template_url(); ?>assets/css/sm-core-css.min.css" rel="stylesheet"/>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.0.2/css/sm-core-css.min.css" integrity="sha512-OF2VNQxelDKPhvZMLozqRe+nZ4EVgNHgD0+Zl3MJxl0h78wC0edWEtJkbn7r4Lrf4ijDMMKu0q80dPGBqLe03Q==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/sm-simple.css" />
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/plugins/meanmenu/meanmenu.min.css" />


    <?php include('template_settings_options.php'); ?>
</head>
<style>
    body {

        margin: 0
    }
    .vacation-wrapper-content-countdown {
        margin-top: 35px !important;
    }
    .vacation-wrapper-content {
        text-align: center;
    }
    .vacation-wrapper {
        width: 100%;
        height: auto;
        /* background: rgb(180, 180, 180);
        background: linear-gradient(180deg, rgba(180, 180, 180, 1) 0%, rgba(218, 218, 218, 1) 35%, rgba(238, 238, 238, 1) 100%); */
        display: block;
    }

    .vacation-wrapper-content h1 {
        font-size: 60px !important;

        text-transform: uppercase;
        margin: 0;
    }

    .vacation-wrapper-content p {
        font-size: 16px;
        margin-top: 10px;
    }

    .vacation-wrapper-row {
        height: 100%;
        width: 500px;
        display: block;
        align-items: center;
        margin: 0px auto;
    }

    .vacation-wrapper-content-password h5 {
        font-weight: 500;
    }

    .vacation-wrapper-content-password button {
        margin-top: 20px;
    }

    .vacation-wrapper-image img {
        width: 100%;
    }

    .vacation-wrapper-image {
        text-align: center;
        width: 100px;
        margin: 30px auto;
    }

    .vacation-wrapper-content-date {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .vacation-wrapper-content-date span {
        display: inline-block;
        border: 1px solid #d5d5d5;
        border-radius: 5px;
        padding: 5px;
        box-shadow: 0 1px 0px 2px #d5d5d5;
    }

    #countdown {
        width: 300px;
        height: 100px;
        text-align: center;
        background: #d7d7d7;
        border: 1px solid #d7d7d7;
        border-radius: 5px 15px;
        box-shadow: 0px 0px 8px rgb(0 0 0 / 60%);
        margin: auto;
        padding: 24px 0;
        position: relative;
    }

    #countdown #tiles {
        position: relative;
        z-index: 1;
    }

    #countdown #tiles>span {
        width: 50px;
        max-width: 92px;
        font: bold 20px 'Droid Sans', Arial, sans-serif;
        text-align: center;
        color: #111;
        background-color: #ddd;
        background-image: -webkit-linear-gradient(top, #bbb, #eee);
        background-image: -moz-linear-gradient(top, #bbb, #eee);
        background-image: -ms-linear-gradient(top, #bbb, #eee);
        background-image: -o-linear-gradient(top, #bbb, #eee);
        border-top: 1px solid #fff;
        border-radius: 3px;
        box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.7);
        margin: 0 7px;
        padding: 10px 0;
        display: inline-block;
        position: relative;
    }

    #countdown #tiles>span:before {
        content: "";
        width: 100%;
        height: 13px;
        background: #111;
        display: block;
        padding: 0 3px;
        position: absolute;
        top: 41%;
        left: -3px;
        z-index: -1;
    }

    #countdown .labels {
        width: 100%;
        height: 25px;
        text-align: center;
        bottom: 8px;
    }

    #countdown .labels li {
        width: 60px;
        font: 10px 'Droid Sans', Arial, sans-serif;
        text-align: center;
        text-transform: uppercase;
        display: inline-block;
    }
    .vw-noedit {
        position: relative;
    }

    .vw-noedit:after {
        position: absolute;
        content: '';
        height: 100%;
        width: 100%;
        background-color: #000;
        z-index: 1;
        left: 0;
        top: 0;
        opacity: 0;
    }

</style>
<?php
  $vacation_start_date = get_option('vacation_mode_start_date', 'vacation_mode_date');
  $vacation_end_date = get_option('vacation_mode_end_date', 'vacation_mode_date');
  if($vacation_end_date && date("Y-m-d") >  $vacation_end_date){
   $option = array();
   $option['option_key'] = 'vacation_mode';
   $option['option_value'] = 'no';
   $option['option_group'] = 'website';
   save_option($option);
   $option = array();
   $option['option_key'] = 'vacation_mode_start_date';
   $option['option_value'] = null;
   $option['option_group'] = 'vacation_mode_date';
   save_option($option);
   $option = array();
   $option['option_key'] = 'vacation_mode_end_date';
   $option['option_value'] = null;
   $option['option_group'] = 'vacation_mode_date';
   save_option($option);
   redirect('/');
}

?>
<body>

    <div class="vacation-top edit" field="vacation-top_container" rel="content">
        <module type="layouts" template="skin-1"/>
    </div>

    <div class="vacation-wrapper">
        <div class="vacation-wrapper-row">
            <div class="vacation-wrapper-col">
                <div class="vacation-wrapper-image edit" rel="content" field="image_vacation">
                    <img src="<?php print modules_url(); ?>default.png" alt="">
                </div>
                <div class="vacation-wrapper-content">
                    <div class="edit" rel="content" field="vacation-description">
                        <h3><?php _e('This shop is on vacation mode'); ?></h3>
                        <p><?php _e('This shop will be open when the vacation time will over'); ?></p>

                    </div>
                    <!-- <div class="vacation-wrapper-content-password">
                        <h5>Enter shop password</h5>
                        <input type="password" class="form-control">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div> -->
                    <?php
                    ?>
                    <?php if($vacation_end_date): ?>
                        <!-- <div class="vacation-wrapper-content-date">
                            <p><strong><?php //_e('Start Date'); ?>:</strong> <span><?php  //print date('Y-m-d',strtotime($vacation_start_date)); ?></span></p>
                            <p><strong><?php //_e('End Date'); ?>:</strong> <span><?php  //print date('Y-m-d',strtotime($vacation_end_date)); ?></span></p>
                        </div> -->
                        <div class="vacation-wrapper-content-countdown">
                            <div id="countdown">
                                <div id='tiles'></div>
                                <div class="labels">
                                    <li><?php _e('Days'); ?></li>
                                    <li><?php _e('Hours'); ?></li>
                                    <li><?php _e('Mins'); ?></li>
                                    <li><?php _e('Secs'); ?></li>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="vacation-bottom edit" field="vacation-bottom_container" rel="content">
        <module type="layouts" template="skin-1"/>
    </div>

    <script>
        var target_date = new Date("<?php print  $vacation_end_date; ?>").getTime(); // set the countdown date
        var days, hours, minutes, seconds; // variables for time units

        var countdown = document.getElementById("tiles"); // get tag element

        getCountdown();

        setInterval(function () { getCountdown(); }, 1000);

        function getCountdown() {

            // find the amount of "seconds" between now and target
            var current_date = new Date().getTime();
            var seconds_left = (target_date - current_date) / 1000;

            days = pad(parseInt(seconds_left / 86400));
            seconds_left = seconds_left % 86400;

            hours = pad(parseInt(seconds_left / 3600));
            seconds_left = seconds_left % 3600;

            minutes = pad(parseInt(seconds_left / 60));
            seconds = pad(parseInt(seconds_left % 60));

            // format countdown string + set tag value
            countdown.innerHTML = "<span>" + days + "</span><span>" + hours + "</span><span>" + minutes + "</span><span>" + seconds + "</span>";
        }

        function pad(n) {
            return (n < 10 ? '0' : '') + n;
        }


    </script>
<script>
$(window).on('load resize', function () {
    if ($(window).width() < 991) {
        $('.navigation-holder>nav').addClass('dt_mobile_nav');
        $(".navigation-holder>nav li").has("ul").addClass("hasSubForMobile");
        $("li.hasSubForMobile>a").on("click", function(){
            $(this).parent().toggleClass("activeSubforMobile");
        });
    }else{
        $('.navigation-holder>nav').removeClass('dt_mobile_nav');
        $(".navigation-holder>nav li").has("ul").removeClass("hasSubForMobile");

    }
});
$(document).ready(function() {
    $('.nav-for-mobile .navbar_new ul').removeClass();
    $('.nav-for-mobile .navbar_new li').removeClass();
    $('.nav-for-mobile .navbar_new li a').removeClass();

    // Mean Menu JS
    $('.nav-for-mobile .navbar_new').meanmenu({
        meanScreenWidth: "1024",
        meanMenuContainer: '.nav-for-mobile'
    });
});

$("body").mousemove(function(event) {
    if ($('#mw-dialog-holder-module-settings-header-menu').length > 0) {
        $("#mw-dialog-holder-module-settings-header-menu .mw-dialog-header").mouseenter(function() {
            $('#mw-dialog-holder-module-settings-header-menu .mw-dialog-header').append('<span class="closeandReload"></span>');
            $('#mw-dialog-holder-module-settings-header-menu .closeandReload').on('click', function() {
                location.reload();
            });
        });
    }
});
</script>

<!-- Plugins -->
<script src="<?php print template_url(); ?>assets/js/mo.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;language=en-GB&amp;key=AIzaSyDbN7i-eF7dlNNp-bxbERNomOGYpZld3B0"></script>
<script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="<?php print template_url(); ?>assets/js/libs/swiper/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/slick/slick.min.js"></script>
<script src="<?php print template_url(); ?>assets/plugins/elevatezoom/jquery.elevatezoom.js"></script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/masonry/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/masonry/isotope.pkgd.min.js"></script>

<script src="<?php print template_url(); ?>assets/js/libs/anime.min.js"></script>
<script src="<?php print template_url(); ?>assets/js/libs/particles.js"></script>
<script src="<?php print template_url(); ?>assets/js/libs/jquery.sticky-sidebar.min.js"></script>
<script>mw.lib.require('collapse_nav');</script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php print template_url(); ?>assets/js/main.js"></script>

<script src="<?php print template_url(); ?>assets/js/fx.js"></script>
<?php
    if(file_exists(module_dir('')."global_code_add_for_template.php")){
        include module_dir('') . "global_code_add_for_template.php";
    }
?>

</body>
</html>
