<?php if ($footer == 'true'): ?>
<footer class="edit p-t-60 p-b-60 nodrop" rel="global" field="footer-main-wrapper">
    <div class="container nodrop">
        <div class="edit allow-drop safe-mode" field="new-world_footer" rel="global">
            <div class="row">
                <div class="col-12 col-lg-12 col-xl-2 mx-auto logo-column text-center m-b-20 allow-drop">
                    <img src="<?php print template_url(); ?>assets/img/logo_footer.png" alt="" class="m-b-10" />
                    <br />
                    <br />
                </div>

                <div class="col-12 col-lg-12 col-xl-6 mx-auto text-center m-b-40 allow-drop">
                    <module type="menu" template="simple" id="footer_menu" name="footer_menu" />
                    <br />
                    <p><?php print _lang('Droptienda is free open source drag and dop website builder and CMS. It is under MIT license and we use Laravel  PHP framework', 'templates/new-world'); ?>
                    </p>
                </div>

                <div class="col-12 col-sm col-lg-7 col-xl mx-auto text-white text-center allow-drop">
                    <h6 class="m-t-5">Social Networks</h6>

                    <module type="social_links" id="footer_socials" />
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12 text-center">
                <p>Shopsystem & Template by <a href="https://www.droptienda.com/" target="_blank">Droptienda®</a> </p>
            </div>
        </div>
    </div>
</footer>

<div class="bg-pines d-block d-lg-none bg-default" style="height: 50px;"></div>
<?php endif; ?>

</div>
<?php
if(is_logged()){
    print chat_footer();
}
?>
<button id="to-top" class="btn" style="display: block;"></button>

<?php
include('footer_cart.php');
?>


<script>
mw.lib.require('slick');
mw.lib.require('collapse_nav');
</script>

<script src="<?php print template_url(); ?>dist/main.min.js"></script>

<!--Term  Modal -->
<div class="modal fade" id="termModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="termModal-content">
                    <module type="legals/shipping-info" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>
<!--Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <div id="checkout-product">
              <module type="shop/cart" template="quick_checkout" />
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
    // $(".header-cat .nav>li>ul>li").has("ul").addClass("sub-cat");
    $('.nav-for-mobile .navbar_new ul').removeClass();
    $('.nav-for-mobile .navbar_new li').removeClass();
    $('.nav-for-mobile .navbar_new li a').removeClass();

    // Mean Menu JS
    $('.nav-for-mobile .navbar_new').meanmenu({
        meanScreenWidth: "1200",
        meanMenuContainer: '.nav-for-mobile'
    });
});
jQuery(window).on('load', function() {
    // if(jQuery(".categorySideBar .module-categories>.well>ul.nav>li").children("ul").length) {
    //     jQuery(".categorySideBar .module-categories>.well>ul.nav>li").children("ul").parent().addClass("hasSubMenu");
    //     jQuery(".categorySideBar .module-categories>.well>ul.nav>li").children("ul").parent().append("<span class='hs-toggle'></span>");
    // }

    // jQuery(".hs-toggle").on("click", function(){
    //     // jQuery(".module-categories").toggleClass("showSub");
    //     //$(".hs-toggle").parent().removeClass("showThisSub");
    //     $(this).parent().toggleClass("showThisSub");

    // });


    if (jQuery(".categorySideBar .module-categories>.well>ul.nav>li").length > 5) {
        jQuery(".categorySideBar").append("<span class='viewMoreCategory'>weitere anzeigen</span>");
    }

    jQuery(".viewMoreCategory").on("click", function() {
        jQuery(".categorySideBar .module-categories>.well>ul.nav").toggleClass("show_ucmAll");

        var currentVMBtnText = jQuery(".viewMoreCategory").text();
        if (currentVMBtnText === "weitere anzeigen") {
            jQuery(".viewMoreCategory").html("ausblenden");
        } else {
            jQuery(".viewMoreCategory").html("weitere anzeigen");
        }
    });

});

$(window).on("load", function() {
    $(".categorySideBar .module-categories ul li:has(ul)").addClass("hasSubCat");
    $(".hasSubCat").append(
        "<span class='clickExpandBtn'><i class='fa fa-caret-down' aria-hidden='true'></i></span>");
});

$(window).bind("load resize", function(e) {
    $(".categorySideBar .module-categories .well>ul.nav li .clickExpandBtn").on("click", function() {
        $(this).parent().toggleClass("showDropCat");
        $(this).children().toggleClass("fa-caret-up");
    });
});

$("body").mousemove(function(event) {
    if ($('#mw-dialog-holder-module-settings-header_menu').length > 0) {
        $("#mw-dialog-holder-module-settings-header_menu .mw-dialog-header").mouseenter(function() {
            $('#mw-dialog-holder-module-settings-header_menu .mw-dialog-header').append('<span class="closeandReload"></span>');
            $('#mw-dialog-holder-module-settings-header_menu .closeandReload').on('click', function() {
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