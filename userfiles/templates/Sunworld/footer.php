<?php if ($footer != 'true'): ?>
    <footer class="edit p-t-100 p-b-60" rel="global" field="footer-main-wrapper">
        <div class="container">
            <div class="edit nodrop safe-mode" field="active_footer" rel="global">
                <div class="row">
                    <div class="col-lg-3 allow-drop">
                        <div class="logo nodrop">
                            <img src="<?php print template_url(); ?>assets/img/logo-footer.png" class="safe-element"/>
                        </div>
                        <module type="social_links" id="footer-socials"/>
                    </div>
                    <div class="col-md-4 col-lg-2  allow-drop m-b-footer">
                        <span class="small-title safe-element"><?php print _lang('Menu', 'templates/active'); ?></span>
                        <module type="menu" template="footer" id="footer_menu" name="footer_menu"/>
                    </div>
                    <div class="col-md-4 col-lg-2 allow-drop m-b-footer">
                        <span class="small-title safe-element"><?php print _lang('More links', 'templates/active'); ?></span>
                        <module type="menu" template="footer" name="footer_menu_2" id="footer_menu_2"/>
                    </div>
                    <!-- <div class="col-6 col-md-4 col-lg-2 allow-drop">
                        <span class="small-title safe-element"><?php print _lang('Other links', 'templates/active'); ?></span>
                        <module type="menu" template="footer" name="footer_menu_3" id="footer_menu_3"/>
                    </div> -->
                    <div class="col-12 col-md-4 col-lg-3 allow-drop footer-address m-b-footer">
                        <span class="small-title safe-element"><?php print _lang('Address', 'templates/active'); ?></span>
                        <p>
                            <?php print _lang('Sofia, Bulgaria (map) Bul. "Cherni Vruh“<br/>
                            <small>we are in the new building</small>', 'templates/active'); ?>
                        </p>

                        <br/>

                        <span class="small-title"><?php print _lang('Contact', 'templates/active'); ?></span>
                        <div class="row nodrop">
                            <div class="col-12">
                                <div style="margin-bottom:10px;">
                                    <p style="margin-bottom:5px;padding-bottom: 0px;">Jobs:</p>
                                    <p>jobs@yourcompany.com</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div style="margin-bottom:10px;">
                                    <p style="margin-bottom:5px;padding-bottom: 0px;">Business:</p>
                                    <p>info@yourcompany.com</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div style="">
                                    <p style="margin-bottom:5px;padding-bottom: 0px;">Website:</p>
                                    <p>www.yourcompany.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row copyright">
                <div class="col-12">
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
<button id="to-top" class="btn" style="display: block;"></button>

<?php include('footer_cart.php');?>

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
</body>
</html>