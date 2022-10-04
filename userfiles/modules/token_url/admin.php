<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <title>Document</title>
    <style>

       #token_save label {
            margin-bottom: 10px;
            justify-content:flex-start !important;
            font-size: 16px;
            font-weight: 600;
        }
        .form-group input{
            width:30%;
        }

        .api-token-button{
            display:flex;
        }
        .api-token-button input{
            color: #fff;
            padding:5px 10px;
            margin-right: 10px;
            border:0px !important;
        }
        .main-container{
            padding:50px;
        }
        .sdk-url{
            width: 20% !important;
        }
    </style>
</head>

<body>
    <div class="main-container">
		<div class="main-toolbar" id="mw-modules-toolbar">
            <a href="javascript:;" onclick="history.go(-1)" class="btn btn-link text-silver px-0"><i class="mdi mdi-chevron-left"></i> Back</a>
        </div>
        <?php $count= DB::table('tokenurl')->first();
        if(empty($count)){
            DB::table('tokenurl')->insert([
                'token' => uniqid(),
                'url' => 'api/sdk_text'
            ]);
        }
        $count= DB::table('tokenurl')->first();

        ?>
        <form action="<?php print api_url('app_token_save'); ?>" class="form-inline" id="token_save" method="post">
        <div style="display:flex;flex-direction:column;">
            <div style="margin-bottom:10px">
                <label for="url">SDK URL</label>
                <p id="url"><?=site_url()?></p>
            </div>
            <div style="margin-bottom:10px">
                <label for="token">TOKEN</label>
                <input type="text" class="form-control" value="<?=$count->token?>" id="token" name="token" >
            </div>

            <div class="api-token-button">
                <input type="button" class="btn btn-primary" value="<?php _e("Generate Token"); ?>"  id="submit" name="submit" >
                <input type="submit" class="btn btn-success" value="<?php _e("Save"); ?>"  id="submitdata" name="submitda" >
            </div>
        </div>
        </form>

    </div>


    <?php

     ?>
     <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script>
        $( "#submit" ).click(function() {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < 10 ; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            $('#token').val(result);


        });
        $("#submitdata").on('click',function(){
            $.post($('form#token_save').attr('action'), $('form#token_save').serialize(), (res) => {
                // $('#input_text').val(res.url)

            });

        });

    </script>


</body>

</html>
