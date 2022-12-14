<?php
$from_live_edit = false;
if (isset($params["live_edit"]) and $params["live_edit"]) {
    $from_live_edit = $params["live_edit"];
}
?>

<?php if (isset($params['backend'])): ?>
    <module type="admin/modules/info"/>
<?php endif; ?>

<div class="card style-1 mb-3 <?php if ($from_live_edit): ?>card-in-live-edit<?php endif; ?>">
    <div class="card-header">
        <?php $module_info = module_info($params['module']); ?>
        <h5>
            <img src="<?php echo $module_info['icon']; ?>" class="module-icon-svg-fill"/> <strong><?php echo $module_info['name']; ?></strong>
        </h5>
    </div>

    <div class="card-body pt-3">
        <nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
            <a class="btn btn-outline-secondary justify-content-center active" data-toggle="tab" href="#settings"><i class="mdi mdi-cog-outline mr-1"></i> <?php print _e('Settings'); ?></a>
        </nav>

        <div class="tab-content py-3">
            <div class="tab-pane fade show active" id="settings">
                <script>mw.require("files.js");</script>
                <script>
                    $(document).ready(function () {
                        $("#upload").on("click", function () {
                            mw.fileWindow({
                                element: mwd.getElementById('upload'),
                                types: 'media',
                                change: function (url) {
                                    mw.$("#upload_value").val(url);

                                    if (Prior.value != '1') {
                                        Prior.value = '1';
                                        $(Prior).trigger('change');
                                    }
                                    mw.$("#upload_value").trigger("change");
                                }
                            });
                        })

                        Prior = mwd.getElementById('prior');
                        mw.$("#audio").keyup(function () {
                            if (Prior.value !== '2') {
                                Prior.value = '2';
                                $(Prior).trigger('change');
                            }
                        });
                    });
                </script>
                
                <!-- Settings Content -->
                <div class="module-live-edit-settings module-audio-settings">
                    <div class="form-group">
                        <label class="control-label d-block"><?php _e("Upload Audio file"); ?></label>
                        <input type="hidden" name="data-audio-upload" value="<?php print get_option('data-audio-upload', $params['id']) ?>" class="mw_option_field" id="upload_value"/>
                        <span class="btn btn-primary btn-rounded relative" id="upload"><span class="fas fa-upload"></span> &nbsp; <?php _e("Upload audio file"); ?></span>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php _e("Paste URL"); ?></label>
                        <small class="text-muted d-block mb-2"><?php print _e('You can <strong>Upload your audio file</strong> or you can <strong>Paste URL</strong> to the file. It\'s possible to use <strong > only one option</strong>.'); ?></small>
                        <input name="data-audio-url" class="mw_option_field form-control" id="audio" type="text" value="<?php print get_option('data-audio-url', $params['id']) ?>"/>
                    </div>

                    <input type="text" class="semi_hidden mw_option_field form-control" name="prior" id="prior" value="<?php print get_option('prior', $params['id']) ?>"/>
                </div>
            </div>
            <!-- Settings Content - End -->
            </div>
        </div>
    </div>
</div>