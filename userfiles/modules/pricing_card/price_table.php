<script>
$(document).ready(function(){
    $.ajax({
        type: "POST",
        url: "<?=api_url('get_pricing_card_details_table_show_hide_info')?>",
        data:{module_id: '<?php print $params['id'] ?>'},
        success: function(response) {
            if(response.message == 'on'){
                $('#ultra-toggle-table-<?php print $params['id']; ?>').show();
                // $('#ultra-toggle-table-2').show();
                // $('#ultra-toggle-table-3').show();
            }else{
                $('#ultra-toggle-table-<?php print $params['id']; ?>').hide();
                // $('#ultra-toggle-table-2').hide();
                // $('#ultra-toggle-table-3').hide();
            }
        }
    });
});

$(document).ready(function(){
    <?php $first_interval = 1; ?>
    <?php foreach($interval_information as $single_interval): ?>
        if('<?php print $first_interval;  ?>' == 1){
            $('#step-<?php print $single_interval->option_key; ?>-btn-<?php print $params['id']; ?>').parent('li').addClass("pricing-collection-item-active");
            $('#step-<?php print $single_interval->option_key; ?>-btn-<?php print $params['id']; ?>').prop("checked",true);
            $('.step-<?php print $single_interval->option_key; ?>-div-<?php print $params['id']; ?>').show();

        }else{
            $('#step-<?php print $single_interval->option_key; ?>-btn-<?php print $params['id']; ?>').parent('li').removeClass("pricing-collection-item-active");
            $('.step-<?php print $single_interval->option_key; ?>-div-<?php print $params['id']; ?>').hide();
        }
        $('#step-<?php print $single_interval->option_key; ?>-btn-<?php print $params['id']; ?>').click(function(){
            <?php foreach($interval_information as $single_interval_show): ?>
                if('<?php print $single_interval_show->option_key?>' == '<?php print $single_interval->option_key?>'){
                    $('#step-<?php print $single_interval_show->option_key; ?>-btn-<?php print $params['id']; ?>').parent('li').addClass("pricing-collection-item-active");
                    $('.step-<?php print $single_interval_show->option_key; ?>-div-<?php print $params['id']; ?>').show();
                }else{
                    $('#step-<?php print $single_interval_show->option_key; ?>-btn-<?php print $params['id']; ?>').parent('li').removeClass("pricing-collection-item-active");
                    $('.step-<?php print $single_interval_show->option_key; ?>-div-<?php print $params['id']; ?>').hide();
                }
            <?php  endforeach;  ?>
        });  
    <?php $first_interval++;  endforeach;  ?>
});

// ultraToggleBtnOne = document.querySelector('#ultra-toggle-btn-<?php //print $params['id']; ?>');
// ultraToggleBtnOne.addEventListener('click', function(){
//     if($('#ultra-toggle-table-<?php //print $params['id']; ?>').css('display') == 'none') {
//         $('#ultra-toggle-table-<?php //print $params['id']; ?>').show();
//     }else{
//         $('#ultra-toggle-table-<?php //print $params['id']; ?>').hide();
//     }
// });

$(document).on("click",'#ultra-toggle-btn-<?php print $params['id']; ?>',function(){
    if($('#ultra-toggle-table-<?php print $params['id']; ?>').css('display') == 'none') {
        $('#ultra-toggle-table-<?php print $params['id']; ?>').show();
    }else{
        $('#ultra-toggle-table-<?php print $params['id']; ?>').hide();
    }
});
</script>

<style>

