            <footer class="nk-footer">
                <div class="nk-footer-cont edit nk-footer_content" rel="global" field="footer_main_content">
                    <div class="container" field="template-footer" rel="global">
                        <div class="container text-xs-center">
                            <div class="footer-menu">
                                <module type="menu" template="navbar" id="footer_menu" name="footer_menu"/>
                            </div>
                            <div class="nk-footer-social">
                                <module type="social_links" id="social-icons-footer" template="default" />
                            </div>

                            <div class="nk-footer-text">
                            <p>Shopsystem & Template by <a href="https://www.droptienda.com/" target="_blank">Droptienda®</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END: Footer -->
        </div>
        <?php
            if(is_logged()){
                print chat_footer();
            }

            if(is_admin()){
                (function_exists('licence_drm')) ? print licence_drm() : '' ;
            }
        ?>

        <script type="text/javascript" src="{TEMPLATE_URL}assets/js/TweenMax.js"></script>

        <script>
            // $(document).ready(function(){
            //     var totatShopLayout = $('[data-type="shop/products"]').length;
            //     var initialshopCount = 1;
            //     $('[data-type="shop/products"]').each(function(){
            //         $(this).addClass('productModuleNumber-'+initialshopCount);
            //         initialshopCount++;
            //     });


            //     // for (let i = 1; i < totatShopLayout+1; i++) {
            //     //     $('.productModuleNumber-'+i+" .js-example-basic-multiple").select2();
            //     //     console.log(i);
            //     // }

            // });

        </script>

<script>
    $(document).ready(function () {
        // alert('start');
        // $("#main-navigation li").has('ul').children('a').append('<span class="caret"></span>');
    });
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