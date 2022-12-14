<?php $id = false; ?>
<?php $lic = false; ?>
<?php $local_key = false; ?>
<?php if (isset($lic['rel_type'])): ?>
    <?php
    $params['prefix'] = $lic['rel_type'];
    ?>
<?php endif; ?>

<?php
if (isset($params['lic_id'])) {
    if (intval($params['lic_id']) == 0) {
        $lic = array();
        $lic['prefix'] = '';
        $lic['local_key'] = '';
        $lic['id'] = '';
    } else {
        $lic = mw()->update->get_licenses('one=1&id=' . $params['lic_id']);
    }
} elseif (isset($params['prefix'])) {
    $lic = mw()->update->get_licenses('one=1&rel=' . $params['prefix']);
}

if ($lic) {
    $local_key = $lic['local_key'];
    $id = $lic['id'];
}

if (!isset($params['prefix'])) {
    $params['prefix'] = '';
}
?>


<?php if (!isset($params['prefix'])): ?>
    <?php return; ?>
<?php endif; ?>


<script type="text/javascript">
    $(document).ready(function () {
        var form = mw.$('#activate-form-<?php print $params['id']; ?>');
        form.on('submit', function () {
            mw.form.post(mw.$('#activate-form-<?php print $params['id']; ?>'), '<?php print site_url('api') ?>/mw_save_license', function () {
                mw.notification.msg(this);
                mw.reload_module('<?php print $params['parent-module']; ?>');
                if (window.licensemodal) {
                    licensemodal.remove()
                }
            });

            return false;
        });
    });
</script>
<?php
//d($params);

?>

<form class="mw-license-key-activate" id="activate-form-<?php print $params['id'] ?>">
    <?php if (isset($lic['status'])): ?>
        <div class="alert alert-dismissible <?php if ($lic['status'] == 'active'): ?>alert-success<?php else: ?>alert-danger<?php endif; ?>"><?php _e('License Status:'); ?><?php print ucwords($lic['status']) ?></div>
    <?php endif; ?>

    <div class="form-group">
        <label class="control-label"><?php _e('Enter the License Key'); ?><?php print ' ' . $params['prefix'] ?></label>
        <small class="text-muted d-block mb-2">Don't have a license key? You can get it from here: <a href="#"><?php _e('Get license key'); ?></a></small>
        <input type="hidden" name="rel" value="<?php print $params['prefix']; ?>">
        <input name="activate_on_save" type="hidden" value="1"/>
        <?php if ($id): ?>
            <input name="id" type="hidden" value="<?php print $id; ?>"/>
        <?php endif; ?>

        <input type="text" name="local_key" class="form-control" value="<?php print $local_key; ?>" placeholder="<?php _e('License key'); ?>">
    </div>

    <div class="row">
        <div class="col d-flex align-items-center justify-content-between">
            <?php if ($id): ?>
                <input type="hidden" name="_delete_license" value="" class="js-edit-license-del-action-<?php print $id; ?>">
                <button type="submit" value="Activate" class="btn btn-danger" onclick="$('.js-edit-license-del-action-<?php print $id; ?>').val('_delete_license')">Delete</button>
            <?php endif; ?>

            <button type="submit" value="Activate" class="btn btn-success"><?php _e('Save key'); ?></button>
        </div>
    </div>

    <hr class="thin"/>

    <div class="row">
        <div class="col-12">
            <small>Have a problem with your White Label license key? <a href="#">Contact us.</a></small>
        </div>
    </div>
</form>
