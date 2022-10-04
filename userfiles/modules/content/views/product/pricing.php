<div class="card style-1 mb-3">
    <div class="card-header no-border">
        <h6><strong><?php _e('Pricing'); ?></strong></h6>
    </div>

    <div class="card-body pt-3">
        <div class="row">
            <div class="col-md-6">
                <label>EK Price</label>
                <div class="input-group mb-3 prepend-transparent">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-muted"><?php echo get_currency_code(); ?></span>
                    </div>
                    <input type="text" class="form-control js-product-price" required <?php if(isset($productEkPrice) && $productEkPrice != 0){?> disabled="disabled" <?php } ?> name="ek_price" value="<?php if(isset($productEkPrice) && $productEkPrice != 0) { echo number_format($productEkPrice, 2); } ?>">
                </div>
            </div>
            <div class="col-md-6">
                <label>VK Price</label>
                <div class="input-group mb-3 prepend-transparent">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-muted"><?php echo get_currency_code(); ?></span>
                    </div>
                    <input type="text" class="form-control js-product-price" required name="price" value="<?php echo number_format($productPrice, 2); ?>">
                </div>
            </div>
            <div class="col-md-12">
                <?php
                if (is_module('shop/offers')):
                ?>
                    <module type="shop/offers/special_price_field" product_id="<?php echo $product['id'];?>" />
                <?php endif; ?>
            </div>

            <?php $tax_types = array(
                            '1' => 'ORIGINAL',
                            '2' => 'REDUCED',
                        ) ?>
            <div class="col-md-6">
                <label><?php _e('Tax Type'); ?>:</label>
                <div class="input-group mb-3 prepend-transparent">
                    <select class="form-control" id="tax_type" name="tax_type" disabled>
                                <?php  foreach ($tax_types as $key => $x) { ?>
                                    <option value="<?php print($key); ?>"
                                        <?php
                                            if($data['id'] != 0){
                                                if(@$data['tax_type']){
                                                    if(@$data['tax_type'] == $key){
                                                        print('selected="selected"');
                                                    }
                                                }
                                            }
                                        ?>>
                                    <?php echo "$x"; ?>
                                </option>
                            <?php } ?>
                        </select>
                </div>
            </div>

        </div>
    </div>
</div>



<?php
   use Illuminate\Support\Facades\DB;

?>

