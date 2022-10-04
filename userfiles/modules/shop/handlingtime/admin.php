<style>
    .hideorshow{
        margin-top: 2px;
        padding: 5px 5px;
        /* border: .5px solid gray; */
    }
    .handelling-time-wrapper {
        background: #fff;
    }
</style>

<?php
    $is_checked = get_option('handlingtime', 'handlingtime_show_hide');
?>


<div class="hideorshow handelling-time-wrapper">
    <div class="row mt-2 ml-2">
        <div class="col col-md-12">
            <h5> <?php _e('Handling time show'); ?> :</h5>
            <p><?php _e('If you turn on "NO" then handling time will not show on the frontend of the product'); ?>.</p>
        </div>
        <div class="col col-md-12">
            <div class="custom-control custom-switch pl-0">
                <label class="d-inline-block mr-5" for="handlingtime"><?php _e("No"); ?></label>
                <input type="checkbox" class="custom-control-input" id="handlingtime" name="handlingtime" onclick="hideorshow()" <?php if(isset($is_checked) and $is_checked == 1): ?> checked <?php endif; ?>>
                <label class="custom-control-label" for="handlingtime"><?php _e("Yes"); ?></label>
            </div>
        </div>
    </div>

    <hr>
    <div id="showorhide" <?php if(!isset($is_checked) or $is_checked != 1): ?> style="display:none;" <?php endif; ?>>
        <div class="row mt-4 ml-2">
            <div class="col col-md-4">
                <h5> <?php _e('Handling time'); ?> :</h5>
            </div>

            <div class="col col-md-6">
                <div class="form-group">
                    <select class="form-control" id="handlingtimeValue" name="handlingtimeValue">
                        <?php
                        $data = DB::table('handling_time')->select('data')->get();
                        for($i=1; $i<=120; $i++){
                            $has = 0;
                            foreach($data as $item){
                                if($item->data == $i){
                                    $has = 1;
                                    break;
                                }
                            }
                            if($has == 1){ ?>
                                <option value="<?php print $i; ?>" style="background-color: gray;"><?php print $i; ?></option>
                            <?php } else { ?>
                                <option value="<?php print $i; ?>"><?php print $i; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col col-md-2">
                <div class="form-group">
                    <button class="btn btn-primary" onclick="addHandlingtime()"><?php _e('Save'); ?></button>
                </div>
            </div>

        </div>

        <module type="shop/handlingtime"/>
    </div>

</div>

<script>
    function hideorshow(){
        var value = $("#handlingtime").prop("checked");
        var id = 0;
        if(value){
            id = 1;
            $("#showorhide").css('display', '');
        }
        else{
            $("#showorhide").css('display', 'none');
        }
        // alert(id);
        $.post("<?=api_url('handlingtimehideorshow') ?>",{
            id : id
        }).then((res, err) => {
            console.log(res, err);
        });
        mw.notification.success("Setting changed sucessfully");
    }

    function addHandlingtime(){
        var data = $("#handlingtimeValue").val();
        // alert(data);
        $.post("<?=api_url('add_handlingtime') ?>",{
            data : data
        },
        function(res){
        mw.notification.success(res);
        });
        location.reload()
    }

</script>