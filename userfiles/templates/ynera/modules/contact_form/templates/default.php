<?php

/*

type: layout

name: Default

description: Default

*/

?>

<style>
#contactform {
    background: #fff;
    padding: 30px;
    box-shadow: 0px 30px 40px 0px rgb(0 0 0 / 20%);
}
</style>

<div class="alert alert-success margin-bottom-30" id="msg<?php print $form_id; ?>" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong><?php _lang("Thank You", "templates/ynera"); ?>!</strong>
    <?php _lang("Your message successfully sent", "templates/ynera"); ?>!
</div>




<div class="section-42 contact-wrapper">
    <div class="container">
        <div class="form">
            <form id="contactform" data-form-id="<?php print $form_id ?>" name="<?php print $form_id ?>" method="post">
                <?php print csrf_form() ?>
                <input type="hidden" name="for" value="contact_form" />
                <input type="hidden" name="for_id" value="<?php print $params['id']; ?>" />

                <div class="row">
                    <div class="col-12">
                        <module type="custom_fields" default-fields="name, email, phone, message"
                            input_class="form-control" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">

                        <!-- <div class="form-group">
                        <?php /*if (get_option('disable_captcha', $params['id']) != 'y'): */ ?>
                            <module type="captcha" template="default"/>
                        <?php /*endif; */ ?>
                    </div>-->

                        <module type="btn" template="bootstrap" button_action="submit" button_style="btn-default"
                            button_size="btn-lg btn-block" text="Send Message" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>