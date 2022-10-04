<div class="modal fade" id="shippingInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php _e('Shipping Information'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <td><b><?php _e('Shipping Name'); ?></b> </td>
                        <td id="shipping-name"></td>

                    </tr>
                    <tr>
                        <td><b><?php _e('Shipping City'); ?></b> </td>
                        <td id="shipping-city"></td>

                    </tr>
                    <tr>
                        <td><b><?php _e('Shipping Zip'); ?></b> </td>
                        <td id="shipping-zip"> </td>

                    </tr>
                    <tr>
                        <td><b><?php _e('Shipping Country'); ?></b> </td>
                        <td id="shipping-country"> </td>

                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="parcelInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php _e('Parcel Information'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            <table class="table table-bordered">
                    <tr>
                        <td><b><?php _e('Parcel Number'); ?></b> </td>
                        <td id="parcel-number"></td>

                    </tr>
                    <tr>
                        <td><b><?php _e('Parcel Service'); ?></b> </td>
                        <td id="parcel-service"></td>

                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
if(isset(get_content_by_id(CONTENT_ID)['url']) && get_content_by_id(CONTENT_ID)['url'] == 'shop'): ?>
    <?php if(is_logged()): ?>
        <script type="text/javascript" src="<?php print modules_url(); ?>microweber/js/bootstrap-toggle.min.js"></script>
        <link href="<?php print modules_url(); ?>microweber/css/bootstrap-toggle.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <?php endif; ?>
<?php else: ?>
    <script type="text/javascript" src="<?php print modules_url(); ?>microweber/js/bootstrap-toggle.min.js"></script>
    <link href="<?php print modules_url(); ?>microweber/css/bootstrap-toggle.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<?php endif; ?>

<style>

.manage-posts-holder-inner .card-body .row {
    flex-wrap: nowrap !important;
}
.product-quantity_number .input-group .quantity-field[type=number] {
    -moz-appearance:textfield;
}
.navigation .menu .list {
    padding: 15px 0;
    max-width: 1100px;
}
#header-menu .owl-nav {
    position: absolute;
    content: '';
    width: 100%;
    top: 18px;
}
#header-menu .owl-nav button:focus{
    outline: 0;
}
#header-menu .owl-nav button.owl-prev {
    position: absolute;
    content: '';
    top: 0;
    left: -10px;
    font-size: 24px;
}
#header-menu .owl-nav button.owl-next {
    position: absolute;
    content: '';
    top: 0;
    right: -10px;
    font-size: 24px;
}
#header-menu .owl-dots {
    display: none;
}
#header-menu .list .owl-stage>.owl-item>li>a{
    padding: 8px 30px !important;
    font-size:20px;
}

