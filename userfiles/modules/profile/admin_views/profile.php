<style>
    .tariff-profile-form {
        padding: 10px;
        border-radius: 5px;
    }

    .genaral-info {
        padding: 10px;
        border-radius: 5px;
        border-bottom: 2px solid #dfdfdf;
    }

    .contact-info {
        padding: 10px;
        border-radius: 5px;
        border-bottom: 2px solid #dfdfdf;
        margin-top: 30px;
    }

    .customer-info {
        padding: 10px;
        border-radius: 5px;
        margin-top: 30px;
    }

    .tariff-profile-form-button {
        text-align: right;
        margin-top: 20px;
    }

    .form {
        box-shadow: 0 0 1px 1px #e6e6e6;
        border-radius: 5px;
        padding: 10px;
        background: #fff;
    }
</style>
<?php


    $u_id = user_id();
    $user_info = get_user_by_id($u_id);
    $key = "admin_profile_data_".$u_id;
    $user_profile_info = get_option($key, 'admin_profile_data');
    if($user_profile_info){
        $user_profile_info = json_decode($user_profile_info, true);
    }

    if(session('success_status')){
        print '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> '. session('success_status') .'</em></div>';
    }

    if(session('failed_status')){
        print '<div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em> '. session('failed_status') .'</em></div>';
    }

    $countries = DB::table('tax_rates')->pluck('country')->toArray();
    $selected_country = (is_array($user_profile_info) and isset($user_profile_info['country'])) ? $user_profile_info['country'] : "";
?>
<div class="card bg-none style-1 mb-0 card-settings">
    <div class="card-header px-0">
        <h5 class="w-100"><i class="mdi mdi-id-card text-primary mr-3"></i> <strong><?php _e('Profile Data'); ?></strong></h5>
        <div class="d-block w-100">
            <nav class="anchorific"></nav>
        </div>
    </div>
