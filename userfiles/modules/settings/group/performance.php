<style>
.switch_image_compressor {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 25px;
        }
        
        .switch_image_compressor input { 
          opacity: 0;
          width: 0;
          height: 0;
        }
        
        .slider_image_compressor {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        
        .slider_image_compressor:before {
            position: absolute;
            content: "";
            height: 21px;
            width: 21px;
            left: 3px;
            bottom: 2px;
            background-color: #ffffff;
            -webkit-transition: .4s;
            transition: .4s;
        }
        
        input:checked + .slider_image_compressor {
          background-color: #2196F3;
        }
        
        input:focus + .slider_image_compressor {
          box-shadow: 0 0 1px #2196F3;
        }
        
        input:checked + .slider_image_compressor:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(18px);
        }
        
        .slider_image_compressor.round_image_compressor {
          border-radius: 34px;
        }
        
        .slider_image_compressor.round_image_compressor:before {
          border-radius: 50%;
        }
        </style>



<div class="card-body pt-2 pb-0">
    <div class="row">
        <div class="col-md-3">
            <h5 class="font-weight-bold"><?php _e("Performance settings"); ?></h5>
            <small class="text-muted"><?php _e('Speed up your website load speed and optimize website.'); ?></small>
        </div>
        <div class="col-md-9">
            <div class="card bg-light style-1 mb-1">
                <div class="card-body pt-3">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label class="control-label"><?php _e("Cache settings"); ?></label>
                                <small class="text-muted d-block mb-2"><?php _e("Speed up your website load speed"); ?></small>
                            
                                <script>
                                    function clearMwCache() {
                                        mw.clear_cache();
                                        mw.notification.success("<?php _ejs("The cache was cleared"); ?>.");
                                    }
                                </script>

                                <a href="javascript:;" class="btn btn-outline-primary btn-sm" onclick="openModuleInModal('settings/group/cache', 'Cache-Einstellungen')"><?php _e("Cache settings"); ?></a>
                                <a class="btn btn-outline-danger btn-sm" href="javascript:clearMwCache();"><?php _e("Clear browser cache"); ?></a>
                                <button class="btn btn-outline-danger btn-sm" onclick="clear_server_cache()"><?php _e("Clear server cache"); ?></button>

                                <script>
                                    function clear_server_cache(){
                                        $.ajax({
                                            url:"<?=site_url().'api/v1/auto_clear_all_server_cache'?>"
                                        });
                                        mw.notification.success("<?php _e('The server cache was cleared'); ?>");
                                    }
                                    function openModuleInModal(module, title) {
                                        if(!title){
                                            title = '';
                                        }
                                        var dialog = mw.dialog({'title': title});
                                        mw.load_module(module, dialog.dialogContainer);
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label"><?php _e("Image Performance"); ?></label>
                                <small class="text-muted d-block mb-2"><?php _e("Optimize all images"); ?></small>
                                <div class="form-check form-switch">
                                    <?php $option = get_option('img_compressor' , 'compressor'); ?>
                                    
                                    <!-- new checkbox -->
                                    <label class="switch_image_compressor">
                                    <input type="checkbox" name="image_performance" id="image_performance" <?php if($option and $option == 1) : ?> checked <?php endif; ?>onclick="image_performance()">
                                    <span class="slider_image_compressor round_image_compressor"></span>
                                    </label>
                                </div>
                                <script>
                                    function image_performance()
                                    {
                                        if(document.getElementById('image_performance').checked){
                                            $.post("<?=api_url('image_performance_on')?>", {
                                                
                                                }).then((res, err) => {
                                                console.log(res, err);
                                                });
                                        } else{
                                            $.post("<?=api_url('image_performance_off')?>", {
                                                
                                            }).then((res, err) => {
                                            console.log(res, err);
                                            });
                                        }
                                        mw.notification.success("<?php _e('Changed saved successfully'); ?>");
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


