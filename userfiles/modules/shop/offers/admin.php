<?php must_have_access(); ?>

<?php
$from_live_edit = false;
if (isset($params["live_edit"]) and $params["live_edit"]) {
    $from_live_edit = $params["live_edit"];
}
?>
<style>
    .counter-skin {
        position: relative;
    }

    .counter-skin ul {
        position: relative;
        padding: 0px;
        list-style-type: none;
    }

    .counter-skin ul li {
        position: relative;
        display: inline-block;
        width: 24%;
        border: 1px solid #000;
        margin: 2px 0px;
        padding: 10px;
        vertical-align: middle;
    }

    .counter-skin ul li input {
        margin-right: 3px;
        display: inline-block;
        vertical-align: middle;
    }

    .counter-skin ul li label {
        width: calc(100% - 20px);
        position: relative;
    }
    .counter-skin ul li img {
        width: 100%;
    }
</style>
<?php if (isset($params['backend'])): ?>
    <module type="admin/modules/info"/>
<?php endif;
$counter = Config::get('custom.counter');
?>
<div class="counter-skin">
    <ul>
        <li><input id="counterSkin-1" type="radio" name="template" value="1" <?php $counter == 1 ? print "checked" : print ""?>>
            <label for="counterSkin-1">
                <img src="<?php print modules_url(); ?>microweber/images/1.png" style="height: 40px;"/>
            </label>
        </li>
        <li>
            <input id="counterSkin-2" type="radio" name="template" value="2" <?php $counter == 2 ? print "checked" : print ""?>>
            <label for="counterSkin-2">
                <img src="<?php print modules_url(); ?>microweber/images/2.png" style="height: 40px;"/>
            </label>
        </li>
        <li>
            <input id="counterSkin-3" type="radio" name="template" value="3" <?php $counter == 3 ? print "checked" : print ""?>>
            <label for="counterSkin-3">
                <img src="<?php print modules_url(); ?>microweber/images/3.png" style="height: 40px;"/>
            </label>
        </li>
        <li>
            <input id="counterSkin-4" type="radio" name="template" value="4" <?php $counter == 4 ? print "checked" : print ""?>>
            <label for="counterSkin-4">
                <img src="<?php print modules_url(); ?>microweber/images/4.png" style="height: 40px;"/>
            </label>
        </li>
        <li>
            <input id="counterSkin-5" type="radio" name="template" value="5" <?php $counter == 5 ? print "checked" : print ""?>>
            <label for="counterSkin-5">
                <img src="<?php print modules_url(); ?>microweber/images/5.png" style="height: 40px;"/>
            </label>
        </li>
        <li>
            <input id="counterSkin-6" type="radio" name="template" value="6" <?php $counter == 6 ? print "checked" : print ""?>>
            <label for="counterSkin-6">
                <img src="<?php print modules_url(); ?>microweber/images/6.png" style="height: 40px;"/>
            </label>
        </li>
        <li>
            <input id="counterSkin-7" type="radio" name="template" value="7" <?php $counter == 7 ? print "checked" : print ""?>>
            <label for="counterSkin-7">
                <img src="<?php print modules_url(); ?>microweber/images/7.png" style="height: 40px;"/>
            </label>
        </li>
        <li>
            <input id="counterSkin-8" type="radio" name="template" value="8" <?php $counter == 8 ? print "checked" : print ""?>>
            <label for="counterSkin-8">
                <img src="<?php print modules_url(); ?>microweber/images/8.png" style="height: 40px;"/>
            </label>
        </li>
    </ul>
    
    <p>Wähle hier (optional) einen Countdown aus, welcher dann auf der Produktunterseite angezeigt wird.</p>
</div>
<script>
    $('[name="template"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/counter", { id: id }, (res) => {



        });
    });
</script>
<div class="card style-1 mb-3 <?php if ($from_live_edit): ?>card-in-live-edit<?php endif; ?>">
    <div class="card-header">
        <?php $module_info = module_info($params['module']); ?>
        <h5>
            <img src="<?php echo $module_info['icon']; ?>" class="module-icon-svg-fill"/> <strong><?php _e($module_info['name']); ?></strong>
        </h5>
    </div>

    <div class="card-body pt-3">
        <script>
            mw.lib.require('jqueryui');
            mw.require("<?php print $config['url_to_module'];?>css/main.css");
        </script>

        <script>
            function editOffer(offer_id = false) {
                var data = {};
                var mTitle = (offer_id ? '<?php _e('Edit offer'); ?>' : '<?php _e('Add new offer'); ?>');
                data.offer_id = offer_id;
                editModal = mw.tools.open_module_modal('shop/offers/edit_offer', data, {overlay: true, skin: 'simple', title: mTitle})
            }

            function deleteOffer(offer_id) {
                var confirmUser = confirm('<?php _e('Are you sure you want to delete this offer?'); ?>');
                if (confirmUser == true) {
                    $.ajax({
                        url: '<?php print route('api.offer.delete');?>',
                        data: 'offer_id=' + offer_id,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            if (typeof(reload_offer_after_save) != 'undefined') {
                                reload_offer_after_save();
                            }
                        }
                    });
                }
            }

            function reload_offer_after_save() {
                mw.reload_module_parent('#<?php print $params['id'] ?>');
                mw.reload_module('shop/offers/edit_offers');
                window.parent.$(window.parent.document).trigger('shop.offers.update');
                if (typeof(editModal) != 'undefined' && editModal.modal) {
                    editModal.modal.remove();
                }
            }

            $(document).ready(function () {

                $(".js-add-new-offer").click(function () {
                    editOffer(false);
                });
            });
        </script>

        <nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
            <a class="btn btn-outline-secondary justify-content-center active" data-toggle="tab" href="#list"><i class="mdi mdi-format-list-bulleted-square mr-1"></i><?php _e('List of Offers'); ?></a>
            <?php if ($from_live_edit) : ?>
                <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#templates"><i class="mdi mdi-pencil-ruler mr-1"></i> <?php print _e('Templates'); ?></a>
            <?php endif; ?>

        </nav>

        <div class="tab-content py-3">
            <div class="tab-pane fade show active" id="list">
                <div class="mb-3">
                    <a class="btn btn-primary btn-rounded js-add-new-offer" href="javascript:;"><?php _e('Add new offer'); ?></a>
                </div>

                <module type="shop/offers/edit_offers"/>
            </div>

            <?php if ($from_live_edit) : ?>
                <div class="tab-pane fade" id="templates">
                    <module type="admin/modules/templates"/>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

