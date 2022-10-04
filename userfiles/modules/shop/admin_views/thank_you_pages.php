<style>


.thank-switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 17px;
    margin-right: 10px;
    margin-bottom: 0;
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

.first-product-name{
    width: 280px;
}
.first-product-name span{
    word-break: break-word;
    font-weight:600;
}

.first-product-name a{
    word-break: break-word;
    font-weight:600;
}

.first-product-name,
.first-checkbox,
.first-edit-btn,
.thnk-u {
    margin-right: 30px;
}

.first-part,
.second-part {
    border: 1px solid #ccc;
    margin-bottom: 30px;
    padding: 20px 10px;
}

.default-wrapper{

}
.first-edit-btn {
    display: flex;
    justify-content: flex-end;
}
.radio-btn,
.second-radio-btn {
    margin-bottom: 20px;
}

.thank-you-section {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    margin-bottom: 20px;
}

.thnk-u{
    display: flex;
    align-items: center;
}

.thnk-u-tag {
    align-items: flex-start;
    margin-bottom: 10px;
    background: #fff;
    padding: 5px;
    box-shadow: 0 0 1px 3px #ebebeb;
    border-radius: 5px;
}

.thnk-u-toggle {
    display: flex;
    margin-right: 20px;
    /* align-items: flex-start; */
}

.thnk-u-toggle p {
    /* display: flex; */
    /* flex-direction: column; */
}

.thnk-u-tag .thank-switch {
    margin-top: 5px;
}

small.bg-secondary.rounded-lg.px-2 {
    display: inline-block;
}

.thnk-u-toggle p a {
    display: block;
}

div#default-div {
    margin-top: 28px;
    /* background: #fff; */
    /* padding: 10px; */
}

.thnk-u-toggle p small {
    background: #ccc !important;
    margin-right: 3px;
}

.thnk-u-edit-btn {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
.thnk-u-edit-btn .btn{
    margin:0 5px;
}
.thank-you-tag-div-header{
    display: flex;
    align-items: center;
}
.thank-you-tag-div-header h5{
    font-weight: 700 !important;
    margin-bottom: 0;
}
.thank-you-tag-div-header i{
    margin-right:8px;
}
.thnk-u-edit-btn a:hover{
    text-decoration:none !important;
    color:#fff !important;
}
</style>
<?php
        use Illuminate\Support\Facades\DB;

    ?>





<div class="default-check" id="default-div">
    <div class="first-part">
        <!-- <div class="radio-btn">
            <input type="radio" id="test" name="aaa" value="aaa">
            <label for="default">Default</label>
        </div> -->
        <div class="default-wrapper">
            <div class="row">
                <div class="col-md-6">
                    <div class="thnk-u">
                        <label class="thank-switch">
                            <input onclick="defaulttyp()"  type="checkbox" id="default-ty">
                            <span class="slider round"></span>
                        </label>
                        <span><?php _e("Deafult Page"); ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="first-edit-btn">
                        <a class="btn btn-success" href="<?php print url('/thank-you') ?>" target="_blank"><?php _e("Edit"); ?></a>
                    </div>
                </div>
            </div>
            <!-- <div class="first-product-name">
                <a href="#">Laptop</a>
            </div> -->

        </div>
    </div>
    <?php
        $all_thank_you_tag_page = DB::table('content')->where([
            ['layout_file', '=', 'layouts__thank_you.php'],
            ['is_deleted', '=', '0'],
            ['url', '<>', 'thank-you'],
        ])->get();
        $active_page_id = get_option('active_thank_you_tags_page_id', 'active_thank_you_tags_page_id') ?? null;
    ?>
    <div class="thank-you-tag-div" id="thank-you-tag-div">
        <div class="thank-you-tag-div-header">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <h5>Cloned Thank you page with tags</h5>
        </div>
        <p>You can choose the cloned thank You page from here.  The selected page will be shown to the customers when they will make a successful order.</p>
        <div class="first-part">
            <div class="default-wrapper-tag">
                <?php if($all_thank_you_tag_page): ?>
                    <?php foreach($all_thank_you_tag_page as $thank_you_tag_page): ?>
                        <?php 
                            $tags = content_tags($thank_you_tag_page->id, false);
                            $hide_delete = hide_delete() ?? [];
                            $status = 0;
                            if(!in_array($thank_you_tag_page->url , $hide_delete)){
                                $status = 1;
                            }
                        ?>
                        <div class="thnk-u-tag">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="thnk-u-toggle">
                                        <?php if (isset($thank_you_tag_page->is_active) AND $thank_you_tag_page->is_active == 1): ?>
                                            <label class="thank-switch">
                                                <input onclick="deactivetagpage(<?php echo $thank_you_tag_page->id; ?>, <?php echo $status; ?>)"  type="checkbox" checked name="active_page_tags" >
                                                <span class="slider round"></span>
                                            </label>
                                        <?php else: ?>
                                            <label class="thank-switch">
                                                <input onclick="activetagpage(<?php echo $thank_you_tag_page->id; ?>)" type="checkbox" name="active_page_tags" >
                                                <span class="slider round"></span>
                                            </label>
                                        <?php endif; ?>
                                        <p>
                                            <a href="<?php print admin_url(); ?>view:content/action:pages#action=editpage:<?php print $thank_you_tag_page->id; ?>" target="_blank"><?php print $thank_you_tag_page->title; ?></a>
                                            <?php if ($tags): ?>
                                                <?php foreach ($tags as $tag): ?>
                                                    <small class="bg-secondary rounded-lg px-2">#<?php echo $tag; ?></small>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="thnk-u-edit-btn">
                                        <?php if (isset($thank_you_tag_page->is_active) AND $thank_you_tag_page->is_active == 1): ?>
                                            <a href="javascript:void"><span class="btn btn-success font-weight-normal" onclick="unPublishedThankPage(<?php echo $thank_you_tag_page->id; ?>, <?php echo $status; ?>)"><?php _e('Published'); ?></span></a>
                                        <?php else: ?>
                                            <a href="javascript:void"><span class="btn btn-warning font-weight-normal" onclick="publishedThankPage(<?php echo $thank_you_tag_page->id; ?>)"><?php _e('Unpublished'); ?></span></a>
                                        <?php endif; ?>
                                        <a class="btn btn-success" href="<?php print site_url().$thank_you_tag_page->url ?>" target="_blank"><?php _e("Edit"); ?></a>
                                    </div>
                                </div>
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
         function activetagpage(id){
            $.post("<?=api_url('publishedPage')?>",{
                id: id
            }).then((res, err) => {
                console.log(res, err);
            });
            mw.notification.success("<?php _e('Page is published sucessfully'); ?>");
            mw.clear_cache();
            location.reload();
        }
        function deactivetagpage(id, status){
            if(status == 1){  
                $.post("<?=api_url('unpublishedPage')?>",{
                id: id
                }).then((res, err) => {
                    console.log(res, err);
                });
                mw.notification.success("<?php _e('Page is unpublished sucessfully'); ?>");
                mw.clear_cache();
                location.reload(); 
                } else{
                    mw.notification.success("<?php _e('Page is unpublished sucessfully'); ?>");
                }
        }

        function unPublishedThankPage(id, status){
                if(status == 1){
                    mw.tools.confirm("<?php _ejs("Do you want to unpublish this page"); ?>?", function () {
                        $.post("<?=api_url('unpublishedPage')?>",{
                        id: id
                        }).then((res, err) => {
                            console.log(res, err);
                        });
                        mw.notification.success("<?php _e('Page is unpublished sucessfully'); ?>");
                        mw.clear_cache();
                        location.reload();
                    });
                } else{
                    mw.tools.confirm("<?php _ejs("This is a default page so you can't unpublish this page."); ?>", function () {
                    });

                }
            }


            function publishedThankPage(id)
            {
                mw.tools.confirm("<?php _ejs("Do you want to publish this page"); ?>?", function () {
                $.post("<?=api_url('publishedPage')?>",{
                    id: id
                }).then((res, err) => {
                    console.log(res, err);
                });
                mw.notification.success("<?php _e('Page is published sucessfully'); ?>");
                mw.clear_cache();
                location.reload();
                });
            }
    </script>
