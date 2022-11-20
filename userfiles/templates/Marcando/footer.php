<?php if ($footer == 'true'): ?>
    <footer class="footer edit" rel="global" field="marcando_footer_content">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="footer-logo">
                            <img src="<?php print template_url(); ?>assets/image/logo.png" alt="">
                        </div>
                        <div class="footer-address">
                            <p>Collins Street West, Victoria</p>
                            <p>8007, Australia.</p>
                        </div>
                        <div class="footer-map-link">
                            <a href="">Show on map</a>
                        </div>
                        <div class="footer-social">
                            <module type="social_links" id="footer_socials" />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="footer-help">
                            <h4>Need Help</h4>
                            <p class="footer-helpline">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                +88000000000
                            </p>
                            <div class="footer-available-time">
                                <p>Monday – Friday : 9:00 – 20:00</p>
                                <p>Saturday: 11:00 – 14:00</p>
                            </div>
                            <p class="footer-mail-address">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                abc@abc.com
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-4">

                                <h4 class="footer-link-header">Footer Menu</h4>
                                <div class="footer-link">
                                    <module type="menu" template="footer" id="footer_menu" name="footer_menu" />
                                </div>

                            </div>
                            <div class="col-md-4">

                                <h4 class="footer-link-header">Account</h4>
                                <div class="footer-link">
                                    <ul>
                                        <li>
                                            <a href="">My account</a>
                                        </li>
                                        <li>
                                            <a href="">Order Tracking</a>
                                        </li>
                                        <li>
                                            <a href="">Checkout</a>
                                        </li>
                                        <li>
                                            <a href="">Wishlist</a>
                                        </li>
                                        <li>
                                            <a href="">Privacy Policy</a>
                                        </li>
                                        <li>
                                            <a href="">Help</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="col-md-4">

                                <h4 class="footer-link-header">Our Stories</h4>
                                <div class="footer-link">
                                    <ul>
                                        <li>
                                            <a href="">New York</a>
                                        </li>
                                        <li>
                                            <a href="">London</a>
                                        </li>
                                        <li>
                                            <a href="">Los Angeles</a>
                                        </li>
                                        <li>
                                            <a href="">Chicago</a>
                                        </li>
                                        <li>
                                            <a href="">Las Vegas</a>
                                        </li>
                                        <li>
                                            <a href="">Miami</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="copyright-text">Shopsystem & Template by <a href="https://www.droptienda.com/" target="_blank">Droptienda®</a></p>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-list">
                            <span>
                                <i class="fab fa-cc-visa" aria-hidden="true"></i>
                            </span>
                            <span>
                                <i class="fab fa-cc-mastercard" aria-hidden="true"></i>
                            </span>
                            <span>
                                <i class="fab fa-cc-paypal" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
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

    $(window).on('load', function () {
        if ($(window).width() < 991) {
            if ($('.homepageCategoryList').length > 0) { 
                $('<div class="header-bottom-category-heading hero-cat-heading"><span><i class="fa fa-bars" aria-hidden="true"></i>All Categories</span></div>').insertBefore( ".header-banner" );
                $('.homepageCategoryList').addClass('hide');
                $('.hero-cat-heading').on('click', function(){
                    $('.homepageCategoryList').toggleClass('hide');
                });


                $('.homepageCategoryList ul li.has-sub').append('<span class="subcat-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>')


                $('.homepageCategoryList ul li.has-sub span.subcat-arrow').on('click', function(){
                    $(this).siblings( ".subCatWrapper" ).toggleClass('showSubCW');
                });
            }
        }

        if ($(window).width() > 992) {}

        if ($('.homepageCategoryList').length > 0) { 
            var homepageCategoryHeight = $('.homepageCategoryList').height(); 
            var setSubcategoryHeight = homepageCategoryHeight+'px';
            $('.homepageCategoryList .subCatWrapper').css('max-height','unset');
            $('.homepageCategoryList .subCatWrapper').css('height',setSubcategoryHeight);
        }
    });
    

    // if ($('.lazy').length > 0) {
    //     $(function() {
    //         $('.lazy').Lazy();
    //     });
    // }
    $(document).ready(function(){
        $(".inner-page .breadcrumb").addClass("container");
        
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
