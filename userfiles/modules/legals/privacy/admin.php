<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .legal-container{
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
    <div class="legal-container">
		<div class="main-toolbar" id="mw-modules-toolbar">
            <a href="javascript:;" onclick="history.go(-1)" class="btn btn-link text-silver px-0"><i class="mdi mdi-chevron-left"></i> Back</a>
        </div>
        <?php if( check('pp')!=null){ ?>
            <form action="<?php print api_url('uppp'); ?>" method="post" class="form-inline" id="pp">
            <?php }else{ ?>
            <form action="<?php print api_url('pp'); ?>" method="post" class="form-inline" id="pp">
            <?php } ?>
            <div class="form-group">
                <label>Datenschutzerklärung</label>
                <textarea class="form-control" id="privacy_editor"  name="pp"><?php if( check('pp')!=null){  echo check('pp')->description; }?></textarea>
                <button id="ppbtn"><?php _e('Change'); ?></button>
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

        $("#ppbtn").on('click',function(){

        return $.post($('form#pp').attr('action'), $('form#pp').serialize(), (res) => {
            $('#input_text').val(res.url)
        });


        });

        $(document).ready(function(){
                CKEDITOR.replace( 'privacy_editor', {

});
});
    </script>
</body>

</html>
