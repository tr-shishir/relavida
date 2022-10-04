<?php

/*

type: layout

name: Features

position: 6

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-90';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-90';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
use Illuminate\Support\Facades\DB;

$check = 1; ?>
<style>
    .icon-holder img {
        width: 80px;
    }
    .icon-uploader-option{
        justify-content: center;
        margin: 10px 0;
    }
    .icon-uploader-option > div{
        margin: 0 5px;
    }
    .icon-uploader-option > div > label{
        color: #fff;
        font-weight: 700;
    }
</style>
<section class="section-13 <?php //print $layout_classes; ?> safe-mode nodrop" data-background-position="center center">
    <div class="d-flex w-100 background-image-holder feature-skin-6 <?php print $layout_classes; ?>">
        <div class="container align-self-centerx">
            <div class="row">
                <div class="col-12 col-xl-12 mx-auto text-center">
                    <div class="row">
                        <div class="icon-holder col-12 col-sm-3 mx-auto cloneable">
                            <?php
                            $imageicondetails7 = DB::table('iconImage')->where('name','iconImage7')->first();
                            ?>
                            <div class="icon-uploader-option" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                                <div>
                                    <input type="radio" id="icon13" name="iconImage7" <?php (isset($imageicondetails7) && $imageicondetails7->iid == 13) ? print "checked":print " "?> value="13">
                                    <label for="icon13">Icon</label>
                                </div>
                                <div>
                                    <input type="radio" id="image14" name="iconImage7" <?php (isset($imageicondetails7) && $imageicondetails7->iid == 14) ? print "checked": print " ";?> value="14">
                                    <label for="image14">Image</label>
                                </div>
                            </div>
                            <?php
                            if(isset($imageicondetails7) && $imageicondetails7->iid == 13){ ?>
                                <div class="edit" field="imageicon13" rel="content">
                                    <i class="icon mw-micon-Sunglasses-2 safe-element"></i>
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } else { ?>
                                <div class="edit" field="imageicon14" rel="content">
                                    <img class="nw-iconimage" src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="icon-holder col-12 col-sm-3 mx-auto cloneable">

                            <?php
                            $imageicondetails8 = DB::table('iconImage')->where('name','iconImage8')->first();
                            ?>
                            <div class="icon-uploader-option" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                                <div>
                                    <input type="radio" id="icon15" name="iconImage8" <?php (isset($imageicondetails8) && $imageicondetails8->iid == 15) ? print "checked":print " "?> value="15">
                                    <label for="icon15">Icon</label>
                                </div>
                                <div>
                                    <input type="radio" id="image16" name="iconImage8" <?php (isset($imageicondetails8) && $imageicondetails8->iid == 16) ? print "checked": print " ";?> value="16">
                                    <label for="image16">Image</label>
                                </div>

                            </div>
                            <?php
                            if(isset($imageicondetails8) && $imageicondetails8->iid == 15){ ?>
                                <div class="edit" field="imageicon15" rel="content">
                                    <i class="icon mw-micon-Sunglasses-2 safe-element"></i>
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } else { ?>
                                <div class="edit" field="imageicon16" rel="content">
                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="icon-holder col-12 col-sm-3 mx-auto cloneable">

                            <?php
                            $imageicondetails9 = DB::table('iconImage')->where('name','iconImage9')->first();
                            ?>
                            <div class="icon-uploader-option" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                                <div>
                                    <input type="radio" id="icon17" name="iconImage9" <?php (isset($imageicondetails9) && $imageicondetails9->iid == 17) ? print "checked":print " "?> value="17">
                                    <label for="icon17">Icon</label>
                                </div>
                                <div>
                                    <input type="radio" id="image18" name="iconImage9" <?php (isset($imageicondetails9) && $imageicondetails9->iid == 18) ? print "checked": print " ";?> value="18">
                                    <label for="image18">Image</label>
                                </div>

                            </div>
                            <?php
                            if(isset($imageicondetails9) && $imageicondetails9->iid == 17){ ?>
                                <div class="edit" field="imageicon17" rel="content">
                                    <i class="icon mw-micon-Sunglasses-2 safe-element"></i>
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } else { ?>
                                <div class="edit" field="imageicon18" rel="content">
                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="icon-holder col-12 col-sm-3 mx-auto cloneable">
                            <?php
                            $imageicondetails10 = DB::table('iconImage')->where('name','iconImage10')->first();
                            ?>
                            <div class="icon-uploader-option" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                                <div>
                                    <input type="radio" id="icon19" name="iconImage10" <?php (isset($imageicondetails10) && $imageicondetails10->iid == 19) ? print "checked":print " "?> value="19">
                                    <label for="icon19">Icon</label>
                                </div>
                                <div>
                                    <input type="radio" id="image20" name="iconImage10" <?php (isset($imageicondetails10) && $imageicondetails10->iid == 20) ? print "checked": print " ";?> value="20">
                                    <label for="image20">Image</label>
                                </div>

                            </div>
                            <?php
                            if(isset($imageicondetails10) && $imageicondetails10->iid == 19){ ?>
                                <div class="edit" field="imageicon19" rel="content">
                                    <i class="icon mw-micon-Sunglasses-2 safe-element"></i>
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } else { ?>
                                <div class="edit" field="imageicon20" rel="content">
                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                    <h6><span class="js-start-from-zero safe-element" data-counter>300</span></h6>
                                    <h6>Sunny days</h6>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('[name="iconImage7"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage7" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage8"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage8" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage9"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage9" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage10"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage10" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
</script>
