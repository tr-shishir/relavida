<style>
    /* .js-track-quantity {
        display: none;
    } */

    .preloader-floating-circles {
        position: relative;
        width: 80px;
        height: 80px;
        margin: auto;
        transform: scale(0.6);
        -o-transform: scale(0.6);
        -ms-transform: scale(0.6);
        -webkit-transform: scale(0.6);
        -moz-transform: scale(0.6);
    }

    .preloader-floating-circles .f_circleG {
        position: absolute;
        background-color: white;
        height: 14px;
        width: 14px;
        border-radius: 7px;
        -o-border-radius: 7px;
        -ms-border-radius: 7px;
        -webkit-border-radius: 7px;
        -moz-border-radius: 7px;
        animation-name: f_fadeG;
        -o-animation-name: f_fadeG;
        -ms-animation-name: f_fadeG;
        -webkit-animation-name: f_fadeG;
        -moz-animation-name: f_fadeG;
        animation-duration: 0.672s;
        -o-animation-duration: 0.672s;
        -ms-animation-duration: 0.672s;
        -webkit-animation-duration: 0.672s;
        -moz-animation-duration: 0.672s;
        animation-iteration-count: infinite;
        -o-animation-iteration-count: infinite;
        -ms-animation-iteration-count: infinite;
        -webkit-animation-iteration-count: infinite;
        -moz-animation-iteration-count: infinite;
        animation-direction: normal;
        -o-animation-direction: normal;
        -ms-animation-direction: normal;
        -webkit-animation-direction: normal;
        -moz-animation-direction: normal;
    }

    .preloader-floating-circles #frotateG_01 {
        left: 0;
        top: 32px;
        animation-delay: 0.2495s;
        -o-animation-delay: 0.2495s;
        -ms-animation-delay: 0.2495s;
        -webkit-animation-delay: 0.2495s;
        -moz-animation-delay: 0.2495s;
    }

    .preloader-floating-circles #frotateG_02 {
        left: 9px;
        top: 9px;
        animation-delay: 0.336s;
        -o-animation-delay: 0.336s;
        -ms-animation-delay: 0.336s;
        -webkit-animation-delay: 0.336s;
        -moz-animation-delay: 0.336s;
    }

    .preloader-floating-circles #frotateG_03 {
        left: 32px;
        top: 0;
        animation-delay: 0.4225s;
        -o-animation-delay: 0.4225s;
        -ms-animation-delay: 0.4225s;
        -webkit-animation-delay: 0.4225s;
        -moz-animation-delay: 0.4225s;
    }

    .preloader-floating-circles #frotateG_04 {
        right: 9px;
        top: 9px;
        animation-delay: 0.509s;
        -o-animation-delay: 0.509s;
        -ms-animation-delay: 0.509s;
        -webkit-animation-delay: 0.509s;
        -moz-animation-delay: 0.509s;
    }

    .preloader-floating-circles #frotateG_05 {
        right: 0;
        top: 32px;
        animation-delay: 0.5955s;
        -o-animation-delay: 0.5955s;
        -ms-animation-delay: 0.5955s;
        -webkit-animation-delay: 0.5955s;
        -moz-animation-delay: 0.5955s;
    }

    .preloader-floating-circles #frotateG_06 {
        right: 9px;
        bottom: 9px;
        animation-delay: 0.672s;
        -o-animation-delay: 0.672s;
        -ms-animation-delay: 0.672s;
        -webkit-animation-delay: 0.672s;
        -moz-animation-delay: 0.672s;
    }

    .preloader-floating-circles #frotateG_07 {
        left: 32px;
        bottom: 0;
        animation-delay: 0.7585s;
        -o-animation-delay: 0.7585s;
        -ms-animation-delay: 0.7585s;
        -webkit-animation-delay: 0.7585s;
        -moz-animation-delay: 0.7585s;
    }

    .preloader-floating-circles #frotateG_08 {
        left: 9px;
        bottom: 9px;
        animation-delay: 0.845s;
        -o-animation-delay: 0.845s;
        -ms-animation-delay: 0.845s;
        -webkit-animation-delay: 0.845s;
        -moz-animation-delay: 0.845s;
    }

    @keyframes f_fadeG {
        0% {
            background-color: black;
        }

        100% {
            background-color: white;
        }
    }

    @-webkit-keyframes f_fadeG {
        0% {
            background-color: black;
        }

        100% {
            background-color: white;
        }
    }

    .digital-product-file-upload-success-text p {
        font-weight: 700;
        color: green;
        font-size: 20px;
        text-align: center;
    }

    .digital-product-file-upload-success-text {
        display: none;
    }

    .digital-product-file-upload-preloader {
        display: none;
    }
    .digital-product-file p {
        display: inline-block;
        margin-bottom: 0;
    }

    .digital-product-file p:first-child {
        font-size: 16px;
        margin-right: 10px;
    }

    .digital-product-file {
        border-radius: 5px;
        padding: 5px;
        background: #ebebeb;
        display: flex;
    }

    .digital-product-file p a {
        word-break: break-all;
    }

    .digital-product-file p:last-child {
        max-width: 700px;
    }