</div>

<div class="productModule-check" id="thank-you-div">

    <div class="second-part">
        <!-- <div class="second-radio-btn">
            <input type="radio" id="bbb" name="bbb" value="bbb">
            <label for="upselling">Upselling Process</label><br>
        </div> -->
        <div class="row">
            <div class="col-md-7">
            <?php
                $checkCount = 0;
                    for ($x = 1; $x <= 6; $x++) {
                ?>
                    <?php if(DB::table("thank_you_pages")->where('template_name',$x)->where('is_active',1)->get()->count()):  ?>
                        <?php
                            $activePage =  DB::table('thank_you_pages')->where('template_name', $x)->where('is_active', '1')->get();
                            $activePageProduct =  DB::table('content')->where('id', $activePage[0]->product_id)->get();
                            $checkCount = $x;
                        ?>
                        <div class="thank-you-section">
                            <div class="thnk-u">
                                <label class="thank-switch">
                                    <input
                                    <?php
                                        if(DB::table('thank_you_pages')->where('is_active', '1')->get()->count() ==  $x){

                                        }else{
                                            print 'disabled';
                                        }
                                    ?>
                                    onclick="check('<?php print $x; ?>')" checked type="checkbox" id="<?php print $x; ?>" value="<?php print $x; ?>">
                                    <span class="slider round"></span>
                                </label>
                                <span>Thank You-<?php print $x; ?></span>
                            </div>
                            <div class="first-product-name">
                                <span id="productName<?php print $x; ?>"> <a href="<?php print url('/admin/view:shop/action:products#action=editpage:').$activePage[0]->product_id ?>" target="_blank"><?php print $activePageProduct[0]->title ?></a> </span>
                            </div>
                            <div class="first-edit-btn" id="tempedit<?php print $x; ?>">
                                <a class="edit-btn" href="<?php print url('/thank-you?temp=').$x ?>" target="_blank">Edit</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="thank-you-section">
                            <?php if(DB::table("thank_you_pages")->where('template_name',$x)->get()->count()):  ?>
                                <?php  $lastPage =  DB::table('thank_you_pages')->where('template_name', $x)->get();?>
                                <?php if( $checkCount + 1 == $x): ?>
                                    <div class="thnk-u">
                                        <label class="thank-switch">
                                            <input onclick="check('<?php print $x; ?>')"  type="checkbox" id="<?php print $x; ?>" value="<?php print $x; ?>">
                                            <span class="slider round"></span>
                                        </label>
                                        <span>Thank You-<?php print $x; ?></span>
                                    </div>
                                    <div class="first-product-name">
                                        <a  id="productName<?php print $x; ?>" href="<?php print url('/admin/view:shop/action:products#action=editpage:').$lastPage[0]->product_id ?>" target="_blank"></a>
                                    </div>
                                    <div class="first-edit-btn" id="tempedit<?php print $x; ?>" style="display:none;">
                                        <a class="edit-btn" href="<?php print url('/thank-you?temp=').$x ?>" target="_blank">Edit</a>
                                    </div>
                                <?php else: ?>
                                    <div class="thnk-u">
                                        <label class="thank-switch">
                                            <input disabled onclick="check('<?php print $x; ?>')"  type="checkbox" id="<?php print $x; ?>" value="<?php print $x; ?>">
                                            <span class="slider round"></span>
                                        </label>
                                        <span>Thank You-<?php print $x; ?></span>
                                    </div>
                                    <div class="first-product-name">
                                        <span id="productName<?php print $x; ?>"></span>
                                    </div>
                                    <div class="first-edit-btn" id="tempedit<?php print $x; ?>" style="display:none;">
                                        <a class="edit-btn" href="<?php print url('/thank-you?temp=').$x ?>" target="_blank">Edit</a>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="thnk-u">
                                    <label class="thank-switch">
                                        <input disabled onclick="check('<?php print $x; ?>')"  type="checkbox" id="<?php print $x; ?>" value="<?php print $x; ?>">
                                        <span class="slider round"></span>
                                    </label>
                                    <span>Thank You-<?php print $x; ?></span>
                                </div>
                                <div class="first-product-name">
                                        <span id="productName<?php print $x; ?>"></span>
                                </div>
                                <div class="first-edit-btn" id="tempedit<?php print $x; ?>" style="display:none;">
                                    <a class="edit-btn" href="<?php print url('/thank-you?temp=').$x ?>" target="_blank">Edit</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php
                    }
                ?>
            </div>
            <div class="col-md-5">
                <div class="thank-you-admin">
                    <p>
                        Du kannst eine Produktempfehlung starten, nachdem dein Kunde gekauft hat. Damit du eine solche Seite einrichten kannst, ist es nötig jeder Seite ein Produkt zuzuweisen. Siehe Foto. Du kannst in den Einstellungen jedes Produkt eine solche Zuordnung treffen. Im Anschluss kehre hierher zurück und aktiviere die Seite. Du kannst die Seite dann auch individuell anpassen.
                    </p>
                    <img src="<?php print modules_url(); ?>/shop/thank_you/thank-you-image.png" alt="">
                </div>
            </div>
        </div>

    </div>
