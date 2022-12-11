mw.require("content.js");
mw.on.hashParam("search", function() {
    mw.$('#pages_edit_container').attr("data-type", 'content/manager');
    var dis = this;
    if (dis !== '') {
        mw.$('#pages_edit_container').attr("data-keyword", dis);
        mw.url.windowDeleteHashParam('pg');
        mw.url.windowDeleteHashParam('brand')
        mw.url.windowDeleteHashParam('ean');
        mw.url.windowDeleteHashParam('sku');
        mw.$('#pages_edit_container').removeAttr("data-brand");
        mw.$('#pages_edit_container').removeAttr("data-ean");
        mw.$('#pages_edit_container').removeAttr("data-sku");

        mw.$('#pages_edit_container').attr("data-page-number", 1);
    } else {
        mw.$('#pages_edit_container').removeAttr("data-keyword");
        mw.url.windowDeleteHashParam('search')
    }
    mw.reload_module('#pages_edit_container');
});
mw.on.hashParam("brand", function() {
    mw.$('#pages_edit_container').attr("data-type", 'content/manager');
    var dis = this;
    if (dis !== '') {
        mw.$('#pages_edit_container').attr("data-brand", dis);
        mw.$('#pages_edit_container').removeAttr("data-keyword");
        mw.$('#pages_edit_container').removeAttr("data-ean");
        mw.$('#pages_edit_container').removeAttr("data-sku");
        mw.url.windowDeleteHashParam('pg');
        mw.url.windowDeleteHashParam('search');
        mw.url.windowDeleteHashParam('ean');
        mw.url.windowDeleteHashParam('sku');
    } else {
        mw.$('#pages_edit_container').removeAttr("data-brand");
    }
    mw.reload_module('#pages_edit_container');
});
mw.on.hashParam("ean", function() {
    mw.$('#pages_edit_container').attr("data-type", 'content/manager');
    var dis = this;
    if (dis !== '') {
        mw.$('#pages_edit_container').attr("data-ean", dis);
        mw.$('#pages_edit_container').removeAttr("data-keyword");
        mw.$('#pages_edit_container').removeAttr("data-brand");
        mw.$('#pages_edit_container').removeAttr("data-sku");
        mw.url.windowDeleteHashParam('pg');
        mw.url.windowDeleteHashParam('search')
        mw.url.windowDeleteHashParam('brand')
        mw.url.windowDeleteHashParam('sku')
    } else {
        mw.$('#pages_edit_container').removeAttr("data-ean");
    }
    mw.reload_module('#pages_edit_container');
});
mw.on.hashParam("sku", function() {
    mw.$('#pages_edit_container').attr("data-type", 'content/manager');
    var dis = this;
    if (dis !== '') {
        mw.$('#pages_edit_container').attr("data-sku", dis);
        mw.$('#pages_edit_container').removeAttr("data-keyword");
        mw.$('#pages_edit_container').removeAttr("data-brand");
        mw.$('#pages_edit_container').removeAttr("data-ean");
        mw.url.windowDeleteHashParam('pg');
        mw.url.windowDeleteHashParam('search')
        mw.url.windowDeleteHashParam('brand')
        mw.url.windowDeleteHashParam('ean')
    } else {
        mw.$('#pages_edit_container').removeAttr("data-sku");
    }
    mw.reload_module('#pages_edit_container');
});
mw.on.moduleReload('#<?php print $params['id'] ?>');


var mainTreeSetActiveItems = function() {
    if (typeof(mw.adminPagesTree) != 'undefined') {

        var hp = mw.url.getHashParams(location.hash);

        if (hp.action) {

            var arr = hp.action.split(':');
            if (arr[0] !== 'new') {
                mw.adminPagesTree.unselectAll();
            }
            var activeTreeItemIsPage = arr[0] === 'editpage' || arr[0] === 'showposts';
            var activeTreeItemIsCategory = arr[0] === 'editcategory' || arr[0] === 'showpostscat';

            if (activeTreeItemIsPage) {
                mw.adminPagesTree.select({
                    id: arr[1],
                    type: 'page'
                })
            }
            if (activeTreeItemIsCategory) {
                mw.adminPagesTree.select({
                    id: arr[1],
                    type: 'category'
                })
            }
        } else {
            mw.adminPagesTree.unselectAll();
        }
    }
};