</style>
<?php
    $d_P_download_link = $data['d_P_download_link'] ?? null;
    if($data['id']==0){
        $d_P_download_link = null;
    }
?>
<script>
    $(document).ready(function() {
        var dig_val = $("select#digital-opt option:checked").val();
        if (dig_val == '1') {
            $(".digital-upload").css("display", "block");
        }
    });

    function digitalProductOption(opt) {
        var option = opt.value;
        $.post("<?= api_url('set_product_opt') ?>", {
            option: option,
            product_id: <?= $data['id'] ?>
        }).then((res, err) => {
            mw.notification.success(res);
        });
        if (option == '1') {
            $(".digital-upload").css("display", "block");
            <?php if($d_P_download_link == null): ?>
                $("#digital-content").prop('required',true);
            <?php endif; ?>
        } else {
            $(".digital-upload").css("display", "none");
            $("#digital-content").prop('required',false);
        }
    }

    $("#digital-content").on('change', function() {
        $(".digital-product-file-upload-preloader").css('display', 'block');
        var file = this.files[0];

        var formData = new FormData();
        formData.append('file', file);
        formData.append('product_id', <?= $data['id'] ?>);

        $.ajax({
            type: "POST",
            url: "<?= url('/') ?>/api/v1/upload_digital_product",
            data: formData,
            async: true,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(response) {
                $(".digital-product-file-upload-preloader").css('display', 'none');
                $(".digital-product-file-upload-success-text").css('display', 'block');
                $('.digital-product-file-upload-success-text').delay(2000).fadeOut('slow');
                mw.notification.success(response);
            }
        });
    });

    $('.js-bottom-save').on('click', function(){

    setTimeout(function(){

        if( $('.invalid-feedback').length > 0 ){
            $('html, body').animate({
                scrollTop: $(".invalid-feedback").offset().top -= 200
            }, 2000);
        }
        }, 1000);

    });
    $(document).ready(function () {
        $('.js-track-quantity-check').click(function () {
            mw.toggle_inventory_forms_fields();
        });
		enableTrackQuantityFields();
        <?php if ($contentData['track_quantity'] != 0):?>
        mw.toggle_inventory_forms_fields();
        enableTrackQuantityFields();
        <?php else: ?>
        //disableTrackQuantityFields();
        <?php endif; ?>

    });


    mw.toggle_inventory_forms_fields = function(){

        $('.js-track-quantity').toggle();

        if ($('.js-track-quantity-check').prop('checked')) {
            enableTrackQuantityFields();
        } else {
            //disableTrackQuantityFields();
        }
    }

    function disableTrackQuantityFields() {
        $("input,select",'.js-track-quantity').prop("disabled", true);
        $("input,select",'.js-track-quantity').attr("readonly",'readonly');

    }

    function enableTrackQuantityFields() {
        $("input,select",'.js-track-quantity').prop("disabled", false);
        $("input,select",'.js-track-quantity').removeAttr("readonly");


    }

    function contentDataQtyChange(instance) {
        if ($(instance).val()== '') {
            $(instance).val('nolimit');
        }
    }
</script>

