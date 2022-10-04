<?php

/*

type: layout

name: Default
description: Default

*/
?>

<style>

    .next-btn-div{
        text-align: center;
    }

    .next-btn-div button:hover{
        color:blue;
    }

</style>


<script type="text/javascript" src="<?php print modules_url(); ?>/shop/thank_you/js/jquery.simple.timer.js"></script>

<style>
    .thank-you-page{
        width:70%;
        border-radius: 30px;
        background: #ffffff;
        box-shadow:  20px 20px 60px #d9d9d9,
        -20px -20px 60px #ffffff;
        margin:0 auto;
        padding:20px;
    }

    .thank-you-row {
        width: 80%;
        margin: 0 auto;
    }

    .thank-you-cartButton{
        margin-top: 20px;
    }
    .thank-you-cartButton a{
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .thank-you-cartButton a{
        font-size:16px;
        font-weight:600px;
    }
    .thank-you-cartButton a span{
        margin-right:10px;
    }

    .thank-you-col .description h2{
        margin-top: 20px;
        color: #000;
        text-align:center;
    }
    .thank-you-col .description .price span{
        font-size:20px !important;
    }
    .thank-you-row .product .image {
        height: auto !important;
        width:auto !important;
        border:0px;
    }
    .thank-you-row .product .image:hover{
        border:0px;
    }
</style>

<style>
    .custom-progressbar {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 30px;
    }

    .custom-progressbar p {
        margin-right: 20px;
    }

    .meter {
        box-sizing: content-box;
        height: 20px;
        position: relative;
        background: #ececec;
        border-radius: 25px;
        padding: 10px;
        box-shadow: inset 0 -1px 1px rgb(255 255 255 / 30%);
        width: 100%;
    }

    .meter>span {
        display: block;
        height: 100%;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        background-color: rgb(43, 194, 83);
        background-image: linear-gradient(center bottom,
        rgb(43, 194, 83) 37%,
        rgb(84, 240, 84) 69%);
        box-shadow: inset 0 2px 9px rgba(255, 255, 255, 0.3),
        inset 0 -2px 6px rgba(0, 0, 0, 0.4);
        position: relative;
        overflow: hidden;
    }

    .meter>span:after,
    .animate>span>span {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background-image: linear-gradient(-45deg,
        rgba(255, 255, 255, 0.2) 25%,
        transparent 25%,
        transparent 50%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0.2) 75%,
        transparent 75%,
        transparent);
        z-index: 1;
        background-size: 50px 50px;
        animation: move 2s linear infinite;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        overflow: hidden;
    }

    .animate>span:after {
        display: none;
    }

    @keyframes move {
        0% {
            background-position: 0 0;
        }

        100% {
            background-position: 50px 50px;
        }
    }

</style>


