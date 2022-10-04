</div>
            <!--  /.main.container -->
</div>
        <!--  /#mw-admin-main-block -->
 <?php
    $usertokenDrm = Config::get('microweber.userToken');
    $excludeurl = Config::get('global.exluded_url');

    if (function_exists('dt_admin_contains_any') && dt_admin_contains_any(url()->current(),$excludeurl) ) {
        //  $usertokenDrm=true;
    }

?>
<div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: <?php if(isset($usertokenDrm) && !empty($usertokenDrm)){?>none;<?php }else{  ?> block; <?php } ?>">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">

    </div>
    <div class="js-login-window">
        <!-- <div class="modal-header">
            <h3 id="myModalLabel">Verbinde jetzt DROPTIENDA® mit DROPMATIX®</h3>
        </div> -->
        <div class="modal-body">
            <div class="drm-login-image">
                <img src="<?php print modules_url(); ?>drm-login-image.jpg" alt="">
                <div class="image-heading">
                    <h5>Verbinde jetzt DROPTIENDA® mit DROPMATIX®</h5>
                </div>
            </div>
            <p style="font-weight:bold">Du hast bereits einen DROPMATIX Account? Dann logge dich jetzt ein.</p>
            <p id="false_txt"></p>

            <div class="form-group">
                <label for="installUserInput" class="mw-ui-label">Nutzername</label>
                <input type="text"class="form-control" id="installUserInput" name="installUserName" placeholder="User Name">
            </div>
            <div class="form-group">
                <label for="installUserPass" class="mw-ui-label">Passwort</label>
                <input type="password" class="form-control" id="installUserPass" name="installUserPass" placeholder="Password">
            </div>
            <p id="false_txt" class="text-danger"></p>
            <a href="https://drm.software/registration/sign-up" target="_blank" style="display: block;margin-bottom: 10px;text-decoration: underline;text-align:right;color:#074A74">Passwort vergessen ?</a>
            <div class="form-group">
                <div class="admin_login-btn">
                <button type="submit" class="btn btn-custom action-button" id="close_btn">Anmeldung</button>
                <!-- <span class="tooltiptext">Stimmen Sie mit unserem überein Geschäftsbedingungen</span> -->

                </div>
            </div>

        </div>

    </div>
    <div class="js-register-window">
        <div class="modal-body">
            <h3 style="text-align: center;">Erstelle jetzt einen neuen Account.</h3>
            <p style="text-align: center;font-weight:600">Wir freuen uns, dich in unserer Community begrüßen zu dürfen. </p>
            <div class="form-group">
                <input class="form-control input-lg" type="text" id="installUserInputNamer" name="installUserNameCheckr" placeholder="<?php _lang('Name', "templates/bamboo"); ?>">
            </div>

            <div class="form-group">
                <input class="form-control input-lg" type="email" id="installUserInputr" name="installUserNamer" placeholder="<?php _lang('Email', "templates/bamboo"); ?>">
            </div>

            <div class="form-group m-t-20">
                <input class="form-control input-lg" type="password" id="installUserPassr" name="installUserPassr" placeholder="<?php _lang('Passwort', "templates/bamboo"); ?>">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="terms_checkbox">ich akzeptiere die <a href="https://drm.software/term-and-conditions" style="text-decoration: underline;color:#000;" target="_blank">AGB</a>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="terms_checkbox">ich akzeptiere die <a href="https://drm.software/privacy-policy" style="text-decoration: underline;color:#000;" target="_blank">Datenschutzerklärung</a>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="terms_checkbox"> Ich willige ein, dass meine Daten wie Namen, Vorname, Adresse, Telefonnummer, Email- und IP-Adresse sowie Kontodaten und Kredikarteninformationen in Drittländer transferiert werden. Dort können unter Umständen Polizeibehörden und ggf. Geheimdienste auf die Daten zugreifen.
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="terms_checkbox"> Ich bin damit einverstanden im Falle eines Verkaufes eine pauschale Transaktionsgebühr von 0,30 Cent zzgl. 1,4 % des Brutto Verkaufspreises zum Ende jedes laufenden Monats zu bezahlen.
                </label>
            </div>
            <div class="admin_login-btn">
                <button type="submit" class="btn btn-custom drm-reg-btn" id="close_btn" disabled>Jetzt anmelden und Shop verbinden</button>
                </div>
            <p class="or"><span>oder</span></p>
            <div class="act create">
                <a href="#" class="js-show-login-window"><span><i class="fa fa-backward" style="margin-right: 10px;" aria-hidden="true"></i>zurück zum Login</span></a>
            </div>
        </div>

    </div>
</div>
</div>
</div>

<!-- DRM Connect Message -->

<div id="drm" class="modal pd-20 hideWhenClickChangeAC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <span class="c-close-btn">
              <i class="fas fa-times"></i>
            </span>
            <div class="drm-card-wrapper">

                <div class="card-content">
                    <div class="card-img">
                    <img src="<?php print modules_url(); ?>drm-connect-image.png" alt="">
                    </div>
                    <div class="card-top">
                    <span class="icon">
                        <img src="<?php print modules_url(); ?>green-circle.png" alt="">
                    </span>
                    <?php $username = Config::get('microweber.userName'); ?>
                    <h3 class="card-heading drm-user-name"><?php _e('Connected to'); ?>: <?php print $username; ?> </h3>
                    </div>
                        <div class="card-links">
                        <a href="#" id="changeAcBtn" data-toggle="modal" data-target="#myModal" style="display: block;margin-bottom: 10px;text-decoration: underline;text-align:right;color:#074A74"><?php _e('Change account'); ?></a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


