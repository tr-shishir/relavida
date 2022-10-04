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


<div class="hideorshow handelling-time-wrapper">
    <div class="row mt-2 ml-2">
        <div class="col col-md-12">
            <h5> <?php _e('Ticker Text'); ?> :</h5>
            <p><?php _e('Please choose you ticker text from here'); ?>.</p>
            <div class="col-md-6" style="padding-left:0px">
                <form action="javascript:save_ticker_text();">
                <div class="input-group">
                        <input type="text" class="form-control" id="ticker_text" aria-label="Text input with dropdown button" required>
                        <div class="input-group-append">
                            <select class="form-control" id="ticker_text_position" required>
                                <option value=""><?php _e('Select option'); ?>...</option>    
                                <?php for($i=1;$i<10;$i++): ?>
                                    <option value="<?php print $i ?>"><?php print $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
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
                    <th scope="col"><?php _e('Ticker Text'); ?></th>
                    <th scope="col"><?php _e('Position'); ?></th>
                    <th scope="col"><?php _e('Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $base_unit_lists = DB::table('options')->where('option_group',$params['id'])->orderBy('option_key', 'asc')->get();
                        $unit_sl = 1;
                    ?>
                    <?php foreach($base_unit_lists as $base_unit_list): ?>
                        <tr>
                            <th scope="row"><?php print $unit_sl; ?></th>
                            <td><?php print $base_unit_list->option_value;  ?></td>
                            <td><?php print $base_unit_list->option_key;  ?></td>
                            <td>
                                <button type="button" onclick="delete_ticker_text('<?php print $base_unit_list->option_key; ?>');" class="btn btn-danger" style="margin-left:10px"><?php _e('DELETE'); ?></button>
                            </td>
                        </tr>
                        <?php $unit_sl++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function save_ticker_text(){
        let ticker_text = $('#ticker_text').val();
        let ticker_text_position = $('#ticker_text_position').val();
        let module_id = '<?php print $params['id']; ?>'
        $.ajax({
            type:"POST",
            url: "<?=api_url('save_ticker_text');?>",
            data:{ticker_text,ticker_text_position,module_id},
            success: function(response){
                if(response.message == 'success'){
                    mw.notification.success("successfully Saved");
                    location.reload();
                }else{
                    mw.notification.error("Error");
                }
            }
        });
    }
    function delete_ticker_text(text_position){
        let module_id = '<?php print $params['id']; ?>';
        mw.tools.confirm("<?php _ejs("Do you want to delete this Ticker Text"); ?>?", function () {
                $.ajax({
                    type:"POST",
                    url: "<?=api_url('delete_ticker_text');?>",
                    data:{text_position,module_id},
                    success: function(response){
                        if(response.message == 'success'){
                            mw.notification.success("successfully Delete");
                            location.reload();
                        }else{
                            mw.notification.error("Error");
                        }
                    }
                });                    
        });
    }
</script>

