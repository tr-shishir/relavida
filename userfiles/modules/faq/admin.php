<?php must_have_access() ?>

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
        <?php
        $settings = get_option('settings', 'faq');
        $defaults = array(
            'question' => '',
            'answer' => '',
            'page_id' => PAGE_ID,
            'module_id' => @$params['parent-module-id'],
        );
        $json = json_decode($settings, true);

        if (isset($json) == false or count($json) == 0) {
            $json = array(0 => $defaults);
        }
        $pp = json_encode($json);
        ?>
        <script>mw.lib.require('mwui_init');</script>
        <script>mw.require('prop_editor.js')</script>
        <script>mw.require('module_settings.js')</script>
        <script>
            $(window).on('load', function (){
                window.faqSettings = new mw.moduleSettings({
                    page_id: <?php print PAGE_ID ?>,
                    moduleId: '<?php print @$params["parent-module-id"] ?>',
                    element: '#settings-box',
                    header: '<i class="mdi mdi-drag"></i> <span class="questionName">Question</span> <a class="pull-right" data-action="remove"><i class="mdi mdi-close-thick"></i></a>',
                    data: <?php print $pp ?>,
                    key: 'settings',
                    group: '<?php print $params['id']; ?>',
                    autoSave: true,
                    schema: [
                        {
                            interface: 'text',
                            label: ['<?php _e('Question'); ?>'],
                            id: 'question'
                        },

                        {
                            interface: 'richtext',
                            label: ['<?php _e('Answer'); ?>'],
                            id: 'answer',
                            options: null
                        },
                        {
                            interface: 'hidden',
                            label: [''],
                            id: 'page_id',
                            value: '<?=PAGE_ID?>'
                        },
                        {
                            interface: 'hidden',
                            label: [''],
                            id: 'module_id',
                            value: '<?=@$params['parent-module-id']?>'
                        }
                    ]
                });
                setTimeout(function (){
                    $(faqSettings).on("change", function (e, val) {
                        var final = [];
                        $.each(val, function () {
                            var curr = $.extend({}, this);
                            final.push(curr)
                        });
                        var toVal = JSON.stringify(final);
                        mw.$('#settingsfield').val(toVal).trigger('change');
                    });
                }, 300)
            })
        </script>
        <style>
            .faq-setting-item{
                cursor: pointer;
            }
            .faq-setting-item .mdi-cursor-move,
            .faq-setting-item .remove-question {
                visibility: hidden;
            }

            .faq-setting-item:hover .mdi-cursor-move,
            .faq-setting-item:hover .remove-question {
                visibility: visible;
            }
        </style>
        <nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
            <a class="btn btn-outline-secondary justify-content-center active" data-toggle="tab" href="#list"><i class="mdi mdi-format-list-bulleted-square mr-1"></i> List of Questions</a>
            <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#templates"><i class="mdi mdi-pencil-ruler mr-1"></i> <?php print _e('Templates'); ?></a>
        </nav>
        <div class="tab-content py-3">
            <div class="tab-pane fade show active" id="list">
                <div class="module-live-edit-settings module-faq-settings">
                    <input type="hidden" class="mw_option_field" name="settings" option-group="faq" id="settingsfield"/>
                    <input type="hidden" class="mw_option_field" name="page_id" id="page_id" value="<?=PAGE_ID?>"/>
                    <input type="hidden" class="mw_option_field" name="module_id" id="module_id" value="<?=@$params['parent-module-id']?>"/>
                    <div class="mb-3">
                        <span class="btn btn-primary btn-rounded btn-sm" onclick="faqSettings.addNew()"><?php _e('Add new'); ?></span>
                    </div>
                    <div id="faq-settings">
                        <div id="settings-box"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="templates">
                <module type="admin/modules/templates"/>
            </div>
        </div>
    </div>
</div>

<script>
    $("#settings-box").children('.mwSetting_singleBox').each(function(e) {
        var getQuestionName1 = $(this).children('.mw-ui-box-content').children('.prop-ui-field-holder:nth-child(3)').find('input').attr('value');
        // console.log(getQuestionName1);
        if (getQuestionName1 == <?php print PAGE_ID ?>) {
            alert('hygghgtfh')
        }
    });
</script>