<div class="card style-1 mb-3">
    <div class="card-header no-border">
        <h6><strong><?php _e("Inventory") ?></strong></h6>
    </div>

    <div class="card-body pt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>SKU (Stock Keeping Unit)</label>
                    <input type="text" name="content_data[sku]" class="form-control" value="<?php echo $contentData['sku']; ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Barcode (ISBN, UPC, GTIN, etc.)</label>
                    <!-- new code ean_input_field-->
                    <?php if($type=='Product'){ ?>
                        <input type="text" name="ean" id="ean_number" class="form-control" <?php if(isset($data['ean'])){ ?>value="<?php print $data['ean']; ?>"  disabled<?php }else{ ?> value="" placeholder="<?php _e('Please enter a 8 to 13 digit EAN number') ?>" required <?php } ?>>
                    <?php } ?>
                    <!-- <input type="text" name="content_data[barcode]" class="form-control" value="<?php echo $contentData['barcode']; ?>"> -->
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <!-- <input type="checkbox" name="content_data[track_quantity]" class="custom-control-input js-track-quantity-check" value="1" <?php if ($contentData['track_quantity']==1):?>checked="checked"<?php endif; ?> id="customCheck2"> -->
                            <input type="checkbox" name="content_data[track_quantity]" class="custom-control-input js-track-quantity-check" value="1" id="customCheck2" checked="checked">
                        <label class="custom-control-label" for="customCheck2"><?php _e("Track quantity") ?></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck3" name="content_data[sell_oos]" value="1" <?php if ($contentData['sell_oos']==1):?>checked="checked"<?php endif; ?>>
                        <label class="custom-control-label" for="customCheck3"><?php _e('Continue selling when out of stock') ?></label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php $digital_opt = $data['digital_opt'] ?? 0; ?>
                    <label><?php _e("Digital product") ?></label>
                    <select class="selectpicker js-search-by-selector form-control" id="digital-opt" name="digital-opt" data-width="100%" data-style="btn-sm" onchange="digitalProductOption(this)">
                        <option value="0" <?php (!$digital_opt) ? print 'selected' : print '' ?>><?php _e("NO"); ?></option>
                        <option value="1" <?php ($digital_opt) ? print 'selected' : print '' ?>><?php _e("YES"); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row digital-upload" style="display:none;">
            <div class="col-md-12">
                <div class="form-group">
                    <label><?php _e("Digital product download limit") ?></label>
                    <select class="selectpicker js-search-by-selector form-control" id="download_limit" name="download_limit" data-width="100%" data-style="btn-sm">
                        <?php for($i=1; $i < 10;$i++): ?>
                            <option value="<?php print $i; ?>" <?php if(isset($data['download_limit']) && $i == $data['download_limit']): ?> selected <?php endif; ?>><?php print $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label><?php _e("Upload Digital product content") ?></label>
                    <input type="file" id="digital-content" name="digital-content" class="form-control" <?php if($d_P_download_link == null && $digital_opt): ?> required <?php endif; ?>>
                </div>
                <div class="preloader-floating-circles digital-product-file-upload-preloader">
                    <div class="f_circleG" id="frotateG_01"></div>
                    <div class="f_circleG" id="frotateG_02"></div>
                    <div class="f_circleG" id="frotateG_03"></div>
                    <div class="f_circleG" id="frotateG_04"></div>
                    <div class="f_circleG" id="frotateG_05"></div>
                    <div class="f_circleG" id="frotateG_06"></div>
                    <div class="f_circleG" id="frotateG_07"></div>
                    <div class="f_circleG" id="frotateG_08"></div>
                </div>
                <div class="digital-product-file-upload-success-text">
                    <p>File uploaded successfully!</p>
                </div>
            </div>
            <?php if ($d_P_download_link) : ?>
                <div class="col-md-12">
                    <div class="form-group mb-3 digital-product-file">
                        <p>File :</p>
                        <p>
                            <i class="fa fa-file" aria-hidden="true"></i>
                            <a href="<?= site_url() . 'admin_download_digital_product/' . $data['id']  ?>"><?= $d_P_download_link ?></a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="js-track-quantity">

            <hr class="thin no-padding"/>

            <h6><strong><?php _e("Quantity") ?></strong></h6>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php _e("Available") ?></label>
                        <div class="input-group mb-1 append-transparent input-group-quantity">
                            <input type="text" class="form-control" name="content_data[qty]" onchange="contentDataQtyChange(this)" value="<?php echo $contentData['qty']; ?>" />
                            <div class="input-group-append">
                                <div class="input-group-text plus-minus-holder">
                                    <button type="button" class="plus"><i class="mdi mdi-menu-up"></i></button>
                                    <button type="button" class="minus"><i class="mdi mdi-menu-down"></i></button>
                                </div>
                            </div>
                        </div>

                        <small class="text-muted"><?php _e("How many products you have") ?></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php _e("Max quantity per order") ?></label>
                        <div class="input-group mb-1 append-transparent input-group-quantity">
                            <input type="text" class="form-control" name="content_data[max_quantity_per_order]" value="<?php echo $contentData['max_quantity_per_order']; ?>" placeholder="<?php _e('No Limit') ?>" />
                            <div class="input-group-append">
                                <div class="input-group-text plus-minus-holder">
                                    <button type="button" class="plus"><i class="mdi mdi-menu-up"></i></button>
                                    <button type="button" class="minus"><i class="mdi mdi-menu-down"></i></button>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted"><?php _e("How many products can be ordered at once") ?></small>
                    </div>
                </div>
                <div class="col-md-12">
                    <small class="text-muted"><?php _e("If you change the quantity manually here, you activate the overright in Dropmatix, i.e. the automatic stock updates are suspended. To undo this, open the product in Dropmatix and remove the overright.") ?></small>
                </div>
            </div>
        </div>

    </div>
</div>
