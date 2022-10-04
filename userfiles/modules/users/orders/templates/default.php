
<?php if (isset($orders) and is_array($orders)):?>



<h3 class="m-b-20 edit" field="order_modal_heading_one" rel="content">meine Bestellungen</h3>
<div class="edit" field="order_modal_top" rel="content">
    <module type="text" />
</div>

<style>
    .my-order-body table tr td {
        border: 0px !important;
    }
    .my-order-body {
        padding-right: 10px;
    }
    .order-chat-box-wrapper .input-area {
        width: 100% !important;
    }

    .input-area .emojiPickerIconWrap {
        width: 100%;
    }

    .input-area .emojiPickerIconWrap input {
        width: 100% !important;
        height: 31px;
    }

    .my-order-header{
        background-color:#ccc;
        padding: 10px;
        display:flex;
        justify-content:space-between;
    }
    .my-order p{
        text-align: left !important;
        font-size:13px !important;
    }
    .my-order-header h6{
        font-size:14px !important;
    }
    .my-order {
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .order-product-button a {
        margin-bottom: 5px;
        position:relative;
    }

    .order-product-button .btn i {
        float: unset !important;
        margin-right: 10px;
    }
    .my-orders-modal .modal-dialog {
        max-width: 70%;
        margin:0 auto;
    }
    .my-order-body table tr td:first-child{
        vertical-align: middle;
        width: 160px;
    }
    .my-order-body img {
        height: 70px;
        width: 100%;
        object-fit: contain;
    }
    .re-order-btn {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 10px;
        border-radius: 5px;
        margin-top: 5px;
        color: #000;
    }
    .order-product-button {
        width: 60%;
        margin-left: auto;
        margin-top: 5px;
    }
    .re-order-btn i{
        margin-right: 5px;
    }

    .order-modal-open{
        cursor: pointer;
    }

    #shippingInfo .modal-header,
    #parcelInfo .modal-header {
        padding-top:5px !important;
        padding-bottom:5px !important;
        background-color: #4592ff;
        border-color: #4592ff;
        color: #fff;
    }

    /* #shippingInfo .modal-dialog,
    #parcelInfo .modal-dialog {
        top: 50%;
        transform: translateY(-50%);
    } */

    #shippingInfo table tr td:last-child,
    #parcelInfo table tr td:last-child
    {
        text-align: right;
    }

    #shippingInfo .modal-header .close,
    #parcelInfo .modal-header .close {
        padding: 0 !important;
        margin: 0 !important;
        border: 1px solid #ccc;
        padding: 5px 10px !important;
        color: #fff;
        opacity: 1;
        text-shadow: 0 0 !important;
        border-radius:5px;
    }

    #shippingInfo .modal-header .close:hover,
    #parcelInfo .modal-header .close:hover {
        background: #fff;
        color: #4592ff;
    }
    #shippingInfo .modal-title {
        display: inline-block;
        color: #fff;
    }
    .order-chat-modal span.badge {
        right: auto !important;
        top: 0 !important;
        left: 104% !important;
    }

@media screen and (max-width: 767px) {
    .order-product-button {
        width: 100%;
        margin-left: 0;
    }
    .my-order-header {
        flex-direction:column;
        align-items:center;
        justify-content:center;
    }

    .my-order-header div{
        margin-bottom:10px;
        text-align:center;
    }

    .order-product-button a {
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

}
@media screen and (max-width: 425px){
    .my-order-body table tr td{
        display:block;
        text-align: center;
    }

    .my-order-body table tr {
        border-bottom: 1px solid #ccc;
    }
}

.re-order-btn:hover {
    color: blue;
}
.disable-re-order-btn{
    background-color: grey;
    cursor: auto !important;
}
.disable-re-order-btn:hover{
    color:#000;
}
.disable-re-order-btn:focus {
    outline: unset;
}
.re-order-btn.disable-dowload-btn{
    cursor: default !important;
    background-color: grey;
}
.re-order-btn.disable-dowload-btn:hover {
    color: initial;
}
}
    span.dl-icon {
    position: relative;
}

