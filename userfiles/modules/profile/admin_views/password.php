<style>
    #heading {
        margin-top: 150px;
        text-align: center;
        font-size: 27px;
        color: #2E2EFE;
    }

    #meter_wrapper {
        border: 1px solid grey;
        /* margin-left: 5%; */
        margin-top: 5px;
        /* width: 90%; */
        height: 5px;
        border-radius: 3px;
    }

    #meter {
        width: 0px;
        height: 5px;
        /* border-radius: */
    }

    #pass_type {
        font-size: 15;
        margin-top: 20px;
        margin-left: 45%;
        text-align: center;
        color: grey;
    }

    .password-input {
        position: relative;
    }

    span.password-input-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        z-index: 9999;
    }
    .form {
        box-shadow: 0 0 1px 1px #e6e6e6;
        border-radius: 5px;
        padding: 10px;
        background: #fff;
    }

    .form-password {
        margin-top: 20px;
    }

    .password-change-btn{
        text-align: right;
    }

    #pass_type.red-alert-pass{
        margin-left: 0;
        text-align:left;
    }
</style>
<div class="card bg-none style-1 mb-0 card-settings">
    <div class="card-header px-0">
        <h5 class="w-100"><i class="mdi mdi-account-key text-primary mr-3"></i> <strong><?php _e('Password'); ?></strong></h5>
        <div class="d-block w-100">
            <nav class="anchorific"></nav>
        </div>
    </div>
