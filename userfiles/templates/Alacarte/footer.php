<?php if ($footer != 'true'): ?>
    <footer class="p-t-100 p-b-60 edit placefooter" field="place_footer_main_content" rel="global">
        <div class="container">
            <div class="edit nodrop safe-mode" field="theplace_footer" rel="global">
                <div class="row">
                    <div class="mx-auto col-xl-11">
                        <div class="row">

                            <div class="mx-auto text-center col-lg-3 allow-drop">
                                <div class="logo nodrop">
                                    <img src="<?php print template_url(); ?>assets/img/logo-footer.png" class="safe-element"/>
                                </div>

                                <h3 class="small-title"><?php print _lang('Orders for parties, requests for <br /> meals day ahead.', 'templates/theplace'); ?></h3>

                                <p><?php print _lang('+359 878 123 456,<br /> +359 889 321 654<br /> info@theplace.email<br /> Sofia 1000, Bulgaria. Main Street 99', 'templates/theplace'); ?></p>

                                <module type="social_links" id="footer-socials"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="edit row copyright" field="bamboo_footer_text" rel="global">
                <div class="mx-auto col-xl-12 allow-drop text-center">
                    <module type="menu" template="footer" id="footer_menu" name="footer_menu"/>
                    <br/><br/>
                </div>
                <div class="col-12">
                    <!-- <p><?php print powered_by_link(); ?>. <?php print _e("All rights Reserved."); ?></p> -->
                    <p>Shopsystem & Template by <a href="https://www.droptienda.com/" target="_blank">Droptienda®</a> </p>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>

</div>

<button id="to-top" class="btn" style="display: block;"></button>

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
<?php
if(is_logged()){
    print chat_footer();
}
?>

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