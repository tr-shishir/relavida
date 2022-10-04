<nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
    <a class="btn btn-outline-secondary justify-content-center active" data-toggle="tab" href="#list"><i class="mdi mdi-format-list-bulleted-square mr-1"></i> <?php _e('List of Taxes'); ?></a>

</nav>
<script>
    $(document).ready(function () {

        $(".js-add-new-taxes").click(function () {
            editTax(false);
        });
    });
    function editTax(tax_id = false) {
        var data = {};
        var mTitle = (tax_id ? 'Edit Tax' : 'Add new tax');
        data.tax_id = tax_id;
        editModal = mw.tools.open_module_modal('shop/tax_rates/edit_taxes', data, {overlay: true, skin: 'simple', title: mTitle})
    }
    function deleteTax(tax_id) {
        var confirmUser = confirm('<?php _e('Are you sure you want to delete this offer?'); ?>');
        if (confirmUser == true) {
            $.post("<?=api_url('delete_tax')?>", {
                id : tax_id
            }).then((res, err) => {
                console.log(res , err);
            });
            location.reload();
        }
    }
</script>

<div class="tab-content py-3">
    <div class="tab-pane fade show active" id="list">
        <div class="mb-3">
<!--            <a class="btn btn-primary btn-rounded js-add-new-taxes" href="javascript:;">Add new Taxes</a>-->
        </div>

        <?php
        use Illuminate\Support\Facades\DB;
        $allTaxes = $GLOBALS['all_tax_rates'] ?? DB::table('tax_rates')->get();
        ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
<!--                    <th>#</th>-->
                    <th><?php _e('Country'); ?></th>
                    <!--                                <th>Country de</th>-->
                    <!--                                <th>Country Code</th>-->
                    <th><?php _e('Orginal Tax Percent'); ?></th>
                    <th><?php _e('Reduced Tax Percent'); ?></th>
                    <!--                                <th>Lang Code</th>-->
                    <!--                                <th>Alpha Three</th>-->
                    <th class="text-left" style="width:200px;"><?php _e('Activate'); ?></th>
                </tr>
                </thead>
                <?php
                if ($allTaxes):
                    foreach ($allTaxes as $tax):
                        ?>
                        <tr class="small td-valign">
<!--                            <td>--><?php //print($tax->id) ?><!--</td>-->
                            <td><?php print($tax->country) ?></td>
                            <!--                                        <td>--><?php //print($tax->country_de) ?><!--</td>-->
                            <!--                                        <td>--><?php //print($tax->country_code) ?><!--</td>-->
                            <td><?php print($tax->charge) ?>%</td>
                            <td><?php print($tax->reduced_charge??0) ?>%</td>
                            <!--                                        <td>--><?php //print($tax->lang_kod) ?><!--</td>-->
                            <!--                                        <td>--><?php //print($tax->alpha_three) ?><!--</td>-->
                            <td class="action-buttons">
<!--                                <button onclick="editTax(--><?php ////print($tax->id) ?><!-- )" class="btn btn-outline-primary btn-sm" title="Edit">Edit</button>
                                <button onclick="deleteTax(--><?php //print($tax->id) ?><!-- )" class="btn btn-outline-danger btn-sm" title="Delete">Delete</button>-->
                                <div class="custom-control custom-switch pl-0">
                                    <label class="d-inline-block mr-5" for="default_tax<?=$tax->id?>"><?php _e("No"); ?></label>
                                    <input type="checkbox" class="custom-control-input" id="default_tax<?=$tax->id?>" name="default_tax" tax-id="<?=$tax->id?>" onclick="change_default(<?=$tax->id?>)" data-value-checked="1" data-value-unchecked="0" value="<?=@$tax->is_default?>" <?php ($tax->is_default == 1)? print 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="default_tax<?=$tax->id?>"><?php _e("Yes"); ?></label>
                                </div>

                            </td>
                        </tr>
                        <script>
                            $('#default_tax<?=$tax->id?>').change(function (){
                                $.post("<?= url('/') ?>/api/v1/default_tax", { data:<?=$tax->id?>, value:$(this).val() }, (res) => {

                                    if(res.success){
                                        $("#default_tax"+res.previous).prop("checked", false);
                                    }

                                });
                            });
                        </script>
                    <?php
                    endforeach;
                endif;
                ?>
            </table>
        </div>
    </div>
</div>
<div id="add" style="display:none;">
    <h2>Show</h2>
</div>

