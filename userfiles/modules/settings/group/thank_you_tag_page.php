<style>
.thank-switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 17px;
    margin-right: 10px;
    margin-bottom: 0;
    margin-top: 5px;
}

.thank-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
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

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
/* For thank-Switch checkbox End*/

/* Button */
.edit-btn {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 5px 12px;
    text-align: center;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
}

.first-part {
    border: 1px solid #ededed;
    margin-bottom: 30px;
    padding: 20px 40px;
    box-shadow: 0 0 2px 2px #f7f7f7;
}


.default-check {
    background: #fff;
    margin-top: 30px;
    padding: 10px;
}

.thnk-u {
    display: flex;
    align-items: flex-start;
    margin-bottom:20px;
}

.thnk-u-toggle {
    margin-right: 20px;
    display: flex;
    align-items: flex-start;
}
.thnk-u-toggle a {
    text-decoration: none;
    color: #000;
    display: block;
}

</style>
<?php
    use Illuminate\Support\Facades\DB;
    $all_thank_you_tag_page = DB::table('content')->where([
        ['layout_file', '=', 'layouts__thank_you.php'],
        ['is_active', '=', '1'],
        ['is_deleted', '=', '0'],
        ['url', '<>', 'thank-you'],
    ])->get();


    $active_page_id = get_option('active_thank_you_tags_page_id', 'active_thank_you_tags_page_id') ?? null;

    // dd($active_page_id);
?>





<div class="default-check" id="default-div">
    <h2>Cloned Thank you page with tags</h2>
    <p>You can choose the cloned thank You page from here.  The selected page will be shown to the customers when they will make a successful order.</p>
    <div class="first-part">
        <div class="default-wrapper">
            <?php if($all_thank_you_tag_page): ?>
                <?php foreach($all_thank_you_tag_page as $thank_you_tag_page): ?>
                    <?php $tags = content_tags($thank_you_tag_page->id, false); ?>
                    <div class="thnk-u">
                        <div class="thnk-u-toggle">
                            <label class="thank-switch">
                                <input onclick="activetagpage(<?php print $thank_you_tag_page->id; ?>)"  type="radio" <?php if($thank_you_tag_page->id == $active_page_id){ print "checked"; } ?>  name="active_page_tags" >
                                <span class="slider round"></span>
                            </label>
                            <p>
                                <a href="<?php print admin_url(); ?>view:content/action:pages#action=editpage:<?php print $thank_you_tag_page->id; ?>" target="_blank"><?php print $thank_you_tag_page->title; ?></a>
                                <?php if ($tags): ?>
                                    <?php foreach ($tags as $tag): ?>
                                        <small class="bg-secondary rounded-lg px-2">#<?php echo $tag; ?></small>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="thnk-u-edit-btn">
                            <a class="edit-btn" href="<?php print site_url().$thank_you_tag_page->url ?>" target="_blank"><?php _e("Edit"); ?></a>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php else: ?>
                <p>You didn't created any thank you page yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>



<script>
    function activetagpage(page_id){
        // console.log(page_id);
        $.ajax({
            type: "POST",
            url: "<?= api_url('active_thank_you_tags_page'); ?>",
            data:{ page_id }
        });
    }
</script>