$(document).ready(function() {

    mw.on.hashParam("page-posts", function() {
        mw_set_edit_posts(this);
    });
    mw.on.moduleReload("pages_tree_toolbar", function(e) {

    });
    mw.on.moduleReload("pages_edit_container", function() {});
    $(mwd.body).ajaxStop(function() {
        $(this).removeClass("loading");
    });

    mw.$(".mw-admin-go-live-now-btn").off('click');

});


mw.contentAction = {
    manage: function(type, id) {



        //   add_to_parent_page

        var id = id || 0;
        if (type === 'page') {
            mw_select_page_for_editing(id);
        } else if (type === 'post') {
            mw_select_post_for_editing(id);
        } else if (type === 'category') {
            mw_select_category_for_editing(id);
        } else if (type === 'mw_backward_prod') {
            mw_add_product(id);
        } else if (type !== '') {
            mw_select_custom_content_for_editing(0, type)
        }
        mw.$(".mw_action_nav").addClass("not-active");
        mw.$(".mw_action_" + type).removeClass("not-active");


    },
    create: function(a) {
        return mw.contentAction.manage(a, 0);
    }
}

function mw_delete_content($p_id) {
    mw.$('#pages_edit_container').attr('data-content-id', $p_id);
    mw.load_module('content/edit', '#pages_edit_container');
}

function mw_select_page_for_editing($p_id) {

    mw.$(".pages_tree_item.active-bg").removeClass('active-bg');
    mw.$(".category_element.active-bg").removeClass('active-bg');

    //var active_item = $('#pages_tree_container_<?php print $my_tree_id; ?> .active-bg').first();
    var active_item_is_page = $p_id;
    var active_item_is_parent = mw.url.windowHashParam("parent-page");
    if (!active_item_is_parent) {
        active_item_is_parent = $p_id;
    }
    var active_item = $('#pages_tree_container_<?php print $my_tree_id; ?> .content-item-' + active_item_is_parent)
        .first();


    var active_item_is_category = active_item.attr('data-category-id');


    active_item.addClass('active-bg');

    mw.$('#pages_edit_container').removeAttr('data-parent-page-id');

    mw.$('.mw-admin-go-live-now-btn').attr('content-id', active_item_is_parent);
    mw.$('#pages_edit_container').attr('content_type', 'page');
    mw.$('#pages_edit_container').removeAttr('subtype');
    mw.$('#pages_edit_container').removeAttr('content_type_filter');
    mw.$('#pages_edit_container').removeAttr('subtype_filter');
    mw.$('#pages_edit_container').removeAttr('data-parent-category-id');
    mw.$('#pages_edit_container').removeAttr('categories_active_ids');
    mw.$('#pages_edit_container').removeAttr('data-categories_active_ids');
    mw.$('#pages_edit_container').removeAttr('data-active_ids');
    mw.$('#pages_edit_container').removeAttr('active_ids');


    if (active_item_is_category != undefined) {
        //   mw.$('#pages_edit_container').attr('data-parent-category-id', active_item_is_category);
        var active_item_parent_page = $('#pages_tree_container_<?php print $my_tree_id; ?> .active-bg').parents(
            '.have_category').first();
        if (active_item_parent_page != undefined) {
            var active_item_is_page = active_item_parent_page.attr('data-page-id');
        } else {
            var active_item_parent_page = $('#pages_tree_container_<?php print $my_tree_id; ?> .active-bg').parents(
                '.is_page').first();
            if (active_item_parent_page != undefined) {
                var active_item_is_page = active_item_parent_page.attr('data-page-id');
            }
        }
    } else {
        mw.$('#pages_edit_container').removeAttr('data-parent-category-id');
    }

    mw.$('#pages_edit_container').removeAttr('data-parent-page-id');

    mw.$('#pages_edit_container').attr('data-page-id', $p_id);
    mw.$('#pages_edit_container').attr('data-type', 'content/edit');
    mw.$('#pages_edit_container').removeAttr('data-subtype');
    mw.$('#pages_edit_container').removeAttr('data-content-id');
    mw.$('#pages_edit_container').removeAttr('content-id');


    mw.$(".mw_edit_page_right").css("overflow", "hidden");
    edit_load('content/edit');
}