#header-menu .list .owl-stage>.owl-item>li.active>a{
    font-weight:700;
}
#header-menu ul li ul li>a {
    color: #fff;
}
#header-menu .owl-carousel .owl-stage-outer {
    overflow: unset !important;
    clip-path: inset( -100vw 0 -100vw 0 );
}
@media (max-width: 1366px) and (min-width: 1281px){
    .navigation .menu .list {
        padding: 15px 0;
        max-width: 800px;
    }
}
@media (max-width: 1280px) and (min-width: 1201px){
    .navigation .menu .list {
        padding: 15px 0;
        max-width: 630px;
    }
}
@media (max-width: 1200px) and (min-width: 1025px){
    .navigation .menu .list {
        padding: 15px 0;
        max-width: 600px;
    }
}
@media (max-width: 1024px) and (min-width: 1000px){
    .navigation .menu .list {
        padding: 15px 0;
        max-width: 430px;
    }
}
</style>
<script>
    <?php if(is_admin()): ?>
        $(document).ready(function() {
            $.ajax({
                type: "POST",
                url: "<?=api_url('licence_drm_connect')?>",
                success: function(response) {
                    if(response.message){
                        window.onUsersnapCXLoad = function(api) {
                            api.init();
                        }
                        var script = document.createElement('script');
                        script.async = 1;
                        script.src = 'https://widget.usersnap.com/load/9c33bd00-3564-480d-b89f-b104f6f0fb90?onload=onUsersnapCXLoad';
                        document.getElementsByTagName('head')[0].appendChild(script);
                    }
                }
            });
        });
    <?php endif; ?>
    // $(window).on('load resize', function () {
    // if($(window).width() > 991){
    //     // $('#header-menu li').has('.depth-0').each(function(){
    //         // var lwidth = $(this).width();
    //         // lsum += parseInt($(this).innerWidth(), 10);
    //         // console.log($(this).innerWidth());
    //         //
    //     // });

    //     // $('.owl-carousel-menu').css('background-color','red');
    //     // console.log(ul_menu);
    //     // console.log(lsum);
    //     // console.log(lsum > ul_menu);
    //     $('.owl-carousel-menu').owlCarousel({
    //         // rewind: true,
    //         loop: false,
    //         margin: 0,
    //         nav: true,
    //         slideBy: 1,
    //         autoWidth:true,
    //     });
    //     var inner_w = $('.owl-stage').width();
    //     var outer_w = $('.owl-stage-outer').width();
    //     $('.owl-carousel-menu').owlCarousel('destroy');
    //     $('.owl-carousel-menu').owlCarousel({
    //         // rewind: true,
    //         loop: false,
    //         margin: 0,
    //         nav: inner_w > outer_w,
    //         slideBy: 1,
    //         autoWidth:true,
    //     });
    //     // $('.owl-carousel-menu').trigger('refresh.owl.carousel');
    // }

    // function recalcCarouselWidth(carousel) {
    //     var $stage = carousel.find('.owl-stage'),
    //         stageW = $stage.width(),
    //     $el = $('.owl-item'),
    //     elW = 0;
    //     $el.each(function() {
    //         elW += $(this)[0].getBoundingClientRect().width;
    //     });
    //     if ( elW > stageW ) {
    //     console.log('elW maggiore di stageW: ' +  elW + ' > ' + stageW);
    //     $stage.width( Math.ceil( elW ) );
    //     }
    // }
    // $(window).on('resize', function(e){
    //     recalcCarouselWidth( $('.owl-carousel') );
    // }).resize();
    // $('.owl-carousel').on('refreshed.owl.carousel', function(event) {
    //     recalcCarouselWidth( $('.owl-carousel') );
    // });
    // $('.owl-carousel').on('onResize.owl.carousel', function(event) {
    //     recalcCarouselWidth( $('.owl-carousel') );
    // });

// });
</script>

<script type="text/javascript">
    window.base_url = "<?php print url("/"); ?>";
    mw.on('mw.cart.qty', function (event, data) {
        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val() ,taxr:$("#p_tax").val() }, (res) => {
            if(res.success){
                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
            }
        });
    });
    mw.on('mw.cart.add', function (event, data) {
        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
            if(res.success){
                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
            }
        });
    });
    mw.on('mw.cart.remove', function (event, data) {
        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
            if(res.success){
                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
            }
        });
        if($('.js-shopping-cart-quantity').html() == 0){
            $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                mw.reload_module('shop/cart');
                mw.reload_module('shop/checkout');
            });
        }
    });
</script>

<script>
    $(document).ready(function() {

        setInterval(() => {
            $('.ordreChat_Modal').each(function() {
                if ($(this).is(':visible')) {
                    let order_id = $(this).attr('data-order-id');
                    load_order_chat(order_id);
                }
            });
        }, 5000);

        function load_order_chat(id) {
            var chatIcon= "<i class='fa fa-circle'></i>";
            $.post("<?= url('/') ?>/api/v1/get_chat", {
                id: id
            }, res => res.data)
                .then(res => res.data)
                .then(data => {
                    var status_badge = '';
                if(parseInt(data.online) > 5){
                    // offline
                    status_badge = chatIcon + "Offline";
                    $(".status_badge").addClass("red");
                    $(".status_badge").html(status_badge);
                }else{
                    // online
                    status_badge =chatIcon + "Online";
                    $(".status_badge").addClass("green");
                    $(".status_badge").html(status_badge);
                }
                $('#order-chat-modal-'+id).find('.status_badge').html(status_badge)
                    if (data.messages) {
                        let message_list = '';
                        data.messages.forEach(msg => {
                            let recipient = msg.recipient;
                            let sender = msg.sender
                            // console.log(msg);
                            message_list += `
                                <li class="clearfix getChat_massage">
                                        <div class="order-outgoing-msg-info message-data ${recipient == 'me'? 'text-right' : ''}">
                                        <span class="message-data-time" title="${msg.created_at}">
                                            <span class="name">${sender && sender.name ? sender.name : ''}</span>,
                                            <span class="time">${msg.time}</span>
                                        </span>
                                        <br>
                                        <span class="email">${sender && sender.email? sender.email : ''}</span>
                                    </div>
                                    <div class="message ${recipient == 'me'? 'my-message float-right' : 'other-message'}">${msg.message}</div>
                                </li>
                            `;
                        })

                        let el_id = `#order-chat-modal-` + id + ` #chat-area` + id;
                        $(el_id).html(message_list)
                        $(`#notifi-${id}`).html('00')
                        $("#chat-area" + id).stop().animate({
                            scrollTop: $("#chat-area" + id)[0].scrollHeight
                        }, 1000);
                    }





                })
                .then(o => {
                    $.post("<?= url('/') ?>/api/v1/seen_chat", {
                        id: id
                    }).catch(err => {})
                })
                .catch(err => {
                    // console.log(err)
                })
        }
        /**
         * Auto Question Reply
         */
        $('.known-questions').on('click', 'button', function(){
            let question = $(this).text();
            $('.ordreChat_Modal').each(function() {
                if ($(this).is(':visible')) {
                    let order_id = $(this).attr('data-order-id');
                    $("#emojionearea"+order_id).val(question);

                    $("#submitOrderText"+order_id).trigger('click');
                }
            });
        });
    })
