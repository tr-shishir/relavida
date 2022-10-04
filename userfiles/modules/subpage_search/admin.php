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

    .subpageform .input-group {
        display: block;
        margin-bottom: 15px;
    }

    .subpageform button.btn.btn-success {
        float: right;
    }
    td.subpage-action span {
        font-size: 10px;
        padding: 5px;
    }
    .module-subpage-search-admin .base-unit-table {
        overflow: scroll;
    }
</style>


<div class="hideorshow handelling-time-wrapper">
    <div class="row mt-2 ml-2">
        <div class="col col-md-12">
            <h5><?php _e('Subpage Search'); ?>:</h5>
            <p><?php _e('Please add new Subpage information here'); ?>.</p>
            <div class="col-md-6 subpageform" style="padding-left:0px">
                <form action="javascript:save_subpage_search_information();">
                    <input type="hidden" id="subpage_info_id">
                    <div class="input-group">
                        <label for=""> <?php _e('Subpage Name'); ?>:</label>
                        <input type="text" class="form-control" id="subpage_name" aria-label="Text input with dropdown button" required>
                    </div>
                    <div class="input-group">
                        <label for=""><?php _e('Subpage Link'); ?>:</label>
                        <input type="text" class="form-control" id="subpage_link" aria-label="Text input with dropdown button" required>
                    </div>
                    <div class="input-group">
                        <button type="submit" class="btn btn-success" style="margin-left:10px"><?php _e('Save'); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 base-unit-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col"><?php _e('SL'); ?></th>
                    <th scope="col"><?php _e('Name'); ?></th>
                    <th scope="col"><?php _e('Link'); ?></th>
                    <th scope="col"><?php _e('Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $subpage_search_informations = DB::table('options')->where('option_group',$params['id'])->get();
                        $subpage_sl = 1;
                    ?>
                    <?php foreach($subpage_search_informations as $subpage_search_information): ?>
                        <tr>
                            <th scope="row"><?php print $subpage_sl; ?></th>
                            <td><?php print $subpage_search_information->option_key;  ?></td>
                            <td><?php print $subpage_search_information->option_value;  ?></td>
                            <td class="subpage-action">
                                <span onclick="delete_subpage_search_information('<?php print $subpage_search_information->option_key; ?>')" class="btn btn-danger fas fa-trash"></span>
                            </td>
                        </tr>
                        <?php $subpage_sl++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function save_subpage_search_information(){
        let subpage_name = $('#subpage_name').val();
        let subpage_link = $('#subpage_link').val();
        let module_id = '<?php print $params['id']; ?>';
        $.ajax({
            type:"POST",
            url: "<?=api_url('save_subpage_search_information');?>",
            data:{subpage_name,subpage_link,module_id},
            success: function(response){
                if(response.message == 'success'){
                    mw.notification.success("<?php _e('successfully Saved'); ?>");
                    location.reload();
                }else{
                    mw.notification.error("Error");
                }
            }
        });  
    }
    function delete_subpage_search_information(subpage_name){
        let module_id = '<?php print $params['id']; ?>';
        mw.tools.confirm("<?php _ejs("Do you want to delete this subpage search information"); ?>?", function () {
            $.ajax({
                type:"POST",
                url: "<?=api_url('delete_subpage_search_information');?>",
                data:{subpage_name,module_id},
                success: function(response){
                    if(response.message == 'success'){
                        mw.notification.success("<?php _e('successfully Delete'); ?>");
                        location.reload();
                    }else{
                        mw.notification.error("Error");
                    }
                }
            });                    
        });
    }
</script>



