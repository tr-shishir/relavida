<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title><?php _e('Vacation Mode'); ?></title>
</head>
<style>
    body {
        overflow: hidden;
        margin: 0
    }

    .vacation-wrapper {
        width: 100%;
        height: 100vh;
        background: rgb(180, 180, 180);
        background: linear-gradient(180deg, rgba(180, 180, 180, 1) 0%, rgba(218, 218, 218, 1) 35%, rgba(238, 238, 238, 1) 100%);
        display: flex;
        justify-content: center;
    }

    .vacation-wrapper-content h1 {
        font-size: 60px !important;
        color: #fff;
        text-transform: uppercase;
        margin: 0;
    }

    .vacation-wrapper-content p {
        font-size: 16px;
        margin-top: 10px;
    }

    .vacation-wrapper-row {
        height: 100%;
        width: 500px;
        display: flex;
        align-items: center;
    }

    .vacation-wrapper-content-password h5 {
        font-weight: 500;
    }

    .vacation-wrapper-content-password button {
        margin-top: 20px;
    }

    .vacation-wrapper-image img {
        width: 100%;
    }

    .vacation-wrapper-image {
        text-align: center;
        width: 100px;
        margin: 30px auto;
    }

    .vacation-wrapper-content-date {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .vacation-wrapper-content-date span {
        display: inline-block;
        border: 1px solid #d5d5d5;
        border-radius: 5px;
        padding: 5px;
        box-shadow: 0 1px 0px 2px #d5d5d5;
    }

    #countdown {
        width: 300px;
        height: 100px;
        text-align: center;
        background: #d7d7d7;
        border: 1px solid #d7d7d7;
        border-radius: 5px 15px;
        box-shadow: 0px 0px 8px rgb(0 0 0 / 60%);
        margin: auto;
        padding: 24px 0;
        position: relative;
    }

    #countdown #tiles {
        position: relative;
        z-index: 1;
    }

    #countdown #tiles>span {
        width: 50px;
        max-width: 92px;
        font: bold 20px 'Droid Sans', Arial, sans-serif;
        text-align: center;
        color: #111;
        background-color: #ddd;
        background-image: -webkit-linear-gradient(top, #bbb, #eee);
        background-image: -moz-linear-gradient(top, #bbb, #eee);
        background-image: -ms-linear-gradient(top, #bbb, #eee);
        background-image: -o-linear-gradient(top, #bbb, #eee);
        border-top: 1px solid #fff;
        border-radius: 3px;
        box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.7);
        margin: 0 7px;
        padding: 10px 0;
        display: inline-block;
        position: relative;
    }

    #countdown #tiles>span:before {
        content: "";
        width: 100%;
        height: 13px;
        background: #111;
        display: block;
        padding: 0 3px;
        position: absolute;
        top: 41%;
        left: -3px;
        z-index: -1;
    }

    #countdown .labels {
        width: 100%;
        height: 25px;
        text-align: center;
        bottom: 8px;
    }

    #countdown .labels li {
        width: 60px;
        font: 10px 'Droid Sans', Arial, sans-serif;
        text-align: center;
        text-transform: uppercase;
        display: inline-block;
    }
</style>
<?php
  $vacation_start_date = get_option('vacation_mode_start_date', 'vacation_mode_date');
  $vacation_end_date = get_option('vacation_mode_end_date', 'vacation_mode_date');
  if($vacation_end_date && date("Y-m-d") >  $vacation_end_date){
   $option = array();
   $option['option_key'] = 'vacation_mode';
   $option['option_value'] = 'no';
   $option['option_group'] = 'website';
   save_option($option);
   $option = array();
   $option['option_key'] = 'vacation_mode_start_date';
   $option['option_value'] = null;
   $option['option_group'] = 'vacation_mode_date';
   save_option($option);
   $option = array();
   $option['option_key'] = 'vacation_mode_end_date';
   $option['option_value'] = null;
   $option['option_group'] = 'vacation_mode_date';
   save_option($option);
   redirect('/');
}

?>
<body>
    <div class="vacation-wrapper">
        <div class="vacation-wrapper-row">
            <div class="vacation-wrapper-col">
                <div class="vacation-wrapper-image">
                    <img src="<?php print modules_url(); ?>default.png" alt="">
                </div>
                <div class="vacation-wrapper-content">
                    <h3><?php _e('This shop is on vacation mode'); ?></h3>
                    <p><?php _e('This shop will be open when the vacation time will over'); ?></p>
                    <!-- <div class="vacation-wrapper-content-password">
                        <h5>Enter shop password</h5>
                        <input type="password" class="form-control">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div> -->
                    <?php
                    ?>
                    <?php if($vacation_end_date): ?>
                        <div class="vacation-wrapper-content-date">
                            <p><strong><?php _e('Start Date'); ?>:</strong> <span><?php  print date('Y-m-d',strtotime($vacation_start_date)); ?></span></p>
                            <p><strong><?php _e('End Date'); ?>:</strong> <span><?php  print date('Y-m-d',strtotime($vacation_end_date)); ?></span></p>
                        </div>
                        <div class="vacation-wrapper-content-countdown">
                            <div id="countdown">
                                <div id='tiles'></div>
                                <div class="labels">
                                    <li><?php _e('Days'); ?></li>
                                    <li><?php _e('Hours'); ?></li>
                                    <li><?php _e('Mins'); ?></li>
                                    <li><?php _e('Secs'); ?></li>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script>
        var target_date = new Date("<?php print  $vacation_end_date; ?>").getTime(); // set the countdown date
        var days, hours, minutes, seconds; // variables for time units

        var countdown = document.getElementById("tiles"); // get tag element
       
        getCountdown();

        setInterval(function () { getCountdown(); }, 1000);

        function getCountdown() {

            // find the amount of "seconds" between now and target
            var current_date = new Date().getTime();
            var seconds_left = (target_date - current_date) / 1000;
           
            days = pad(parseInt(seconds_left / 86400));
            seconds_left = seconds_left % 86400;

            hours = pad(parseInt(seconds_left / 3600));
            seconds_left = seconds_left % 3600;

            minutes = pad(parseInt(seconds_left / 60));
            seconds = pad(parseInt(seconds_left % 60));

            // format countdown string + set tag value
            countdown.innerHTML = "<span>" + days + "</span><span>" + hours + "</span><span>" + minutes + "</span><span>" + seconds + "</span>";
        }

        function pad(n) {
            return (n < 10 ? '0' : '') + n;
        }


    </script>
</body>

</html>