span.dli-tooltip {
    position: absolute;
    right: -58px;
    top: 25px;
    background-color: #fff;
    border: 1px solid #acacac;
    width: max-content;
    max-width: 232px;
    padding: 8px;
    border-radius: 3px;
    z-index: 2;
    display: none;
    font-size: 13px;
    line-height: 16px;
    text-align: justify;
}
span.dl-icon:hover span.dli-tooltip {
    display: block;
}
.disable-download-link{
    pointer-events: none;
}
.my-order .support-chat-text{
    font-size: 14px !important;
}

.my-order .order-product-button .showparcelmodal,
.my-order .order-product-button .order-chat-modal > a,
.my-order .order-product-button .order-chat-modal > a > p {
    font-size: 14px !important;
}

.delete-product-img {
    width: 80px;
    background-color: gray;
    margin: auto;
    padding: 5px;
}

.delete-product-img span {
    font-size: 12px;
    text-align: center;
    display: inline-block;
    font-weight: 600;
    /* word-break: break-word; */
}
</style>
<?php $status = DB::table('subscription_order_status')->where('order_id','<>', null)->get();
?>
<?php
foreach ($orders as $order) {
    ?>
    <?php $orderShow = 0; ?>
    <?php if(isset($status) && count($status) > 0) {
        foreach ($status as $subOrder) {
            if($subOrder->order_id == $order['id']) {
                $orderShow = 1;
            }
        }
    }
    ?>
    <?php if($orderShow == 0) : ?>
    <?php $cart = get_cart('order_id=' . $order['id']);
    ?>
    <?php if (is_array($cart) and !empty($cart)): ?>

        <div class="my-order">
            <div class="my-order-header">
                <div class="order-info-one">
                    <h6><?php _e('ORDER PLACED'); ?></h6>
                    <p><?php print $order['created_at']; ?></p>
                </div>
                <div class="order-info-price">
                    <h6><?php _e('TOTAL'); ?></h6>
                    <p><?php print $order['amount']; ?> <?php print $order['currency']; ?></p>
                </div>
                <div class="order-send-info">
                    <h6><?php _e('SEND TO'); ?></h6>
                    <a href="#" style="text-decoration: none;" class="order-modal-open" onclick="showShipping(<?php echo $order['id']; ?>)" data-toggle="modal" data-target="#shippingInfo"><?php print $order['shipping_name']; ?></a>
                </div>
                <div class="order-info-two">
                    <h6><?php _e('ORDER NUMBER'); ?>: #<?php print $order['id']; ?></h6>
                    <?php if(function_exists('delivery_bill_url')) {
                            $pdfLink =  delivery_bill_url($order['id']);
                            $pdfLink .= "&show=yes";
                        } else{
                            $pdfLink = "#";
                        }
                        ?>
                    <a href="<?php print $pdfLink; ?>" target="_blank" style="text-decoration: none ;"><?php _e('Invoice'); ?></a>
                </div>
            </div>
            <div class="my-order-body mt-2">
                <div class="row">
                    <div class="col-md-6">
                        <table width="100%" class="table" cellspacing="0" class="mw-ui-table mw-ui-table-basic product-order-table">
                            <tbody>
                                <?php foreach($cart as $product): ?>
                                <?php $item = get_content_by_id($product['rel_id']);
                                    if(!$item): ?>
                                <tr>
                                    <td>
                                        <div class="delete-product-img">
                                            <span class=""><?php _e('This product information is not available anymore'); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?php  print $product['title']; ?></h5>
                                        <?php
                                            $in_stock = false;
                                        if (isset($product['digital_product']) && $product['digital_product'] == 1):
                                            ?>
                                            <a class="" href="<?= site_url() . 'download_digital_product/' . $product['id']  ?>">
                                                <button type="button" class="re-order-btn  <?php ($in_stock == false || !$product['download_limit'] > 0) ? print "disable-dowload-btn" : print "" ?>" <?php ($in_stock == false || !$product['download_limit'] > 0) ? print "disabled" : print "" ?>><i class="fas fa-download"></i><?php _e('Download'); ?></button>
                                                <span class="download-limit"><span class="dl-icon"><i class="fas fa-luggage-cart"></i><span class="dli-tooltip">This number is representing that how many times you can download this product.</span> </span><?php print $product['download_limit']; ?> </span>
                                            </a>
                                        <?php else : ?>
                                                <button type="button" class="re-order-btn disable-re-order-btn"> <i class="fas fa-cart-plus"></i><?php _e('Buy it again'); ?></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                    <?php else: ?>
                                <tr>
                                    <td>
                                        <img src="<?php print get_picture($item['id']); ?>" width="70" alt=""/>
                                    </td>
                                    <td>
                                        <h5><a href="<?php print url('/').'/'.$item['url']; ?>" target="_blank"><?php  print $item['title']; ?></a></h5>
                                        <?php
                                            $in_stock = true;
                                            if (isset($item['contentData'][0]['field_value']) and $item['contentData'][0]['field_value'] != 'nolimit' and intval($item['contentData'][0]['field_value']) == 0) {
                                                $in_stock = false;
                                            }
                                        if (isset($product['digital_product']) && $product['digital_product'] == 1):
                                            ?>
                                            <a class="" href="<?= site_url() . 'download_digital_product/' . $product['id']  ?>">
                                                <button type="button" class="re-order-btn  <?php ($in_stock == false || !$product['download_limit'] > 0) ? print "disable-dowload-btn" : print "" ?>" <?php ($in_stock == false || !$product['download_limit'] > 0) ? print "disabled" : print "" ?>><i class="fas fa-download"></i><?php _e('Download'); ?></button>
                                                <span class="download-limit"><span class="dl-icon"><i class="fas fa-luggage-cart"></i><span class="dli-tooltip">This number is representing that how many times you can download this product.</span> </span><?php print $product['download_limit']; ?> </span>
                                            </a>
                                        <?php else : ?>
                                            <?php if($in_stock): ?>
                                                <a href="javascript:void" class="re-order-btn" onclick="mw.cart.add_and_checkout(<?php echo $product['rel_id']; ?>,<?php echo $product['price']; ?>)" style="text-decoration: none ;">
                                                <i class="fas fa-cart-plus"></i><?php _e('Buy it again'); ?>
                                                </a>
                                            <?php else: ?>
                                                <button type="button" class="re-order-btn disable-re-order-btn"> <i class="fas fa-cart-plus"></i><?php _e('Buy it again'); ?></button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                    <?php endif; endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                    <div class="order-product-button">
                        <a href="#" id="parcel-info-<?= $order['id'] ?>" class="btn btn-primary order-modal-open btn-block showparcelmodal" data-order-id="<?= $order['id'] ?>" ><i class="fas fa-info-circle"></i><?php _e('Information'); ?></a>
                        <div class="order-chat-modal-option">
                        <span id="my-order-ChatOption" class="order-chat-modal order-chat-modal-<?=$order['id']?>" data-id="<?=$order['id']?>" data-toggle="modal" data-target="#order-chat-modal-<?=$order['id']?>">
                            <a href="#" class="btn btn-primary btn-block">
                                <p class="support-chat-text">
                                    <i class="fas fa-comments"></i><?php _e('Support chat'); ?>
                                    <span class="badge" id="notifi-<?=$order['id']?>">00
                                    </span>
                                </p>
                            </a>

                        </span>
                        </div>
                        <div class="order-chat-modal-option">
                        <span id="my-order-ChatOption" class="order-chat-modal order-chat-modal-<?=$order['id']?>" data-id="<?=$order['id']?>" data-toggle="modal" data-target="#order-chat-modal-<?=$order['id']?>">
                            <a href="#" class="btn btn-primary btn-block"><i class="fas fa-comments"></i><?php _e('Return product'); ?> </a>
                        </span>
                        </div>
                        <h4 style="display: none;"><span><?php print $order['id']; ?></span>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <script>
            function showShipping(id)
            {
                var data = {};
                data.id = id;
                $.post("<?=api_url('showShippingInfo') ?>", data,
                function (res) {
                    var json = JSON.parse(res);
                    // console.log(json["id"]);
                    $("#shipping-name").text(json["shipping_name"]);
                    $("#shipping-city").text(json["city"]);
                    $("#shipping-zip").text(json["zip"]);
                    $("#shipping-country").text(json["country"]);
                });

            }

        </script>
        <br/>
    <?php endif; ?>
    <script>

        $(".order-chat-modal-<?=$order['id']?>").on("click", function(){
            $("#chat-popup-<?=$order['id']?>").addClass("show");
            // $("#emojionearea<?=$order['id']?>").emojioneArea({
            //     pickerPosition: "top",
            //     tonesStyle: "bullet"
            // });
            $('#emojionearea<?=$order['id']?>').emojiPicker({
                height: '150px',
                width:  '250px'
            });

        });

        $(document).on('click', ".order-chat-modal", function(){
            const id = $(this).data('id');
            $.post("<?= url('/') ?>/api/v1/get_chat", { id:id }, res => res.data)
                .then(res => res.data)
                .then(data => {
                    if(data.messages) {
                        let message_list = '';
                        data.messages.forEach(msg => {
                            let recipient = msg.recipient;
                            let sender = msg.sender
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
                        } )
                        let el_id = `#order-chat-modal-`+id+` #chat-area`+id ;
                        $(el_id).html(message_list)
                        $(`#notifi-${id}`).html('00')
                        $("#chat-area"+id).stop().animate({ scrollTop: $("#chat-area"+id)[0].scrollHeight}, 1000);
                    }
                })
                .then( o => {
                    $.post("<?= url('/') ?>/api/v1/seen_chat", { id:id } ).catch(err => {})
                })
                .catch(err => {
                    console.log(err)
                })
        });



        $('#submitOrderText<?=$order['id']?>').on('click', function(){
            var inputElm = document.querySelector('input#emojionearea<?=$order['id']?>');
            var popup = document.querySelector('#chat-popup<?=$order['id']?>');
            //const chatBtn = document.querySelector('#my-order-ChatOption');
            // const submitBtn = document.querySelector('.submitOrderText');
            var chatArea = document.querySelector('#chat-area<?=$order['id']?>');
            let userInput = inputElm.value;

            var msg = $("#emojionearea<?=$order['id']?>").val();


            $("#chat-area<?=$order['id']?>").stop().animate({ scrollTop: $("#chat-area<?=$order['id']?>")[0].scrollHeight}, 1000);

            $.post("<?= url('/') ?>/api/v1/send_chat", { id: <?=$order['id']?> ,data: msg }, res => res.data)
                .then(res => res.data)
                .then(data => {

                    if(data) {
                        let temp = '';
                        let recipient = data.recipient;
                        let sender = data.sender

                        temp += `
                            <li class="clearfix Sentchat_Massage">
                                <div class="order-outgoing-msg-info message-data ${recipient == 'me'? 'text-right' : ''}">
                                    <span class="message-data-time" title="${msg.created_at}">
                                            <span class="name">${sender && sender.name ? sender.name : ''}</span>,
                                        <span class="time">${data.time}</span>
                                    </span>
                                    <br>
                                    <span class="email">${sender && sender.email? sender.email : ''}</span>
                                </div>
                                <div class="message ${recipient == 'me'? 'my-message float-right' : 'other-message'}">${data.message}</div>
                            </li>
                        `;

                        $(".emojionearea-editor").html(temp);

//                        chatArea.insertAdjacentHTML("beforeend", temp);
                        $("#chat-area<?=$order['id']?>").stop().animate({ scrollTop: $("#chat-area<?=$order['id']?>")[0].scrollHeight}, 1000);

                    }

                })
                .catch(err => {
                    console.log(err)
                })



            inputElm.value = '';
            $(".emojionearea-editor").html("");
        });


        $("#emojionearea<?=$order['id']?>").keydown(function(event) {
            if(event.which == 13) {
                if($("#emojionearea<?=$order['id']?>").val() ) {
                    $('#submitOrderText<?=$order['id']?>').click();


                }
            }

        });

    </script>
    <?php endif; ?>
<?php } ?>

