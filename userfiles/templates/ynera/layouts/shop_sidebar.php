<?php
$showHeader = temp_shop_collapse();
?>
<style>
.categorySideBar .module-categories>.well>ul.nav>li ul {
    left: -200%;
    display: none !important;
    transition: 0.5s ease;
    opacity: 0;
    height: 0px;
    overflow: hidden;
}

.categorySideBar .module-categories>.well>ul.nav li.showThisSub>ul {
    display: block !important;
}

span.hs-toggle {
    position: absolute;
    height: 20px;
    width: 20px;
    background-color: #005c46;
    top: 15px;
    right: 0px;
    cursor: pointer;
    z-index: 1;
}

.categorySideBar .module-categories>.well>ul.nav li {
    position: relative;
}

span.hs-toggle:after {
    position: absolute;
    content: "+";
    color: #fff;
    font-size: 18px;
    line-height: 20px;
    text-align: center;
    width: 100%;
}

.categorySideBar .module-categories>.well>ul.nav li.showThisSub ul {
    padding-left: 20px;
    border: none;
    position: relative;
    left: 0;
    opacity: 1;
    height: auto;
    overflow: hidden;
}




span.hs-toggle {
    position: absolute;
    height: 21px;
    width: 20px;
    background-color: #005c46;
    top: 6px;
    right: 0px;
    cursor: pointer;
    z-index: 1;
}

.showThisSub>span.hs-toggle:after {
    content: "-";
}

span.viewMoreCategory {
    position: relative;
    border: 1px solid#005c46;
    display: block;
    margin: 15px auto;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    display: none;
}

span.viewMoreCategory:hover {
    background-color: #005c46;
    color: #fff;
}

@media only screen and (min-width: 768px) {
    .categorySideBar .module-categories {
        max-height: 760px;
        overflow-y: scroll;
        border-radius: 0px;
    }

    /* width */
    .categorySideBar .module-categories::-webkit-scrollbar {
        width: 3px;
    }

    /* Track */
    .categorySideBar .module-categories::-webkit-scrollbar-track {
        background: #fff;
    }

    /* Handle */
    .categorySideBar .module-categories::-webkit-scrollbar-thumb {
        background: #41544A;
    }

    /* Handle on hover */
    .categorySideBar .module-categories::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
}

@media only screen and (max-width: 767px) {
    span.viewMoreCategory {
        display: block;
    }

    .categorySideBar .module-categories>.well>ul.nav>li {
        display: none;
    }

    .categorySideBar .module-categories>.well>ul.nav.show_ucmAll>li {
        display: block;
    }

    .categorySideBar .module-categories>.well>ul.nav>li:first-child,
    .categorySideBar .module-categories>.well>ul.nav>li:nth-child(2),
    .categorySideBar .module-categories>.well>ul.nav>li:nth-child(3),
    .categorySideBar .module-categories>.well>ul.nav>li:nth-child(4),
    .categorySideBar .module-categories>.well>ul.nav>li:nth-child(5) {
        display: block;
    }
}
</style>

<div class="shop-sidebar">
    <div class="shop-sidebar-cat categorySideBar <?php print @$showHeader['sidebar']; ?>">
        <h5 class="shop-sidebar-heading edit" field="shop_sidebar_cat_heading" rel="content">PRODUCT CATEGORIES</h5>
        <div class="edit" field="cat_content_main_wrapper" rel="content">
            <module type="shop_categories" content-id="<?php print PAGE_ID; ?>" />
        </div>
    </div>

    <?php if (get_option('enable_wishlist', 'shop')) : ?>
    <div class="wishlist-widget">
        <h5 class="shop-sidebar-heading edit" field="shop_sidebar_wishlist_heading" rel="content">
            <?php _lang("Wunschzettel"); ?></h5>
        <div class="wishlist-widget-box">
            <ul class="mw-cats-menu" id="wishlist-list">

            </ul>
        </div>

        <?php if (is_logged()) { ?>
        <div id="wishlist-sidebar"></div>
        <p>&nbsp;</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Erstellen Sie eine neue Wunschliste
        </button>
        <?php } else { ?>
        <button data-toggle="modal" class="btn btn-primary login-modal" data-target="#loginModal">Login für
            Wunschliste</button>
        <?php } ?>
    </div>
    <?php endif; ?>

    <!-- <div class="shop-sidebar-image edit" field="shop_sidebar_image" rel="content">
        <img src="<?php print template_url(); ?>assets/image/product-sidebar-image.jpg" alt="">
    </div> -->

    <div class="sidebar-content edit allow-drop" field="shop_sidebar-content" rel="content">

    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titel der Wunschliste</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="<?php _e('Enter wishlist title'); ?>">
                        <small id="emailHelp" class="form-text text-muted red" style="display: none;">Bitte geben Sie
                            den Namen der Wunschliste ein</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-primary" onclick="create_sessions()">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenteredit" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titel der Wunschliste</label>
                        <input type="text" class="form-control" id="exampleInputEmailedit" aria-describedby="emailHelp"
                            placeholder="<?php _e('Enter wishlist title'); ?>">
                        <input type="hidden" class="form-control" id="exampleInputEmailedithide"
                            aria-describedby="emailHelp" placeholder="<?php _e('Enter wishlist title'); ?>">
                        <small id="emailHelp" class="form-text text-muted red" style="display: none;">Bitte geben Sie
                            den Namen der Wunschliste ein</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-primary" onclick="edit_sessions()">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function create_sessions() {
    let title = $('#exampleInputEmail1').val();
    const emailHelp = $('#emailHelp');
    emailHelp.hide();
    if (title.trim().length > 0) {
        $.post("<?php print api_url('set_wishlist_sessions'); ?>", {
            title: title
        }, function(sessions) {
            if (sessions === 'false') {
                emailHelp.show();
            } else {
                location.reload();
            }
        });
    } else {
        emailHelp.show();
    }
}

