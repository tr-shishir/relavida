<style>
    .main{
        background : #f2f2f2;
    }
    .part{
        background :  #ffffff;
        padding : 20px 20px;
        margin : 15px 5px;
        border-radius : 10px;
    }
    .part h3{
        font-size: 22px;
        line-height: 1.2;
    }
    .part p{
        font-size: 18px;
        color : #595959;
    }
    .part h4{
        font-size: 20px;
        color : #4d4d4d;
    }
    .part i{
        font-size: 15px;
        color: green;
    }
    .part button{
        border: 1px solid #663399;
        color: white;
        padding: 10px 15px;
    }
    .part button a{
        text-decoration: none;
    }
    .delete-product-img {
        width: 80px;
        background-color: gray;
        margin: auto;
        padding: 5px;
    }

    .delete-product-img span {
        font-size: 12px;
        text-align: center;
        display: inline-block;
        font-weight: 600;
        /* word-break: break-word; */
    }


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->


<div class="subscription-main-layout">
    <?php
        $id = $_REQUEST['id'];
        $pro_id = DB::table('subscription_order_status')->where('id', $id)->first();
        if($pro_id == null){
            header("Location: ".site_url());
                    exit();
        }
        $product = get_cart("order_id=$pro_id->order_id");
        $sub_inter = DB::table('subscription_items')->where('id','=', $pro_id->subscription_id)->first();
        $sub_dur = DB::table('subscription_status')->where('product_id','=', $pro_id->product_id)->first();
        $sub_details =    DB::table('subscriptionorders')->where('agreement_id', $pro_id->agreement_id)->first();
        $item_details = get_content_by_id($pro_id->product_id);
        // dd($product);
    ?>
    <div class="main"><br><br><br>
        <h1 style="margin-left: 25px; "><?php _e("Your Subscription Order Details"); ?>:</h1><hr>
        <div class="row mb-4">
            <div class="col-md-8 pl-5 pr-3">
                <div class="part">
                    <h3><?php _e("Collection"); ?></h3>
                    <p><i class="fas fa-check-circle"></i> <?php _e("You have one Subscription Product"); ?></p>
                </div>
                <div class="part">
                    <h3><?php _e("Subscription type"); ?></h3>
                    <p><i class="fas fa-check-circle"></i> <?php _e("Paid Subscription"); ?></p>
                </div>
                <div class="part">
                    <h3><?php _e("Order Schedule"); ?></h3><br>
                    <h4><?php _e("Delivery Product Every"); ?> <i class="fas fa-info-circle"></i></h4>
                    <p><i class="fas fa-check-circle"></i> <?php  print $sub_inter->sub_interval ?></p>
                    <!-- <h4>Product subcription Cycle <i class="fas fa-info-circle"></i></h4>
                    <p><i class="fas fa-check-circle"></i> <?php  print $pro_id->cycles ?></p> -->
                    <h4><?php _e("Subscription Cycle Completed"); ?> <i class="fas fa-info-circle"></i></h4>
                    <p><i class="fas fa-check-circle"></i> <?php  print $sub_details->cycle_completed ?></p>
                    <!-- <h4>Subcription Cycle Remaining <i class="fas fa-info-circle"></i></h4>
                    <p><i class="fas fa-check-circle"></i> <?php  print $sub_details->cycle_remaining ?></p> -->
                </div>
                <div class=part>
                    <a href="/subscribe/suspend?id=<?php echo $pro_id->agreement_id; ?>"><button class="btn btn-warning mr-3">
                    <?php _e("Pause Subscritption"); ?>
                    </button></a>
                    <a href="subscribe/cancel?id=<?php echo $pro_id->agreement_id; ?>" ><button class="btn mr-3 btn-danger">
                    <?php _e("Delete Subscritption"); ?>
                    </button></a>
                    <button class="btn btn-info" onclick="show()" id="updateBtn">
                    <?php _e("Change Interval"); ?>
                    </button>
                </div>
                <div class="part" id="update" style="display:none;">
                    <div class="form-group">
                        <label for="option"><?php _e("Change interval time"); ?></label>
                        <select name="interval" id="interval" class="form-control">
                        <?php
                        $sub=DB::table('subscription_status')->where('product_id',$pro_id->product_id)->get()->all();
                            if(count($sub)>0){
                                foreach($sub as $option){
                                    $sub_item=DB::table('subscription_items')->where('id',$option->sub_id)->first();
                                    printf("<option value='%d' >%s</option><br>",$sub_item->id,$sub_item->sub_interval);

                                }

                            }
                            else {
                                printf("<option value=''>No Product Found</option>");
                            }
                        ?>
                        </select>
                    </div>
                    <input type="hidden" name="agreement_id" id="agreement_id" value="<?php print $pro_id->agreement_id ?>">
                    <button type="submit" class="btn btn-primary" onclick="valueUpdate()"><?php _e("Update"); ?></button>
                    <button type="submit" class="btn btn-primary" onclick="hide()"><?php _e("Cancel"); ?></button>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="part">
                <?php if(isset($item_details) && $item_details):
                    foreach ($product as $value) : ?>
                        <h3><?php _e("Product Summary"); ?></h3>
                        <img src="<?php  print $value['picture'] ?>" alt="product image" height="200" width="300">
                        <p><i class="fas fa-check-circle"></i> <?php  print $value['title'] ?></p>
                <?php endforeach; else:?>
                        <h3><?php _e("Product Summary"); ?></h3>
                        <div class="delete-product-img">
                            <span class=""><?php _e("This product information is not available anymore"); ?></span>
                        </div>
                        <img src="<?php  print $value['picture'] ?>" alt="product image" height="200" width="300">
                        <p><i class="fas fa-check-circle"></i> <?php  print $value['title'] ?></p>
                <?php endif; ?>
                </div>
                <div class="part">
                    <h3><?php _e("Order Detaiils"); ?></h3>
                    <p><i class="fas fa-check-circle"></i> <?php _e("Product can be purchase paid subcription"); ?></p>
                    <p><i class="fas fa-check-circle"></i> <?php _e("Product delivery every"); ?>: <b><?php  print $sub_inter->sub_interval ?></b></p>
                    <!-- <p><i class="fas fa-check-circle"></i> Product subcribe Cycles: <b><?php  print $pro_id->cycles ?></b></p> -->
                    <p><i class="fas fa-check-circle"></i> <?php _e("Customer need to pay after"); ?> <?php print $sub_inter->sub_interval  ?></p>
                    <p><i class="fas fa-check-circle"></i> <?php _e("Next schedule date is"); ?>: <b>
                    <?php
                         $date = $pro_id->updated_at;
                         $nextDate = date('F, jS', strtotime($date . ' +'.$sub_inter->sub_interval));
                         print $nextDate;
                    ?>
                    </b></p>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function show(){
        document.getElementById('update').style.display="";
        document.getElementById('updateBtn').style.display="none";
    }
    function hide(){
        document.getElementById('update').style.display="none";
        document.getElementById('updateBtn').style.display="";
    }
    function valueUpdate(){
        mw.tools.confirm("<?php _ejs("If you will change interval than you need to create plan again. Do you want to create plan now?"); ?>", function () {
            var sub_id = document.getElementById('interval').value;
            var id = document.getElementById('agreement_id').value;
            // alert(sub_id);
            // alert(id);
            // $.post("<?=api_url('update_subscription_order')?>", {
            //     id: id,
            //     sub_id: sub_id
            //     }).then((res, err) => {
            //     console.log(res, err);
            //     });
                window.location.href =  "<?=url('/')?>/update_subscription_plan?id="+id+"&sub="+sub_id;
            });

    }
</script>