mw.on.hashParam("action", function() {

    if (this == false) {
        mw.tools.classNamespaceDelete(mwd.body, 'action-')
    }



    mainTreeSetActiveItems()

    if (this == false) {
        mw.$('#pages_edit_container').removeAttr('page-id');
        mw_clear_edit_module_attrs();
        mw.$(".fix-tabs").removeClass('fix-tabs');
    }


    mw.$(".js-top-save").hide();


    //  mw.tools.loading(mwd.body, true)
    window.scrollTo(0, 0);
    mw.$("#pages_edit_container").stop();
    mw.$('#pages_edit_container').removeAttr('mw_select_trash');
    mw.$(".mw_edit_page_right").css("overflow", "hidden");

    if (this == false) {
        mw.$(".mw_edit_page_right").css("overflow", "hidden");
        edit_load('content/manager');
        return false;
    }
    var arr = this.split(":");
    // $(mwd.body).removeClass("action-Array");
    // $(mwd.body).removeClass("action-");
    // $(mwd.body).removeClass("action-showposts");
    // $(mwd.body).removeClass("action-showpostscat");
    // $(mwd.body).removeClass("action-editpage");
    // $(mwd.body).removeClass("action-trash");
    // $(mwd.body).removeClass("action-editcategory");
    // $(mwd.body).removeClass("action-editpost");
    // $(mwd.body).removeClass("action-addsubcategory");
    mw.tools.classNamespaceDelete(mwd.body, 'action-')




    if (arr[0] === 'new') {
        mw.contentAction.create(arr[1]);
        if (arr[0]) {
            $(mwd.body).addClass("action-" + arr[0] + '-' + arr[1]);
        }
    } else {

        mw.$(".active-bg").removeClass('active-bg');
        mw.$(".mw_action_nav").removeClass("not-active");
        var active_item = mw.$(".item_" + arr[1]);

        if (arr[0]) {
            $(mwd.body).addClass("action-" + arr[0]);
        }
        if (arr[0] == 'showposts') {
            var active_item = mw.$(".content-item-" + arr[1]);
        } else if (arr[0] == 'showpostscat') {
            var active_item = mw.$(".category-item-" + arr[1]);
        }

        if (arr[0] === 'editpage') {
            mw_select_page_for_editing(arr[1])
        }


        if (arr[0] === 'trash') {
            mw_select_trash(arr[0])
        } else if (arr[0] === 'showposts') {
            mw_set_edit_posts(arr[1])
        } else if (arr[0] === 'showpostscat') {
            mw_set_edit_posts(arr[1], true)
        } else if (arr[0] === 'editcategory') {
            mw_select_category_for_editing(arr[1])
        } else if (arr[0] === 'editpost') {

            mw_select_post_for_editing(arr[1]);


        } else if (arr[0] === 'addsubcategory') {
            mw_select_add_sub_category(arr[1]);
        }
    }

});


edit_load = function(module, callback) {
    var spinner = mw.spinner({
        element: '#mw-content-backend',
        size: 40
    })
    var n = mw.url.getHashParams(window.location.hash)['new_content'];
    if (n == 'true') {
        var slide = false;
        mw.url.windowDeleteHashParam('new_content');
    } else {
        var slide = true;
    }
    var action = mw.url.windowHashParam('action');
    var holder = $('#pages_edit_container');

    var time = !action ? 300 : 0;
    if (!action) {
        mw.$('.fade-window').removeClass('active');
    }
    setTimeout(function() {
        mw.load_module(module, holder, function() {

            mw.$('.fade-window').addClass('active')
            if (callback) callback.call();
            spinner.remove()
        });
    }, time)


}

function mw_select_category_for_editing($p_id) {

    mw_clear_edit_module_attrs();

    mw.$(".pages_tree_item.active-bg").removeClass('active-bg');
    mw.$(".category_element.active-bg").removeClass('active-bg');


    var active_item = mw.$(".category-item-" + $p_id);
    active_item.addClass('active-bg');


    mw.$('#pages_edit_container').removeAttr('parent_id');
    mw.$('#pages_edit_container').removeAttr('data-parent-category-id');
    mw.$('#pages_edit_container').attr('data-category-id', $p_id);
    mw.$(".mw_edit_page_right").css("overflow", "hidden");
    edit_load('categories/edit_category');
}

function mw_select_add_sub_category($p_id) {

    mw_clear_edit_module_attrs();


    mw.$('#pages_edit_container').removeAttr('parent_id');
    mw.$('#pages_edit_container').attr('data-category-id', 0);
    mw.$('#pages_edit_container').attr('data-parent-category-id', $p_id);
    mw.$(".mw_edit_page_right").css("overflow", "hidden");
    edit_load('categories/edit_category');
}


