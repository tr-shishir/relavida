<style>
.categorySideBar .module-categories>.well {
    border: 1px solid #fbdd05;
    padding: 10px;
    border-radius: 5px;
}

.categorySideBar .module-categories>.well>ul.nav {
    position: relative;
    overflow: hidden;
}

.categorySideBar .module-categories>.well>ul.nav>li {
    position: relative;
}

.categorySideBar .module-categories>.well>ul.nav li {
    position: relative;
    margin-bottom: 0px;
}

.categorySideBar .module-categories>.well>ul.nav li a {
    display: block;
    width: 100%;
    padding: 8px 10px;
    transition: .3s ease;
}

.categorySideBar .module-categories>.well>ul.nav>li ul {
    height: 0px;
    position: relative;
    overflow: hidden;
    left: -100%;
    transition: .7s ease;
    padding-left: 10px;
}

/* .categorySideBar .module-categories>.well>ul.nav li:hover>ul {
    left: 0px;
    height: auto;
} */

.categorySideBar .module-categories>.well>ul.nav li>a:hover {
    background-color: #f6f6f6;
}

/* .categorySideBar .module-categories>.well>ul.nav li span.hs-toggle {
    position: absolute;
    height: 20px;
    width: 20px;
    background-color: #282627;
    top: 10px;
    right: 5px;
    z-index: 1;
    color: #fbdd05;
    cursor: pointer;
    border-radius: 3px;
    display: none;
} */

/* .categorySideBar .module-categories>.well>ul.nav li span.hs-toggle:after {
    position: absolute;
    top: -3px;
    content: "+";
    width: 100%;
    text-align: center;
} */

/* .categorySideBar .module-categories>.well>ul.nav li.showThisSub span.hs-toggle:after {
    position: absolute;
    content: "-";
} */

/* .categorySideBar .module-categories>.well>ul.nav li.showThisSub ul {
    left: 0px;
    height: auto;
} */

span.viewMoreCategory {
    display: none;
}

.categorySideBar span.clickExpandBtn {
    display: none;
    border-radius: 3px;
}

@media only screen and (min-width: 992px) {
    .categorySideBar .module-categories .well>ul.nav li.showDropCat>ul {
        left: 0px;
        height: auto;
    }

    .categorySideBar  span.clickExpandBtn {
        cursor: pointer;
        position: absolute;
        right: 5px;
        top: 10px;
        z-index: 1;
        height: 25px;
        width: 25px;
        border: 1px solid #000;
        text-align: center;
        display: block;
    }

}

