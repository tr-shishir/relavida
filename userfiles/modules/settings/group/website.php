<?php must_have_access(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        mw.options.form('.js-permalink-edit-option-hook', function () {

            mw.clear_cache();

            mw.notification.success("Permalink changes updated.");
        });
    });
</script>

<script type="text/javascript">
    mw.lib.require('collapse_nav');
</script>
<script type="text/javascript">
    $(document).ready(function () {
        mw.options.form('.<?php print $config['module_class'] ?>', function () {
            mw.notification.success("<?php _ejs("All changes are saved"); ?>.");
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/anchorific/1.2/min/anchorific.min.js"></script>
<script>
    $(document).ready(function () {
        $('.js-anchorific').anchorific({
            navigation: '.anchorific', // position of navigation
            headers: 'h5', // headers that you wish to target
            speed: 200, // speed of sliding back to top
            anchorText: '#', // prepended or appended to anchor headings
            top: '.top', // back to top button or link class
            spyOffset: 0, // specify heading offset for spy scrolling
        });

        $('.js-anchorific ul').collapseNav({
            'mobile_break': 320,
//            'li_class': '',
//            'li_a_class': '',
//            'li_ul_class': ''
        });
    })
</script>

<div class="<?php print $config['module_class'] ?> js-anchorific">
    <div class="card bg-none style-1 mb-0 card-settings">
        <div class="card-header px-0">
            <h5 class="w-100"><i class="mdi mdi-signal-cellular-3 text-primary mr-3"></i> <strong><?php _e("General"); ?></strong></h5>
            <div class="d-block w-100">
                <nav class="anchorific"></nav>
            </div>
        </div>
    </div>

    <div class="card bg-none style-1 mb-0 card-settings">
        <div class="card-body pt-3 px-0">
            <hr class="thin mt-0 mb-5">

            <div class="row">
                <div class="col-md-3">
                    <h5 class="font-weight-bold"><?php echo _e('General Settings'); ?></h5>
                    <small class="text-muted"><?php echo _e('Set regional settings for your website or online store. They will also affect the language you use and the fees for the orders.'); ?></small>
                </div>
                <div class="col-md-9">
                    <div class="card bg-light style-1 mb-3">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <!-- <div class="form-group mb-4">
                                        <label class="control-label"><?php //_e("Maintenance mode"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php //_e("Turn on 'Under construction' mode of your site"); ?></small>
                                        <?php //$maintenance_mode = get_option('maintenance_mode', 'website'); ?>

                                        <ul class="mw-ui-inline-list">
                                            <li>
                                                <label class="mw-ui-check">
                                                    <input class="mw_option_field" type="radio" name="maintenance_mode" <?php //if ($maintenance_mode == 'y'): ?> checked <?php //endif; ?> value="y" option-group="website">
                                                    <span></span><span><?php //_e("Yes"); ?></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="mw-ui-check">
                                                    <input class="mw_option_field" type="radio" name="maintenance_mode" <?php //if (!$maintenance_mode or $maintenance_mode != 'y'): ?> checked <?php //endif; ?> value="n" option-group="website">
                                                    <span></span><span><?php //_e("No"); ?></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div> -->

                                    <div class="form-group mb-4">
                                        <label class="control-label"><?php _e("Date Format"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Choose a date format for your website"); ?></small>
                                        <?php $date_formats = array("Y-m-d H:i:s", "Y-m-d H:i", "d-m-Y H:i:s", "d-m-Y H:i", "m/d/y", "m/d/Y", "d/m/Y", "F j, Y g:i a", "F j, Y", "F, Y", "l, F jS, Y", "M j, Y @ G:i", "Y/m/d \a\t g:i A", "Y/m/d \a\t g:ia", "Y/m/d g:i:s A", "Y/m/d", "g:i a", "g:i:s a", 'D-M-Y', 'D-M-Y H:i'); ?>
                                        <?php $curent_val = get_option('date_format', 'website'); ?>
                                        <select name="date_format" class="selectpicker mw_option_field" data-width="100%" data-size="7" option-group="website">
                                            <?php if (is_array($date_formats)): ?>
                                                <?php foreach ($date_formats as $item): ?>
                                                    <option value="<?php print $item ?>" <?php if ($curent_val == $item): ?> selected="selected" <?php endif; ?>><?php print date($item, time()) ?> - (<?php print $item ?>)</option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"><?php _e("Time Zone"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Set a time zone"); ?></small>
                                        <?php $curent_time_zone = get_option('time_zone', 'website'); ?>
                                        <?php
                                        if ($curent_time_zone == false) {
                                            $curent_time_zone = date_default_timezone_get();
                                        }

                                        $timezones = timezone_identifiers_list(); ?>
                                        <select name="time_zone" class="selectpicker mw_option_field" data-width="100%" data-size="7" data-live-search="true" option-group="website">
                                            <?php foreach ($timezones as $timezone) {
                                                echo '<option';
                                                if ($timezone == $curent_time_zone) echo ' selected="selected"';
                                                echo '>' . $timezone . '</option>' . "\n";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $favicon_image = get_option('favicon_image', 'website');
                                        if (!$favicon_image) {
                                            $favicon_image = modules_url() . 'microweber/api/libs/mw-ui/assets/img/no-image-2.jpg';
                                        }
                                        ?>

                                        <script>
                                            $(document).ready(function () {
                                                favUP = mw.uploader({
                                                    element: mwd.getElementById('upload-icoimage'),
                                                    filetypes: 'images',
                                                    multiple: false
                                                });

                                                $(favUP).on('FileUploaded', function (a, b) {
                                                    mw.$("#favicon_image").val(b.src).trigger('change');
                                                    mw.$(".js-icoimage").attr('src', b.src);
                                                    mw.$("link[rel*='icon']").attr('href', b.src);
                                                });
                                            });
                                        </script>

                                        <label class="control-label"><?php _e("Change Favicon"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Select an icon for your website. It is best to be part of your logo"); ?></small>
                                        <div class="d-flex">
                                            <div class="img-circle-holder img-absolute w-40 border-radius-0 border-silver mr-3">
                                                <img src="<?php print $favicon_image; ?>" class="js-icoimage"/>
                                                <input type="hidden" class="mw_option_field" name="favicon_image" id="favicon_image" value="<?php print $favicon_image; ?>" option-group="website"/>
                                            </div>

                                            <button type="button" class="btn btn-outline-primary" id="upload-icoimage"><?php _e("Upload favicon"); ?></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php _e("Posts per Page"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Select how many posts or products you want to be shown per page"); ?></small>
                                        <select name="items_per_page" class="form-control mw_option_field" type="range" option-group="website">
                                            <?php
                                            $per_page = get_option('items_per_page', 'website');
                                            $found = false;
                                            for ($i = 5; $i < 40; $i += 5) {
                                                if ($i == $per_page) {
                                                    $found = true;
                                                    print '<option selected="selected" value="' . $i . '">' . $i . '</option>';
                                                } else {
                                                    print '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                            }
                                            if ($found == false) {
                                                print '<option selected="selected" value="' . $per_page . '">' . $per_page . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="display: none;">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php _e("Fonts"); ?></label>
                                        <small class="text-muted d-block mb-2">Select fonts you want to install for your website.</small>

                                        <div class="table-responsive">
                                            <?php
                                            $fonts = get_option('fonts', 'website');

                                            if (!$fonts) {
                                                ?>
                                                <p class="text-muted">No fonts</p>
                                                <?php
                                            } else {
                                                $fonts = json_encode($fonts);
                                                ?>
                                                <table class="table">
                                                    <?php foreach ($fonts as $font) { ?>
                                                        <tr>
                                                            <td><?php print $font['name']; ?></td>
                                                            <td><?php print $font['status']; ?></td>
                                                            <td></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-none style-1 mb-0 card-settings">
        <div class="card-body pt-3 px-0">
            <hr class="thin mt-0 mb-5">

            <div class="row">
                <div class="col-md-3">
                    <h5 class="font-weight-bold"><?php _e("Social Media"); ?></h5>
                    <small class="text-muted"><?php _e("Add links to your social media accounts. Once set up, you can use them anywhere on your site using the 'social networks' module with drag and drop technology."); ?></small>
                </div>
                <div class="col-md-9">
                    <div class="card bg-light style-1 mb-3">
                        <div class="card-body pt-3">
                            <div id="mw-global-fields-social-profile-set">
                                <module type="social_links/admin" module-id="website" live_edit="false"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-none style-1 mb-0 card-settings">
        <div class="card-body pt-3 px-0">
            <hr class="thin mt-0 mb-5">

            <div class="row">
                <div class="col-md-3">
                    <h5 class="font-weight-bold"><?php _e("Online Shop"); ?></h5>
                    <small class="text-muted"><?php _e("Enable or disable your online shop"); ?></small>
                </div>
                <div class="col-md-9">
                    <div class="card bg-light style-1 mb-3">
                        <div class="card-body pt-3">
                            <!-- <module type="shop/orders/settings/enable_disable_shop"/> -->
                            <?php
                                $vacation_mode_on = get_option('vacation_mode', 'website') ?? 'no';
                                $vacation_end_date = get_option('vacation_mode_end_date', 'vacation_mode_date');
                                if($vacation_end_date){
                                    $vacation_end_date = date('Y-m-d',strtotime($vacation_end_date));
                                }else{
                                    $vacation_end_date = '';
                                }
                            ?>
                            <div class="form-group">
                                <label class="control-label d-block"><?php _e("Online shop status"); ?></label>
                                <small class="text-muted d-block mb-2"><?php _e("Here you can put your shop in the so-called vacation mode"); ?></small>
                                <div class="custom-control custom-radio d-inline-block mr-2">
                                    <input name="vacation_mode" class="mw_option_field custom-control-input" onclick="vacation_date_div_show_hide('yes')" id="vacation_mode_0" data-option-group="website" value="yes" type="radio" <?php if ($vacation_mode_on == "yes"): ?> checked="checked" <?php endif; ?> >
                                    <label class="custom-control-label" for="vacation_mode_0"><?php _e("Enabled"); ?></label>
                                </div>

                                <div class="custom-control custom-radio d-inline-block mr-2">
                                    <input name="vacation_mode" class="mw_option_field custom-control-input" onclick="vacation_date_div_show_hide('no')" id="vacation_mode_1" data-option-group="website" value="no" type="radio" <?php if (get_option('vacation_mode', 'website') == "no"): ?> checked="checked" <?php endif; ?> >
                                    <label class="custom-control-label" for="vacation_mode_1"><?php _e("Disabled"); ?></label>
                                </div>
                            </div>
                            <div class="vacation-date" <?php if($vacation_mode_on != 'yes'): ?> style="display:none;" <?php endif; ?>>
                                <!-- <p><strong>Start Date:</strong> <span> <input type="date"  onchange="vacation_start_date_get()" value="<?php //echo $vacation_start_date ?>" name="vacation-start-date" id="vacation-start-date"> </span></p> -->
                                <p><strong><?php _e('End Date'); ?>:</strong> <span> <input type="date" onchange="vacation_end_date_get()" value="<?php echo $vacation_end_date ?>" name="vacation-end-date" id="vacation-end-date"> </span></p>
                                <a href="<?php echo site_url('vacation?editmode=y'); ?>" target="_blank">
                                    <?php _e('Here you can edit the page that your customers see in vacation mode'); ?>.
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   
    function vacation_end_date_get(){
        vacation_end_date = $('#vacation-end-date').val();
        current_time = new Date().getTime();
        vacation_end_time = new Date(vacation_end_date).getTime();
        if(current_time < vacation_end_time){
            $.ajax({
                type: "POST",
                url: "<?=api_url('vacation_mode_end_date_save')?>",
                data:{ vacation_end_date }
            });
        }else{
            $('#vacation-end-date').val(' ');
            mw.notification.error("Please set valid date for vacation mode");
        }
    }
    function vacation_date_div_show_hide(vacation_mode){
        if(vacation_mode == 'yes'){
            $('.vacation-date').show();
        }else if(vacation_mode == 'no'){
            $('.vacation-date').hide();
            $.ajax({
                type: "POST",
                url: "<?=api_url('vacation_mode_date_stop')?>",
                success: function(response) {
                    // location.reload();
                    $('#vacation-end-date').val(' ');  
                }
            });
        }
    }
</script>
