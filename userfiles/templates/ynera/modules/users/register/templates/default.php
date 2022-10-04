<?php

/*

type: layout

name: Default

description: Default register template

*/

$countries_all = mw()->forms_manager->countries_list();
$tax_default = DB::table('tax_rates')->where('is_default', 1)->first();
?>
<?php if (is_logged() == false): ?>
    <script type="text/javascript">
        mw.moduleCSS("<?php print modules_url(); ?>users/users_modules.css");
        mw.require('forms.js', true);
        mw.require('url.js', true);
        $(document).ready(function () {
            mw.$('#user_registration_form_holder').submit(function () {
                mw.form.post(mw.$('#user_registration_form_holder'), '<?php print site_url('api') ?>/user_register', function () {
                    mw.response('#register_form_holder', this);
                    if (typeof this.success !== 'undefined') {
                        mw.form.post(mw.$('#user_registration_form_holder'), '<?php print site_url('api') ?>/user_login', function () {
                            mw.load_module('users/login', '#<?php print $params['id'] ?>');
                            window.location.href = window.location.href;
                        });
                    }
                });
                return false;
            });
        });
    </script>

    <div id="register_form_holder">
        <h2  class="text-center p-t-10 edit" field="register_heading" rel="module">
            Neues Kundenkonto anlegen.

        </h2>
        <h4 class="text-center p-t-10" field="register_massage" rel="module"> Die Anmeldung ist 100% kostenfrei </h4>
        <form class="p-t-10" action="#" id="user_registration_form_holder" method="post">
            <?php print csrf_form(); ?>
            <?php if ($form_show_first_name): ?>
                <div class="form-group">
                    <input class="form-control input-lg" type="text" name="first_name" placeholder="<?php _lang('Vorname', "templates/bamboo"); ?>">
                </div>
            <?php endif; ?>

            <?php if ($form_show_last_name): ?>
                <div class="form-group">
                    <input class="form-control input-lg" type="text" name="last_name" placeholder="<?php _lang('Nachname', "templates/bamboo"); ?>">
                </div>
            <?php endif; ?>

            <div class="form-group">
                <input class="form-control input-lg" type="email" name="email" placeholder="<?php _lang('Email', "templates/bamboo"); ?>">
            </div>

            <div class="form-group m-t-20">
                <input class="form-control input-lg" type="password" name="password" placeholder="<?php _lang('Passwort', "templates/bamboo"); ?>">
            </div>

            <div class="form-group">
                <select name="country" class="shipping-country-select form-control" id="country_name">
                    <option value=""><?php _e("Choose country"); ?></option>
                    <?php foreach($countries_all  as $item): ?>
                        <option value="<?php print $item ?>"  <?php if(isset($tax_default->country) and $tax_default->country == $item): ;?> selected="selected" <?php endif; ?>><?php print $item ?></option>
                    <?php endforeach ;?>
                </select>
            </div>

            <?php if ($form_show_password_confirmation): ?>
                <div class="form-group m-t-20">
                    <input class="form-control input-lg" type="password" name="password2" placeholder="">
                </div>
            <?php endif; ?>

            <?php if (!$captcha_disabled): ?>
                <module type="captcha" template="skin-1"/>
            <?php endif; ?>

            <button type="submit" class="btn btn-default btn-lg btn-block m-t-30 m-b-20">Weiter</button>
        </form>
    </div>
<?php else: ?>
    <p class="text-center">
        <?php _lang('You Are Logged In', "templates/bamboo"); ?>">
    </p>
<?php endif; ?>
<br/>
