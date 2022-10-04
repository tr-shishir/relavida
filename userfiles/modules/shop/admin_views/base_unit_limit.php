<style>
    .hideorshow{
        margin-top: 2px;
        padding: 5px 5px;
        /* border: .5px solid gray; */
    }
    .handelling-time-wrapper {
        background: #fff;
    }
    .input-group-append {
        margin-left: -4px;
    }

    .base-unit-table{
        margin-top:30px;
    }
</style>


<!-- 
<div class="hideorshow handelling-time-wrapper">
    <div class="row mt-2 ml-2">
        <div class="col col-md-12">
            <h5> <?php //_e('Base Unit Limit'); ?> :</h5>
            <p><?php //_e('Please choose you base unit limit from here'); ?>.</p>
            <div class="col-md-6" style="padding-left:0px">
                <form action="javascript:save_base_unit_limit();">
                <div class="input-group">
                        <input type="text" class="form-control" id="base_unit_limit" aria-label="Text input with dropdown button" required>
                        <div class="input-group-append">
                            <select class="form-control" id="select_base_unit" required>
                                <option value=""><?php //_e('Select option'); ?>...</option>
                                <option value="Gram">Gram</option>
                                <option value="Kilogram">Kilogram</option>
                                <option value="Milliliter">Milliliter</option>
                                <option value="Liter">Liter</option>
                                <option value="Centimeter">Centimeter</option>
                                <option value="Meter">Meter</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success" style="margin-left:10px"><?php //_e('Save'); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 base-unit-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col"><?php //_e('SL'); ?></th>
                    <th scope="col"><?php //_e('Limit'); ?></th>
                    <th scope="col"><?php //_e('Unit'); ?></th>
                    <th scope="col"><?php //_e('Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        // $base_unit_lists = DB::table('options')->where('option_group','save_base_unit_limit')->get();
                        // $unit_sl = 1;
                    ?>
                    <?php //foreach($base_unit_lists as $base_unit_list): ?>
                        <tr>
                            <th scope="row"><?php //print $unit_sl; ?></th>
                            <td><?php //print $base_unit_list->option_value;  ?></td>
                            <td><?php //print $base_unit_list->option_key;  ?></td>
                            <td>
                                <button type="button" onclick="delete_base_unit_limit('<?php //print $base_unit_list->option_key; ?>');" class="btn btn-danger" style="margin-left:10px"><?php //_e('DELETE'); ?></button>
                            </td>
                        </tr>
                        <?php //$unit_sl++; ?>
                    <?php //endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> -->

<script>
    function save_base_unit_limit(){
        let base_unit_limit = $('#base_unit_limit').val();
        let base_unit = $('#select_base_unit').val();
        $.ajax({
            type:"POST",
            url: "<?=api_url('save_base_unit_limit');?>",
            data:{base_unit_limit,base_unit},
            success: function(response){
                if(response.message == 'success'){
                    mw.notification.success("<?php _e('successfully Saved'); ?>");
                    location.reload();
                }else{
                    mw.notification.error("<?php _e('Error'); ?>");
                }
            }
        });
    }
    function delete_base_unit_limit(base_unit){
        mw.tools.confirm("<?php _ejs("Do you want to delete this Unit"); ?>?", function () {
                $.ajax({
                    type:"POST",
                    url: "<?=api_url('delete_base_unit_limit');?>",
                    data:{base_unit},
                    success: function(response){
                        if(response.message == 'success'){
                            mw.notification.success("<?php _e('successfully Delete'); ?>");
                            location.reload();
                        }else{
                            mw.notification.error("<?php _e('Error'); ?>");
                        }
                    }
                });                    
        });
    }
</script>

<!-- menu dynamic value -->
<!-- array (
    'id' => '24',
    'shortcut' => '0',
    'position' => 24,
    'name' => 'Base Unit Limit',
    'sub_name' => 'Base Unit Limit Settings',
    'link' => NULL,
    'mw_link' => NULL,
    'dt_link' => 'view:shop/action:base_unit_limit',
    'dt_temp_link' => NULL,
    'icon' => NULL,
    'img' => 'admin-logo/shop-settings/1.png',
    'active_name' => 'settings',
    'module_name' => NULL,
    'data_link' => NULL,
    'data_title' => NULL,
  ) -->