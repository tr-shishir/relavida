



<script>

$(document).ready(function(){
    $("#layout_search_key").keyup(function(){
        var layout_search_key = $(this).val();
        $("#sidebar_navigation_layout_information ul li").each(function(){
            search_layout_id =  $(this).children('a').attr('href');
            sidebar_layout_li = $(this);
            $(search_layout_id).each(function(){
                if($(this).text().search(new RegExp(layout_search_key, "gi")) < 0) {
                    $(search_layout_id).find(".highlight-wrapper").contents().unwrap();
                    $(search_layout_id).find(".highlight-wrapper").remove();
                    sidebar_layout_li.fadeOut();
                    $('.collapse'+search_layout_id.replace("#", "-")).removeClass('show');
                    $(search_layout_id).css('display', 'none');
                }else{
                    sidebar_layout_li.show();
                    $(search_layout_id).css('display', 'block');
                    $(search_layout_id).find(".highlight-wrapper").contents().unwrap();
                    $(search_layout_id).find(".highlight-wrapper").remove();
                    $('.collapse'+search_layout_id.replace("#", "-")).removeClass('show');
                    $(search_layout_id+" *").each(function() {
                        if($(this).children().length==0 || ($(this).children().length == 1 && $(this).children('br').length > 0)) {
                            if(layout_search_key.length > 0){
                                $(this).html($(this).text().replace(new RegExp(layout_search_key,"gi"), '<span class="highlight-wrapper">$&</span>'));
                                $('.collapse'+search_layout_id.replace("#", "-")).addClass('show');
                            }
                        }
                    });
                }
            });
        });
    });

    //SideNav Sho Hide On Mobile Toggle
    $('.sidenav-open-close-for-mobile').on('click', function(){
        $('.fwidht-sidebar').toggleClass('show-sidenav');
    });
    $('.fw-page-title-lists ul li a').on('click', function(){
        $('.fwidht-sidebar').removeClass('show-sidenav');
    });
});

function sidebar_module_info_delete(page_id,m_id,l_id){
    $.post('<?php print url('/api/v1/delete_faq_sidebar') ?>',{ page_id:page_id, m_id:m_id ,l_id:l_id}, function (res) {
        if(res.success){
            $.post( mw.settings.api_url + 'mw_post_update' );
            location.reload();
        }
    });

}


function sidebar_module_info_edit(active_module_id,faq){
    current_page_id = '<?php print PAGE_ID; ?>';
    if($('#layout_icon').val()){
        $('.demo-icon').removeClass($('#layout_icon').val());
    }

    $('#layout_name_set').val('');
    if(faq == true){
        $('#layout_name_field').hide();
    }
    $('#layout_icon').val('');
    $.ajax({
        type:"POST",
        url: "<?=api_url('get_module_info_for_edit');?>",
        data:{active_module_id,current_page_id},
        success: function(response){
            if(response.message != 'error'){
                $('#layout_name_set').val(response.message[0]['option_value']);
                $('#layout_icon').val(response.message[0]['option_value2']);
                $('.demo-icon').addClass(response.message[0]['option_value2']);
                console.log(response.message[0]['id']);
            }
        }
    });
    $("#current-module-id").val(active_module_id);
    $("#sidebar_nav_module_info_edit_modal").modal('show');
}
function save_module_name_for_sidebar_nav(){
    module_name = $('#layout_name_set').val();
    module_icon = $('#layout_icon').val();
    current_page_id = '<?php print PAGE_ID; ?>';
    current_module_id = $("#current-module-id").val();
    $.ajax({
        type:"POST",
        url: "<?=api_url('save_module_name_for_sidebar_nav');?>",
        data:{module_name,module_icon,current_module_id,current_page_id},
        success: function(response){
            if(response.message == 'success'){
                $("#sidebar_nav_module_info_edit_modal").hide();
                mw.notification.success("successfully Saved");
                location.reload();
            }else{
                mw.notification.error("Error");
            }
        }
    });
}