</script>

<?php
if( isset($_SERVER['HTTP_ACCEPT']) && strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) === false ) {
    ?>
    <script>
        $(document).ready(function() {

            $('.rawurlstyle').each(function(){
                var valuerow = $(this).attr('data-raw-url');
                $(this).css("backgroundImage","url("+ valuerow +")");
            });

            $('.rawurlsrc').each(function(){
                var valuerow = $(this).attr('data-raw-url');
                $(this).attr("src",valuerow);
            });
        });
    </script>
    <?php
}
?>

<style>
    #price-on-request-modal .modal-dialog {
        margin-top: 100px;
        max-width: 1200px;
    }
    #price-on-request-offer .form-group {
        box-shadow: 0 0 2px 1px #e3e3e3;
        padding: 5px;
    }

    #price-on-request-offer .form-group .dropdown {
        border: 1px solid #ccc;
    }

    img.variant-image {
        margin-right: 10px;
        height: 60px !important;
        width: 60px !important;
        object-fit: cover;
        max-height: none;
    }


    #price-on-request-modal .form-group >label,
    #price-on-request-offer > label{
        font-weight: 700;
    }

    .three-col-img .mw-col img{
        height: 300px !important;
        width: 100% !important;
        object-fit: cover;
    }

    .two-col-img .mw-col img{
        height: 400px !important;
        width: 100% !important;
        object-fit: cover;
    }
</style>
<?php
 $user_info = get_user();
 if($user_info){
    $user_first_name = $user_info['first_name'];
    $user_last_name = $user_info['last_name'];
    $user_full_name = $user_first_name.' '.$user_last_name;
    $user_email = $user_info['email'];
 }else{
    $user_first_name = "";
    $user_last_name = "";
    $user_email = "";
    $user_full_name = "";
 }