<?php if($product['id']): ?>
    <?php
        $productUpsellingData = DB::table('product_upselling')->get()->all();
        $selectproductUpsellingData = DB::table('product_upselling_item')->where('product_id',$product['id'])->get(['item_id']);
        $itemcount = 0;
        $passloop = false;
    ?>

    <div class="card style-1 mb-3">
        <div class="card-header no-border">
        <h6><strong><?php _e('Product Upselling'); ?></strong></h6>
        </div>
        <div class="card-body pt-3">
            <div class="row">
                <?php if(isset($productUpsellingData)):  ?>
                    <?php foreach($productUpsellingData as $pitem):  ?>
                        <?php if(!$selectproductUpsellingData->count()): ?>
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label><input type="checkbox" id="<?php print $pitem->id;  ?>" value="<?php print $pitem->id;  ?>"> <?php print $pitem->serviceName;  ?></label>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach($selectproductUpsellingData as $sitem):  ?>
                                <?php if($pitem->id == $sitem->item_id): ?>
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            <label><input type="checkbox" checked id="<?php print $pitem->id;  ?>" value="<?php print $pitem->id;  ?>"> <?php print $pitem->serviceName;  ?></label>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php
                                        $itemcount++;
                                        if($selectproductUpsellingData->count() == $itemcount){
                                            $passloop = true;
                                        }
                                    ?>
                                <?php endif; ?>
                            <?php endforeach;  ?>
                        <?php endif; ?>

                        <?php if($passloop):
                        $passloop = false;
                        $itemcount = 0;
                        ?>
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label><input type="checkbox" id="<?php print $pitem->id;  ?>" value="<?php print $pitem->id;  ?>"> <?php print $pitem->serviceName;  ?></label>
                                </div>
                            </div>
                        <?php else: ?>
                                <?php
                                    $passloop = false;
                                    $itemcount = 0;
                                ?>
                        <?php endif; ?>
                        <script>
                            $('#<?php print $pitem->id;  ?>').click(function() {
                                if($('#<?php print $pitem->id;  ?>').is(':checked')){
                                    var product_id = '<?php echo $product['id'];?>';
                                    var item_id = $('#<?php print $pitem->id;  ?>').val();
                                    $.ajax({
                                        type: "POST",
                                        url: "<?=api_url('productUpsellingItemInsert')?>",
                                        data:{ product_id : product_id, item_id : item_id },
                                        success: function(response) {
                                            // console.log(response.message);
                                        },
                                        error: function(response){
                                            // console.log(response.responseJSON.message);
                                        }
                                    });

                                }
                                else{
                                    var product_id = '<?php echo $product['id'];?>';
                                    var item_id = '<?php print $pitem->id;  ?>';
                                    $.ajax({
                                        type: "POST",
                                        url: "<?=api_url('productUpsellingItemDelete')?>",
                                        data:{ product_id : product_id, item_id : item_id },
                                        success: function(response) {
                                            console.log(response.message);
                                        },
                                        error: function(response){
                                            console.log(response.responseJSON.message);
                                        }
                                    });

                                }

                                });


                        </script>
                    <?php endforeach;  ?>
                <?php endif;  ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php
        $productUpsellingData = DB::table('product_upselling')->get()->all();
    ?>

    <div class="card style-1 mb-3">
        <div class="card-header no-border">
        <h6><strong><?php _e('Product Upselling'); ?></strong></h6>
        </div>
        <div class="card-body pt-3">
            <div class="row">
                <?php if(isset($productUpsellingData)):  ?>
                    <?php foreach($productUpsellingData as $pitem):  ?>
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="upselling<?php print $pitem->id; ?>" > <?php print $pitem->serviceName; ?></label>
                                </div>
                            </div>
                    <?php endforeach;  ?>
                <?php endif;  ?>
            </div>
        </div>
    </div>
<?php endif; ?>