function mw_set_edit_posts(in_page, is_cat, c) {
    var is_cat = typeof is_cat === 'function' ? undefined : is_cat;
    var cont = mw.$('#pages_edit_container');
    cont
        .removeAttr('data-content-id')
        .removeAttr('data-page-id')
        .removeAttr('data-category-id')
        .removeAttr('data-selected-category-id')
        .removeAttr('data-parent-category-id')
        .removeAttr('subtype')
        .removeAttr('data-subtype')
        .removeAttr('data-content-id')
        .removeAttr('parent_id')
        .removeAttr('is_shop');
    //  .attr('content-id', in_page);
    mw.$('#pages_edit_container').removeAttr('content_type');
    mw.$('#pages_edit_container').removeAttr('subtype');
    mw.$('#pages_edit_container').removeAttr('subtype_value');
    mw.$('#pages_edit_container').removeAttr('content_type_filter');
    mw.$('#pages_edit_container').removeAttr('subtype_filter');
    mw.$('#pages_edit_container').removeAttr('categories_active_ids');
    mw.$('#pages_edit_container').removeAttr('data-categories_active_ids');

    mw.$('#pages_edit_container').removeAttr('data-active_ids');
    mw.$('#pages_edit_container').removeAttr('active_ids');
    mw.$('#pages_edit_container').removeAttr('content-id');
    mw.$('#pages_edit_container').removeAttr('category-id');


    mw.$(".pages_tree_item.active-bg").removeClass('active-bg');
    mw.$(".category_element.active-bg").removeClass('active-bg');


    if (in_page != undefined && is_cat == undefined) {
        cont.attr('data-page-id', in_page);
        var active_item = mw.$(".content-item-" + in_page);
        active_item.addClass('active-bg');
    }

    if (in_page != undefined && is_cat != undefined) {
        cont.attr('data-category-id', in_page);
        var active_item = mw.$(".category-item-" + in_page);
        active_item.addClass('active-bg');
    }

    var cat_id = mw.url.windowHashParam("category_id");
    if (cat_id) {
        cont.attr('data-category-id', cat_id);
    }


    mw.load_module('content/manager', '#pages_edit_container');
}


function mw_clear_edit_module_attrs() {
    var container = mw.$('#pages_edit_container');
    container
        .removeAttr('content_type')
        .removeAttr('subtype')
        .removeAttr('data-parent-category-id')
        .removeAttr('data-category-id')
        .removeAttr('data-category-id')
        .removeAttr('data-category-id')
        .removeAttr('content-id')
        .removeAttr('data-page-id')
        .removeAttr('content_type_filter')
        .removeAttr('subtype_filter');
}

function mw_select_trash(c) {
    var container = mw.$('#pages_edit_container');
    container.removeAttr('data-content-id')
        .removeAttr('data-page-id')
        .removeAttr('data-category-id')
        .removeAttr('data-selected-category-id')
        .removeAttr('data-keyword')
        .removeAttr('content_type_filter')
        .removeAttr('subtype_filter');

    mw.load_module('content/trash', '#pages_edit_container', function() {
        typeof c === 'function' ? c.call() : '';
    });
}