<style>
    #drm-account-connect .modal-dialog {
        margin-top: 200px;
    }

    #myModal.shadow {
        z-index: 1020;
    }
</style>

<!--After Registration Modal -->
<div class="modal" id="afterReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <h3>Sie haben sich erfolgreich registriert.</h3>
                <h4>Bitte überprüfen Sie die E-Mail, um Ihre zu aktivieren <a href="http://drm.software/" style="display:inline-block">DRM</a> Konto. Unmittelbar danach ist Ihr Geschäft einsatzbereit.</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="drm-account-connect" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="hide-div">
            <h4>Do you already have a Dropmatix account?</h4>
            <div class="text-center">
                        <button class="btn btn-success" id="yes-btn">Yes</button>
                <button class="btn btn-secondary" id="no-btn">No</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?php print modules_url(); ?>/admin/js/jquery-image-scroll.js"></script>

<script>
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "<?=api_url('licence_drm_connect')?>",
                success: function (response) {
                    if (response.message) {
                        window.onUsersnapCXLoad = function (api) {
                        api.init();
                    }
                    var script = document.createElement('script');
                    script.async = 1;
                    script.src = 'https://widget.usersnap.com/load/9c33bd00-3564-480d-b89f-b104f6f0fb90?onload=onUsersnapCXLoad';
                    document.getElementsByTagName('head')[0].appendChild(script);
                }
            }
        });
    });

    $(window).on('load', function () {

        $('.screen').scrollImage();
    });


    function setConfig(userT, userP, userN) {
        $.post("<?= api_url('config_set_drm') ?>", {
                userToken: userT,
                userPassToken: userP,
                userName: userN,
        });
    }

    $(document).ready(function () {

        $("#changeAcBtn").click(function(){
             $(".hideWhenClickChangeAC").hide();
        });

        $(".c-close-btn").click(function(){
             $(".hideWhenClickChangeAC").hide();
        });

        $("#drm-account-connect").modal("hide");

        $(".action-button").on("click", function () {
            $("#myModal").addClass("shadow");


            var email = document.querySelector("#installUserInput").value;
            var password = document.querySelector("#installUserPass").value;
            // console.log(email,password);


            $.post("<?= url('/') ?>/api/v1/drm_token_get", {
                installUserName: email,
                installUserPass: password,
                url: "<?=url('/')?>"
            }, (res) => {

                if (res.success) {


                    jQuery('.drm-user-name').text("<?php _e('Connected to'); ?>: " + res.userName);
                    // console.log(res);

                    setConfig(res.userToken, res.userPassToken, res.userName)

                    $('#myModal').hide();
                    $('#drm').show();

                    // return false;

                } else {
                    // console.log(res)
                    if(res.status){
                        $("#drm-account-connect").modal("show");
                    }else{
                        var htmlvalue = "Your DRM account is not Active!";
                    $("#false_txt").html(htmlvalue);
                    }
                    // var htmlvalue = res.message;
                    // $("#false_txt").html(htmlvalue);
                    // return false;
                }

            });

            $("#yes-btn").click(function () {
                var htmlvalue = "Your password is incorrect! Please provide a valid Password.";
                $("#false_txt").html(htmlvalue);
                $("#drm-account-connect").modal("hide");
        });
            $("#no-btn").click(function () {
                var htmlvalue = "This email already used! Please provide a new Email.";
                $("#false_txt").html(htmlvalue);
                $("#drm-account-connect").modal("hide");
            });

        });
        $(".drm-reg-btn").on("click", function () {
            var name = document.querySelector("#installUserInputNamer").value;
            var email = document.querySelector("#installUserInputr").value;
            var password = document.querySelector("#installUserPassr").value;
            var register = "dt";
            // console.log(email,password);


            $.post("<?= url('/') ?>/api/v1/drm_token_get", {
                name: name,
                installUserName: email,
                installUserPass: password,
                url: "<?=url('/')?>",
                is_register: register
            }, (res) => {

                if (res.success) {



                    // console.log('dfhfiasfuhiasu');

                    setConfig(res.userToken, res.userPassToken)

                    $('#myModal').hide();
                    $('#afterReg').modal("show");
                    // return false;

                } else {
                    // console.log(res)
                    var htmlvalue = res.message;
                    $("#false_txt").html(htmlvalue);
                    return false;
                }

            });

        });

        $(".terms_checkbox").change(function () {
            if ($('.terms_checkbox:checked').length == $('.terms_checkbox').length) {
                $('.drm-reg-btn').removeAttr('disabled');
                 $('.tooltiptext').hide();
            } else {
                $('.drm-reg-btn').prop('disabled', true);
                     $('.tooltiptext').show();
            }
        });
        $('.js-register-window').hide();
        $('.js-show-register-window').on('click', function () {
            $('.js-login-window').hide();
            $('.js-register-window').show();
        });
        $('.js-show-login-window').on('click', function () {

            $('.js-register-window').hide();
            $('.js-login-window').show();
        });
    });
</script>


    </body>

</html>