</div>
<div class="tariff-profile-form">
    <form action="<?php print api_url('update_admin_profile_data') ?>" method="post">
        <div class="genaral-info">
            <div class="row">
                <div class="col-6 col-md-4">
                    <h5 class="font-weight-bold"><?php _e('Your customer data'); ?></h5>
                    <small class="text-muted"><?php _e('Enter your current customer data here, this data will be used for billing and the order processing contract. Please keep this information up to date'); ?>.</small>
                </div>
                <div class="col-12 col-sm-6 col-md-8 form">
                    <div class="form-group">
                        <label><?php _e('Email'); ?>*</label>
                        <input type="email" class="form-control" name="email" disabled value="<?php if(isset($user_info['email'])) print $user_info['email']; ?>">
                        <input type="hidden" name="email" value="<?php if(isset($user_info['email'])) print $user_info['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label><?php _e('Company'); ?></label>
                        <input type="text" class="form-control" name="company" value="<?php if(is_array($user_profile_info) and isset($user_profile_info['company'])) print $user_profile_info['company']; ?>">
                    </div>
                    <!-- <div class="form-group">
                        <label><?php //_e('Salutation'); ?></label>
                        <input type="text" class="form-control" name="salutation" value="<?php //if(is_array($user_profile_info) and isset($user_profile_info['salutation'])) print $user_profile_info['salutation']; ?>"> -->
                        <!-- <select class="form-control" name="salutation"  value="<?php //if(is_array($user_profile_info) and isset($user_profile_info['salutation'])) print $user_profile_info['salutation']; ?>">
                            <option selected>..</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select> -->
                    <!-- </div> -->
                    <!-- <div class="form-group">
                        <label><?php //_e('Title'); ?></label>
                        <input type="text" class="form-control" name="title"  value="<?php if(is_array($user_profile_info) and isset($user_profile_info['title'])) print $user_profile_info['title']; ?>">
                    </div> -->
                    <div class="form-group">
                        <label><?php _e('Name'); ?>*</label>
                        <input type="text" class="form-control" name="first_name" value="<?php if(is_array($user_profile_info) and isset($user_profile_info['first_name'])) print $user_profile_info['first_name']; ?>" required>
                    </div>
                    <!-- <div class="form-group">
                        <label><?php //_e('Last name'); ?></label>
                        <input type="text" class="form-control" name="last_name"  value="<?php //if(is_array($user_profile_info) and isset($user_profile_info['last_name'])) print $user_profile_info['last_name']; ?>">
                    </div> -->
                    <div class="form-group">
                        <label><?php _e('Address'); ?>*</label>
                        <input type="text" class="form-control" name="address" value="<?php if(is_array($user_profile_info) and isset($user_profile_info['address'])) print $user_profile_info['address']; ?>" required>
                    </div>
                    <!-- <div class="form-group">
                        <label><?php //_e('Address Supplement'); ?></label>
                        <input type="text" class="form-control" name="address_supplement" value="<?php //if(is_array($user_profile_info) and isset($user_profile_info['address_supplement'])) print $user_profile_info['address_supplement']; ?>">
                    </div> -->
                    <div class="form-group">
                        <label><?php _e('Postal Code'); ?>*</label>
                        <input type="text" class="form-control" name="postal_code" value="<?php if(is_array($user_profile_info) and isset($user_profile_info['postal_code'])) print $user_profile_info['postal_code']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label><?php _e('City'); ?>*</label>
                        <input type="text" class="form-control" name="city" value="<?php if(is_array($user_profile_info) and isset($user_profile_info['city'])) print $user_profile_info['city']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label><?php _e('Country'); ?> *</label>
                        <select class="form-control" name="country" required>
                            <option value="">Select one</option>
                            <?php foreach ($countries as $val){ ?>
                                <option value="<?php print $val; ?>" <?php if($val==$selected_country || $val=="Germany") print "Selected";  ?>><?php print $val ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-info">
            <div class="row">
                <div class="col-6 col-md-4">
                    <h5 class="font-weight-bold"><?php _e('Contact details'); ?></h5>
                    <small class="text-muted"><?php _e('Please enter your contact details here'); ?>.</small>
                </div>
                <div class="col-12 col-sm-6 col-md-8 form">
                    <div class="form-group">
                        <label><?php _e('Phone'); ?></label>
                        <input type="text" class="form-control" name="phone" value="<?php if(is_array($user_profile_info) and isset($user_profile_info['phone'])) print $user_profile_info['phone']; ?>">
                    </div>
                    <div class="form-group">
                        <label><?php _e('Email'); ?>*</label>
                        <input type="email" class="form-control" name="email" disabled value="<?php if(isset($user_info['email'])) print $user_info['email']; ?>">
                    </div>
                    <!-- <div class="form-group">
                        <label><?php //_e('Mobile'); ?></label>
                        <input type="text" class="form-control" name="mobile" value="<?php //if(is_array($user_profile_info) and isset($user_profile_info['mobile'])) print $user_profile_info['mobile']; ?>">
                    </div>
                    <div class="form-group">
                        <label><?php //_e('Fax'); ?></label>
                        <input type="text" class="form-control" name="fax" value="<?php //if(is_array($user_profile_info) and isset($user_profile_info['fax'])) print $user_profile_info['fax']; ?>">
                    </div> -->
                </div>
            </div>
        </div>
        <div class="customer-info">
            <div class="row">
                <div class="col-6 col-md-4">
                    <h5 class="font-weight-bold"><?php _e('Customer Information'); ?></h5>
                    <small class="text-muted"><?php _e('You can update your customer information here'); ?>.</small>
                </div>
                <div class="col-12 col-sm-6 col-md-8 form">
                    <div class="form-group">
                        <label><?php _e('VAT ID no'); ?>.</label>
                        <input type="text" class="form-control valid_id" onkeyup="check_valid_id(this.value)" name="valid_id" value="<?php if(is_array($user_profile_info) and isset($user_profile_info['valid_id'])) print $user_profile_info['valid_id']; ?>">
                        <span id="valid_error"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="tariff-profile-form-button">
            <button class="btn btn-success info_save_btn">
                <?php _e('Save'); ?>
            </button>
        </div>
    </form>
</div>

<script>
    function check_valid_id(data){
        if(data.length == 0){
            jQuery('.info_save_btn').removeAttr('disabled');
            jQuery('#valid_error').text('');
            jQuery('.valid_id').css('border', '1px solid gray');
        } else{
            $.get("https://drm.software/api/check-vat-number?vat_id="+data,function(res){
                if(res['success']){
                    jQuery('.info_save_btn').removeAttr('disabled');
                    jQuery('#valid_error').text('This id is verrified');
                    jQuery('.valid_id').css('border', '1px solid gray');
                    jQuery('#valid_error').css("color", 'green');
                }else{
                    jQuery('.info_save_btn').attr('disabled', true);
                    jQuery('.valid_id').css('border', '1px solid red');
                    jQuery('#valid_error').text("This id is invalid!");
                    jQuery('#valid_error').css("color", 'red');
                }
            });


        }
    }
</script>
