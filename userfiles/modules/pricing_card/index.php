<link rel="stylesheet" type="text/css" href="<?php print $config['url_to_module'] ?>css/pricing_card.css" />
<?php $card_limit_quantity = get_option($params['id'],'pricing_card_limit_quantity'); ?>
<?php $table_limit_quantity = get_option($params['id'],'pricing_table_limit_quantity');   ?>
<?php
    $table_readmore_limit = get_option('table_readmore_'.$params['id'],'pricing_table_readmore_row_limit');
    if(!$table_readmore_limit){
        $table_readmore_limit = 'off';
    }
?>
<?php 
    $interval_limit = get_option('interval_limit','pricing_interval_'.$params['id']);
?>
<?php $active_card_number = get_option($params['id'],'pricing_card_active');   ?>
<?php $interval_information = DB::table('options')->where('option_group','pricing_interval_info_'.$params['id'])->orderBy('option_key','asc')->get(); ?>
<div class="">
    <div class="row">
        <div class="col-xl-12">
            <div class="row text-center">
                <div class="col-12 edit allow-drop " field="pricing_card_heading_title_<?php print $params['id']; ?>" rel="content" >
                    <h2 class="hr">See our plans</h2>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pricing-radio-top">
                            <ul class="pricing-ultra-colloction">
                                <?php if(get_option('initial_intervel_on_off','pricing_interval_'.$params['id']) == 'on'): ?> 
                                    <li class="pricing-collection-item">
                                        <div class="edit allow-drop " field="initial_interval_<?php print $params['id']; ?>" rel="content" >
                                            <label for="Zahlungsintervall">Zahlungsintervall</label><br>
                                        </div>
                                    </li>
                                <?php endif; ?>
                                <?php if($interval_information): ?>
                                    <?php foreach($interval_information as $single_interval): ?>
                                        <li class="pricing-collection-item">
                                            <input type="radio" id="step-<?php print $single_interval->option_key ?>-btn-<?php print $params['id']; ?>" name="pricing-step-<?php print $params['id']; ?>" value="step_<?php print $single_interval->option_key; ?>">
                                            <div class="plan-card-titile">
                                                <div>
                                                    <label for="Jahreszahlung"><?php print $single_interval->option_value; ?>
                                                    </label>
                                                    <?php if($single_interval->option_value2): ?>
                                                        <div class="pricing-perc">
                                                            <span> -<?php print $single_interval->option_value2; ?>%</span>
                                                        </div>
                                                    <?php endif; ?> 
                                                </div>
                                            </div>
                                            <br>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($interval_information): ?>
        <?php foreach($interval_information as $single_interval): ?>
            <?php 
                $i = $single_interval->option_key; 
                $interval_discount_value = (isset($single_interval->option_value2) && $single_interval->option_value2 != "") ? $single_interval->option_value2 : 0;
                $discount_price = 10 - ((10*$interval_discount_value)/100);
            ?>
            <div class="step-<?php print $i; ?>-div-<?php print $params['id']; ?>" style="display:none;">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row pricing-list-new d-flex justify-content-center pricing-card">
                            <?php if($card_limit_quantity): ?>
                                <?php for($k=1; $k <=$card_limit_quantity; $k++): ?>
                                    <div class="col-sm-6 col-lg-3 allow-drop">
                                        <div class="plan <?php if($active_card_number == $k): ?> pricing-card-active-color <?php endif; ?>">
                                            <div class="heading edit  allow-drop  parent-heading parent-heading-<?=$i.$k?>" data-id="<?=$i.$k?>" field="card_heading_<?php print $i.$k.'_'.$params['id']; ?>" rel="content">
                                                <p class="">Early Bird</p>
                                                <div class="price">
                                                    <h1 class="sum "><?=$discount_price?></h1>
                                                    <h3 class="period ">EUR/Per month</h3>
                                                </div>
                                                <div class="element button-holder">
                                                    <module type="btn" template="bootstrap" button_style="btn-outline-primary" button_size="btn-sm btn-block" class="" button_text="Purchase Now"/>
                                                </div>
                                            </div>
                                            <div class="description edit allow-drop" field="card_description_<?php print $i.$k.'_'.$params['id']; ?>" rel="content">
                                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when.</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div> 
        <?php endforeach; ?>
   
        <div class="ultra-accordio-section">
            <div class="row">
                <?php if($card_limit_quantity): ?>
                    <div class="col-md-12">
                        <div class="ultra-acc-top">
                            <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                            <h2 class="edit " id="ultra-toggle-btn-<?php print $params['id']; ?>" field="ultra_toggle_btn_<?php print $params['id']; ?>" rel="content"> Merkmale für alle Pläne ausblenden</h2>
                        </div>
                        <div class="pricing-table-wrapper" id="ultra-toggle-table-<?php print $params['id']; ?>" style="display:none;">
                            <div class="main-table">
                                <table class="marketing-table">
                                    <thead>
                                    <?php if($interval_information): ?>
                                        <?php foreach($interval_information as $single_interval): ?>
                                            <?php
                                                $interval_discount_value = (isset($single_interval->option_value2) && $single_interval->option_value2 != "") ? $single_interval->option_value2 : 0;
                                                $discount_price = 10 - ((10*$interval_discount_value)/100);
                                            ?>
                                            <?php $i = $single_interval->option_key; ?>
                                            <tr class="first-tr step-<?php print $i; ?>-div-<?php print $params['id']; ?>" style="display:none;">
                                                <th class="ultra-th ultra-th-empty"></th>
                                                <?php for($k=1; $k <=$card_limit_quantity; $k++): ?>
                                                    <th class="ultra-th allow-drop <?php if($active_card_number == $k): ?> pricing-card-active-color <?php endif; ?>">
                                                        <div class="col-12 allow-drop">
                                                            <div class="plan">
                                                                <div class="heading edit allow-drop child-heading child-heading-<?=$i.$k?>" data-id="<?=$i.$k?>" field="card_heading_<?php print $i.$k.'_'.$params['id']; ?>" rel="content">
                                                                    <p class="">Early Bird</p>
                                                                    <div class="price">
                                                                        <h1 class="sum "><?=$discount_price?></h1>
                                                                        <h3 class="period ">EUR/Per month</h3>
                                                                    </div>
                                                                    <div class="element button-holder">
                                                                        <module type="btn" template="bootstrap" button_style="btn-outline-primary" button_size="btn-sm btn-block" class="" button_text="Purchase Now"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>
                                                <?php endfor; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </thead>
                                    <?php if($table_limit_quantity): ?>
                                        <?php $column_default_value = "Test Content"; ?>
                                        <?php for($i=1; $i <=$table_limit_quantity; $i++): ?>
                                            <?php $table_row_limit_quantity = get_option('table_'.$i.'_'.$params['id'],'pricing_table_row_limit_quantity'); ?>
                                            <?php if($table_row_limit_quantity): ?>
                                                <tr class="pricing-table-heading-tr">
                                                    <td class="pricing-table-heading" colspan="<?php print $card_limit_quantity+1; ?>">
                                                        <div class="edit allow-drop" field="table_heading_<?php print $i.'_'.$params['id']; ?>" rel="content">
                                                            <h4 class="tr-highlight">TSE / KassenSichV (pro POS-Standort)</h4>
                                                            <p>OnlineshopEinschließlich E-Commerce-Website und Blog.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php for($j=1;$j<=$table_row_limit_quantity;$j++): ?>
                                                    <tr <?php if($j>$table_readmore_limit && $table_readmore_limit != 'off'): ?> class="table-row-hide-<?php print $i; ?>" style="display:none" <?php endif; ?>>
                                                        <td>
                                                            <div class="row-heading">
                                                                <div class="row-description edit allow-drop" field="table_row_heading_<?php print $i.$j.'_'.$params['id']; ?>" rel="module">
                                                                    <p>Unbegrenzte Produkte</p>
                                                                </div>
                                                                <div class="row-icon">
                                                                    <?php $description_popup_id = 'row_description_'.$i.$j.'_'.$params['id']; ?>
                                                                    <?php if(get_option('row_popup_on_off',$description_popup_id) == 'on'): ?>
                                                                        <i class="fa fa-info-circle row-icon-des-info" onclick="description_show_modal('<?php print $description_popup_id; ?>');"> </i>
                                                                    <?php endif; ?>
                                                                    <?php if(is_live_edit()): ?>
                                                                        <span class="layout-edit-icon" onclick="description_set_modal('<?php print $description_popup_id; ?>');">Description Popup <i class="fa fa-pencil-square" aria-hidden="true"></i></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <?php if($card_limit_quantity): ?>
                                                            <?php for($k=1; $k <=$card_limit_quantity; $k++): ?>
                                                                <td class="td-check">
                                                                    <div class="edit allow-drop" field="table_specific_column_serial_<?php print $i.$j.$k.'_'.$params['id']; ?>" rel="content">
                                                                    <p><?=$column_default_value?></p>
                                                                    </div>
                                                                </td>
                                                            <?php endfor; ?>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endfor; ?>
                                                <?php if($table_readmore_limit && $table_row_limit_quantity > $table_readmore_limit): ?>
                                                    <tr class="readmore-td">
                                                        <td colspan="<?php print $card_limit_quantity+1; ?>">
                                                            <div class="readmore-icon" onclick="table_row_readmore_option(<?php print $i; ?>);">
                                                                <div class="readmore-icon-show-<?php print $i; ?>">
                                                                    <span class="readmore-icon-text"><?php _e('Read More'); ?></span>
                                                                    <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                                                </div>
                                                                <div class="readless-icon-show-<?php print $i; ?>" style="display:none;">
                                                                    <span class="readmore-icon-text"><?php _e('Read Less'); ?></span>
                                                                    <i class="fa fa-angle-double-up" aria-hidden="true"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                                <script>
                                                    function table_row_readmore_option(index_number){
                                                        if($('.table-row-hide-'+index_number).css("display") == "table-row") {
                                                            $('.table-row-hide-'+index_number).css("display", "none");
                                                            $('.readmore-icon-show-'+index_number).show();
                                                            $('.readless-icon-show-'+index_number).hide();
                                                        }else{
                                                            $('.table-row-hide-'+index_number).css("display", "table-row");
                                                            $('.readmore-icon-show-'+index_number).hide();
                                                            $('.readless-icon-show-'+index_number).show();
                                                        }
                                                    }
                                                </script>
                                        <?php endfor; ?>
                                        <script>
                                            function description_set_modal(row_description_id){
                                                $('#description_popup_id').val(row_description_id);
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?=api_url('pricing_card_table_row_description_value')?>",
                                                    data:{ row_description_id },
                                                    success: function(response) {
                                                        if(response.message['on_off'] == 'on'){
                                                            $('#pricing-card-table-row-description-show-hide').prop('checked',true);
                                                            CKEDITOR.instances.row_description.setData(response.message['value']);
                                                            $('#pricing_card_description_add_for_table_row').modal('show');
                                                        }else{
                                                            $('#pricing-card-table-row-description-show-hide').prop('checked',false);
                                                            CKEDITOR.instances.row_description.setData(' ');
                                                            $('#pricing_card_description_add_for_table_row').modal('show');
                                                        }
                                                    }
                                                });
                                            }
                                            function description_show_modal(row_description_id){
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?=api_url('pricing_card_table_row_description_value')?>",
                                                    data:{ row_description_id },
                                                    success: function(response) {
                                                        $('#row_description_value').html(response.message['value']);
                                                        $('#pricing_card_row_description_show').modal('show');
                                                    }
                                                });
                                            }
                                        </script>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-12">
                        <div class="pricing-layout-alert">
                            <h2> <?php _e('Please add pricing plans from pricing card edit'); ?>!</h2>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="col-md-12">
            <div class="pricing-layout-alert">
                <h2> <?php _e('Please add pricing card interval and pricing plans from pricing card edit'); ?>!</h2>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php include modules_path() . "pricing_card/price_table.php"; ?>

<script>
$(".heading.edit.parent-heading").on("keyup",function(){
    let id = $(this).data("id");
    let field = $(".heading.edit").attr("field");
    let text = $(this).html();
    $('.child-heading-'+id).html(text);
});

$(".heading.edit.child-heading").on("keyup",function(){
    let id = $(this).data("id");
    let field = $(".heading.edit").attr("field");
    let text = $(this).html();
    $('.parent-heading-'+id).html(text);
});
</script>