var icons = [{ icon: 'fa fa-music' }, { icon: 'fa fa-search' }, { icon: 'fa fa-envelope' }, { icon: 'fa fa-heart' }, { icon: 'fa fa-star' }, { icon: 'fa fa-star' }, { icon: 'fa fa-user' }, { icon: 'fa fa-film' }, { icon: 'fa fa-th-large' }, { icon: 'fa fa-th' }, { icon: 'fa fa-th-list' }, { icon: 'fa fa-check' }, { icon: 'fa fa-times' }, { icon: 'fa fa-search-plus' }, { icon: 'fa fa-search-minus' }, { icon: 'fa fa-power-off' }, { icon: 'fa fa-signal' }, { icon: 'fa fa-cog' }, { icon: 'fa fa-trash' }, { icon: 'fa fa-home' }, { icon: 'fa fa-file' }, { icon: 'fa fa-clock' }, { icon: 'fa fa-road' }, { icon: 'fa fa-download' }, { icon: 'fa fa-inbox' }, { icon: 'fa fa-play-circle' },{ icon: 'fa fa-list-alt' }, { icon: 'fa fa-lock' }, { icon: 'fa fa-flag' }, { icon: 'fa fa-headphones' }, { icon: 'fa fa-volume-off' }, { icon: 'fa fa-volume-down' }, { icon: 'fa fa-volume-up' }, { icon: 'fa fa-qrcode' }, { icon: 'fa fa-barcode' }, { icon: 'fa fa-tag' }, { icon: 'fa fa-tags' }, { icon: 'fa fa-book' }, { icon: 'fa fa-bookmark' }, { icon: 'fa fa-print' }, { icon: 'fa fa-camera' }, { icon: 'fa fa-font' }, { icon: 'fa fa-bold' }, { icon: 'fa fa-italic' }, { icon: 'fa fa-text-height' }, { icon: 'fa fa-text-width' }, { icon: 'fa fa-align-left' }, { icon: 'fa fa-align-center' }, { icon: 'fa fa-align-right' }, { icon: 'fa fa-align-justify' }, { icon: 'fa fa-list' }, { icon: 'fa fa-outdent' }, { icon: 'fa fa-indent' },{ icon: 'fa fa-map-marker' }, { icon: 'fa fa-adjust' }, { icon: 'fa fa-tint' }, { icon: 'fa fa-share-square' }, { icon: 'fa fa-check-square' }, { icon: 'fa fa-step-backward' }, { icon: 'fa fa-fast-backward' }, { icon: 'fa fa-backward' }, { icon: 'fa fa-play' }, { icon: 'fa fa-pause' }, { icon: 'fa fa-stop' }, { icon: 'fa fa-forward' }, { icon: 'fa fa-fast-forward' }, { icon: 'fa fa-step-forward' }, { icon: 'fa fa-eject' }, { icon: 'fa fa-chevron-left' }, { icon: 'fa fa-chevron-right' }, { icon: 'fa fa-plus-circle' }, { icon: 'fa fa-minus-circle' }, { icon: 'fa fa-times-circle' }, { icon: 'fa fa-check-circle' }, { icon: 'fa fa-question-circle' }, { icon: 'fa fa-info-circle' }, { icon: 'fa fa-crosshairs' }, { icon: 'fa fa-times-circle' }, { icon: 'fa fa-check-circle' }, { icon: 'fa fa-ban' }, { icon: 'fa fa-arrow-left' }, { icon: 'fa fa-arrow-right' }, { icon: 'fa fa-arrow-up' }, { icon: 'fa fa-arrow-down' }, { icon: 'fa fa-share' }, { icon: 'fa fa-expand' }, { icon: 'fa fa-compress' }, { icon: 'fa fa-plus' }, { icon: 'fa fa-minus' }, { icon: 'fa fa-asterisk' }, { icon: 'fa fa-exclamation-circle' }, { icon: 'fa fa-gift' }, { icon: 'fa fa-leaf' }, { icon: 'fa fa-fire' }, { icon: 'fa fa-eye' }, { icon: 'fa fa-eye-slash' }, { icon: 'fa fa-exclamation-triangle' }, { icon: 'fa fa-plane' }, { icon: 'fa fa-calendar' }, { icon: 'fa fa-random' }, { icon: 'fa fa-comment' }, { icon: 'fa fa-magnet' }, { icon: 'fa fa-chevron-up' }, { icon: 'fa fa-chevron-down' }, { icon: 'fa fa-retweet' }, { icon: 'fa fa-shopping-cart' }, { icon: 'fa fa-folder' }, { icon: 'fa fa-folder-open' },{ icon: 'fa fa-camera-retro' }, { icon: 'fa fa-key' }, { icon: 'fa fa-cogs' }, { icon: 'fa fa-comments' },{ icon: 'fa fa-star-half' }, { icon: 'fa fa-heart' },{ icon: 'fa fa-trophy' },{ icon: 'fa fa-upload' }, { icon: 'fa fa-lemon' }, { icon: 'fa fa-phone' }, { icon: 'fa fa-square' }, { icon: 'fa fa-bookmark' }, { icon: 'fa fa-phone-square' },{ icon: 'fa fa-unlock' }, { icon: 'fa fa-credit-card' }, { icon: 'fa fa-rss' }, { icon: 'fa fa-hdd' }, { icon: 'fa fa-bullhorn' }, { icon: 'fa fa-bell' }, { icon: 'fa fa-certificate' },{ icon: 'fa fa-arrow-circle-left' }, { icon: 'fa fa-arrow-circle-right' }, { icon: 'fa fa-arrow-circle-up' }, { icon: 'fa fa-arrow-circle-down' }, { icon: 'fa fa-globe' }, { icon: 'fa fa-wrench' }, { icon: 'fa fa-tasks' }, { icon: 'fa fa-filter' }, { icon: 'fa fa-briefcase' }, { icon: 'fa fa-arrows-alt' }, { icon: 'fa fa-users' }, { icon: 'fa fa-link' }, { icon: 'fa fa-cloud' }, { icon: 'fa fa-flask' }, { icon: 'fa fa-paperclip' },{ icon: 'fa fa-square' }, { icon: 'fa fa-bars' }, { icon: 'fa fa-list-ul' }, { icon: 'fa fa-list-ol' }, { icon: 'fa fa-strikethrough' }, { icon: 'fa fa-underline' }, { icon: 'fa fa-table' }, { icon: 'fa fa-magic' }, { icon: 'fa fa-truck' },{ icon: 'fa fa-caret-down' }, { icon: 'fa fa-caret-up' }, { icon: 'fa fa-caret-left' }, { icon: 'fa fa-caret-right' }, { icon: 'fa fa-columns' }, { icon: 'fa fa-sort' }, { icon: 'fa fa-envelope' },{ icon: 'fa fa-undo' }, { icon: 'fa fa-gavel' },{ icon: 'fa fa-comment' }, { icon: 'fa fa-comments' }, { icon: 'fa fa-bolt' }, { icon: 'fa fa-sitemap' }, { icon: 'fa fa-umbrella' }, { icon: 'fa fa-clipboard' }, { icon: 'fa fa-lightbulb' },{ icon: 'fa fa-user-md' }, { icon: 'fa fa-stethoscope' }, { icon: 'fa fa-suitcase' }, { icon: 'fa fa-bell' }, { icon: 'fa fa-coffee' },{ icon: 'fa fa-building' }, { icon: 'fa fa-hospital' }, { icon: 'fa fa-ambulance' }, { icon: 'fa fa-medkit' }, { icon: 'fa fa-fighter-jet' }, { icon: 'fa fa-beer' }, { icon: 'fa fa-h-square' }, { icon: 'fa fa-plus-square' }, { icon: 'fa fa-angle-double-left' }, { icon: 'fa fa-angle-double-right' }, { icon: 'fa fa-angle-double-up' }, { icon: 'fa fa-angle-double-down' }, { icon: 'fa fa-angle-left' }, { icon: 'fa fa-angle-right' }, { icon: 'fa fa-angle-up' }, { icon: 'fa fa-angle-down' }, { icon: 'fa fa-desktop' }, { icon: 'fa fa-laptop' }, { icon: 'fa fa-tablet' }, { icon: 'fa fa-mobile' }, { icon: 'fa fa-circle' }, { icon: 'fa fa-quote-left' }, { icon: 'fa fa-quote-right' }, { icon: 'fa fa-spinner' }, { icon: 'fa fa-circle' }, { icon: 'fa fa-reply' },{ icon: 'fa fa-folder' }, { icon: 'fa fa-folder-open' }, { icon: 'fa fa-smile' }, { icon: 'fa fa-frown' }, { icon: 'fa fa-meh' }, { icon: 'fa fa-gamepad' }, { icon: 'fa fa-keyboard' }, { icon: 'fa fa-flag' }, { icon: 'fa fa-flag-checkered' }, { icon: 'fa fa-terminal' }, { icon: 'fa fa-code' }, { icon: 'fa fa-reply-all' }, { icon: 'fa fa-star-half' }, { icon: 'fa fa-location-arrow' }, { icon: 'fa fa-crop' },{ icon: 'fa fa-question' }, { icon: 'fa fa-info' }, { icon: 'fa fa-exclamation' }, { icon: 'fa fa-superscript' }, { icon: 'fa fa-subscript' }, { icon: 'fa fa-eraser' }, { icon: 'fa fa-puzzle-piece' }, { icon: 'fa fa-microphone' }, { icon: 'fa fa-microphone-slash' },{ icon: 'fa fa-calendar' }, { icon: 'fa fa-fire-extinguisher' }, { icon: 'fa fa-rocket' },{ icon: 'fa fa-chevron-circle-left' }, { icon: 'fa fa-chevron-circle-right' }, { icon: 'fa fa-chevron-circle-up' }, { icon: 'fa fa-chevron-circle-down' },{ icon: 'fa fa-anchor' }, { icon: 'fa fa-unlock-alt' }, { icon: 'fa fa-bullseye' }, { icon: 'fa fa-ellipsis-h' }, { icon: 'fa fa-ellipsis-v' }, { icon: 'fa fa-rss-square' }, { icon: 'fa fa-play-circle' }, { icon: 'fa fa-minus-square' }, { icon: 'fa fa-minus-square' }, { icon: 'fa fa-female' }, { icon: 'fa fa-male' }, { icon: 'fa fa-archive' }, { icon: 'fa fa-bug' },{ icon: 'fa fa-university' }, { icon: 'fa fa-graduation-cap' }, { icon: 'fa fa-language' }, { icon: 'fa fa-fax' }, { icon: 'fa fa-building' }, { icon: 'fa fa-child' }, { icon: 'fa fa-paw' },{ icon: 'fa fa-cube' }, { icon: 'fa fa-cubes' }, { icon: 'fa fa-recycle' }, { icon: 'fa fa-car' }, { icon: 'fa fa-taxi' }, { icon: 'fa fa-tree' }, { icon: 'fa fa-database' }, { icon: 'fa fa-file-pdf' }, { icon: 'fa fa-file-word' }, { icon: 'fa fa-file-excel' }, { icon: 'fa fa-file-powerpoint' }, { icon: 'fa fa-file-image' }, { icon: 'fa fa-file-archive' }, { icon: 'fa fa-file-audio' }, { icon: 'fa fa-file-video' }, { icon: 'fa fa-file-code' }, { icon: 'fa fa-life-ring' },{ icon: 'fa fa-paper-plane' }, { icon: 'fa fa-paper-plane' }, { icon: 'fa fa-history' }, { icon: 'fa fa-paragraph' }, { icon: 'fa fa-share-alt' }, { icon: 'fa fa-share-alt-square' }, { icon: 'fa fa-bomb' },{ icon: 'fa fa-tty' }, { icon: 'fa fa-binoculars' }, { icon: 'fa fa-plug' },{ icon: 'fa fa-newspaper' }, { icon: 'fa fa-wifi' }, { icon: 'fa fa-calculator' }, { icon: 'fa fa-bell-slash' },{ icon: 'fa fa-trash' }, { icon: 'fa fa-copyright' }, { icon: 'fa fa-at' },{ icon: 'fa fa-paint-brush' }, { icon: 'fa fa-birthday-cake' }, { icon: 'fa fa-toggle-off' }, { icon: 'fa fa-toggle-on' }, { icon: 'fa fa-bicycle' }, { icon: 'fa fa-bus' }, { icon: 'fa fa-cart-plus' }, { icon: 'fa fa-cart-arrow-down' },{ icon: 'fa fa-ship' }, { icon: 'fa fa-user-secret' }, { icon: 'fa fa-motorcycle' }, { icon: 'fa fa-street-view' }, { icon: 'fa fa-heartbeat' }, { icon: 'fa fa-venus' }, { icon: 'fa fa-mars' }, { icon: 'fa fa-mercury' }, { icon: 'fa fa-transgender' }, { icon: 'fa fa-transgender-alt' }, { icon: 'fa fa-venus-double' }, { icon: 'fa fa-mars-double' }, { icon: 'fa fa-venus-mars' }, { icon: 'fa fa-mars-stroke' }, { icon: 'fa fa-mars-stroke-v' }, { icon: 'fa fa-mars-stroke-h' }, { icon: 'fa fa-neuter' }, { icon: 'fa fa-server' }, { icon: 'fa fa-user-plus' }, { icon: 'fa fa-user-times' }, { icon: 'fa fa-bed' }, { icon: 'fa fa-train' }, { icon: 'fa fa-subway' }];