<script>
    $(".showparcelmodal").on("click" , function (){
        $("#parcelInfo").attr('data-order-id',$(this).data('order-id'));
        let parcelInfo = $(this).data('json');
        $("#parcel-number").text(parcelInfo.package_number);
        $("#parcel-service").text(parcelInfo.parcel_name);
        $("#parcelInfo").modal('show');
    });
</script>



<!-- <script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.1.1/dist/index.min.js"></script> -->

<link rel="stylesheet" type="text/css" href="<?= url('/') ?>/public/emoji-picker/jquery.emojipicker.css">
<script type="text/javascript" src="<?= url('/') ?>/public/emoji-picker/jquery.emojipicker.js"></script>
<!-- Emoji Data -->
<link rel="stylesheet" type="text/css" href="<?= url('/') ?>/public/emoji-picker/jquery.emojipicker.tw.css">
<script type="text/javascript" src="<?= url('/') ?>/public/emoji-picker/jquery.emojis.js"></script>


<script>

    $(document).ready(function () {
        $.post("<?= url('/') ?>/api/v1/unseen", { ids:'all' }, res => res.data)
            .then(res => res.data)
            .then(data => {
                if(data) {
                    for(const item in data) {
                        let newd = data[item];
                        let tracking = newd.tracking;
                        if(typeof (tracking[Object.keys(tracking)[0]]) != 'undefined'){
                            $(`#parcel-info-${item}`).attr(`data-json`,JSON.stringify(tracking[Object.keys(tracking)[0]]));
                        }else{
                            $(`#parcel-info-${item}`).attr(`style`,'pointer-events: none !important;background-color: gray;');
                        }

                        $(`#notifi-${item}`).html(newd.unseen)

                        $(`#order_status_${item}`).html('<strong>Order-Status:</strong>'+newd.status)

                    }

                }
            })
            .catch(err => {
                console.log(err)
            })
    });
    //  $("#my-order-ChatOption").on("click", function(){
    //     $(".chat-popup").toggleClass("show");
    // });




    // const emojiBtn = document.querySelector('#emoji-btn');

    //   chat button toggler

    // chatBtn.addEventListener('click', ()=>{
    //     //popup.classList.toggle('show');
    //     $(".chat-popup").addClass("show");
    //     $("#emojionearea1").emojioneArea({
    //         pickerPosition: "top",
    //         tonesStyle: "bullet"
    //     });
    // })




    $(".order-chat-modal-option").on("click", function(){
        var clickedOrderNumber = $(this).siblings( "h4" ).children("span").text();
        $(".currentOrderId").html('Order Id: #'+clickedOrderNumber);
        $(".currentOrderNo").val(clickedOrderNumber);

    });

    // send msg .

</script>
<?php else: ?>



<div class="edit" field="order_modal_heading_two" rel="content">
    <h3>Sie haben keine Bestellungen</h3>
</div>


<?php endif; ?>


<?php if (isset($status) &&  count($status) > 0) : ?>
<div class="">
    <module type="shop/subscriptionProduct/template/default"/>
</div>
<?php endif; ?>
