<module type="editor/stylesheet_compiler"/>

<?php include('template_settings_options.php'); ?>
<script>mw.lib.require('bootstrap3ns');</script>

<style>
    .bootstrap3ns .checkbox label, .bootstrap3ns .radio label {
        padding-left: 0;
    }
</style>

<div id="settings-holder">
    <div class="col-12">
        <h5 style="font-weight: bold;"><?php _lang("Website Settings", "templates/active"); ?></h5>
    </div>

    <div class="bootstrap3ns">
        <div class="form-group">
            <label for="select" class="control-label">Sticky Navigation</label>
            <div>
                <select name="sticky_navigation" id="sticky_navigation" class="mw_option_field form-control" data-option-group="<?php echo $option_group; ?>">
                    <option value="" <?php if ($sticky_navigation == '') {
                        echo 'selected';
                    } ?>>Normal
                    </option>
                    <option value="sticky-nav"<?php if ($sticky_navigation == 'sticky-nav') {
                        echo 'selected';
                    } ?>>Sticky
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="select" class="control-label">Member Navigation Style</label>
            <div>
                <select name="member_navigation_style" id="member_navigation_style" class="mw_option_field form-control" data-option-group="<?php echo $option_group; ?>">
                    <option value="" <?php if ($member_navigation_style == '') {
                        echo 'selected';
                    } ?>>Normal
                    </option>
                    <option value="member-nav-inverse"<?php if ($member_navigation_style == 'member-nav-inverse') {
                        echo 'selected';
                    } ?>>Inverse
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="select" class="control-label">Titles in Black</label>
            <div>
                <select name="titles_inverse" id="titles_inverse" class="mw_option_field form-control" data-option-group="<?php echo $option_group; ?>">
                    <option value="" <?php if ($titles_inverse == '') {
                        echo 'selected';
                    } ?>>Normal
                    </option>
                    <option value="titles-inverse"<?php if ($titles_inverse == 'titles-inverse') {
                        echo 'selected';
                    } ?>>In Black
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="select" class="control-label">Buttons Style</label>
            <div>
                <select name="buttons_style" id="buttons_style" class="mw_option_field form-control" data-option-group="<?php echo $option_group; ?>">
                    <option value="" <?php if ($buttons_style == '') {
                        echo 'selected';
                    } ?>>Normal
                    </option>
                    <option value="rounded-buttons"<?php if ($buttons_style == 'rounded-buttons') {
                        echo 'selected';
                    } ?>>Rounded
                    </option>
                    <option value="squared-buttons"<?php if ($buttons_style == 'squared-buttons') {
                        echo 'selected';
                    } ?>>Squared
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label class="mw-ui-check">
                    <input type="checkbox" class="mw_option_field" id="shopping_cart" name="shopping_cart" data-option-group="<?php echo $option_group; ?>" value="true" <?php if ($shopping_cart == 'true') {
                        echo 'checked';
                    } ?> />
                    <span></span><span><?php _lang("Show shopping cart in header", "templates/active"); ?></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label class="mw-ui-check">
                    <input type="checkbox" class="mw_option_field" id="profile_link" name="profile_link" data-option-group="<?php echo $option_group; ?>" value="true" <?php if ($profile_link == 'true') {
                        echo 'checked';
                    } ?> />
                    <span></span><span><?php _lang("Show Profile link in header", "templates/active"); ?></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label class="mw-ui-check">
                    <input type="checkbox" class="mw_option_field" id="footer" name="footer" data-option-group="<?php echo $option_group; ?>" value="true" <?php if ($footer == 'true') {
                        echo 'checked';
                    } ?> />
                    <span></span><span><?php _lang("Turn off Footer for website", "templates/active"); ?></span>
                </label>
            </div>
        </div>
    </div>
</div>
<!-- /#settings-holder -->