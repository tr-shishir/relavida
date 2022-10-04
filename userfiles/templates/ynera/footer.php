<style>
.footer-menu-wrapper {
    text-align: center;
}

.footer-menu-wrapper #footer_menu {
    margin-top: 20px;
}

.footer-menu-wrapper #footer_menu ul {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.footer-menu-wrapper #footer_menu ul li:not(:last-child) {
    margin-right: 20px;

}

.footer-menu-wrapper #footer_menu ul li a {
    color: #b3cfc8;
    transition: color .3s ease-in-out;
}
</style>

<?php if ($footer == 'true'): ?>
<footer class="footer-wrapper edit" rel="global" field="ynera-footer_9">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h4 class="widget-heading">ÜBER YNERA</h4>
                    <p class="body-text light">
                        Freude am Rasen erleben! Darum geht’s bei YNERA. Wir sind Ihr
                        kompetenter Ansprechpartner rund um Ihren Bedarf an hochwertigen
                        Rasenpflege Produkten wie Rasen Dünger, Rasen Samen, Roll-rasen,
                        Bewässerungssysteme u.v.m.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget widget-post">
                    <h4 class="widget-heading">NEUE BEITRÄGE</h4>
                    
                    <div class="footer-blog">
                        <module type="posts/" template="skin-3"/>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget widget-nav">
                    <h4 class="widget-heading">NAVIGATION</h4>
                    <div class="footer-link">
                        <ul class="nav-items">
                            <li><a href="#">Rasendünger </a></li>
                            <li><a href="#">Rasensamen </a></li>
                            <li><a href="#">Rasendünger </a></li>
                            <li><a href="#">Rasenbewässerung </a></li>
                            <li><a href="#">Rasenkanten </a></li>
                            <li><a href="#">Über uns </a></li>
                            <li><a href="#">Blog </a></li>
                            <li><a href="#">Kontakt </a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer-menu-wrapper">
            <module type="menu" template="footer" id="footer_menu" name="footer_menu" />

        </div>
    </div>
    <div class="footer-copyrights">
        <p class="copyright-text">Shopsystem & Template by <a href="https://www.droptienda.com/"
                target="_blank">Droptienda®</a></p>
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



<script>
$(window).on('load resize', function() {
    if ($(window).width() < 991) {
        $('.navigation-holder>nav').addClass('dt_mobile_nav');
        $(".navigation-holder>nav li").has("ul").addClass("hasSubForMobile");


        $("li.hasSubForMobile>a").on("click", function() {
            $(this).parent().toggleClass("activeSubforMobile");
        });

    } else {
        $('.navigation-holder>nav').removeClass('dt_mobile_nav');
        $(".navigation-holder>nav li").has("ul").removeClass("hasSubForMobile");
    }

});

$("body").mousemove(function(event) {
    if ($('#mw-dialog-holder-module-settings-header-menu').length > 0) {
        $("#mw-dialog-holder-module-settings-header-menu .mw-dialog-header").mouseenter(function() {
            $('#mw-dialog-holder-module-settings-header-menu .mw-dialog-header').append(
                '<span class="closeandReload"></span>');
            $('#mw-dialog-holder-module-settings-header-menu .closeandReload').on('click', function() {
                location.reload();
            });
        });
    }
});

$(window).on('load', function() {
    if ($(window).width() < 991) {
        if ($('.homepageCategoryList').length > 0) {
            $('<div class="header-bottom-category-heading hero-cat-heading"><span><i class="fa fa-bars" aria-hidden="true"></i>All Categories</span></div>')
                .insertBefore(".header-banner");
            $('.homepageCategoryList').addClass('hide');
            $('.hero-cat-heading').on('click', function() {
                $('.homepageCategoryList').toggleClass('hide');
            });


            $('.homepageCategoryList ul li.has-sub').append(
                '<span class="subcat-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>')


            $('.homepageCategoryList ul li.has-sub span.subcat-arrow').on('click', function() {
                $(this).siblings(".subCatWrapper").toggleClass('showSubCW');
            });
        }
    }

    if ($(window).width() > 992) {}

    if ($('.homepageCategoryList').length > 0) {
        var homepageCategoryHeight = $('.homepageCategoryList').height();
        var setSubcategoryHeight = homepageCategoryHeight + 'px';
        $('.homepageCategoryList .subCatWrapper').css('max-height', 'unset');
        $('.homepageCategoryList .subCatWrapper').css('height', setSubcategoryHeight);
    }
});


// if ($('.lazy').length > 0) {
//     $(function() {
//         $('.lazy').Lazy();
//     });
// }
$(document).ready(function() {
    $(".inner-page .breadcrumb").addClass("container");

});

$("body").mousemove(function(event) {
    if ($('#mw-dialog-holder-module-settings-header-menu').length > 0) {
        $("#mw-dialog-holder-module-settings-header-menu .mw-dialog-header").mouseenter(function() {
            $('#mw-dialog-holder-module-settings-header-menu .mw-dialog-header').append(
                '<span class="closeandReload"></span>');
            $('#mw-dialog-holder-module-settings-header-menu .closeandReload').on('click', function() {
                location.reload();
            });
        });
    }
});
</script>
<!-- Plugins -->
<script
    src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;language=en-GB&amp;key=AIzaSyDbN7i-eF7dlNNp-bxbERNomOGYpZld3B0">
</script>

<script src="<?php print template_url(); ?>assets/js/libs/swiper/js/swiper.min.js"></script>
<script src="<?php print template_url(); ?>assets/plugins/elevatezoom/jquery.elevatezoom.js"></script>
<script type="text/javascript"
    src="<?php print template_url(); ?>assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
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
<script src="<?php print template_url(); ?>assets/js/script.js"></script>


<!--Pricing Ultra Layout-->
<script>
// const ultraToggleBtn = document.querySelector('#ultra-toggle-btn');
// const ultraToggleTable = document.querySelector('#ultra-toggle-table');
// const accToggle = document.querySelector('.acc-toggle');

// ultraToggleBtn.addEventListener('click', function(){
//     ultraToggleTable.classList.toggle("show-table");

//     if (accToggle.innerText === "+") {
//         accToggle.innerText = "-";
//     } else {
//         accToggle.innerText = "+";
//     }
// });
</script>



<?php
    if(file_exists(module_dir('')."global_code_add_for_template.php")){
        include module_dir('') . "global_code_add_for_template.php";
    }
?>

</body>

</html>