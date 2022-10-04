<?php if ($footer == 'true'): ?>
    <style>
        footer ul li a {
            display: block;
            color: #f3f3f3;
            text-decoration: none;
            padding: 10px 12px !important;
        }
        footer ul li {
            display: inline-block !important;
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

    <footer id="footer-section">
        <div class="footer-wrapper edit" field="sunshine-footer_main" rel="global">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-1">
                        <div class="footer-1-wrapper">
                            <p><?php print _lang('The purity of nature in harmony with a clear design.'); ?></p>
                            <div class="footer-logo">
                                <img src="<?php print template_url(); ?>assets/image/footer-logo.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-2">
                        <div class="footer-2-top">
                            <h5>Footer Menu</h5>
                        </div>
                        <module type="menu" template="footer" id="footer_menu" name="footer_menu"/>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-3">
                        <div class="footer-3-top">
                            <h5><?php print _lang('My account'); ?></h5>
                        </div>
                        <ul>
                            <li><a href="#">My account</a></li>
                            <li><a href="#">My wishlist</a></li>
                            <li><a href="#">My Orders</a></li>
                            <li><a href="#">Account details</a></li>
                            <li><a href="#">My Cart</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 footer-4">
                        <div class="footer-4-top">
                            <h5><?php print _lang('How can we help you?'); ?></h5>
                        </div>
                        <ul>
                            <li>
                                <p>Phone: +8800000000000</p>
                            </li>
                            <li>
                                <p>Time: 0:00 a.m. - 0:00 p.m.</p>
                            </li>
                            <li>
                                <p>Mail: info@abc.xyz.de</p>
                            </li>
                        </ul>
                        <div class="footer-social">
                            <module type="social_links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright edit" field="emotionss_footer_text_content" rel="global">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="footer-droptienda">
                            <p>Shopsystem & Template by <a href="https://www.droptienda.com/" target="_blank">Droptienda®</a> </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-card-image">
                            <span class="footer-card-per-image">
                                <i class="fa fa-cc-paypal" aria-hidden="true"></i>
                            </span>
                            <span class="footer-card-per-image">
                                <i class="fa fa-cc-visa" aria-hidden="true"></i>
                            </span>
                            <span class="footer-card-per-image">
                                <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>


</div>
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
<button id="to-top" class="btn" style="display: block;">
    <span class="material-icons">keyboard_arrow_up</span>
</button>

<?php
include('footer_cart.php');

if(is_admin()){
    (function_exists('licence_drm')) ? print licence_drm() : '' ;
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
    mw.lib.require('slick');
    mw.lib.require('collapse_nav');
</script>
<script src="<?php print template_url(); ?>assets/js/main.js"></script>

<script src="<?php print template_url(); ?>assets/js/fx.js"></script>

<!-- Owl Carousel -->
<script src="<?php print template_url(); ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php print template_url(); ?>assets/js/jquery.mousewheel.min.js"></script>

<!-- Elevate -->



<script src="<?php print template_url(); ?>assets/js/raising-main.js"></script>



<script>
    $(".raising-main-menu ul li a.dropdown-toggle .caret").on("click", function(){
        $(this).parent().parent().toggleClass("showDrop");
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

<?php
    if(file_exists(module_dir('')."global_code_add_for_template.php")){
        include module_dir('') . "global_code_add_for_template.php";
    }
?>
</body>
</html>