function mw_select_custom_content_for_editing($p_id, $type) {

    var active_item = $('#pages_tree_container_<?php print $my_tree_id; ?> .active-bg').first();
    var active_item_is_page = active_item.attr('data-page-id');

    mw.$('#pages_edit_container').removeAttr('content_type_filter');
    mw.$('#pages_edit_container').removeAttr('subtype_filter');

    $subtype = '';
    var res = $type.split(".");

    if (typeof(res[1]) == 'string') {

        $type = res[0];
        $subtype = res[1];

    }

    mw.$('.mw-admin-go-live-now-btn').attr('content-id', $p_id);


    var active_item_is_category = active_item.attr('data-category-id');
    if (active_item_is_category != undefined) {

        mw.$('#pages_edit_container').attr('data-parent-category-id', active_item_is_category);

        var active_bg = mwd.querySelector('#pages_tree_container_<?php print $my_tree_id; ?> .active-bg');

        var active_item_parent_page = mw.tools.firstParentWithClass(active_bg, 'have_category');

        if (active_item_parent_page == false) {
            var active_item_parent_page = mw.tools.firstParentWithClass(active_bg, 'is_page');

        }

        if (active_item_parent_page == false) {
            var active_item_parent_page = mw.tools.firstParentWithClass(active_bg, 'pages_tree_item');

        }


        if (active_item_parent_page != false) {
            var active_item_is_page = active_item_parent_page.getAttribute('data-page-id');

        }

    } else {
        mw.$('#pages_edit_container').removeAttr('data-parent-category-id');

    }
    mw_clear_edit_module_attrs()

    if (active_item_is_page != undefined) {
        mw.$('#pages_edit_container').attr('data-parent-page-id', active_item_is_page);

    } else {
        mw.$('#pages_edit_container').removeAttr('data-parent-page-id');

    }
    mw.$('#pages_edit_container').removeAttr('data-subtype');
    mw.$('#pages_edit_container').removeAttr('is_shop');
    mw.$('#pages_edit_container').attr('data-content-id', $p_id);
    if ($subtype != undefined) {
        if ($subtype == 'product') {
            mw.$('#pages_edit_container').attr('is_shop', 'y');
        }

        mw.$('#pages_edit_container').attr('subtype', $subtype);
    } else {
        mw.$('#pages_edit_container').attr('subtype', 'post');
    }
    mw.$('#pages_edit_container').attr('content_type', $type);


    mw.$(".mw_edit_page_right").css("overflow", "hidden");
    edit_load('content/edit');
}

function mw_select_post_for_editing($p_id, $subtype) {

    var active_item = $('#pages_tree_container_<?php print $my_tree_id; ?> .active-bg').first();
    var active_item_is_page = active_item.attr('data-page-id');

    mw.$('#pages_edit_container')
        .removeAttr('data-parent-category-id')
        .removeAttr('data-category-id')
        .removeAttr('data-category-id')
        .removeAttr('data-category-id')
        .removeAttr('content-id')
        .removeAttr('content-id')
        .removeAttr('content-id')
        .removeAttr('subtype')
        .removeAttr('content_type_filter')
        .removeAttr('subtype_filter')
        .removeAttr('subtype_value')
        .removeAttr('data-page-id');


    mw.$('.mw-admin-go-live-now-btn').attr('content-id', $p_id);


    var active_item_is_category = active_item.attr('data-category-id');
    if (active_item_is_category != undefined) {

        mw.$('#pages_edit_container').attr('data-parent-category-id', active_item_is_category);

        var active_bg = mwd.querySelector('#pages_tree_container_<?php print $my_tree_id; ?> .active-bg');

        var active_item_parent_page = mw.tools.firstParentWithClass(active_bg, 'have_category');

        if (active_item_parent_page == false) {
            var active_item_parent_page = mw.tools.firstParentWithClass(active_bg, 'is_page');

        }

        if (active_item_parent_page == false) {
            var active_item_parent_page = mw.tools.firstParentWithClass(active_bg, 'pages_tree_item');

        }


        if (active_item_parent_page != false) {
            var active_item_is_page = active_item_parent_page.getAttribute('data-page-id');

        }

    } else {
        mw.$('#pages_edit_container').removeAttr('data-parent-category-id');

    }


    if (active_item_is_page != undefined) {
        mw.$('#pages_edit_container').attr('data-parent-page-id', active_item_is_page);

    } else {
        mw.$('#pages_edit_container').removeAttr('data-parent-page-id');

    }
    mw.$('#pages_edit_container').removeAttr('data-subtype');
    mw.$('#pages_edit_container').removeAttr('is_shop');
    mw.$('#pages_edit_container').attr('data-content-id', $p_id);
    if ($subtype != undefined) {
        if ($subtype == 'product') {
            mw.$('#pages_edit_container').attr('is_shop', 'y');
        }

        mw.$('#pages_edit_container').attr('subtype', $subtype);
    } else {
        mw.$('#pages_edit_container').attr('subtype', 'post');
    }
    mw.$(".mw_edit_page_right").css("overflow", "hidden");
    edit_load('content/edit');
}

function mw_add_product() {
    mw_select_post_for_editing(0, 'product')
}
$("#prductClassLayout").on("click", function() {

    var layoutStatusEnable = "";
    if ($('input#prductClassLayout').is(':checked')) {
        var layoutStatusEnable = "1";
    } else {
        var layoutStatusEnable = "0";
    };

    $.post("https://1-31-4-update.droptienda.eu/api/enableClassicProductLayout", {
        layoutStatus: layoutStatusEnable
    }).then((res, err) => {
        console.log(res, err);
    });

});