@media only screen and (max-width: 991px) {
    .categorySideBar .module-categories .well>ul.nav li.showDropCat>ul {
        left: 0px;
        height: auto;
    }

    .categorySideBar  span.clickExpandBtn {
        cursor: pointer;
        position: absolute;
        right: 5px;
        top: 10px;
        z-index: 1;
        height: 25px;
        width: 25px;
        border: 1px solid #000;
        text-align: center;
        display: block;
    }

    /* .categorySideBar .module-categories>.well>ul.nav li span.hs-toggle {
        display: block;
    } */

    span.viewMoreCategory {
        position: relative;
        display: block;
        background-color: #282627;
        color: #fbdd05;
        font-size: 15px;
        line-height: 22px;
        padding: 8px;
        text-align: center;
        cursor: pointer;
    }

    .categorySideBar .module-categories>.well>ul.nav>li {
        display: none;
    }

    .categorySideBar .module-categories>.well>ul.nav.nav-list.show_ucmAll>li {
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

.categorySideBar .module-categories>.well>ul.nav li.showDropCat>a.currentActiveCategory + ul.nav {
    display: flex !important;
}

.categorySideBar .module-categories>.well>ul.nav li.currentParents>ul.currentParents {
    display: flex !important;
    height: auto !important;
    left: 0;
}

</style>

<?php
$showHeader = temp_shop_collapse();
?>

<div class="allow-drop" rel="inherit">
    <div class="sidebar">

        <div class="sidebar__widget sidebar-cat categorySideBar <?php print @$showHeader['sidebar']; ?>">
            <h5><?php _lang("Kategorien", "templates/bamboo"); ?></h5>
            <hr>
            <div class="edit" field="cat_content_main" rel="content">
                <module type="shop_categories" content-id="<?php print PAGE_ID; ?>" />
            </div>
        </div>
        <?php if (get_option('enable_wishlist', 'shop')) : ?>
            <div class="sidebar__widget">
                <h5 class=""><?php _lang("Wunschzettel"); ?></h5>
                <hr>
                <div class="sidebar-box sidebar-custom-style">
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
        <div class="sidebar__widget edit" field="related_products_ab" rel="inherit">
            <h5>Über uns</h5>
            <hr>
            <div class="sidebar-custom-style edit" field="related_products_ab_text" rel="inherit">
                <p style="font-size:16px">
                    We're a digital focussed collective working with individuals and businesses to establish rich,
                    engaging online presences.
                </p>
            </div>
        </div>
        <div class="sidebar-content edit allow-drop" field="shop_sidebar-content" rel="content">

        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titel der Wunschliste</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="<?php _e('Enter wishlist title'); ?>">
                        <small id="emailHelp" class="form-text text-muted red" style="display: none;">Bitte geben Sie den Namen der Wunschliste ein</small>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titel der Wunschliste</label>
                        <input type="text" class="form-control" id="exampleInputEmailedit" aria-describedby="emailHelp"
                            placeholder="<?php _e('Enter wishlist title'); ?>">
                        <input type="hidden" class="form-control" id="exampleInputEmailedithide"
                            aria-describedby="emailHelp" placeholder="<?php _e('Enter wishlist title'); ?>">
                        <small id="emailHelp" class="form-text text-muted red" style="display: none;">Bitte geben Sie den Namen der Wunschliste ein</small>
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


$(window).on('load', function() {
    // if ($(".categorySideBar .module-categories>.well>ul.nav>li").children("ul").length) {
    //     $(".categorySideBar .module-categories>.well>ul.nav>li").children("ul").parent().addClass(
    //         "hasSubMenu");
    //     $(".categorySideBar .module-categories>.well>ul.nav>li").children("ul").parent().append(
    //         "<span class='hs-toggle'></span>");
    // }

    // $(".hs-toggle").on("click", function() {
    //     $(".hs-toggle").parent().removeClass("showThisSub");
    //     $(this).parent().addClass("showThisSub");

    // });


    if ($(".categorySideBar .module-categories>.well>ul.nav>li").length > 5) {
        $(".categorySideBar").append("<span class='viewMoreCategory'>weitere anzeigen</span>");
    }

    $(".viewMoreCategory").on("click", function() {
        $(".categorySideBar .module-categories>.well>ul.nav").toggleClass("show_ucmAll");

        var currentVMBtnText = $(".viewMoreCategory").text();
        if (currentVMBtnText === "weitere anzeigen") {
            $(".viewMoreCategory").html("ausblenden");
        } else {
            $(".viewMoreCategory").html("weitere anzeigen");
        }
    });

});

$(window).on("load",function(){
    $(".categorySideBar .module-categories ul li:has(ul)").addClass("hasSubCat");
    $(".hasSubCat").append("<span class='clickExpandBtn'><i class='fa fa-caret-down' aria-hidden='true'></i></span>");
});

$(window).bind("load resize",function(e){
    $(".categorySideBar .module-categories .well>ul.nav li .clickExpandBtn").on("click", function(){
        $(this).parent().toggleClass("showDropCat");
        $(this).children().toggleClass("fa-caret-up");
    });
});

$(document).ready(function(){
    $.get(`<?= api_url('get_wishlist_sessions'); ?>`, result => {
        const selected = [];
        if(result!='false'){
            result.forEach(function(session) {
                $.post("<?= url('/') ?>/api/v1/wishlist_check", {
                    id: session['id']
                }, (res) => {

                    if (res.success) {
                        $("#wishlist-list").append('<li title="' + session['name'] + '"><a href="shop?wishlist_id=' + session["id"] + '" data-category-id="' + session['id'] + '" title="' + session['name'] + '" class="depth-0">' + session['name'] + '</a><button type="button" id="delete_sss" class="btn" data-toggle="modal" data-name="' + session['name'] + '" ><span class="material-icons">delete</span></button><button type="button" id="edit_sss" class="btn" data-toggle="modal" data-target="#exampleModalCenteredit" data-name="' + session['name'] + '" ><span class="material-icons">create</span></button></li>');

                    } else {
                        $("#wishlist-list").append('<li title="' + session['name'] + '"><span class="depth-0">' + session['name'] + '</span><button type="button" id="delete_sss" class="btn" data-toggle="modal" data-name="' + session['name'] + '" ><span class="material-icons">delete</span></button><button type="button" id="edit_sss" class="btn" data-toggle="modal" data-target="#exampleModalCenteredit" data-name="' + session['name'] + '" ><span class="material-icons">create</span></button></li>');
                    }

                });
            });
        }
    });
});
</script>