<?php if($product['id']): ?>
    <div class="card style-1 mb-3">
        <div class="card-header no-border">
        <h6><strong><?php _e('Thank You Product Templates') ?></strong></h6>
        </div>
        <div class="card-body pt-3">
            <div class="row">
                <?php
                    for ($x = 1; $x <= 6; $x++) {
                ?>
                    <?php if(DB::table("thank_you_pages")->where('template_name',$x)->where('product_id',$product['id'])->get()->count()):  ?>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label><input onclick="check('<?php print $x; ?>')" checked type="checkbox" id="theme<?php print $x; ?>" value="<?php print $x; ?>"> <?php _e('Thank You') ?>-<?php print $x; ?> </label>
                        </div>
                    </div>
                    <?php else:  ?>
                        <div class="col-md-4">
                            <div class="checkbox">
                            <label><input onclick="check('<?php print $x; ?>')"  type="checkbox" id="theme<?php print $x; ?>" value="<?php print $x; ?>"> <?php _e('Thank You') ?>-<?php print $x; ?> </label>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>

    <script>
     function check(id){
        if($('#theme'+id).is(':checked')){

            templateName = $('#theme'+id).val();
            // console.log(templateName);
            $.ajax({
                type: "POST",
                url: "<?=api_url('productModulesInsert')?>",
                data:{ template_name : templateName, product_id : '<?php echo $product['id'];?>' },
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
        else{
            templateName = $('#theme'+id).val();
            // console.log(templateName);
            $.ajax({
                type: "POST",
                url: "<?=api_url('productModulesDelete')?>",
                data:{ template_name : templateName, product_id : '<?php echo $product['id'];?>' },
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
     }

    </script>
<?php else: ?>
    <div class="card style-1 mb-3">
        <div class="card-header no-border">
        <h6><strong><?php _e('Thank You Product Templates') ?></strong></h6>
        </div>
        <div class="card-body pt-3">
            <div class="row">
                <?php for($x = 1; $x <= 6; $x++): ?>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label><input  type="checkbox" name="theme<?php print $x; ?>"> <?php _e('Thank You') ?>-<?php print $x; ?> </label>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
<?php endif; ?>






<?php if($product['id']): ?>
    <div class="card style-1 mb-3">
        <div class="card-header no-border">
        <h6><strong><?php _e("Checkout Bumbs") ?></strong></h6>
        </div>
        <div class="card-body pt-3">
            <div class="row">
                    <?php if(DB::table("checkout_bumbs")->where('product_id',$product['id'])->get()->count()):  ?>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label><input onclick="bumbs()" checked type="checkbox" id="checkBumbs" > <?php _e("Select This Product") ?> </label>
                        </div>
                    </div>
                    <?php else:  ?>
                        <div class="col-md-12">
                            <div class="checkbox">
                            <label><input onclick="bumbs()"  type="checkbox" id="checkBumbs"> <?php _e("Select This Product") ?> </label>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
        <div class="card-body pt-3" style="margin-left: 10px; ">
            <div class="row">
                <?php if(DB::table("checkout_bumbs")->where('show_cart',1)->get()->count()):  ?>
                    <div class="form-check" style="margin-right: 10px; ">
                        <input class="form-check-input" type="radio" onclick="checkbumbs('scart',1,0)" name="flexRadioDefault" id="scart" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            <?php _e(" Shopping Cart Bumbs") ?>
                        </label>
                    </div>
                <?php else: ?>
                    <div class="form-check" style="margin-right: 10px; ">
                        <input class="form-check-input" onclick="checkbumbs('scart',1,0)" type="radio" name="flexRadioDefault" id="scart">
                        <label class="form-check-label" for="flexRadioDefault2">
                            <?php _e(" Shopping Cart Bumbs") ?>
                        </label>
                    </div>
                <?php endif; ?>
                <?php if(DB::table("checkout_bumbs")->where('show_checkout',1)->get()->count()):  ?>
                    <div class="form-check" style="margin-right: 10px; ">
                        <input class="form-check-input" type="radio" onclick="checkbumbs('scheckout',0,1)" name="flexRadioDefault" id="scheckout" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            <?php _e("Checkout Page-2 Bumbs") ?>
                        </label>
                    </div>
                <?php else: ?>
                    <div class="form-check" style="margin-right: 10px; ">
                        <input class="form-check-input" onclick="checkbumbs('scheckout',0,1)" type="radio" name="flexRadioDefault" id="scheckout">
                        <label class="form-check-label" for="flexRadioDefault2">
                            <?php _e("Checkout Page-2 Bumbs") ?>
                        </label>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
     function bumbs(id){
        if($('#checkBumbs').is(':checked')){
            if($('#scart').is(':checked')){
                show_cart = 1;
            }else{
                show_cart = 0;
            }
            if($('#scheckout').is(':checked')){
                show_checkout = 1;
            }else{
                show_checkout = 0;
            }
            $.ajax({
                type: "POST",
                url: "<?=api_url('checkoutBumbsInsert')?>",
                data:{ product_id : '<?php echo $product['id'];?>',show_cart : show_cart, show_checkout: show_checkout },
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
        else{
            $.ajax({
                type: "POST",
                url: "<?=api_url('checkoutBumbsDelete')?>",
                data:{ product_id : '<?php echo $product['id'];?>' },
                success: function(response) {
                    $('#scart').prop('checked', false);
                    $('#scheckout').prop('checked', false);
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
     }


     function checkbumbs(name,show_cart,show_checkout){
        if($('#'+name).is(':checked')){
            $.ajax({
                type: "POST",
                url: "<?=api_url('activeBumbs')?>",
                data:{ show_cart : show_cart, show_checkout: show_checkout },
                success: function(response) {
                    $('#'+name).prop('checked', true);
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
     }


    </script>
<?php else: ?>
    <div class="card style-1 mb-3">
        <div class="card-header no-border">
        <h6><strong><?php _e("Checkout Bumbs") ?></strong></h6>
        </div>
        <div class="card-body pt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="checkbox">
                    <label><input  type="checkbox" name="checkBumbs"> <?php _e("Select This Product") ?> </label>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body pt-3" style="margin-left: 10px; ">
        <?php $check_bumbs = DB::table("checkout_bumbs")->get()->first();  ?>
            <div class="row">
                <div class="form-check" style="margin-right: 10px; ">
                    <input class="form-check-input"  type="radio" name="bumbs" value="cartbumbs" <?php if(isset($check_bumbs->show_cart) && !empty($check_bumbs->show_cart)): ?> checked <?php endif; ?>>
                    <label class="form-check-label" for="flexRadioDefault2">
                        <?php _e(" Shopping Cart Bumbs") ?>
                    </label>
                </div>
                <div class="form-check" style="margin-right: 10px; ">
                    <input class="form-check-input"  type="radio" name="bumbs" value="checkoutbumbs" <?php if(isset($check_bumbs->show_checkout) && !empty($check_bumbs->show_checkout)): ?> checked <?php endif; ?>>
                    <label class="form-check-label" for="flexRadioDefault2">
                        <?php _e("Checkout Page-2 Bumbs") ?>
                    </label>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>



<!-- Subscription product start from here -->
<?php
    if($product['id']):
    //$type="product";
    //$optionValue= DB::table('subscription_items')->get()->all();
    // dd($optionValue);
    $isChecked=null;
    $status=DB::table('subscription_status')->where('product_id',$product['id'])->get();
        if(count($status)>0){
            $isChecked="checked";
        }

?>


<div class="card style-1 mb-3">
    <div class="card-header no-border">
        <h6><strong><?php _e('Available for Subscription'); ?></strong></h6>
    </div>

    <div class="card-body pt-3">
        <div class="row">
            <div class="col-md-12">
               <input type="checkbox" name="sub_product" id="sub_product" onclick="isSubShow()" <?php print $isChecked; ?>>
               <label for="sub_product"><?php _e('Is this product available for subscription'); ?></label>

            </div>
        </div>
    </div>

    <div class="card-body pt-3" id="status" style="display:none;">

        <div class="row">
            <div class="col-md-12">
                <label for="live"><?php _e('Available Subscription Interval'); ?></label><br><br>
                <input type="hidden" name="id" id="id" value="<?php print $product['id']; ?>">
                <div class="row">
                <?php
                    $sub=DB::table('subscription_items')->groupBy('sub_interval')->get();

                ?>
                <?php if(isset($sub)):  ?>
                    <?php foreach($sub as $item):  ?>
                        <?php
                            $z="";
                            $a=DB::table('subscription_status')->where('product_id',$product['id'])->where('sub_id',$item->id)->get();
                            if(count($a)>0){
                                $z="checked";
                            }
                        ?>
                        <div class="col col-3">
                            <input type="checkbox" id="live<?php print $item->id; ?>" name="live" onclick="insertData(<?php print $item->id; ?>)" <?php print $z; ?> >
                            <label for="item" class="mr-3"><?php $sub_info = explode(" ", $item->sub_interval);
                                                                    print $sub_info[0] . ' ';
                                                                    _e($sub_info[1]); ?></label>
                        </div>

                    <?php endforeach ?>
                <?php endif ?>
            </div>
            </div>
        </div><br>

    </div>
    <div class="card-body pt-3">
        <h6><a href="<?php echo site_url('admin/view:shop/action:options/?group=subProduct'); ?>" target="_blank"><?php _e('Here you can create and manage your intervals'); ?></a> </h6>
    </div>
</div>




<script>
$( document ).ready(function() {
    isSubShow();
    // window.alert("hum");
});
function isSubShow(){
    var pId=document.getElementById("id").value;
    if(document.getElementById("sub_product").checked==true){
        // window.alert("show");
        document.getElementById("status").style.display="";
    }
    else{
        $.post("<?=api_url('delete_subscription_statuses')?>", {
            product_id: pId
        }).then((res, err) => {
            // console.log(res, err);
        });
        document.getElementById("status").style.display="none";
    }
}

function insertData(data){
    var pId=document.getElementById("id").value;
    var sub_id=data;
    if(document.getElementById("live"+data).checked==true){

        $.post("<?=api_url('add_subscription_status')?>", {
            product_id: pId,
            sub_id: sub_id
        }).then((res, err) => {
            console.log(res, err);
        });
        console.log("add");
    } else{
        $.post("<?=api_url('delete_subscription_status')?>", {
            sub_id: sub_id
        }).then((res, err) => {
            console.log(res, err);
        });
    }

}
</script>

<!-- End Add Subcription product -->

<?php endif; ?>
