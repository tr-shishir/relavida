<style>

.onoffswitch {
    position: relative; width: 50px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    display: inline-block;
    text-align: left;
}
.onoffswitch-checkbox {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
    position: relative;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
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
.pricing-card-limit {
    margin-top: 8px;
}

.pricing-card-limit-wrapper,
.pricing-card-table-limit-wrapper,
.pricing-card-read-more-wrapper,
.pricing-card-intervel-wrapper {
    margin-bottom: 20px;
    padding: 5px;
    border: 1px solid #ccc;
    background: #ffffff;
    border-radius: 5px;
}

.pricing-card-intervel-toggle {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.pricing-card-intervel-toggle .onoffswitch {
    margin-left: 10px;
}

.pricing-card-intervel-toggle p {
    font-size: 16px;
    margin-bottom: 0;
}

.pricing-card-intervel-toggle .onoffswitch-label {
    margin-bottom: 0;
}

.mw-dialog-holder{
    width: 700px !important;
}
.pricing-card-interval-name,
.pricing-card-interval-percent,
.pricing-card-interval-save-button{
    margin-bottom:20px;
}
.pricing-card-interval-name .input-group-append{
    width: 110px;
}
.text-center{
    text-align: center !important;
}
.text-danger{
    color: red !important;
}
.text-secondary{
    color: green !important;
}
.cursor-pointer{
    cursor: pointer;
}
.onoffswitch-inner:before, .onoffswitch-inner:after{
    height: 22px !important;
}
.pricing-card-admin-tab .nav-tabs {
    border-bottom: 1px solid #ccc;
}

.pricing-card-admin-tab .nav-tabs .nav-item {
    flex: 1 1 auto;
}

.pricing-card-admin-tab .nav-tabs .nav-item .nav-link {
    border-bottom: 0;
    color: #717171;
    display: flex;
    align-items: center;
    font-size: 12px;
    padding: 4px;
}

.pricing-card-admin-tab .nav-tabs .nav-item .nav-link.active {
    color: #2b2b2b;
    border: 0;
    border-bottom: 4px solid #4592ff;
}

.pricing-card-admin-tab .nav-tabs .nav-item .nav-link:hover{
    color: #2b2b2b !important;
    background-color: #f0f0f0;
}
.pricing-card-admin-tab .nav-tabs .nav-item .nav-link:hover i{
    color: #4592ff;
}

.tab-content {
    margin-top: 30px;
}

.pricing-card-admin-tab .nav-tabs .nav-item .nav-link i {
    font-size: 18px;
}

.pricing-card-admin-tab .nav-tabs .nav-item .nav-link.active i {
    color: #4592ff;
}
.limit-title>.element, .limit-title>.element>span,.limit-title h1,.limit-title h2,.limit-title h3,.limit-title h4,.limit-title h5,.limit-title h6,.limit-title p {
    font-size: 14px !important;
    margin-bottom: 5px;
}

.pricing-card-limit {
    margin-bottom: 20px;
}
</style>

<div class="pricing-card-admin-tab">
    <ul class="nav nav-tabs" id="pricing-card-admin-tab-list-<?=$params['id']?>" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active"  data-toggle="tab" href="#pricing_card_interval_<?=$params['id']?>" role="tab" aria-selected="false"><i class="mdi mdi-cog-outline mr-1"></i><?php _e('Interval Settings'); ?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link"  data-toggle="tab" href="#pricing_card_limit_<?=$params['id']?>" role="tab" aria-selected="false"><i class="mdi mdi-cog-outline mr-1"></i><?php _e('Card Settings'); ?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-toggle="tab" href="#pricing_card_table_<?=$params['id']?>" role="tab" aria-selected="false"><i class="mdi mdi-cog-outline mr-1"></i><?php _e('Table Settings'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active show" id="pricing_card_interval_<?=$params['id']?>" role="tabpanel">
            <div class="pricing-card-intervel-wrapper">
                <h4><?php _e('Pricing card interval setting'); ?></h4>
                <div class="pricing-card-intervel-toggle">
                    <p><?php _e('Pricing card initial interval'); ?></p>
                    <div class="onoffswitch">
                        <input type="checkbox" id="pricing-card-initial-intervel-show-hide" onclick="pricing_card_initial_interval()" class="onoffswitch-checkbox" name="pricing-card-initial-intervel-show-hide" <?php if(get_option('initial_intervel_on_off','pricing_interval_'.$params['id']) == 'on'): ?> checked <?php endif; ?> >
                        <label class="onoffswitch-label" for="pricing-card-initial-intervel-show-hide">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
                <div class="pricing-card-interval-name">
                    <p><?php _e("Pricing card interval's Title and Position"); ?></p>
                    <div class="input-group">
                        <input type="hidden" class="form-control" id="interval_id">
                        <input type="text" class="form-control" id="interval_title" placeholder="<?php _e('Title'); ?>">
                        <div class="input-group-append">
                            <select class="form-control" id="interval_position" >
                                <option value=""><?php _e('Position'); ?></option>
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <option value="<?php print $i; ?>"><?php print $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="pricing-card-interval-percent">
                    <p><?php _e('Pricing card interval Percentage'); ?></p>
                    <select class="form-control" id="interval_percentage">
                        <option value="0"><?php _e('Select option'); ?></option>
                        <?php for($i=1; $i<100; $i++): ?>
                            <option value="<?php print $i; ?>"><?php print $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="pricing-card-interval-save-button">
                    <button class="btn btn-success" id="interval_save_button" onclick="interval_information_save();"><?php _e('Save'); ?></button>
                    <button class="btn btn-primary" id="interval_update_button" style="display: none" onclick="interval_information_update();"><?php _e('Update'); ?></button>
                </div>
                <div class="pricing-card-interval-table">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col"><?php _e('Title'); ?></th>
                            <th class="text-center" scope="col"><?php _e('Position'); ?></th>
                            <th class="text-center" scope="col"><?php _e('Discount in %'); ?></th>
                            <th class="text-center" scope="col"><?php _e('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $interval_information = DB::table('options')->where('option_group','pricing_interval_info_'.$params['id'])->orderBy('option_key','asc')->get(); ?>
                            <?php foreach($interval_information as $single_interval): ?>
                                <tr>
                                    <td><?php print $single_interval->option_value; ?></td>
                                    <td class="text-center"><?php print $single_interval->option_key; ?></td>
                                    <td class="text-center"><?php print $single_interval->option_value2; ?> %</td>
                                    <td class="text-center">
                                        <span><i class="fa fa-trash text-danger cursor-pointer" aria-hidden="true" onclick="interval_information_delete('<?php print $single_interval->option_key; ?>');"></i></span>
                                        <span><i class="fa fa-edit text-secondary cursor-pointer" aria-hidden="true" onclick="interval_information_edit('<?php print $single_interval->option_key; ?>');"></i></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pricing_card_limit_<?=$params['id']?>" role="tabpanel">
            <div class="pricing-card-limit-wrapper">
                <h4><?php _e('Pricing Card Limit'); ?></h4>
                <div class="pricing-card-limit">
                    <div class="limit-title">
                        <p><?php _e('Please set card limit here'); ?></p>
                    </div>
                    <?php $card_limit_quantity = get_option($params['id'],'pricing_card_limit_quantity');   ?>
                    <div class="limit-quantity">
                        <select class="form-control" id="card-limit-quantity-<?php print $params['id']; ?>">
                            <option value=""><?php _e('Select option'); ?>...</option>
                            <?php for($i=1;$i<=5;$i++): ?>
                                <option value="<?php print $i ?>" <?php if($card_limit_quantity == $i): ?> selected <?php endif; ?>><?php print $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <?php if($card_limit_quantity): ?>
                        <?php $active_card_number = get_option($params['id'],'pricing_card_active');   ?>
                        <div class="limit-title">
                            <p><?php _e('Please set Active card here'); ?></p>
                        </div>
                        <div class="limit-quantity">
                            <select class="form-control" id="active-pricing-card-<?php print $params['id']; ?>">
                                <option value=""><?php _e('Select option'); ?>...</option>
                                <option value="none" <?php if($active_card_number == 'none'): ?> selected <?php endif; ?>><?php _e('None'); ?></option>
                                <?php for($i=1;$i<=$card_limit_quantity;$i++): ?>
                                    <option value="<?php print $i ?>" <?php if($active_card_number == $i): ?> selected <?php endif; ?>><?php print $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pricing_card_table_<?=$params['id']?>" role="tabpanel">
            <div class="pricing-card-admin">
                <div class="pricing-card-admin-toggle">
                    <h4><?php _e('Pricing card detailed table'); ?></h4>
                    <div class="onoffswitch">
                        <input type="checkbox" id="pricing-card-table-show-hide" onclick="pricing_card_details_table()" class="onoffswitch-checkbox" name="pricing-card-table-show-hide" <?php if(get_option($params['id'],'pricing_card_details_table_show_hide')=='on'): ?> checked <?php endif; ?>>
                        <label class="onoffswitch-label" for="pricing-card-table-show-hide">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
                <div class="pricing-card-admin-content">
                    <p><?php _e('When the toggle button will be turned on that time the detailed table will be initially shown. On the other hand when the toggle button will be turned off that time the detailed table will be initially hidden'); ?>.</p>
                </div>
            </div>
            <div class="pricing-card-table-limit-wrapper">
                <h4><?php //_e('Pricing Card Table Limit'); ?></h4>
                <div class="pricing-card-limit">
                    <div class="limit-title">
                        <p><?php _e('How many subject blocks should there be? (Each topic can have a maximum of 50 entries.)'); ?></p>
                    </div>
                    <?php $table_limit_quantity = get_option($params['id'],'pricing_table_limit_quantity');   ?>
                    <div class="limit-quantity">
                        <select class="form-control" id="table-limit-quantity">
                            <option value=""><?php _e('Select option'); ?>...</option>
                            <?php for($i=1;$i<=15;$i++): ?>
                                <option value="<?php print $i ?>" <?php if($table_limit_quantity == $i): ?> selected <?php endif; ?>><?php print $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <?php for($i=1; $i<=$table_limit_quantity;$i++): ?>
                    <?php 
                        $table_heading_title = DB::table('content_fields')->where('field','table_heading_'.$i.'_'.$params['id'])->first();
                        if(isset($table_heading_title)){
                            $dom = new DOMDocument();
                            @$dom->loadHTML($table_heading_title->value);
                            if($dom->getElementsByTagName("h1")->length > 0){
                                $nodes = $dom->getElementsByTagName("h1");
                            }elseif($dom->getElementsByTagName("h2")->length > 0){
                                $nodes = $dom->getElementsByTagName("h2");
                            }elseif($dom->getElementsByTagName("h3")->length > 0){
                                $nodes = $dom->getElementsByTagName("h3");
                            }elseif($dom->getElementsByTagName("h4")->length > 0){
                                $nodes = $dom->getElementsByTagName("h4");
                            }elseif($dom->getElementsByTagName("h5")->length > 0){
                                $nodes = $dom->getElementsByTagName("h5");
                            }elseif($dom->getElementsByTagName("h6")->length > 0){
                                $nodes = $dom->getElementsByTagName("h6");
                            }
                            $element = $dom->saveHtml($nodes[0]); 
                            $element_length = $nodes->length;
                        }else{
                            $element_length = 0;
                        }
                        
                    ?>
                    <div class="pricing-card-limit">
                        <?php if($element_length > 0): ?>
                            <div class="limit-title">
                                <p><?php _e('How many rows are used for topic block'); ?> "<?=strip_tags($element)?>" <?php _e('needed?'); ?></p>   
                            </div>
                        <?php else: ?>
                            <div class="limit-title">
                                <p><?php _e('How many rows are used for topic block'); ?> "<?php print $i;?>" <?php _e('needed?'); ?></p>
                            </div>
                        <?php endif; ?>
                       
                        <?php $table_row_limit_quantity = get_option('table_'.$i.'_'.$params['id'],'pricing_table_row_limit_quantity');   ?>
                        <div class="limit-quantity">
                            <select class="form-control" id="table-<?php print $i; ?>-row-limit-quantity">
                                <option value=""><?php _e('Select option'); ?>...</option>
                                <?php for($k=1;$k<=50;$k++): ?>
                                    <option value="<?php print $k ?>" <?php if($table_row_limit_quantity == $k): ?> selected <?php endif; ?>><?php print $k ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <script>
                        $('#table-<?php print $i; ?>-row-limit-quantity').on('change', function() {
                            $.ajax({
                                type: "POST",
                                url: "<?=api_url('pricing_table_row_limit_quantity_save')?>",
                                data:{ limit : this.value,table_number : '<?php print $i; ?>', module_id: '<?php print $params['id'] ?>'},
                                success: function(response) {
                                    mw.notification.success("successfully Saved");
                                }
                            });
                        });
                    </script>
                <?php endfor; ?>
            </div>
            <div class="pricing-card-read-more-wrapper">
                <h4><?php _e('A maximum of 50 lines can be displayed per topic block. Should the default view be reduced'); ?>?</h4>
                <p><?php _e('Example: If you set 10, a maximum of 10 lines will be displayed per topic block. If you have more content (11 to 50), a "Read more" button will appear. Only then will the rest of the content open fully.'); ?></p>
                <div class="pricing-card-limit">
                    <div class="limit-title">
                        <p><?php _e('Please active and set read more limit here'); ?>:</p>
                    </div>
                    <?php $table_readmore_limit = get_option('table_readmore_'.$params['id'],'pricing_table_readmore_row_limit');   ?>
                    <div class="limit-quantity">
                        <select class="form-control" id="table_readmore_<?php print $params['id']; ?>">
                            <option value="off"><?php _e('Read more off'); ?>...</option>
                            <?php for($k=1;$k<=20;$k++): ?>
                                <option value="<?php print $k ?>" <?php if($table_readmore_limit == $k): ?> selected <?php endif; ?>><?php print $k ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function interval_information_save(){
        let interval_title = $('#interval_title').val();
        let interval_position = $('#interval_position').val();
        let interval_percentage = $('#interval_percentage').val();
        let module_id = '<?php print $params['id']; ?>';
        if(interval_title && interval_position){
            $.ajax({
                type:"POST",
                url: "<?=api_url('interval_information_save');?>",
                data:{interval_title,interval_position,interval_percentage,module_id},
                success: function(response){
                    if(response.message == 'success'){
                        mw.notification.success("successfully Saved");
                        location.reload();
                    }else{
                        mw.notification.error("Selected position already exist,So you can't select this position.You can add new position");
                    }
                }
            });
        }else{
            mw.notification.error("Please fillup the all field");
        }
    }

    function interval_information_delete(interval_position){
        module_id = '<?php print $params['id']; ?>';
        mw.tools.confirm("<?php _ejs("Do you want to delete this"); ?>?", function () {
            $.ajax({
                type:"POST",
                url: "<?=api_url('interval_information_delete');?>",
                data:{interval_position,module_id},
                success: function(response){
                    mw.notification.success("successfully Delete");
                    location.reload();
                }
            });
        });
    }

    function interval_information_edit(interval_position){
        module_id = '<?php print $params['id']; ?>';
        mw.tools.confirm("<?php _ejs("Do you want to edit this"); ?>?", function () {
            $.ajax({
                type:"POST",
                url: "<?=api_url('interval_information_edit');?>",
                data:{interval_position,module_id},
                success: function(response){
                    $("#interval_save_button").hide();
                    $("#interval_update_button").show();
                    // $('#interval_position').attr('disabled','disabled');
                    $('#interval_id').val(response.data['id']);
                    $('#interval_title').val(response.data['option_value']);
                    $('#interval_position').val(response.data['option_key']);
                    $('#interval_percentage').val(response.data['option_value2']);
                }
            });
        });
    }

    function interval_information_update(){
        let interval_id = $('#interval_id').val();
        let interval_title = $('#interval_title').val();
        let interval_position = $('#interval_position').val();
        let interval_percentage = $('#interval_percentage').val();
        let module_id = '<?php print $params['id']; ?>';
        if(interval_title && interval_position){
            $.ajax({
                type:"POST",
                url: "<?=api_url('interval_information_update');?>",
                data:{interval_id,interval_title,interval_position,interval_percentage,module_id},
                success: function(response){
                    if(response.message == 'success'){
                        mw.notification.success("successfully Updated");
                        location.reload();
                    }else{
                        mw.notification.error("Selected position already exist,So you can't select this position.You can add new position");
                    }
                }
            });
        }else{
            mw.notification.error("Please fillup the all field");
        }
    }

    function pricing_card_details_table(){
        if($('#pricing-card-table-show-hide').is(':checked')){
            $.ajax({
                type: "POST",
                url: "<?=api_url('pricing_card_details_table_show_hide')?>",
                data:{ check_value : 'on',module_id: '<?php print $params['id'] ?>'},
                success: function(response) {
                    mw.notification.success("successfully ON");
                }
            });
        }else{
            $.ajax({
                type: "POST",
                url: "<?=api_url('pricing_card_details_table_show_hide')?>",
                data:{ check_value : 'off',module_id: '<?php print $params['id'] ?>'},
                success: function(response) {
                    mw.notification.success("successfully OFF");
                }
            });
        }
    }
    $('#card-limit-quantity-<?php print $params['id']; ?>').on('change', function() {
        $.ajax({
            type: "POST",
            url: "<?=api_url('pricing_card_limit_quantity_save')?>",
            data:{ limit : this.value,module_id: '<?php print $params['id'] ?>'},
            success: function(response) {
                mw.notification.success("successfully Saved");
                location.reload();
            }
        });
    });
    $('#table-limit-quantity').on('change', function() {
        $.ajax({
            type: "POST",
            url: "<?=api_url('pricing_table_limit_quantity_save')?>",
            data:{ limit : this.value,module_id: '<?php print $params['id'] ?>'},
            success: function(response) {
                mw.notification.success("successfully Saved");
                location.reload();
            }
        });
    });
    $('#active-pricing-card-<?php print $params['id']; ?>').on('change', function() {
        $.ajax({
            type: "POST",
            url: "<?=api_url('pricing_card_active_save')?>",
            data:{ limit : this.value,module_id: '<?php print $params['id'] ?>'},
            success: function(response) {
                mw.notification.success("successfully Saved");
            }
        });
    });

    $('#table_readmore_<?php print $params['id']; ?>').on('change', function() {
        $.ajax({
            type: "POST",
            url: "<?=api_url('pricing_table_readmore_row_limit_save')?>",
            data:{ limit : this.value,module_id: '<?php print $params['id'] ?>'},
            success: function(response) {
                mw.notification.success("successfully Saved");
            }
        });
    });

    function pricing_card_initial_interval(){
        if($('#pricing-card-initial-intervel-show-hide').is(':checked')){
            console.log('check');
            $.ajax({
                type: "POST",
                url: "<?=api_url('pricing_card_initial_intervel_show_hide')?>",
                data:{ check_value : 'on',module_id: '<?php print $params['id'] ?>'},
                success: function(response) {
                    mw.notification.success("successfully ON");
                }
            });
        }else{
            console.log('uncheck');
            $.ajax({
                type: "POST",
                url: "<?=api_url('pricing_card_initial_intervel_show_hide')?>",
                data:{ check_value : 'off',module_id: '<?php print $params['id'] ?>'},
                success: function(response) {
                    mw.notification.success("successfully OFF");
                    location.reload();
                }
            });
        }
    }

    $(document).ready(function(){
        $('#pricing-card-admin-tab-list-<?=$params['id']?> a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#pricing-card-admin-tab-list-<?=$params['id']?> a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>
