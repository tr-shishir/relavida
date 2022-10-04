<?php $user = get_user_by_id(user_id());
$countries_all = mw()->forms_manager->countries_list();
?>
<div>
    <script>
        saveuserdata = function () {
            var data = mw.serializeFields('#user-data');
            // if (data.password != data.password2) {
            //     return false;
            // } else {
            //     mw.$('#errnotification').hide();
            //
            //     if (data.password == '') {
            //         delete data.password;
            //         delete data.password2;
            //     }
            // }
            mw.tools.loading('#user-data')
            $.post("<?php print api_url(); ?>save_user", data, function () {
                mw.tools.loading('#user-data', false);
                mw.$('#succnotification').html('Profile updated successfully').show();
                location.reload();

            });
        }
    </script>


    <p>From this window you can edit your profile.<br/><br/></p>

    <form method="post" id="user-data">
        <div class="mw-ui-box mw-ui-box-important mw-ui-box-content" id="errnotification" style="display: none;margin-bottom: 12px;"></div>
        <div class="mw-ui-box mw-ui-box-important mw-ui-box-content" id="succnotification" style="display: none;margin-bottom: 12px; background-color:green !important;"></div>

        <!--        <div class="form-group">-->
        <!--            <input class="form-control input-lg" type="text" name="username" value="--><?php //print $user['username']; ?><!--" placeholder="--><?php //_lang('Username or E-mail', "templates/bamboo"); ?><!--">-->
        <!--        </div>-->

        <div class="form-group">
            <input class="form-control input-lg" type="email" name="email" value="<?php print $user['email']; ?>" placeholder="<?php _lang('E-mail'); ?>">
        </div>

        <div class="form-group">
            <input class="form-control input-lg" type="text" name="first_name" value="<?php print $user['first_name']; ?>" placeholder="<?php _lang('First name'); ?>">
        </div>

        <div class="form-group">
            <input class="form-control input-lg" type="text" name="last_name" value="<?php print $user['last_name']; ?>" placeholder="<?php _lang('Last name'); ?>">
        </div>

        <div class="form-group">
            <select name="country" class="shipping-country-select form-control" id="country_name">
                <option value=""><?php _e("Choose country"); ?></option>
                <?php foreach($countries_all  as $item): ?>
                    <option value="<?php print $item ?>"  <?php if(isset($user['country']) and $user['country'] == $item): ;?> selected="selected" <?php endif; ?>><?php print $item ?></option>
                <?php endforeach ;?>
            </select>
        </div>

        <!--        <div class="form-group">-->
        <!--            <input class="form-control input-lg" type="password" name="password" placeholder="--><?php //_lang('New Password', "templates/bamboo"); ?><!--">-->
        <!--        </div>-->
        <!---->
        <!--        <div class="form-group">-->
        <!--            <input class="form-control input-lg" type="password" name="password2" placeholder="--><?php //_lang('Confirm Password', "templates/bamboo"); ?><!--">-->
        <!--        </div>-->

        <button type="button" class="btn btn-default btn-lg btn-block m-t-10" onclick="saveuserdata()"><?php _lang('Save'); ?></button>
    </form>
</div>