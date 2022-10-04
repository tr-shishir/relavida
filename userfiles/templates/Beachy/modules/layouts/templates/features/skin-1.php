<?php

/*

type: layout

name: Features

position: 1

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-50';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>
<?php

use Illuminate\Support\Facades\DB;
$imageicondetails = DB::table('iconImage');

$check = 1; ?>
<style>
     .stamp img {
         width: 80px;
     }
    .icon-uploader-option-one{
        justify-content: flex-start;
        margin: 10px 0;
    }
    .icon-uploader-option-one> div{
        margin: 0 5px;
    }
    .icon-uploader-option-one> div > label{
        color: #000;
        font-weight: 700;
    }
</style>
<section class="section-7 <?php echo $layout_classes; ?> safe-mode nodrop" >
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-10 mx-auto">
                <div class="row">
                    <div class="m-b-40 col-sm-6 col-lg-4">
                        <?php
                        $imageicondetails1 = $imageicondetails->where('name','iconImage')->first();
                        ?>
                        <div class="icon-uploader-option-one"  style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                            <div>
                                <input type="radio" id="icon" name="iconImage" <?php (isset($imageicondetails1) && $imageicondetails1->iid == 1) ? print "checked":print " "?> value="1">
                                <label for="icon">Icon</label>
                            </div>
                            <div>
                                <input type="radio" id="image" name="iconImage" <?php (isset($imageicondetails1) && $imageicondetails1->iid == 2) ? print "checked": print " ";?> value="2">
                                <label for="image">Image</label>
                            </div>

                        </div>
                        <div class="card shadow-sm">
                            <?php
                            if(isset($imageicondetails1) && $imageicondetails1->iid == 1){ ?>
                                <div class="stamp edit" field="iconImage1" rel="content">

                                    <i class="mw-micon-Monitor-2"></i>
                                </div>

                            <?php } else { ?>
                                <div class="stamp edit" field="iconImage16" rel="content">

                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                </div>

                            <?php } ?>

                            <div class="allow-drop">
                                <div class="edit" field="layout-features-skin-12-deymhgfh" rel="content">
                                    <h4 class="m-b-30" >Beautiful Website</h4>
                                </div>
                                <div class="edit" field="layout-features-skin-12-deygcvbfh" rel="content">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when .</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-b-40 col-sm-6 col-lg-4">
                        <?php
                            $imageicondetails2 = DB::table('iconImage')->where('name','=','iconImage2')->first();

                        ?>
                        <div class="icon-uploader-option-one" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                            <div>
                                <input type="radio" id="icon3" name="iconImage2" <?php (isset($imageicondetails2) && $imageicondetails2->iid == 3)?print "checked":print " ";?> value="3">
                                <label for="icon3">Icon</label>
                            </div>
                            <div>
                                <input type="radio" id="image4" name="iconImage2" <?php (isset($imageicondetails2) && $imageicondetails2->iid == 4)?print "checked":print ""?> value="4">
                                <label for="image4">Image</label>
                            </div>


                        </div>
                        <div class="card shadow-sm">
                            <?php
                            if(isset($imageicondetails2) && $imageicondetails2->iid == 3){ ?>
                                <div class="stamp edit" field="iconImage2" rel="content">

                                    <i class="mw-micon-Monitor-2 "></i>
                                </div>

                            <?php } else { ?>
                                <div class="stamp edit" field="iconImage25" rel="content">

                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                </div>

                            <?php } ?>

                            <div class="allow-drop">
                                <div class="edit" field="layout-features-skin-12-deydtgfh" rel="content">
                                    <h4 class="m-b-30">Beautiful Website</h4>
                                </div>
                                <div class="edit" field="layout-features-skin-12-gfdeygfh" rel="content">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when .</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-b-40 col-sm-6 col-lg-4">
                        <?php
                        $imageicondetails3 = DB::table('iconImage')->where('name','iconImage3')->first();
                        ?>
                        <div class="icon-uploader-option-one" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                            <div>
                                <input type="radio" id="icon5" name="iconImage3" <?php (isset($imageicondetails3) && $imageicondetails3->iid == 5)?print "checked":print ""?> value="5">
                                <label for="icon5">Icon</label>
                            </div>
                            <div>
                                <input type="radio" id="image6" name="iconImage3" <?php (isset($imageicondetails3) && $imageicondetails3->iid == 6)?print "checked":print ""?> value="6">
                                <label for="image6">Image</label>
                            </div>

                        </div>
                        <div class="card shadow-sm">
                            <?php
                            if(isset($imageicondetails3) && $imageicondetails3->iid == 5){ ?>
                                <div class="stamp edit" field="iconImage3" rel="content">

                                    <i class="mw-micon-Monitor-2 "></i>
                                </div>

                            <?php } else { ?>
                                <div class="stamp edit" field="iconImage34" rel="content">

                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                </div>

                            <?php } ?>

                            <div class="allow-drop">
                                <div class="edit" field="layout-features-skin-12-deghygfh" rel="content">
                                    <h4 class="m-b-30">Beautiful Website</h4>
                                </div>
                                <div class="edit" field="layout-features-skin-12-ddcvfgbeygfh" rel="content">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when .</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-b-40 col-sm-6 col-lg-4">
                        <?php
                        $imageicondetails4 = DB::table('iconImage')->where('name','iconImage4')->first();
                        ?>
                        <div class="icon-uploader-option-one" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                            <div>
                                <input type="radio" id="icon7" name="iconImage4" <?php (isset($imageicondetails4) && $imageicondetails4->iid == 7)?print "checked":print ""?> value="7">
                                <label for="icon7">Icon</label>
                            </div>
                            <div>
                                <input type="radio" id="image8" name="iconImage4" <?php (isset($imageicondetails4) && $imageicondetails4->iid == 8)?print "checked":print ""?> value="8">
                                <label for="image8">Image</label>
                            </div>
                        </div>
                        <div class="card shadow-sm">
                            <?php
                            if(isset($imageicondetails4) && $imageicondetails4->iid == 7){ ?>
                                <div class="stamp edit" field="iconImage4" rel="content">

                                    <i class="mw-micon-Monitor-2 "></i>
                                </div>

                            <?php } else { ?>
                                <div class="stamp edit" field="iconImage43" rel="content">

                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                </div>

                            <?php } ?>

                            <div class="allow-drop">
                                <div class="edit" field="layout-features-skin-12-deZXgfh" rel="content">
                                    <h4 class="m-b-30">Beautiful Website</h4>
                                </div>
                                <div class="edit" field="layout-features-skin-12-deygfbvh" rel="content">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when .</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-b-40 col-sm-6 col-lg-4">
                        <?php
                        $imageicondetails5 = DB::table('iconImage')->where('name','iconImage5')->first();
                        ?>
                        <div class="icon-uploader-option-one" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                            <div>
                                <input type="radio" id="icon9" name="iconImage5" <?php (isset($imageicondetails5) && $imageicondetails5->iid == 9)?print "checked":print ""?> value="9">
                                <label for="icon9">Icon</label>
                            </div>
                            <div>
                                <input type="radio" id="image10" name="iconImage5" <?php (isset($imageicondetails5) && $imageicondetails5->iid == 10)?print "checked":print ""?> value="10">
                                <label for="image10">Image</label>
                            </div>

                        </div>
                        <div class="card shadow-sm">
                            <?php
                            if(isset($imageicondetails5) && $imageicondetails5->iid == 9){ ?>
                                <div class="stamp edit" field="iconImage5" rel="content">

                                    <i class="mw-micon-Monitor-2 "></i>
                                </div>

                            <?php } else { ?>
                                <div class="stamp edit" field="iconImage52" rel="content">

                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                </div>

                            <?php } ?>

                            <div class="allow-drop">
                                <div class="edit" field="layout-features-skin-12-deawygfh" rel="content">
                                    <h4 class="m-b-30">Beautiful Website</h4>
                                </div>
                                <div class="edit" field="layout-features-skin-12-sdgf" rel="content">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when .</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="m-b-40 col-sm-6 col-lg-4">
                        <?php
                        $imageicondetails6 = DB::table('iconImage')->where('name','iconImage6')->first();
                        ?>
                        <div class="icon-uploader-option-one" style="display: <?php (is_admin()!=true)?print "none":print "flex";?>">
                            <div>
                                <input type="radio" id="icon11" name="iconImage6" <?php (isset($imageicondetails6) && $imageicondetails6->iid == 11)?print "checked":print ""?> value="11">
                                <label for="icon11">Icon</label>
                            </div>
                            <div>
                                <input type="radio" id="image12" name="iconImage6" <?php (isset($imageicondetails6) && $imageicondetails6->iid == 12)?print "checked":print ""?> value="12">
                                <label for="image12">Image</label>
                            </div>

                        </div>
                        <div class="card shadow-sm">
                            <?php
                            if(isset($imageicondetails6) && $imageicondetails6->iid == 11){ ?>
                                <div class="stamp edit" field="iconImage6" rel="content">

                                    <i class="mw-micon-Monitor-2"></i>
                                </div>

                            <?php } else { ?>
                                <div class="stamp edit" field="iconImage61" rel="content">

                                    <img src="<?=site_url();?>userfiles/modules/microweber/images/admin-logo.png" alt="">
                                </div>

                            <?php } ?>

                            <div class="allow-drop">
                                <div class="edit" field="layout-features-skin-12-sh" rel="content">
                                    <h4 class="m-b-30">Beautiful Website</h4>
                                </div>
                                <div class="edit" field="layout-features-skin-12-rty" rel="content">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when .</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
<script>
    $('[name="iconImage"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage2"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage2" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage3"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage3" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage4"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage4" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage5"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage5" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
    $('[name="iconImage6"]').on('change',function (){
        var id = $(this).val();
        $.post("<?= url('/') ?>/api/v1/iconImage", { id: id, name : "iconImage6" }, (res) => {

            if(res.success){

                location.reload();

            }

        });
    });
</script>