var itemTemplate = $('.icon-picker-list').clone(true).html();

$('.icon-picker-list').html('');

// Loop through JSON and appends content to show icons
$(icons).each(function(index) {
var itemtemp = itemTemplate;
var item = icons[index].icon;

if (index == selectedIcon) {
    var activeState = 'active'
} else {
    var activeState = ''
}

itemtemp = itemtemp.replace(/{{item}}/g, item).replace(/{{index}}/g, index).replace(/{{activeState}}/g, activeState);

$('.icon-picker-list').append(itemtemp);
});

// Variable that's passed around for active states of icons
var selectedIcon = null;

$('.icon-class-input').each(function() {
if ($(this).val() != null) {
    $(this).siblings('.demo-icon').addClass($(this).val());
}
});

// To be set to which input needs updating
var iconInput = null;

// Click function to set which input is being used
$('.picker-button').click(function() {
// Sets var to which input is being updated
iconInput = $(this).siblings('.icon-class-input');
// Shows Bootstrap Modal
$('#iconPicker').modal('show');
// Sets active state by looping through the list with the previous class from the picker input
selectedIcon = findInObject(icons, 'icon', $(this).siblings('.icon-class-input').val());
// Removes any previous active class
$('.icon-picker-list a').removeClass('active');
// Sets active class
$('.icon-picker-list a').eq(selectedIcon).addClass('active');
});

