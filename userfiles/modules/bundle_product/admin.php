<style>
.bundle-product-layout-settings {
    box-shadow: 0 0 4px 0px #b9b9b9;
    padding: 10px;
    margin-top: 15px;
}
</style>

<div class="container">
    <div class="bundle-product-layout-settings">
        <div class="form-group">
            <label for="bundle"><?php _e('Select Your Bundle'); ?>:</label>
            <?php
            $selected_bundle = get_option('bundle_id', $params['id']);
            $bundles = DB::table('bundles')->get();
            $selected_option = "";
            if ($selected_bundle) {
                $existing_bundle = $bundles->contains('id', $selected_bundle);
                if ($existing_bundle) {
                    $selected_option = $selected_bundle;
                }
            }

            ?>
            <div>
                <select class="selectpicker js-search-by-selector form-control" id="bundle" onchange="module_based_bundle_store(this)" data-live-search="true" data-width="100%" data-style="btn-sm" tabindex="-98" aria-label="bundle selected">
                    <?php if ($bundles) : ?>
                        <?php if ($selected_option == "") : ?>
                            <option value=""><?php _e('choose one'); ?></option>
                        <?php endif; ?>
                        <?php foreach ($bundles as $bundle) : ?>

                            <?php if ($bundle->id == $selected_option) : ?>
                                <option value="<?= $bundle->id; ?>" selected="selected"><?= $bundle->title; ?></option>
                            <?php else : ?>
                                <option value="<?= $bundle->id; ?>"><?= $bundle->title; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value=""><?php _e('Bundle not found'); ?></option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
    function module_based_bundle_store(select) {
        var bundle_id = select.value;
        if (bundle_id) {
            $.post("<?= api_url('module_based_bundle_store') ?>", {
                bundle_id: bundle_id,
                module_id: '<?= $params['id'] ?>'
            }).then((res, err) => {
                mw.notification.success(res);
                mw.reload_module_parent("#<?= $params['id'] ?>");
            });
        }
    }
</script>