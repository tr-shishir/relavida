<style>
.instagram-feed-settings {
    background: #fff;
    padding: 10px;
    margin-top: 30px;
}
.url-text {
    position: relative;
}

.url-text span {
    display: inline-block;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
}
.instragram-gallery-countdown{
    margin-top: 20px;
    display:flex;
    align-items: center;
}

.instragram-gallery-countdown p {
    margin-bottom: 0;
    margin-left: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
}

.instragram-gallery-countdown h4 {
    margin-bottom: 0;
}

.instragram-gallery-countdown small {
    color: #a7a7a7;
}
</style>


<div class="instagram-feed-settings">
    <h2><?php _e('Instagram Settings'); ?></h2>
<?php
if(isset($_REQUEST['code'])){
    delete_option('instagram_token' , 'instagram');
}
$tokens = get_option('instagram_token' , 'instagram',true) ?? null;
$insta_credentials = json_decode(get_option('insta_credentials','instagram'));
$token = null;
if(isset($tokens) && $tokens != false){
    $token = json_encode($tokens['option_value']);
    $dates = Carbon::parse($tokens['created_at'])
        ->addSeconds(@$token->expires_in ?? 999999)
        ->format('Y-m-d');
    $start_date = new DateTime();
    $since_start = $start_date->diff(new DateTime($dates));
}



// adds 674165 secs
?>
    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""><?php _e('App ID'); ?></label>
                    <input type="text" class="form-control" id="app_id" name="app_id" value="<?php print @$insta_credentials->app_id ?? '' ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""><?php _e('App Secret'); ?></label>
                    <input type="text" class="form-control" id="app_secret" name="app_secret" value="<?php print @$insta_credentials->app_secret ?? '' ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for=""><?php _e('URL'); ?></label>
                    <div class="url-text">
                        <input type="text" class="form-control" id="input_text" value="<?php print url()->current(); ?>" readonly>
                        <span>
                            <i class="fa fa-link" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <?php
                            echo '<button type="submit" class="btn btn-primary" onclick="add_insta_data()" >Connect</button>';


                ?>
            </div>
        </div>
    </form>
    <?php if(isset($dates)){ ?>
    <div class="row">
        <div class="col-md-12">

            <div class="instragram-gallery-countdown">
                <h4>Expires at:</h4>
                <div>
                    <p>
                        <?php

                        print $dates;
                        ?>
                        <small>(yyyy/mm/dd)</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php


if((!$token && !isset($token)) && isset($insta_credentials) && isset($_REQUEST['code'])){
    require_once('instagram.php');
    $igAPI = new Instagram\Instagram($insta_credentials->app_id, $insta_credentials->app_secret, $insta_credentials->input_text);
    $token = $igAPI->get_access_token($_REQUEST['code']);
    $curl = curl_init();
    $date = new DateTime();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret='.$insta_credentials->app_secret.'&access_token='.$token->access_token,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    curl_close($curl);
//    dump($response);
    $response = json_decode($response);
//    $long_lived_token = $response->access_token;
    $response->user_id = $token->user_id;
    $response->sort_token = $token->access_token;
    $date->add(new DateInterval('PT'.$response->expires_in.'S'));

    save_option('instagram_token' ,json_encode($response), 'instagram');
//            $user_id = $token->user_id;
}
?>
<script>
    $(document).on('click','.url-text', function(){
            $(".url-text input").select();
            document.execCommand('copy');
        });
    function add_insta_data(){
        var app_id = $("#app_id").val();
        var app_secret = $("#app_secret").val();
        var input_text = $("#input_text").val();
        data = {
            app_id :app_id,
            app_secret :app_secret,
            input_text :input_text,
        }
        $.post("<?= url('/') ?>/api/v1/insta_connection", data, (res) => {
            if(res.success){
                window.location.href = res.url;
            }
        });
    }

    function date_set_show(el){
        let time_interval = setInterval(function() {
            let total = el.data('end');

            if(!total){
                el.hide();
                el.html('');
                clearInterval(time_interval);
                return;
            }

            const seconds = Math.floor( total % 60 );
            const minutes = Math.floor( (total/60) % 60 );
            const hours = Math.floor( (total/(60*60)) % 24 );
            const days = Math.floor( total/(60*60*24) );
            --total;

            el.data('end', total);
            el.css('padding', '10px 15px');
            el.html(`${days < 10? ' 0'+days : days} Days, H: ${hours < 10?  '0'+hours : hours} M: ${minutes < 10?  '0'+minutes : minutes} S: ${seconds < 10?  '0'+seconds : seconds}`);

        }, 1000);
    }

    function instagram_exoired_date()
    {
        if(!$('.dt_t_countdown_data').length) return;

        $('.dt_t_countdown_data').each(function() {
            let _st = $(this).data('end');
            if(_st){
                date_set_show($(this))
            }
        });
    }

    $(document).ready(function(){
       instagram_exoired_date();
    })

</script>