</div>
<div class="form-password">
    <div class="row">
        <div class="col-6 col-md-4">
            <h5 class="font-weight-bold"><?php _e('Password Change'); ?></h5>
            <small class="text-muted"><?php _e('You can update your password here'); ?>.</small>
        </div>
        <div class="col-12 col-sm-6 col-md-8 form">
            <div class="form-group">
                <label><?php _e('New Password'); ?></label>
                <div class="password-input">
                    <input type="password" name="pass" id="pass" class="form-control" placeholder="<?php _e('Type your new password'); ?>" autocomplete="new-password">
                    <span class="password-input-icon">
                        <i class="fa fa-eye-slash" id="new-pass-icon" aria-hidden="true" onclick="password_show(1)" style="cursor:pointer;"></i>
                    </span>
                </div>
                <div id="meter_wrapper" style="display: none;">
                    <div id="meter"></div>
                    <span id="pass_type"></span>
                </div>
            </div>
            <div class="form-group">
                <label><?php _e('Re-type Password'); ?></label>
                <input type="password" id="pass2" name="pass2" class="form-control" onchange="match_password()" placeholder="<?php _e('Re type your password'); ?>" autocomplete="new-password">
                <span id="pass_match" style="color:red;"></span>
            </div>
            <div class="form-group">
                <label><?php _e('Current Password'); ?></label>
                <div class="password-input">
                    <input type="password" class="form-control" id="current_pass" name="current_pass" placeholder="<?php _e('Type new password'); ?>" autocomplete="new-password">
                    <span class="password-input-icon">
                        <i class="fa fa-eye-slash" id="current-pass-icon" aria-hidden="true" onclick="password_show(0)" style="cursor:pointer;"></i>
                    </span>
                </div>
                <span id="pass_res" style="color:red;"></span>
            </div>
            <div class="password-change-btn">
                <button type="submit" class="btn btn-success" id="pass_change" onclick="password_update(2)">
                    <?php _e('Update'); ?>
                </button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $("#pass").keyup(function() {
            check_pass();
        });
    });

    function check_pass() {
        var val = document.getElementById("pass").value;
        var meter = document.getElementById("meter");
        var meter_wrapper = document.getElementById("meter_wrapper");
        var pass_type = document.getElementById("pass_type");
        var no = 0;
        if (val != "") {
            // If the password length is less than or equal to 6
            if (val.length < 6) no = 1;

            // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
            if (val.length > 6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))) no = 2;

            // If the password length is greater than 6 and contain alphabet,number,special character respectively
            if (val.length > 6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))) no = 3;

            // If the password length is greater than 6 and must contain alphabets,numbers and special characters
            if (val.length > 6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) no = 4;

            if (no == 1) {
                $("#meter").animate({
                    width: '25%'
                }, 300);
                meter.style.backgroundColor = "red";
                pass_type.style.color = "red";
                meter_wrapper.style.display = "";
                document.getElementById("pass_type").innerHTML = "<?php _e('Password must be contain 6 chracter'); ?>";
                document.getElementById('pass_change').setAttribute('disabled', true);
                document.getElementById("pass_type").classList.add("red-alert-pass");
            }

            if (no == 2) {
                $("#meter").animate({
                    width: '50%'
                }, 300);
                meter.style.backgroundColor = "#F5BCA9";
                pass_type.style.color = "#F5BCA9";
                meter_wrapper.style.display = "";
                document.getElementById("pass_type").innerHTML = "<?php _e('Weak'); ?>";
                document.getElementById('pass_change').removeAttribute('disabled');
                document.getElementById("pass_type").classList.remove("red-alert-pass");
            }

            if (no == 3) {
                $("#meter").animate({
                    width: '75%'
                }, 300);
                meter.style.backgroundColor = "#FF8000";
                pass_type.style.color = "#FF8000";
                meter_wrapper.style.display = "";
                document.getElementById("pass_type").innerHTML = "<?php _e('Good'); ?>";
                document.getElementById('pass_change').removeAttribute('disabled');
                document.getElementById("pass_type").classList.remove("red-alert-pass");
            }

            if (no == 4) {
                $("#meter").animate({
                    width: '100%'
                }, 300);
                meter.style.backgroundColor = "green";
                pass_type.style.color = "green";
                meter_wrapper.style.display = "";
                document.getElementById("pass_type").innerHTML = "<?php _e('Strong'); ?>";
                document.getElementById('pass_change').removeAttribute('disabled');
                document.getElementById("pass_type").classList.remove("red-alert-pass");
            }
        } else {
            meter.style.backgroundColor = "white";
            meter_wrapper.style.display = "none";
            document.getElementById("pass_type").innerHTML = "";
            document.getElementById('pass_change').removeAttribute('disabled');
            document.getElementById("pass_type").classList.remove("red-alert-pass");
        }
    }

    function match_password() {
        var val = document.getElementById("pass").value;
        var val1 = document.getElementById("pass2").value;
        if (val == val1) {
            document.getElementById('pass_change').removeAttribute('disabled');
            document.getElementById('pass_match').innerHTML = "";
        } else {
            document.getElementById('pass_change').setAttribute('disabled', true);
            document.getElementById('pass_match').innerHTML = "<?php _e('Password didn`t match'); ?>";
        }
    }

    function password_update() {
        var val = document.getElementById("pass").value;
        var val1 = document.getElementById("pass2").value;
        var val2 = document.getElementById("current_pass").value;
        if (val && val1 && val2) {
            var data = {
                new_pass: val,
                old_pass: val2
            };
            $.post('<?php print api_url('update_password'); ?>',
                    data)
                .success(function(res, err) {
                    if (res == 'true') {
                        document.getElementById('pass_res').innerHTML = "";
                        mw.notification.success("<?php _e('Password updated successfully'); ?>");
                    } else {
                        document.getElementById('pass_res').innerHTML = "<?php _e('Your old password is incorrect'); ?>!";
                        mw.notification.error("<?php _e('Your old password is incorrect'); ?>!");
                    }
                })

        } else {
            alert("<?php _e('Please Insert all values'); ?>");
        }
    }

    function password_show(id) {
        if (id == 1) {
            var y = document.getElementById('new-pass-icon');
            var x = document.getElementById("pass");
        } else {
            var y = document.getElementById('current-pass-icon');
            var x = document.getElementById("current_pass");
        }
        if (x.type === "password") {
            y.classList.remove('fa', 'fa-eye-slash');
            y.classList.add('fa', 'fa-eye');
            x.type = "text";
        } else {
            x.type = "password";
            y.classList.remove('fa', 'fa-eye');
            y.classList.add('fa', 'fa-eye-slash');
        }
    }
</script>