.onoffswitch {
    position: relative; width: 50px;
    -webkit-user-select:none;
     -moz-user-select:none;
      -ms-user-select: none;
    display: inline-block;
    text-align: left;
}
.onoffswitch-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.onoffswitch-label {
    display: block;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #999999;
    border-radius: 20px;
    position: relative;
    margin-bottom:0px;
}
.onoffswitch-inner {
    display: block;
    width: 200%;
    margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block;
    float: left;
    width: 50%;
    height: 20px;
    padding: 0;
    line-height: 22px;
    font-size: 10px;
    color: white;
    font-family: Trebuchet, Arial, sans-serif;
    font-weight: bold;
    box-sizing: border-box;
}
.onoffswitch-inner:before {
    content: "ON";
    padding-left: 7px;
    background-color: #074a74; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "OFF";
    padding-right: 7px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
}
.onoffswitch-switch {
    display: block; width: 15px; margin: 3px;
    background: #FFFFFF;
    position: absolute; top: 0; bottom: 0;
    right: 25px;
    border: 2px solid #999999; border-radius: 20px;
    transition: all 0.3s ease-in 0s;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px;
}

.pricing-card-admin-toggle {
    display: flex;
    align-items: center;
}

.pricing-card-admin-toggle h4 {
    margin-right: 20px;
}

.pricing-card-admin-toggle p {
    font-size: 14px;
    font-weight: 700;
    margin-right: 10px;
}

.pricing-card-des-popup-info {
    margin-top: 10px;
}

.pricing-card-des-popup-info p {
    font-size: 16px;
    margin-bottom: 5px;
}

.pricing-card-des-popup-info .btn {
    margin-top: 10px;
}
</style>
<div class="modal fade layout-name-edit" id="pricing_card_row_description_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-info-circle" aria-hidden="true"></i><?php _e('Description Details'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="pricing-card-table-td-info" id="row_description_value">
            </div>
        </div>
    </div>
  </div>
</div>
<div class="modal fade layout-name-edit" id="pricing_card_description_add_for_table_row" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-cog" aria-hidden="true"></i><?php _e('Description popup setting'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="description_popup_id">
            <div class="pricing-card-admin">
                <div class="pricing-card-admin-toggle">
                    <p><?php _e('Description popup'); ?>:</p>
                    <div class="onoffswitch">
                        <input type="checkbox" id="pricing-card-table-row-description-show-hide" onclick="row_description_show_hide();" class="onoffswitch-checkbox" name="pricing-card-table-row-description-show-hide">
                        <label class="onoffswitch-label" for="pricing-card-table-row-description-show-hide">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="pricing-card-des-popup-info">
                <p><?php _e('Insert your description here'); ?>:</p>
                <textarea name="row-description" id="row_description" cols="30" rows="5" class="ckeditor form-control form-control-lg" required></textarea>
                <button class="btn btn-primary" onclick="row_description_save();"><?php _e('Save'); ?></button>
            </div>
        </div>
    </div>
  </div>
</div>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
    function row_description_save(){
        row_description_id = $('#description_popup_id').val();
        row_description = CKEDITOR.instances.row_description.getData();
        if($('#pricing-card-table-row-description-show-hide').is(':checked')){
            if(row_description){
                $.ajax({
                    type: "POST",
                    url: "<?=api_url('pricing_card_table_row_description_save')?>",
                    data:{ row_description_id,row_description },
                    success: function(response) {
                        location.reload();
                    }
                });
            }else{
                mw.notification.success("<?php _e('Please write something in description box'); ?>");
            }
        }else{
            mw.notification.success("<?php _e('Please on the description button'); ?>");
        }
    }

    function row_description_show_hide(){
        row_description_id = $('#description_popup_id').val();
        if($('#pricing-card-table-row-description-show-hide').is(':checked')){
            row_on_off = 'on';
            $.ajax({
                type: "POST",
                url: "<?=api_url('pricing_card_table_row_description_show_hide')?>",
                data:{ row_description_id,row_on_off },
                success: function(response) {
                    mw.notification.success("<?php _e('successfully on'); ?>");
                }
            });
        }else{
            row_on_off = 'off';
            $.ajax({
                type: "POST",
                url: "<?=api_url('pricing_card_table_row_description_show_hide')?>",
                data:{ row_description_id,row_on_off },
                success: function(response) {
                    mw.notification.success("<?php _e('successfully off'); ?>");
                    location.reload();
                }
            });
        }
    }

</script>
