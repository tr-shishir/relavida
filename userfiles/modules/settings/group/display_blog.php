<div class="card-body pt-2 pb-0">
    <div class="row">
        <div class="col-md-3">
            <h5 class="font-weight-bold"><?php _e("Blog Post settings"); ?></h5>
            <small class="text-muted"><?php _e('Choose the condition for display post on frontend'); ?></small>
        </div>
        <div class="col-md-9">
            <div class="card bg-light style-1 mb-1">
                <div class="card-body pt-3">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php _e("Blog post settings"); ?></label>
                                <small class="text-muted d-block mb-2"><?php _e("Choose the condition for display post on frontend"); ?></small>
                                <?php $rssOption = get_option('rss_option', 'rss_data'); ?>
                                <select onchange="Blog_option()" id="rssOption" name="rssOption" class="selectpicker js-search-by-selector" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">
                                    <option selected><?php _e('Add your option'); ?></option>
                                    <option <?php if (intval($rssOption) == 0) {
                                                echo "selected";
                                            } ?> value="0"><?php _e('Own Posts'); ?>
                                    </option>
                                    <option <?php if (intval($rssOption) == 1) {
                                                echo "selected";
                                            } ?> value="1"><?php _e('Merge Post'); ?>
                                    </option>
                                    <option <?php if (intval($rssOption) == 2) {
                                                echo "selected";
                                            } ?> value="2"><?php _e('RSS Post'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function Blog_option() {
        var option = $('#rssOption').val();
        $.post("<?= api_url('rss_link_option') ?>", {
            option: option
        }).then((res, err) => {
            mw.notification.success("Your option is saved successfully");
        });
    }
</script>