<style>
    .timer, .timer-done, .timer-loop {
        font-size: 30px;
        color: black;
        font-weight: bold;
        padding: 10px;
    }
    .timer{
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    .jst-hours {
        float: left;
        display:none !important;
    }
    .jst-minutes {
        background-color: #000;
        border-radius: 5px;
        color: #fff;
        padding: 15px;
        margin-right: 10px;
    }
    .jst-seconds {
        background-color: #000;
        border-radius: 5px;
        color: #fff;
        padding: 15px;
    }
    .jst-timeout {
        color: red;
    }

    .thank-you-cart-text{
        text-align: center;
        margin-bottom: 20px;
    }


    #thankYou-redirect .modal-dialog{
        margin-top: 200px !important ;
    }

    .product-style{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .thank-you-row.shop-products .product:hover .image{
        border:0px !important;
        box-shadow:unset !important;
    }

    .module-shop-thank-you .mw-notification.mw-success {
        display: none !important;
    }
</style>

<?php
    $ord_id = DB::table('cart_orders')->orderBy('id', 'desc')->first();
    $ord_info = DB::table('cart_orders')->where('id', @$ord_id->id)->first();
    if(isset($ord_info)){
            if (function_exists('googleAnalyticalOrder')) {
                googleAnalyticalOrder($ord_info->amount, $ord_info->currency, $ord_info->id);
            }
            if(function_exists('dt_google_analytical_ecommerce_tracking')){
                dt_google_analytical_ecommerce_tracking($ord_info->id);
            }
        }
?>
<?php $time = 300; ?>


<?php
use Illuminate\Support\Facades\DB;
$activeTheme = DB::table("thank_you_pages")->where('is_active',1)->orderBy('template_name','asc')->get();
$serial = 1;
?>
<?php
if(!isset($_GET['temp'])){
    $_GET['temp'] = 1;
}
if($activeTheme->count() >0):
    $progress = 100/$activeTheme->count();

    ?>

    <?php foreach($activeTheme as $active):
    $GLOBALS[$active->template_name] = $serial;
    ?>
        <?php if($_GET['temp'] == $serial ): ?>
            <div class="thank-you-page"  id="<?php print  $serial; ?>">

                <div class="thank-you-page-1" id="shop-content-<?php print CONTENT_ID; ?>">
                    <section class="p-b-50 fx-particles">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">

                                    <div class="custom-progressbar">

                                        <p><?php print ceil($progress*$serial); ?>%</p>
                                        <div class="meter">
                                            <span style="width: <?php print  $progress*$serial; ?>%"></span>
                                        </div>
                                    </div>
                                    <module type="shop/thank_you" template="template-<?php print $active->template_name; ?>"/>

                                    <div class="timer <?php print  $serial; ?>" data-seconds-left=<?php print  $time; ?>></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="next-btn-div">
                    <?php if($serial == $activeTheme->count()): ?>
                        <a class="btn" href="" data-toggle="modal" data-target="#thankYou-redirect" onclick="totalPrice()">NEIN Danke, ich verzichte auf dieses einmalige Angebot </a>
                    <?php else: ?>
                        <a class="btn" href="?temp=<?php print $serial+1;  ?>"  >NEIN Danke, ich verzichte auf dieses einmalige Angebot  </a>
                    <?php endif; ?>
                </div>

            </div>


            <div id="payment_mathode"></div>
        <?php endif; ?>
        <?php $serial++;  ?>
    <?php endforeach;   $serial = 1;?>
<?php else: ?>
    <?php 
        $last_order_information = DB::table('cart_orders')->where('order_completed',1)->get('id')->last();
        if(isset($last_order_information)){
            $last_ordered_all_product = DB::table('cart')->where('order_id', $last_order_information->id)->get('rel_id');
        }
        $tag_check = null;
        $tag_page_url_link = null;
        // $active_page_id = get_option('active_thank_you_tags_page_id', 'active_thank_you_tags_page_id') ?? null;
    
        $tag_page_urls = DB::table('content')->where([
            ['layout_file', '=', 'layouts__thank_you.php'],
            ['is_active', '=', '1'],
            ['is_deleted', '=', '0'],
            ['url', '<>', 'thank-you'],
        ])->get();
    
    
        foreach($tag_page_urls as $tag_page_url){
            if($tag_page_url_link){
                break;
            }
            $thank_you_page_all_tag =  content_tags($tag_page_url->id, false);
            if($thank_you_page_all_tag){
                foreach($last_ordered_all_product as $last_ordered_product){
                    $product_tag = content_tags($last_ordered_product->rel_id, false);
                    if($product_tag){
                        $all_tags = array_intersect($product_tag , $thank_you_page_all_tag);
                        if($all_tags){
                            $tag_check = $all_tags;
                            $tag_page_url_link = $tag_page_url->url;
                            break;
                        }
                    }
                }
            }
        }    
    ?>
    <?php if($tag_check && $tag_page_url_link): ?>
          <?php $return_to = url('/') . '/'.$tag_page_url_link; ?>
          <script>
              window.location.href = '<?php echo $return_to; ?>';
          </script>
    <?php else: ?>
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <module type="shop/thank_you" template="default-template"/>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>



<script>

    mw.on('mw.cart.add', function (event, data) {

        var selector = sessionStorage.getItem('selector');
        selector = JSON.parse(selector);

        var callback = sessionStorage.getItem('callback');
        callback = JSON.parse(callback);

        var obj = sessionStorage.getItem('obj');
        obj = JSON.parse(obj);

        var form = sessionStorage.getItem('form');
        form = JSON.parse(form);
        $( document ).trigger( "checkoutBeforeProcess", form );



        setTimeout(function(){







            $.ajax({
                type: "POST",
                url: mw.settings.api_url + 'checkout',
                data: obj
            })
                .done(function (data) {

                    if(data.success) {
                        var html = data.success;
                        $('#payment_mathode').append('<div>' + html + '</div>');
                    }else if(data.error){
                        var html = data.error;
                        $('#payment_mathode').append('<div>' + html + '</div>');
                    }


                    <?php $activeTheme = DB::table("thank_you_pages")->where('is_active',1)->orderBy('template_name','asc')->get();


                    $page = explode('?' , url()->full());
                    //                    dd($page);
                    if(!empty($page[1])) {
                        $page_no = explode('=', $page [1]);
//                        dd($GLOBALS);
                        if ($page_no[1] == 1 && $activeTheme->count() >= 2) {
                            $url_thank = url('/') . '/thank-you?temp=2';
                        } elseif ($page_no[1] == 2 && $activeTheme->count() >= 3) {
                            $url_thank = url('/') . '/thank-you?temp=3';
                        } elseif ($page_no[1] == 3 && $activeTheme->count() >= 4) {
                            $url_thank = url('/') . '/thank-you?temp=4';
                        } elseif ($page_no[1] == 4 && $activeTheme->count() >= 5) {
                            $url_thank = url('/') . '/thank-you?temp=5';
                        } elseif ($page_no[1] == 5 && $activeTheme->count() >= 6) {
                            $url_thank = url('/') . '/thank-you?temp=6';
                        } elseif ($page_no[1] == 6) {
                            $url_thank = url('/');
                        } else {
                            $url_thank = url('/');
                        }
                        $return_to = $url_thank;
                    }else{
                        $return_to = url('/') . '/thank-you?temp=1';
                    } ?>

                    if (typeof(data.redirect) != 'undefined') {

                        setTimeout(function () {
                            window.location.href = data.redirect;
                        }, 10)

                    }else{
                        window.location.href = "<?=$return_to?>";
                    }

                    console.log(data.success)
                    return true

                    html+= data.toString();
                    var data = sessionStorage.getItem('data');
                    data = JSON.parse(data);

                    mw.trigger('checkoutDone', data);
                    console.log(selector,callback,obj,form)

                    var data2 = data;



                    if (data != undefined) {
                        mw.$(selector + ' .mw-cart-data-btn').removeAttr('disabled');
                        mw.$('[data-type="shop/cart"]').removeAttr('hide-cart');


                        if (typeof(data2.error) != 'undefined') {
                            mw.$(selector + ' .mw-cart-data-holder').show();
                            if (typeof(data2.error.address_error) != 'undefined') {
                                var form_with_err = form;
                                var isModalForm = $(form_with_err).attr('is-modal-form')

                                if(isModalForm){
                                    mw.cart.modal.showStep(form_with_err, 'delivery-address');
                                }
                                mw.notification.error('Please fill your address details');

                            }

                            mw.response(selector, data2);
                        } else if (typeof(data2.success) != 'undefined') {


                            if (typeof callback === 'function') {
                                callback.call(data2.success);

                            } else if (typeof window[callback] === 'function') {
                                window[callback](selector, data2.success);
                            } else {

                                mw.$('[data-type="shop/cart"]').attr('hide-cart', 'completed');
                                mw.reload_module('shop/cart');
                                mw.$(selector + ' .mw-cart-data-holder').hide();
                                mw.response(selector, data2);
                            }


                            mw.trigger('mw.cart.checkout.success', data2);


                            if (typeof(data2.redirect) != 'undefined') {

                                setTimeout(function () {
                                    window.location.href = data2.redirect;
                                }, 10)

                            }


                        } else if (parseInt(data) > 0) {
                            mw.$('[data-type="shop/checkout"]').attr('view', 'completed');
                            mw.reload_module('shop/checkout');
                        } else {
                            if (obj.payment_gw != undefined) {
                                var callback_func = obj.payment_gw + '_checkout';
                                if (typeof window[callback_func] === 'function') {
                                    window[callback_func](data, selector);
                                }
                                var callback_func = 'checkout_callback';
                                if (typeof window[callback_func] === 'function') {
                                    window[callback_func](data, selector);
                                }
                            }
                        }

                    }
                    mw.trigger('mw.cart.checkout', [data]);
                });

        }, 1500);

    })




    function thankYou_redirectToHome(){

        window.location.href = "<?=url('/')?>";

    }


    $(document).ready(function(){
        // $('#1').show();

        $('.<?php print $_GET['temp']?>').startTimer({
            onComplete: function(element){
                if(<?php print $_GET['temp']?> >= <?php print $activeTheme->count(); ?> ){
                    // $('#thankYou-redirect').modal({
                    //     backdrop: 'static',
                    //     keyboard: false
                    // })
                    totalPrice();
                    $("#thankYou-redirect").modal('show');
                }else{
                    if(<?php print $_GET['temp'] ?>==1){
                        window.location.href = "<?=url('/')?>"+'/thank-you?temp=2';
                    }
                    if(<?php print $_GET['temp'] ?>==2){
                        window.location.href = "<?=url('/')?>"+'/thank-you?temp=3';
                    }
                    if(<?php print $_GET['temp'] ?>==3){
                        window.location.href = "<?=url('/')?>"+'/thank-you?temp=4';
                    }
                    if(<?php print $_GET['temp']?>==4){
                        window.location.href = "<?=url('/')?>"+'/thank-you?temp=5';
                    }
                    if(<?php print $_GET['temp']?>==5){
                        window.location.href = "<?=url('/')?>"+'/thank-you?temp=6';
                    }
                }
            }
        });
        if(<?php print $_GET['temp']?> == 1){
            let totalPrice = 0;
            localStorage.clear();
            $(".title").html('');
            $(".prices").html('');
        }

    });

</script>

<div class="modal fade edit" id="thankYou-redirect" tabindex="-1" role="dialog" field="thankYou-redirect_modal" rel="content" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="thankyoustatus">
            </div>
            <div class="modal-body">
                <table class="table table-borderless" id="priceTable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="title1" class="title"></td>
                        <td id="price1" class="prices"></td>
                    </tr>
                    <tr>
                        <td id="title2" class="title"></td>
                        <td id="price2" class="prices"></td>
                    </tr>
                    <tr>
                        <td id="title3" class="title"></td>
                        <td id="price3" class="prices"></td>
                    </tr>
                    <tr>
                        <td id="title4" class="title"></td>
                        <td id="price4" class="prices"></td>
                    </tr>
                    <tr>
                        <td id="title5" class="title"></td>
                        <td id="price5" class="prices"></td>
                    </tr>
                    <tr>
                        <td id="title6" class="title"></td>
                        <td id="price6" class="prices"></td>
                    </tr>
                    <tr>
                        <td id="total" class="title"></td>
                        <td id="tprice" class="prices"></td>
                    </tr>

                    </tbody>
                </table>
                <!-- <p>Please complete the process</p> -->
            </div>
            <div class="modal-footer">
                <button type="button" onclick="thankYou_redirectToHome();" class="btn btn-primary">Thank You</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    function totalPrice(){

        let x = 1;
        let totalPrice = 0;

        var all_products = JSON.parse(localStorage.getItem('products'));
        // console.log(all_products);
        if(all_products){
            for (let product of all_products) {

                totalPrice = totalPrice + parseFloat(product['price']);
                $("#title"+x).html(product['name']);
                $("#price"+x).html(product['sprice']);
                x++;
            }
        }


        if(totalPrice==0){
            // console.log('test');
            $("#priceTable").hide();
            $("#thankyoustatus").html("No Purchase Any Products");

        }

        $.ajax({
            type: "POST",
            url: "<?=api_url('thankyouPrice')?>",
            data:{ totalPrice : totalPrice},
            success: function(response) {
                console.log(response.message);
                $("#total").html('Total');
                $("#tprice").html(response.message.toString());

            },
            error: function(response){

            }
        });

    }

</script>
