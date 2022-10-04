<style>

    .data h6{
        line-height : 1.7;
    }
    .data{
        border : 1px solid  #FFF8DC;
        padding: 20px 10px;
        margin-bottom: 20px;
        background-color: #FFFFFF;
    }
    .data button{
        border: 1px solid #663399;
        color: #FFFFFF;
        padding: 10px 15px;
        background-color: #222222;
    }
    .data button:hover{
        opacity: .8;
        color: #FFFFFF;
    }
    .subscription-product-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .subscription-product-image{
        height:auto !important;
    }
     .subscription-container .order-product-button .btn{
        margin-left: auto;
    }

    .subscription-container .subscription-product-image{
        width: 130px;
    }

    .delete-product-img {
        width: 80px;
        background-color: gray;
        padding: 5px;
    }

    .delete-product-img span {
        font-size: 12px;
        text-align: center;
        display: inline-block;
        font-weight: 600;
        /* word-break: break-word; */
    }

    .subscription-container .table td{
        border-top: 0px;
    }

    .subscription-container .my-order-header{
        border-bottom: 1px solid #ccc;
    }

</style>
<div class="">
    <!-- active subcription -->
    <?php
        $item = DB::table('subscription_order_status')->where('order_id','<>',null)->where('order_status','=',"active")->where('order_type','=',"new")->where('user_id', user_id())->get();
        $item1 = DB::table('subscription_order_status')->where('order_id','<>',null)->where('order_status','=',"inactive")->where('order_type','=',"new")->where('user_id', user_id())->get();
    ?>
    <?php if(isset($item) || isset($item1)): ?>
        <h4><?php _e('Your Subscriptions Product'); ?></h4><hr>
        <?php
        if (count($item)>0) { ?>
            <h5><?php _e('Active Subscriptions'); ?></h5><br>
            <?php foreach ($item as $value) :
                $products = get_cart("order_id=$value->order_id");
                $order = get_order_by_id($value->order_id);
                $sub_inter = DB::table('subscription_items')->where('id','=', $value->subscription_id)->first();
                $sub_dur = DB::table('subscription_status')->where('product_id','=', $value->product_id)->first();?>
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
                        <a href="<?php print $pdfLink; ?>" target="_blank" style="text-decoration: none ;">Invoice</a>
                    </div>
                </div>
                <?php foreach ($products as $product) :
                // dd($product);
                ?>


                <div class="my-order-body mt-2">
                    <div class="row">
                        <div class="col-md-6 table-responsive">
                            <table width="100%" class="table" cellspacing="0" class="mw-ui-table mw-ui-table-basic product-order-table">
                                <tbody>
                                    <?php $item = get_content_by_id($product['rel_id']);
                                    if(!$item){
                                        $img_or_text = '<div class="delete-product-img">
                                            <span class="">'. _e("This product information is not available anymore") .'</span>
                                        </div>';
                                        $product_title = $product['title'];
                                        $style_text = "opacity: .5; cursor: default !important;background-color:#ccc !important;";
                                        $onclick_function = "";
                                    } else{
                                        $img_src_get = get_picture($item['id']);
                                        $img_or_text = '<img src="'. $img_src_get. '" width="70" alt=""/>';
                                        $product_title = $item['title'];
                                        $style_text = "";
                                        $onclick_function = "show_single_order({$value->id})";
                                    }?>
                                    <tr>
                                        <td class="subscription-product-image">
                                            <?php echo $img_or_text; ?>
                                        </td>
                                        <td>
                                            <h5><?php  print $product_title; ?></h5>
                                            <button class="btn btn-primary mt-2" <?php if($item) : ?> onclick="<?php print $onclick_function; ?>" <?php endif; ?> style="<?php print $style_text; ?>"><?php _e('Manage subscription'); ?></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                <?php
                    endforeach;
                ?>
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

                                chatArea.insertAdjacentHTML("beforeend", temp);
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
            <?php endforeach; ?>
        <?php
        } else { ?>
        <div class="row data">
                <h6><?php _e('You have no any active subscription product'); ?></h6>
            </div>

        <?php } ?>

        <!-- inactive subcription -->

        <?php
        if (count($item1)>0) { ?>
        <h5>Inactive Subscriptions</h5><br>
            <?php foreach ($item1 as $value) :
                $product = get_cart("order_id=$value->order_id");
                $order = get_order_by_id($value->order_id);
                $sub_inter = DB::table('subscription_items')->where('id','=', $value->subscription_id)->first();
                $sub_dur = DB::table('subscription_status')->where('product_id','=', $value->product_id)->first();?>
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
                        } ?>
                        <a href="<?php print $pdfLink; ?>" target="_blank" style="text-decoration: none ;">Invoice</a>
                    </div>
                </div>

                <?php $products = get_cart("order_id=$value->order_id");
                // dd($product);
                $sub_inter = DB::table('subscription_items')->where('id','=', $value->subscription_id)->first();
                $sub_dur = DB::table('subscription_status')->where('product_id','=', $value->product_id)->first();
                foreach ($products as $product) :
                    $item = get_content_by_id($product['rel_id']);
                    if(!$item){
                        $img_or_text = '<div class="delete-product-img">
                                            <span class="">'. _e("This product information is not available anymore") .'</span>
                                        </div>';
                        $product_title = $product['title'];
                        $style_text = "opacity: .5; cursor: default !important;background-color:#ccc !important;";
                        $link_text = "javascript:void(0);";
                    } else{
                        $img_src_get = get_picture($item['id']);
                        $img_or_text = '<img src="'. $img_src_get. '" width="70" alt=""/>';
                        $product_title = $item['title'];
                        $style_text = "";
                        $link_text = "/subscribe/reactive?id={$value->agreement_id}";
                    }
                ?>
                    <div class="my-order-body mt-2">
                    <div class="row">
                        <div class="col-md-6 table-responsive">
                            <table width="100%" class="table" cellspacing="0" class="mw-ui-table mw-ui-table-basic product-order-table">
                                <tbody>
                                    <tr>
                                        <td class="subscription-product-image">
                                            <?php print $img_or_text; ?>
                                        </td>
                                        <td>
                                            <h5><?php  print $product_title; ?></h5>
                                            <div class="col-4"  style="padding-left:5px;padding-top:4%;">
                                                <a href="<?php print $link_text; ?>" style="<?php print $style_text; ?>"><button class="btn btn-primary"><?php _e('Reactive'); ?></button></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                <?php
                    endforeach;
                ?>

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

                                chatArea.insertAdjacentHTML("beforeend", temp);
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
            <?php endforeach;
        } else {
            ?>
            <div class="row data">
                <h6><?php _e('You have no any inactive subscription product'); ?></h6>
            </div>

        <?php } ?>
    <?php endif; ?>
</div>
<script>
    function show_single_order(id){
        window.location.href =  "<?=url('/')?>/subscription_product?id="+id;
    }

</script>