?>
<div class="modal fade" id="price-on-request-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="javascript:send_price_on_request_info();">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="price_request_header"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName"><?php _e('First Name'); ?> *</label>
                                        <input type="text" class="form-control" value="<?=$user_first_name?>" name="firstName" id="firstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName"><?php _e('Last Name'); ?> *</label>
                                        <input type="text" class="form-control" value="<?=$user_last_name?>" name="lastName" id="lastName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email"><?php _e('Email'); ?> *</label>
                                        <input type="email" class="form-control" value="<?=$user_email?>" name="email" id="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phnNumber"><?php _e('Phone Number'); ?></label>
                                        <input type="text" class="form-control" name="phnNumber" id="phnNumber">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="street"><?php _e('Street'); ?> *</label>
                                        <input type="text" class="form-control" name="street" id="street" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city"><?php _e('City'); ?> *</label>
                                        <input type="text" class="form-control" name="city" id="city" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state"><?php _e('State'); ?> *</label>
                                        <input type="text" class="form-control" name="state" id="state" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zip_code"><?php _e('Zip Code'); ?> *</label>
                                        <input type="text" class="form-control" name="zip_code" id="zip_code" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php _e('Country'); ?> *</label>
                                        <?php
                                            $all_country = DB::table('tax_rates')->get('country');
                                            // dd($all_country);
                                        ?>
                                        <select class="form-control" required name="country" id="country">
                                            <?php if($all_country): ?>
                                                <?php foreach($all_country as $country): ?>
                                                    <option value="<?php print $country->country; ?>"><?php print $country->country; ?></option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="Germany">Germany</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php _e('Comment'); ?></label>
                                        <textarea class="form-control" name="comment" id="comment" rows="6"></textarea>
                                    </div>
                                </div>
                                <div id="price-on-request-offer" class="col-md-12">
                                </div>
                            </div>
                        </div>


                        <!-- <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="true" name="sendme">
                                    Please send me a copy
                                </label>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close'); ?></button>
                    <button type="submit" class="btn btn-primary" ><?php _e('Send'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    function priceModal(){
        $("#price-on-request-modal").modal("show");
    }

    price_on_request_product_id = null;
    function price_on_request_product_id_get(id,name){
        $('#price_request_header').html("<p style='font-size: 24px;'><b>Stellen Sie Ihre unverbindliche Preisanfrage</b></p> <p><b style='font-size: 20px;'>Produktname:</b> <span style='font-size: 18px;'>"+name+"</span></p>");
        $('#comment').text("Sehr geehrte Damen und Herren, ich bin auf das Produkt "+name+" aufmerksam geworden und möchte Sie bitten, mir unverbindliches Angebot als Preisauskunft zukommen zu lassen."+"\n\nMit freundlichen Grüßen,"+"\n<?=$user_full_name?>");
        price_on_request_product_id = id;
        $.post("<?=api_url('price_on_request_offer_html')?>", {
            product_id: id
        }).then((res, err) => {
            $('#price-on-request-offer').html(res.html);
            $('.selectpicker').selectpicker('render');
        });
    }

    function send_price_on_request_info(){

        first_name = $("#firstName").val();
        last_name  = $("#lastName").val();
        email = $("#email").val();
        phone_number = $("#phnNumber").val();
        city = $("#city").val();
        zip_code = $("#zip_code").val();
        street = $("#street").val();
        state = $("#state").val();
        country = $("#country").val();
        comment = $("#comment").val();

        var variant_type = $('.variant-type').val();
        var product_variants = [];
        $('select[name="variant[]"]').each(function() {
            product_variants.push($(this).val());
        });
        // alert(price_on_request_product_id);
        // alert(first_name);
        if(first_name == '' || last_name == '' || email == '' || city == '' ||  country == '' || zip_code == '' || street == '' || state == ''){
            mw.notification.error("Required field missing");
        }else{
            $.ajax({
                type:"POST",
                url: "<?=api_url('price_on_request_info');?>",
                data:{first_name,last_name,email,phone_number,city,zip_code,street,state,country,comment,price_on_request_product_id,variant_type, product_variants},
                success: function(response){
                    // $("#price-on-request-modal").modal("hide");
                    if(response.message['success']){
                        $("#price-on-request-modal").modal("hide");
                        mw.notification.success("Request sent successfully");
                    }else{
                        mw.notification.error(response.message['message']['email'][0]);
                    }
                }
            })
        }
    }



</script>

<script>
    $(".product-cart-icon").on("click", function(){
        if($('*').hasClass('blankCartBox')){
            $(".blankCartBox").addClass('checkoutloader');
        } else{
            $(".product-cart-modal").addClass('checkoutloader');
            $(".product-cart-modal").addClass('checkoutloaderWith5opacity');
            $(".products-amount").css("opacity",".5");
        }
    });

    $(".preloader-cart-icon").on("click", function(){
        if($(".blankCartBox").length > 0 ) {
            $(".blankCartBox").removeClass('checkoutloader');
        } else{
            $(".product-cart-modal").removeClass('checkoutloader');
            $(".product-cart-modal").removeClass('checkoutloaderWith5opacity');
            $(".products-amount").css("opacity","1");
        }
    });


</script>
<?php if(!is_live_edit()): ?>
    <script type="text/javascript" data-cmp-ab="1" src="https://cdn.consentmanager.net/delivery/autoblocking/<?=get_option("consentmanager_code_id", "consentmanager")?>.js" data-cmp-host="a.delivery.consentmanager.net" data-cmp-cdn="cdn.consentmanager.net" data-cmp-codesrc="11"></script>
<?php endif; ?>
