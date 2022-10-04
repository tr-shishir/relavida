<style>
    .post-limite{
        margin-top: 20px;
        background: #fff;
        border-radius: 5px;
        padding: 10px 20px;
        box-shadow: 0 0 2px 2px #ececec;
    }
    .post-limit-input{
        display:flex;
        align-items:center;
        margin-bottom: 20px;
    }
    .post-limite .custom-control{
        display: flex;
        align-items: center;
    }
</style>

<?php
$limit = Config::get('custom.blog_limit');
if(!$limit){
    Config::set('custom.blog_limit', 1000);
    Config::save(array('custom'));
}
$limit = Config::get('custom.blog_limit');
$status = Config::get('custom.blog_status') ?? 1;
?>

<div class="post-limite">
    <h3><?php _e('Post Limit'); ?></h3>
    <h6><?php _e('Define here up to where the customer can read your blog post without a customer account'); ?></h6>
    <div class="post-limit-input">
        <input type="text" class="form-control w-50" id="postlimit" placeholder="Word Limit" value="<?php echo $limit;?>">
        <button class="btn btn-success ml-2" id="limitsave" onclick="save_limit()"><?php _e("Save"); ?></button>
    </div>
    <div class="custom-control custom-switch pl-0">
        <div class="mr-2">
            <label> <strong style="font-size: 18px"><?php _e("Enable post limit for all post"); ?> :</strong> </label>
        </div>
        <label class="d-inline-block mr-5" for="post_status"><?php _e("Off"); ?></label>
        <input type="checkbox" class="custom-control-input" id="post_status" name="post_status" data-value-checked="1" data-value-unchecked="0" value="<?=$status?>" <?php ($status == 1) ? print "checked" : '' ?> >
        <label class="custom-control-label" for="post_status"><?php _e("On"); ?></label>
    </div>
</div>
<script>
    function save_limit(){
        var postlimit = $("#postlimit").val();
        $.post("<?= url('/') ?>/api/v1/post_limit", { postlimit: postlimit }, (res) => {
            if(res.success){
                mw.notification.success("Post limit is saved successfully");
            }

        });
    }
    $("#post_status").click(function (){
        // console.log($(this).val())
        $.post("<?= url('/') ?>/api/v1/post_limit", { poststatus: $("#post_status").val() }, (res) => {
            if(res.success){
                if($("#post_status").val() == 0){
                    $("#post_status").val("1");
                    mw.notification.success("Blog Post limit turned on successfully");
                }else{
                    $("#post_status").val("0");
                    mw.notification.success("Blog Post limit turned off successfully");

                }
            }

        });
    });
</script>
