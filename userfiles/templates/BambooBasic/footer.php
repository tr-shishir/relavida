<?php if ($footer == 'true'): ?>
    <style>
        footer ul li a {
            display: block;
            color: #f3f3f3;
            text-decoration: none;
            padding: 10px 12px !important;
        }
        footer ul li {
            display: inline-block;
            color: #f3f3f3;
            width: auto;
        }

        span.closeandReload {
            position: absolute;
            background-color: #f00;
            height: 32px;
            width: 32px;
            right: 7px;
            top: 7px;
            z-index: 1;
            cursor: pointer;
            opacity: 0;
        }
    </style>
    <footer class="edit p-t-60 p-b-60" rel="global" field="footer-main-wrapper">
        <div class="container">
            <div class="edit nodrop safe-mode" field="bamboo_footer_content" rel="global">
                <div class="row">
                    <div class="mx-auto col-xl-8 allow-drop text-center">
                        <module type="menu" template="footer" id="footer_menu" name="footer_menu"/>
                        <p><?php print _lang('THE CONTENT BELONGS TO  pivotsubscriptions.com', 'templates/bamboo'); ?></p>
                        <p><?php print _lang('All photo and video materials belong to their owners and are used for demonstration purposes only.', 'templates/bamboo'); ?></p>
                        <p><?php print _lang('Please do not use them in commercial projects.', 'templates/bamboo'); ?></p>
                        <br/><br/>
                    </div>
                </div>
            </div>

            <div class="edit row copyright" field="bamboo_footer_text" rel="global">
                <div class="col-12">
                    <!-- <p><?php print powered_by_link(); ?>. <?php print _e("All rights Reserved."); ?></p> -->
                    <p>Shopsystem & Template by <a href="https://www.droptienda.com/" target="_blank">Droptienda®</a> </p>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>

</div>

<?php
if(is_logged()){
    print chat_footer();
}
?>

<button id="to-top" class="btn" style="display: block;">
    <span class="material-icons">keyboard_arrow_up</span>
</button>
<!--Term  Modal -->
<div class="modal fade" id="termModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="termModal-content">
                    <module type="legals/shipping-info"/>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>
<?php include('footer_cart.php');
// if(is_admin()){
//     (function_exists('licence_drm')) ? print licence_drm() : '' ;
// }
?>


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

    // if ($('.lazy').length > 0) {
    //     $(function() {
    //         $('.lazy').Lazy();
    //     });
    // }
    
</script>
<!-- Plugins -->
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;language=en-GB&amp;key=AIzaSyDbN7i-eF7dlNNp-bxbERNomOGYpZld3B0"></script>

<script src="<?php print template_url(); ?>assets/js/libs/swiper/js/swiper.min.js"></script>
<script src="<?php print template_url(); ?>assets/plugins/elevatezoom/jquery.elevatezoom.js"></script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/masonry/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/masonry/isotope.pkgd.min.js"></script>

<script src="<?php print template_url(); ?>assets/js/libs/anime.min.js"></script>
<script src="<?php print template_url(); ?>assets/js/libs/particles.js"></script>
<script src="<?php print template_url(); ?>assets/js/libs/jquery.sticky-sidebar.min.js"></script>
<script>
    mw.lib.require('slick');
    mw.lib.require('collapse_nav');
</script>
<script src="<?php print template_url(); ?>assets/js/main.js"></script>

<script src="<?php print template_url(); ?>assets/js/fx.js"></script>




<?php
    if(file_exists(module_dir('')."global_code_add_for_template.php")){
        include module_dir('') . "global_code_add_for_template.php";
    }
?>

</body>
</html>
