<?php

/*

type: layout

name: Default

description: Default

*/

?>

<div class="alert alert-success margin-bottom-30" id="msg<?php print $form_id; ?>" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong><?php _lang("Thank You", "templates/active"); ?>!</strong>
    <?php _lang("Your message successfully sent", "templates/active"); ?>!
</div>
<div class="section-42">
    <div class="form">
        <form id="contactform" data-form-id="<?php print $form_id ?>" name="<?php print $form_id ?>" method="post">
            <?php print csrf_form() ?>
            <input type="hidden" name="for" value="contact_form" />
            <input type="hidden" name="for_id" value="<?php print $params['id']; ?>" />

            <div class="row">
                <div class="col-12">
                    <div class="edit" rel="content" field="active-form-content">
                        <div class="form-group">
                            <label class="control-label" for="first_name">Name</label>
                            <input class="form-control" id="first_name" name="first_name" type="text"
                                placeholder="Vollständiger Name">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email">E-mail</label>
                            <input class="form-control" id="email" name="email" type="email"
                                placeholder="E-Mail-Addresse">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="company">Unternehmen</label>
                            <input class="form-control" id="company" type="text"
                                placeholder="Unternehmen / Organisation">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="subject">Untertan</label>
                            <input class="form-control" id="subject" name="subject" type="text"
                                placeholder="Betreff definieren">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="message">Nachricht</label>
                            <textarea class="form-control" id="message" name="message"
                                placeholder="Schreiben Sie ihre Nachricht hier"></textarea>
                        </div>

                        <div class="form-group">
                            <?php if (get_option('disable_captcha', $params['id']) != 'y'): ?>
                            <module type="captcha" template="default" />
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-default btn-lg btn-block">Nachricht senden</button>
                </div>
            </div>
        </form>
    </div>
</div>