$("#prductReadmore").on("click", function() {
    var productReadmore = "";
    if ($('input#prductReadmore').is(':checked')) {
        var productReadmore = "1";

        $(".sc-limit").removeClass("hide");
    } else {
        var productReadmore = "0";
        $(".sc-limit").addClass("hide");
    };

    $.post("https://1-31-4-update.droptienda.eu/api/enableProductReadmore", {
        productReadmoreStatus: productReadmore
    }).then((res, err) => {
        console.log(res, err);
    });

    var productDescriptionLimit = $("#readMoreLimit").val();

    $.post("https://1-31-4-update.droptienda.eu/api/pdescriptionWordLimit", {
        pdLimitStatus: productDescriptionLimit
    }).then((res, err) => {
        console.log(res, err);
    });
});

$("#readMoreLimit").on("keyup", function() {
    var productDescriptionLimit = $("#readMoreLimit").val();
    // if ($('input#readMoreLimit').is(':checked')) {
    //     var productDescriptionLimit = "1";
    // }else{
    //     var productDescriptionLimit = "0";
    // };

    $.post("https://1-31-4-update.droptienda.eu/api/pdescriptionWordLimit", {
        pdLimitStatus: productDescriptionLimit
    }).then((res, err) => {
        console.log(res, err);
    });
});

$('.select_posts_for_action').on('change', function() {
    var all = mwd.querySelector('.select_posts_for_action:checked');
    if (all === null) {
        $('.js-bulk-actions').hide();
    } else {
        $('.js-bulk-actions').show();
    }
});

$('.js-bulk-action').on('change', function() {
    var selectedBulkAction = $('.js-bulk-action option:selected').val();
    if (selectedBulkAction == 'assign_selected_posts_to_category') {
        assign_selected_posts_to_category();
    } else if (selectedBulkAction == 'publish_selected_posts') {
        publish_selected_posts();
    } else if (selectedBulkAction == 'unpublish_selected_posts') {
        unpublish_selected_posts();
    } else if (selectedBulkAction == 'delete_selected_posts') {
        delete_selected_posts();
    }
});

$("#rss-submit").click(function() {
    alert("Handler for .click() called.");
});
mw.require('forms.js', true);
postsSort = function(obj) {

    var group = mw.tools.firstParentWithClass(obj.el, 'js-table-sorting');
    var parent_mod = mwd.getElementById('pages_edit_container_content_list');


    var others = group.querySelectorAll('.js-sort-btn'),
        i = 0,
        len = others.length;
    for (; i < len; i++) {
        var curr = others[i];
        if (curr !== obj.el) {
            $(curr).removeClass('ASC DESC active');
        }
    }
    obj.el.attributes['data-state'] === undefined ? obj.el.setAttribute('data-state', 0) : '';
    var state = obj.el.attributes['data-state'].nodeValue;

    var jQueryEl = $(obj.el);

    var tosend = {}
    tosend.type = obj.el.attributes['data-sort-type'].nodeValue;
    if (state === '0') {
        tosend.state = 'ASC';
        //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right ASC';
        obj.el.setAttribute('data-state', 'ASC');

        jQueryEl.find('i').removeClass('mdi-chevron-down');
        jQueryEl.find('i').addClass('mdi-chevron-up');
    } else if (state === 'ASC') {
        tosend.state = 'DESC';
        //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right DESC';
        obj.el.setAttribute('data-state', 'DESC');

        jQueryEl.find('i').removeClass('mdi-chevron-up');
        jQueryEl.find('i').addClass('mdi-chevron-down');
    } else if (state === 'DESC') {
        tosend.state = 'ASC';
        //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right ASC';
        obj.el.setAttribute('data-state', 'ASC');

        jQueryEl.find('i').removeClass('mdi-chevron-down');
        jQueryEl.find('i').addClass('mdi-chevron-up');
    } else {
        tosend.state = 'ASC';
        //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right ASC';
        obj.el.setAttribute('data-state', 'ASC');

        jQueryEl.find('i').removeClass('mdi-chevron-down');
        jQueryEl.find('i').addClass('mdi-chevron-up');
    }

    if (parent_mod !== undefined) {
        parent_mod.setAttribute('data-order', tosend.type + ' ' + tosend.state);
        mw.reload_module(parent_mod);
    }
}