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
        <?php if( check('agb')!=null){ ?>
        <form action="<?php print api_url('upagb'); ?>" method="post" class="form-inline" id="agb">
        <?php }else{ ?>
        <form action="<?php print api_url('agb'); ?>" method="post" class="form-inline" id="agb">
            <?php } ?>
            <div class="form-group">
                <label>AGB </label>
                <textarea class="form-control" id="agb_editor"
                    name="agb"><?php if( check('agb')!=null){  echo check('agb')->description; }?></textarea>
                <button id="agbbtn"><?php _e("Change"); ?></button>

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

        $("#agbbtn").on('click',function(){

        return $.post($('form#agb').attr('action'), $('form#agb').serialize(), (res) => {
            $('#input_text').val(res.url)
        });


        });
        $(document).ready(function(){
                CKEDITOR.replace( 'agb_editor', {

});

            });
        // ClassicEditor
        //     .create(document.querySelector('#agb_editor'))
        //     .catch(error => {
        //         console.error(error);
        //     });
    </script>
</body>

</html>
