<div id="msg<?php print $form_id; ?>" style="display:none;">
    <div class="alert alert-success">
        <h2>Form has been sent</h2>
        <p>We will contact you soon with a responce.</p>
    </div>
</div>

<form class="nk-form nk-form-ajax mw_form form" data-form-id="<?php print $form_id ?>" name="<?php print $form_id ?>" method="post">
    <?php print csrf_form() ?>
    <input type="hidden" name="for" value="contact_form"/>
    <input type="hidden" name="for_id" value="<?php print $params['id']; ?>"/>

    <div class="row vertical-gap">
        <div class="col-md-6">
            <input type="text" class="form-control required" name="name" placeholder="Your Name" required>
        </div>
        <div class="col-md-6">
            <input type="email" class="form-control required" name="email" placeholder="Your Email" required>
        </div>
    </div>

    <div class="nk-gap-1"></div>
    <input type="text" class="form-control required" name="title" placeholder="Your Title">

    <div class="nk-gap-1"></div>
    <textarea class="form-control required" name="message" rows="8" placeholder="Your Comment" aria-required="true" required></textarea>

    <div class="nk-gap-1"></div>
    <?php if (get_option('disable_captcha', $params['id']) != 'y'): ?>
        <module type="captcha"/>
    <?php endif; ?>
    <div class="nk-gap-1"></div>

    <div class="nk-form-response-success"></div>
    <div class="nk-form-response-error"></div>
    <button class="nk-btn" type="submit">Send Message</button>
</form>