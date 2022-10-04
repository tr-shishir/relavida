<?php

/*

type: layout

name: Login admin

description: Admin login style

*/

?>

<?php
$user = user_id();
$selected_lang = 'en';

if (isset($_COOKIE['lang'])) {
    $selected_lang = $_COOKIE['lang'];
}

$current_lang = current_lang();


if (!isset(mw()->ui->admin_logo_login_link) or mw()->ui->admin_logo_login_link == false) {
    $link = site_url();

} else {
    $link = mw()->ui->admin_logo_login_link;
}
?>
<div class="main container my-3" id="mw-login">
    <script>mw.require("session.js");</script>
    <script>
        mw.session.checkPauseExplicitly = true;
        $(document).ready(function () {
            mw.tools.dropdown();
            mw.session.checkPause = true;
            // mw.$("#lang_selector").on("change", function () {
            //     mw.cookie.set("lang", $(this).getDropdownValue());
            // });
        });

        function select_Language() {
            var cooklie_lang = $("#user_lang").val();
            // console.log(cooklie_lang);
            aplyChangeLanguage(cooklie_lang);
        }

        function aplyChangeLanguage(selectedLang) {
           $.ajax({
               type: "POST",
               url: mw.settings.api_url + "apply_change_language",
               data: {lang: selectedLang},
               success: function (data) {
                   $.get(mw.settings.api_url + "clearcache", {}, function () {
                    //    mw.notification.success("<?php _ejs("Clear cache.."); ?>.");
                    //    location.reload();
                   });
               }
           });
       }

    </script>

    <main class="w-100" style="min-height: 100vh;">
        <div class="row mb-5">
            <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4 mx-auto">
                <div class="m-auto" style="max-width: 380px;">
                    <a href="<?php print $link; ?>" target="_blank" id="login-logo" class="mb-4 d-block text-center">
                        <img src="<?php print modules_url(); ?>microweber/images/admin-logo.png" alt="Logo" style="max-width: 70%;"/>
                    </a>

                    <div class="card mb-3">
                        <div class="card-body py-4" id="admin_login">
                            <?php if ($user != false): ?>
                                <div><?php _e("Welcome") . ' ' . user_name(); ?></div>
                                <a href="<?php print site_url() ?>"><?php _e("Go to"); ?> &nbsp;
                                    <small><?php print site_url() ?></small>
                                </a>
                                <br/>
                                <a href="<?php print api_link('logout') ?>"><?php _e("Log Out"); ?></a>
                            <?php else: ?>
                                <?php if (get_option('enable_user_microweber_registration', 'users') == 'y' and get_option('microweber_app_id', 'users') != false and get_option('microweber_app_secret', 'users') != false): ?>
                                <?php endif; ?>

                                <?php event_trigger('mw.ui.admin.login.form.before'); ?>
                                <?php if(session('status')): ?>
                                    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> <?php print session('status'); ?></em></div>
                                <?php endif; ?>
                                <form autocomplete="on" method="post" id="user_login_<?php print $params['id'] ?>" action="<?php print api_link('user_login') ?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label class="text-muted" for="username"><?php _e('Username'); ?>:</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="<?php _e("Username or Email"); ?>" <?php if (isset($input['username']) != false): ?>value="<?php print $input['username'] ?>"<?php endif; ?> autofocus=""/>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="text-muted" for="inputDefault"><?php _e('Password'); ?>:</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="<?php _e("Password"); ?>" <?php if (isset($input['password']) != false): ?>value="<?php print $input['password'] ?>"<?php endif; ?> required>
                                            </div>
                                        </div>

                                        <?php if (isset($login_captcha_enabled) and $login_captcha_enabled): ?>
                                            <?php
                                            /* <div class="col-12">
                                                <div class="form-group mb-3">
                                                    <label class="text-muted" for="captcha-field-<?php print $params['id']; ?>">Captcha:</label>

                                                    <div class="input-group mb-3 prepend-transparent">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text p-0 overflow-hidden">
                                                            <img onclick="mw.tools.refresh_image(this);" id="captcha-<?php print $params['id']; ?>" src="<?php print api_link('captcha') ?>" style="max-height: 38px;"/>
                                                        </span>
                                                        </div>

                                                        <input name="captcha" type="text" required class="form-control" placeholder="<?php _e("Security code"); ?>" id="captcha-field-<?php print $params['id']; ?>"/>
                                                    </div>
                                                </div>
                                            </div>*/

                                            ?>
                                            <div class="col-12">
                                                <module type="captcha" template="admin"/>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="text-muted"><?php _e("Language"); ?>:</label>
                                                <?php
                                                $langs = mw()->lang_helper->get_all_lang_codes();
                                                $def_language = current_lang();
                                                if ($def_language == false) {
                                                    $def_language = 'de';
                                                }

                                                ?>
                                                <?php if ($langs) : ?>
                                                    <select id="user_lang" name="language" class="mw_option_field selectpicker" data-size="7" data-width="100%" option-group="website" data-also-reload="settings/group/language_edit">
                                                        <option disabled="disabled"><?php _e('Select Language...'); ?></option>
                                                        <?php foreach (array_reverse($langs) as $key => $lang): ?>
                                                            <option <?php if ($def_language == $key): ?> selected="" <?php endif; ?> value="<?php print $key ?>"><?php _e($lang); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 text-center text-sm-right">
                                            <input type="hidden" name="where_to" value="admin_content"/>
                                            <?php if (isset($_GET['redirect'])): ?>
                                                <input type="hidden" value="<?php echo $_GET['redirect']; ?>" name="redirect">
                                            <?php endif; ?>
                                            <div class="form-group">
                                                <label class="d-none d-sm-block">&nbsp;</label>
                                                <button class="btn btn-outline-primary btn-sm"  onclick=(select_Language())  type="submit"><?php _e("Login"); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <?php event_trigger('mw.ui.admin.login.form.after'); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-sm-12 d-md-flex align-items-center justify-content-between">
                            <a href="<?php print site_url() ?>" class="btn btn-link text-dark btn-sm"><i class="mdi mdi-arrow-left"></i> <?php _e("Back to My WebSite"); ?></a>

                            <a href="javascript:;" onClick="mw.load_module('users/forgot_password', '#admin_login', false, {template:'admin'});" class="btn btn-link btn-sm"><?php _e("Forgot my password"); ?>?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <module type="admin/copyright"/>
    </main>
</div>