function edit_sessions() {
    let title = $('#exampleInputEmailedit').val();
    let titlehide = $('#exampleInputEmailedithide').val();
    const emailHelp = $('#emailHelp');
    emailHelp.hide();
    if (title.trim().length > 0) {
        $.post("<?php print api_url('edit_wishlist_sessions'); ?>", {
            title: title,
            titlehide: titlehide
        }, function(sessions) {
            if (sessions === 'false') {
                emailHelp.show();
            } else {
                location.reload();
            }
        });
    } else {
        emailHelp.show();
    }
}



jQuery(window).on('load', function() {
    if (jQuery(".categorySideBar .module-categories>.well>ul.nav>li").children("ul").length) {
        jQuery(".categorySideBar .module-categories>.well>ul.nav li").children("ul").parent().append(
            "<span class='hs-toggle'></span>");
    }



    jQuery('.categorySideBar .module-categories>.well>ul.nav li:has(ul)').addClass('hasSubMenu');


    jQuery(".hs-toggle").on("click", function() {
        $(this).parent().toggleClass("showThisSub");

    });


    if (jQuery(".categorySideBar .module-categories>.well>ul.nav>li").length > 5) {
        jQuery(".categorySideBar").append("<span class='viewMoreCategory'>weitere anzeigen</span>");
    }

    jQuery(".viewMoreCategory").on("click", function() {
        jQuery(".categorySideBar .module-categories>.well>ul.nav").toggleClass("show_ucmAll");

        var currentVMbtnText = jQuery(".viewMoreCategory").text();
        if (currentVMbtnText === "weitere anzeigen") {
            jQuery(".viewMoreCategory").html("ausblenden");
        } else {
            jQuery(".viewMoreCategory").html("weitere anzeigen");
        }
    });

});

$(document).ready(function() {
    $.get(`<?= api_url('get_wishlist_sessions'); ?>`, result => {
        const selected = [];
        if (result != 'false') {
            result.forEach(function(session) {
                $.post("<?= url('/') ?>/api/v1/wishlist_check", {
                    id: session['id']
                }, (res) => {

                    if (res.success) {
                        $("#wishlist-list").append('<li title="' + session['name'] +
                            '"><a href="shop?wishlist_id=' + session["id"] +
                            '" data-category-id="' + session['id'] + '" title="' +
                            session['name'] + '" class="depth-0">' + session[
                                'name'] +
                            '</a><button type="button" id="delete_sss" class="btn" data-toggle="modal" data-name="' +
                            session['name'] +
                            '" ><span class="material-icons">delete</span></button><button type="button" id="edit_sss" class="btn" data-toggle="modal" data-target="#exampleModalCenteredit" data-name="' +
                            session['name'] +
                            '" ><span class="material-icons">create</span></button></li>'
                        );

                    } else {
                        $("#wishlist-list").append('<li title="' + session['name'] +
                            '"><span class="depth-0">' + session['name'] +
                            '</span><button type="button" id="delete_sss" class="btn" data-toggle="modal" data-name="' +
                            session['name'] +
                            '" ><span class="material-icons">delete</span></button><button type="button" id="edit_sss" class="btn" data-toggle="modal" data-target="#exampleModalCenteredit" data-name="' +
                            session['name'] +
                            '" ><span class="material-icons">create</span></button></li>'
                        );
                    }

                });
            });
        }
    });
});
</script>