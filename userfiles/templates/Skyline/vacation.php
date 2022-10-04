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
    <?php if (Config::get('custom.disableGoggleIndex') == 1) : ?>
        <meta name="robots" content="noimageindex,nomediaindex" />
    <?php endif; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="{content_meta_title}">
    <meta name="keywords" content="{content_meta_keywords}">
    <meta name="description" content="{content_meta_description}">
    <meta property="og:type" content="{og_type}">
    <meta property="og:url" content="{content_url}">
    <meta property="og:image" content="{content_image}">
    <meta property="og:description" content="{og_description}">
    <meta property="og:site_name" content="{og_site_name}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i%7cWork+Sans:400,500,700" rel="stylesheet" type="text/css">
    <script src="<?php print template_url(); ?>assets/js/jquery.smartmenus.min.js"></script>
    <link href="<?php print template_url(); ?>assets/css/sm-core-css.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/sm-simple.css" />
    <link rel="stylesheet" href="{TEMPLATE_URL}modules/layouts/templates/layouts.css" type="text/css" media="all">
    <?php $color_scheme = get_option('color-scheme', 'mw-template-snow'); ?>
    <?php if ($color_scheme != '' and $color_scheme != 'default') : ?>
        <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/<?php print $color_scheme; ?>.css" type="text/css" media="all">
    <?php endif; ?>


    <?php if(isset(get_content_by_id(CONTENT_ID)['url']) && get_content_by_id(CONTENT_ID)['url'] == 'shop'): ?>
        <?php if(is_logged()): ?>
            <script type="text/javascript" src="{TEMPLATE_URL}assets/js/jquery-ui.js"></script>
            <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
            <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
        <?php endif; ?>
    <?php else: ?>
        <script type="text/javascript" src="{TEMPLATE_URL}assets/js/jquery-ui.js"></script>
        <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
        <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
    <?php endif; ?>
    <script type="text/javascript" src="{TEMPLATE_URL}assets/js/main.js"></script>
    <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/combined.css" type="text/css" media="all">
    <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/main-style.css" type="text/css" media="all">
    <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/responsive.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/plugins/meanmenu/meanmenu.min.css" />
    <?php print get_template_stylesheet(); ?>

    <script>
        mw.require('icon_selector.js');
        mw.lib.require('bootstrap4');
        mw.lib.require('bootstrap_select');
        mw.iconLoader()
            .addIconSet('fontAwesome')
            .addIconSet('iconsMindLine')
            .addIconSet('iconsMindSolid')
            .addIconSet('mwIcons')
            .addIconSet('materialIcons');
    </script>
    <script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/meanmenu/jquery.meanmenu.min.js"></script>
    <?php
    print(template_head(true));
    //Seo data for google anaylytical
    $is_installed_status = Config::get('microweber.is_installed');
    (@$is_installed_status) ? basicGoogleAnalytical() : '';
    //end code
    ?>
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
        <module type="layouts" template="empty"/>
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
        <module type="layouts" template="empty"/>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script> -->
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
            $('.nk-header>nav').addClass('dt_mobile_nav');
            $("#mobile-navigation li").has("ul").addClass("hasSubForMobile");
            $("#mobile-navigation li").has('ul').children('a').append('<span class="caret"></span>');


            $("li.hasSubForMobile>a").on("click", function(){
                $(this).parent().toggleClass("activeSubforMobile").fadeIn("slow");;
            });
        }else{
            $('.nk-header>nav').removeClass('dt_mobile_nav');
            $("#mobile-navigation li").has("ul").removeClass("hasSubForMobile");

        }
    });

    $("body").mousemove(function(event) {
        if ($('#mw-dialog-holder-module-settings-main-navigation').length > 0) {
            $("#mw-dialog-holder-module-settings-main-navigation .mw-dialog-header").mouseenter(function() {
                $('#mw-dialog-holder-module-settings-main-navigation .mw-dialog-header').append('<span class="closeandReload"></span>');
                $('#mw-dialog-holder-module-settings-main-navigation .closeandReload').on('click', function() {
                    location.reload();
                });
            });
        }
    });


</script>
<script>
    mw.lib.require('slick');
    mw.lib.require('collapse_nav');
</script>
<?php
    if(file_exists(module_dir('')."global_code_add_for_template.php")){
        include module_dir('') . "global_code_add_for_template.php";
    }
?>

</body>
</html>