// Click function to select icon
$(document).on('click', '.icon-picker-list a', function() {
// Sets selected icon
selectedIcon = $(this).data('index');

// Removes any previous active class
$('.icon-picker-list a').removeClass('active');
// Sets active class
$('.icon-picker-list a').eq(selectedIcon).addClass('active');
});

// Update icon input
$('#change-icon').click(function() {
iconInput.val(icons[selectedIcon].icon);
iconInput.siblings('.demo-icon').attr('class', 'demo-icon');
iconInput.siblings('.demo-icon').addClass(icons[selectedIcon].icon);
$('#iconPicker').modal('hide');
console.log(iconInput);
console.log(icons[selectedIcon].icon);
});

function findInObject(object, property, value) {
for (var i = 0; i < object.length; i += 1) {
    if (object[i][property] === value) {
        return i;
    }
}
}

$(".fw-page-title-lists ul a").on("click", function (e) {
e.preventDefault();
const href = $(this).attr("href");
$("html, body").animate({ scrollTop: $(href).offset().top-80 }, 900);
});


$(window).scroll(function() {
    var scrollPos = $(document).scrollTop();
    $('#sidebar_navigation_layout_information a').each(function () {

        var currLink = $(this);
        var currLinkParent=$(this).parent();
        var refElement = $(currLink.attr("href"));
        if ((refElement.position().top-100) <= scrollPos && (refElement.position().top-100) + refElement.height() > scrollPos) {
            $('#sidebar_navigation_layout_information ul li').removeClass("active");
            currLinkParent.addClass("active");
        }
        else{
            currLinkParent.removeClass("active");
        }
    });
});
</script>