</div>




<script>
    function check(id){
        if($('#'+id).is(':checked')){
            if(id==1){
                $('#default-div').hide();
                $('.thank-you-admin').hide();
            }
            idb = parseInt(id) + 1;
            $("#"+idb).prop("disabled", false);
            if(id>1){
                idt = parseInt(id) - 1;
                $("#"+idt).prop("disabled", true);
            }

            $.ajax({
                type: "POST",
                url: "<?=api_url('activeTemplate')?>",
                data:{ template_name : id },
                success: function(response) {
                    $("#productName"+id).html(response.message);
                    $("#tempedit"+id).show();
                    console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
        else{
            if(id==1){
                $('#thank-you-div').hide();
                $('#default-div').show();
                $('#thank-you-tag-div').show();
                $('.thank-you-admin').show();
                // $('#default-ty').attr("checked",true);
                $("#default-ty").prop('checked', true);
            }
            idb = parseInt(id) + 1;
            $("#"+idb).prop("disabled", true);

            if(id>1){
                idt = parseInt(id) - 1;
                $("#"+idt).prop("disabled", false);
            }


            $.ajax({
                type: "POST",
                url: "<?=api_url('deactiveTemplate')?>",
                data:{ template_name : id },
                success: function(response) {
                    $("#productName"+id).html('');
                    $("#tempedit"+id).hide();
                    console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
    }

    function defaulttyp() {
            if($('#default-ty').is(':checked')){
                $('#thank-you-div').hide();
                $('#thank-you-tag-div').show();
            }else{
                $('#thank-you-tag-div').hide();
                $('#thank-you-div').show();
            }
        }

    $(document).ready(function () {
        if($('#1').is(':checked')){
            $('#thank-you-div').show();
            $('#default-div').hide();
            $('.thank-you-admin').hide();
        }else{
            $('#default-div').show();
            $('.thank-you-admin').show();
            $('#thank-you-div').hide();
            $("#default-ty").prop('checked', true);
        }
    });

</script>