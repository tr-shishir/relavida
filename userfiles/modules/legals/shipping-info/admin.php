<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .shipping-container{
            padding:50px 20px;
        }
        .form-group {
            margin-bottom: 40px;
            display:flex !important;
            flex-direction:column !important;
            align-items: flex-start !important;
        }

        .form-group label {
            margin-bottom: 10px;
            display: block;
            font-size: 18px;
            font-weight: 600;
        }

        .form-group button {
            background-color: #42A1E3;
            padding: 8px 15px;
            color: #fff;
            border: 0px;
            border-radius: 5px;
            box-shadow: 0;
            margin-top: 5px;
        }

    </style>
</head>

<body>
    <div class="shipping-container">
        <div class=" module module-admin-modules-info " id="info-toolbar" history_back="true" data-type="admin/modules/info" parent-module="admin/modules/info" parent-module-id="info-toolbar" contenteditable="false">
            <div class="position-relative">
                <div class="main-toolbar" id="mw-modules-toolbar">
                    <a href="javascript:;" onclick="history.go(-1)" class="btn btn-link text-silver px-0"><i class="mdi mdi-chevron-left"></i> Back</a>
                </div>
            </div>
        </div>

        <?php if( check('shipping')!=null){ ?>
            <form action="<?php print api_url('upshipping'); ?>" method="post" class="form-inline" id="shipping">
            <?php }else{ ?>
            <form action="<?php print api_url('shipping'); ?>" method="post" class="form-inline" id="shipping">
            <?php } ?>
            <div class="form-group">
                <label><?php _e("Shipping information"); ?></label>
                <textarea class="form-control" id="shipping_editor"   name="shipping"><?php if( check('shipping')!=null){  echo check('shipping')->description; }?></textarea>
                <button id="shippingbtn"><?php _e("Save"); ?></button>

            </div>
            </form>
    </div>
    <?php
    function check($name){
        $count= DB::table('legals')->where('term_name',$name)->first();
        return $count;
    }
     ?>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script>

        $("#shippingbtn").on('click',function(){

        return $.post($('form#shipping').attr('action'), $('form#shipping').serialize(), (res) => {
            $('#input_text').val(res.url)
        });


        });
        $(document).ready(function(){
                CKEDITOR.replace( 'shipping_editor', {

});
});
    </script>
</body>

</html>
