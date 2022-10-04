
<?php include modules_path() . 'editor' . DS . 'template_settings' . DS . 'generated_vars.php'; ?>

<?php if (isset($params['data-parent-module-id']) AND $params['data-parent-module-id'] == 'template_settings_admin'): ?>
    <module type="editor/stylesheet_compiler"/>
    <module type="editor/template_settings"/>
<?php endif; ?>



<!-- <module type="editor/stylesheet_compiler"/> -->

<?php include('template_settings_options.php'); ?>
<script>mw.lib.require('bootstrap3ns');</script>

<style>
    .bootstrap3ns .checkbox label, .bootstrap3ns .radio label {
        padding-left: 0;
    }
</style>

<div id="settings-holder">
    <div class="col-12">
        <h5 style="font-weight: bold;"><?php _lang("Website Settings", "templates/theplace"); ?></h5>
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
            <label for="select" class="control-label">Header Style</label>
            <div>
                <select name="header_style" id="header_style" class="mw_option_field form-control" data-option-group="<?php echo $option_group; ?>">
                    <option value="" <?php if ($header_style == '') {
                        echo 'selected';
                    } ?>>White
                    </option>
                    <option value="header-inverse"<?php if ($header_style == 'header-inverse') {
                        echo 'selected';
                    } ?>>Black
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
                    <span></span><span><?php _lang("Show shopping cart in header", "templates/theplace"); ?></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label class="mw-ui-check">
                    <input type="checkbox" class="mw_option_field" id="profile_link" name="profile_link" data-option-group="<?php echo $option_group; ?>" value="true" <?php if ($profile_link == 'true') {
                        echo 'checked';
                    } ?> />
                    <span></span><span><?php _lang("Show Profile link in header", "templates/theplace"); ?></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label class="mw-ui-check">
                    <input type="checkbox" class="mw_option_field" id="footer" name="footer" data-option-group="<?php echo $option_group; ?>" value="true" <?php if ($footer == 'true') {
                        echo 'checked';
                    } ?> />
                    <span></span><span><?php _lang("Turn off Footer for website", "templates/theplace"); ?></span>
                </label>
            </div>
        </div>
    </div>
</div>
<!-- /#settings-holder -->