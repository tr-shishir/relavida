<?php must_have_access(); ?>

<?php
$from_live_edit = false;
if (isset($params["live_edit"]) and $params["live_edit"]) {
    $from_live_edit = $params["live_edit"];
}
?>

<?php if (isset($params['backend'])): ?>
    <module type="admin/modules/info"/>
<?php endif; ?>

<style type="text/css">
    label{
        font-weight: bold;
        color: #bcbfc2;
    }
    .control-label p{
        margin-right: auto;
        padding-left: 5px;
        color: #000;
    }
    hr {
        border-top: 1px solid #cfcfcf;
    }
    input.mw-ui-field{
        width: 50%;
    }
    .single_field input.mw-ui-field{
        width: 9%;
    }
    .justify-content-between{
        padding-top: 5px;
    }
</style>
<div class="card style-1 mb-3 <?php if ($from_live_edit): ?>card-in-live-edit<?php endif; ?>">
    <div class="card-header">
        <?php $module_info = module_info($params['module']); ?>
        <h5>
            <img src="<?php echo $module_info['icon']; ?>" class="module-icon-svg-fill"/> <strong><?php _e($module_info['name']); ?> </strong>
        </h5>
    </div>
    <?php
        use Illuminate\Support\Facades\DB;
        $image_compress = DB::table('image_optimize')->where('status',1)->first();
        $minimum_size   = DB::table('image_optimize')->where('status',2)->first();
        $thumbnail      = DB::table('image_optimize')->where('status',3)->first();
        // $original       = DB::table('image_optimize')->where('status',4)->first();
        $live_edit_compress = DB::table('image_optimize')->where('status',5)->first();
        $live_edit_minimum_size = DB::table('image_optimize')->where('status',6)->first();
    ?>
    <div class="card-body pt-3">
        <strong><?php _e('Product Image'); ?></strong><hr>
        <label class="control-label d-flex justify-content-between">
        <?php _e('Compression size (In percent)'); ?>: <p id="compress_value"> <?php if($image_compress){ print($image_compress->compress); } ?></p>
                <button onclick="compress_quantity();" class="btn btn-outline-primary btn-sm" id="create-menu-btn"><?php if($image_compress){ _e("Edit");}else{  _e("Add");} ?></button>
        </label>
        <div id="compress_quantity_form" style="display:none;">
            <form action="" class="btn-submit" method="POST">
                <div class="mw-ui-field-holder single_field">
                    <small class="text-muted d-block mb-2"><?php _e('Compress quantity'); ?></small>
                    <input type="number" id="compress" name="compress" class="mw-ui-field w100" value="<?php if($image_compress){ print($image_compress->compress); }?>">
                    <input type="hidden" id="id" name="compress_id" value="<?php if($image_compress){print($image_compress->id);} ?>">
                </div>
                <button id="compress_submit" class="btn btn-success"><?php _e('Save'); ?></button>
            </form>
        </div>

        <label class="control-label d-flex justify-content-between">
        <?php _e('Set minimum size limit to execute image compressor(In KB)'); ?>: <p id="minimum_value"> <?php if($minimum_size){ print($minimum_size->minimum_size); } ?></p>
                <button onclick="minimum_size_apply();" class="btn btn-outline-primary btn-sm" id="create-menu-btn"><?php if($minimum_size){ _e("Edit");}else{  _e("Add");} ?></button>
        </label>
        <div id="minimum_size_apply_form" style="display:none;">
            <form action="" class="btn-submit" method="POST">
                <div class="mw-ui-field-holder single_field">
                    <small class="text-muted d-block mb-2"><?php _e('Optimize Range'); ?></small>
                    <input type="number" id="minimum_size" name="minimum_size" class="mw-ui-field w100" value="<?php if($minimum_size){ print($minimum_size->minimum_size); }?>">
                    <input type="hidden" id="minimum_id" name="minimum_id" value="<?php if($minimum_size){print($minimum_size->id);} ?>">
                </div>
                <button id="minimum_size_submit" class="btn btn-success"><?php _e('Save'); ?></button>
            </form>
        </div>

        <label class="control-label d-flex justify-content-between">
        <?php _e('Set thumbnail width'); ?>: <p id="thumbnail_value"><?php if($thumbnail){ print($thumbnail->thumbnail_width); } ?></p>
                <button onclick="thumbnail();" class="btn btn-outline-primary btn-sm" id="create-menu-btn"><?php if($thumbnail){ _e("Edit");}else{ _e("Add");} ?></button>
        </label>
        <div id="thumbnail_form" style="display:none;">
            <form action="" class="btn-submit" method="POST">
                <div class="mw-ui-field-holder" style="display:flex; align-items: center;">
                    <div style="margin-right: 10px;">
                        <small class="text-muted d-block mb-2"><?php _e('Thumbnail width'); ?></small>
                        <input type="number" id="thumbnail_width" name="thumbnail_width" class="mw-ui-field w100" value="<?php if($thumbnail){ print($thumbnail->thumbnail_width); }?>">
                        <input type="hidden" id="thumbnail_id" name="thumbnail_id" value="<?php if($thumbnail){print($thumbnail->id);} ?>">
                    </div>
                    <!-- <div>
                        <small class="text-muted d-block mb-2">Thumbnail height</small>
                        <input type="number" id="thumbnail_height" name="thumbnail_height" class="mw-ui-field w100" value="<?php //if($thumbnail){ print($thumbnail->thumbnail_height); }?>">
                    </div> -->
                </div>
                <button id="thumbnail_submit" class="btn btn-success"><?php _e('Save'); ?></button>
            </form>
        </div>

        <!-- <label class="control-label d-flex justify-content-between">
                Original image (Width/height): <p id="original_value"><?php //if($original){ print($original->original_width.'X'.$original->original_height); } ?></p>
                <button onclick="original();" class="btn btn-outline-primary btn-sm" id="create-menu-btn"><?php //if($original){ echo "Edit";}else{ echo "Add";} ?></button>
        </label> -->
        <!-- <div id="original_form" style="display:none;">
            <form action="" class="btn-submit" method="POST">
                <div class="mw-ui-field-holder" style="display:flex; align-items: center;">
                    <div style="margin-right: 10px;">
                        <small class="text-muted d-block mb-2">Original width</small>
                        <input type="number" id="original_width" name="original_width" class="mw-ui-field w100" value="<?php //if($original){ print($original->original_width); }?>">
                    </div>
                    <div>
                        <small class="text-muted d-block mb-2">Original height</small>
                        <input type="number" id="original_height" name="original_height" class="mw-ui-field w100" value="<?php //if($original){ print($original->original_height); }?>">
                        <input type="hidden" id="original_id" name="original_id" value="<?php //if($original){print($original->id);} ?>">
                    </div>
                </div>
                <button id="original_submit" class="btn btn-success">Save</button>
            </form>
        </div> -->
    </div>
    <div class="card-body pt-3">
        <strong><?php _e('Live Editor Image'); ?></strong><hr>
        <label class="control-label d-flex justify-content-between">
        <?php _e('Live Editor Compression size (In percent)'); ?>: <p id="live_editor_compress_value"> <?php if($live_edit_compress){ print($live_edit_compress->live_edit_compress); } ?></p>
                <button onclick="live_edit_compress_quantity();" class="btn btn-outline-primary btn-sm" id="create-menu-btn"><?php if($live_edit_compress){ _e("Edit");}else{ _e("Add");} ?></button>
        </label>
        <div id="live_edit_compress_quantity_form" style="display:none;">
            <form action="" class="btn-submit" method="POST">
                <div class="mw-ui-field-holder single_field">
                    <small class="text-muted d-block mb-2"><?php _e('Compress quantity'); ?></small>
                    <input type="number" id="live_edit_compress" name="live_edit_compress" class="mw-ui-field w100" value="<?php if($live_edit_compress){ print($live_edit_compress->live_edit_compress); }?>">
                    <input type="hidden" id="live_edit_compress_id" name="live_edit_compress_id" value="<?php if($live_edit_compress){print($live_edit_compress->id);} ?>">
                </div>
                <button id="live_edit_compress_submit" class="btn btn-success"><?php _e('Save'); ?></button>
            </form>
        </div>

        <label class="control-label d-flex justify-content-between">
        <?php _e('Live Editor Set minimum size limit to execute image compressor(In KB)'); ?>: <p id="live_edit_minimum_size_value"> <?php if($live_edit_minimum_size){ print($live_edit_minimum_size->live_edit_minimum_size); } ?></p>
                <button onclick="live_edit_minimum_size();" class="btn btn-outline-primary btn-sm" id="create-menu-btn"><?php if($live_edit_minimum_size){ _e("Edit"); }else{ _e("Add"); } ?></button>
        </label>
        <div id="live_edit_minimum_size_form" style="display:none;">
            <form action="" class="btn-submit" method="POST">
                <div class="mw-ui-field-holder single_field">
                    <small class="text-muted d-block mb-2"><?php _e('Compress quantity'); ?></small>
                    <input type="number" id="live_edit_minimum_size" name="live_edit_minimum_size" class="mw-ui-field w100" value="<?php if($live_edit_minimum_size){ print($live_edit_minimum_size->live_edit_minimum_size); }?>">
                    <input type="hidden" id="live_edit_minimum_size_id" name="live_edit_minimum_size_id" value="<?php if($live_edit_minimum_size){print($live_edit_minimum_size->id);} ?>">
                </div>
                <button id="live_edit_minimum_size_submit" class="btn btn-success"><?php _e('Save'); ?></button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function compress_quantity() {
          var x = document.getElementById("compress_quantity_form");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
        function minimum_size_apply() {
          var x = document.getElementById("minimum_size_apply_form");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
        function thumbnail() {
          var x = document.getElementById("thumbnail_form");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
        // function original() {
        //   var x = document.getElementById("original_form");
        //   if (x.style.display === "none") {
        //     x.style.display = "block";
        //   } else {
        //     x.style.display = "none";
        //   }
        // }

        // live editor image compressed modal

        function live_edit_compress_quantity() {
          var x = document.getElementById("live_edit_compress_quantity_form");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
        function live_edit_minimum_size() {
          var x = document.getElementById("live_edit_minimum_size_form");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
    </script>
    <script type="text/javascript">

        $("#compress_submit").click(function(e){
            e.preventDefault();

            var compress = $("input[name=compress]").val();
            var id       = $("input[name=compress_id]").val();

            $.ajax({
                type: "POST",
                url: "<?=api_url('image_compress')?>",
                data:{
                      compress,id,
                    },
                success:function(response){
                    if(response.message){
                        $('#compress_value').text(response.message);
                    }else{
                        alert(response.error);
                    }
                },
            });
            $('#compress_quantity_form').css('display','none');
        });
        $("#minimum_size_submit").click(function(e){
            e.preventDefault();

            var minimum_size   = $("input[name=minimum_size]").val();
            var minimum_id     = $("input[name=minimum_id]").val();

            $.ajax({
                type: "POST",
                url: "<?=api_url('image_minimum_size')?>",
                data:{
                      minimum_size,minimum_id,
                    },
                success:function(response){
                    // console.log(response);
                    $('#minimum_value').text(response.message)
                },
                error:function(error){
                    console.log(error)
                }
            });
            $('#minimum_size_apply_form').css('display','none');
        });
        $("#thumbnail_submit").click(function(e){
            e.preventDefault();

            var thumbnail_width  = $("input[name=thumbnail_width]").val();
            // var thumbnail_height = $("input[name=thumbnail_height]").val();
            var thumbnail_id     = $("input[name=thumbnail_id]").val();

            $.ajax({
                type: "POST",
                url: "<?=api_url('image_thumbnail')?>",
                data:{
                      thumbnail_width,thumbnail_id,
                    },
                success:function(response){
                    // $('#thumbnail_value').html(String(message.thumbnail_width)+"X"+String(message.thumbnail_height));
                    $('#thumbnail_value').text(response.message)
                },
                error:function(error){
                //   console.log(error)
                }
            });
            $('#thumbnail_form').css('display','none');
        });
        // $("#original_submit").click(function(e){
        //     e.preventDefault();

        //     var original_width  = $("input[name=original_width]").val();
        //     var original_height = $("input[name=original_height]").val();
        //     var original_id     = $("input[name=original_id]").val();

        //     $.ajax({
        //         type: "POST",
        //         url: "<?=api_url('original_thumbnail')?>",
        //         data:{
        //               original_width,original_height,original_id,
        //             },
        //         success:function(response){
        //             const message = response.message;
        //             $('#original_value').html(String(message.original_width)+"X"+String(message.original_height));
        //         },
        //         error:function(error){
        //           console.log(error)
        //         }
        //     });
        // });

        // live editor image settings
        $("#live_edit_compress_submit").click(function(e){
            e.preventDefault();

            var live_edit_compress    = $("input[name=live_edit_compress]").val();
            var live_edit_compress_id = $("input[name=live_edit_compress_id]").val();

            $.ajax({
                type: "POST",
                url: "<?=api_url('live_edit_image_compress')?>",
                data:{
                    live_edit_compress,live_edit_compress_id
                    },
                success:function(response){
                    if(response.message){
                        $('#live_editor_compress_value').text(response.message);
                    }else{
                        alert(response.error);
                    }
                },
                error:function(error){
                //   console.log(error)
                }
            });
            $('#live_edit_compress_quantity_form').css('display','none');
        });

        $("#live_edit_minimum_size_submit").click(function(e){

            e.preventDefault();

            var live_edit_minimum_size    = $("input[name=live_edit_minimum_size]").val();
            var live_edit_minimum_size_id = $("input[name=live_edit_minimum_size_id]").val();

            $.ajax({
                type: "POST",
                url: "<?=api_url('live_edit_minimum_size')?>",
                data:{
                    live_edit_minimum_size,live_edit_minimum_size_id
                    },
                success:function(response){
                    $('#live_edit_minimum_size_value').text(response.message)
                },
                error:function(error){
                // console.log(error)
                }
            });
            $('#live_edit_minimum_size_form').css('display','none');
        });
    </script>

</div>