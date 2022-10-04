<?php

/*

type: layout

name: Small Test

description: Small cart template

*/
?>
<style>
    a:hover{
        text-decoration: none;
    }
    .customize-modal {
        background-color: #fff;
    width: 40%;
    padding: 50px 10px;
    border-radius: 5px;
    position: absolute;
    border: 0px !important;
    left: 50%;
    transform: translate(-50%,-50%);
    top: 50%;
    }

    .close-icon{
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }
    .customize-modal .mw-ui-row-nodrop{
        display: flex !important;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .shopping-info {
        width: 50%;
        display: flex;
        justify-content: space-around;
        margin-bottom: 30px;
        align-items: center;
    }
    .shopping-info .material-icons{
        font-size: 40px !important;
    }
    a.mw-cart-small-checkout {
        color: #fff;
        background-color: #007bff;
        padding: 10px;
        border-radius: 10px;
    }
    .modal-name{
        margin-bottom: 30px;
    }
    .modal-name p{
        font-weight: bold;
        font-size:18px;
    }

    .ctn-button{
        margin-top: 20px;
    }
    .ctn-button button{
        display: inline-block;
        background-color: #FFC737;
        padding: 8px;
        border-radius: 5px;
        color: #000;
        border: 0px;
    }

    #quick_overview{
        width:100%;
    }

    .mw-cart-small-order-info-total{
        margin-left:0px !important;
    }
</style>

<div class="customize-modal mw-cart-small <?php if(is_array($data)==false){print "mw-cart-small-no-items";} ?>  mw-cart-<?php print $params['id']?> <?php print  $template_css_prefix;  ?>">
    <div class="mw-ui-row-nodrop">
        <div class="modal-name edit" field="related_products_cart" rel="inherit">
            <p>Your Product is add to cart</p>
        </div>

        <?php if(is_array($data)) : ?>
            <?php
            
            $total_qty = 0;
            $total_price = 0;
            foreach ($data as $item) {
                $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'] )->where('user_id',user_id())->get();
                if($selectedUpselling->count()){
                    foreach($selectedUpselling as $selectValue){
                        $item['price']= $item['price'] + $selectValue->service_price;
                    }
                    $total_qty += $item['qty'];
                    $taxam = 0; $tax= mw()->tax_manager->get();
                    !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                    $item['price']= $item['price'] + ($taxam*$item['price'])/100;
                    $total_price +=  $item['price']* $item['qty'];
                }
                else{
                    $total_qty += $item['qty'];
                    $taxam = 0; $tax= mw()->tax_manager->get();
                    !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                    $item['price']= $item['price'] + ($taxam*$item['price'])/100;
                    $total_price +=  $item['price']* $item['qty'];
                }
              
            }
            ?>
            <div class="shopping-info">
                <span class="material-icons" id="quick_overview-icon">
                                        shopping_cart
                </span>
                <span class="mw-cart-small-order-info">
                    <strong> Einkaufswagen (<?php print $total_qty; ?>)</strong> <br>
                    <span class="mw-cart-small-order-info-total"><?php print currency_format($total_price); ?></span>
                </span>
            </div>
            <div id="quick_overview">
        <?php if (is_array($data)) : ?>
        <table class="table table-bordered product-cart-list-tbl table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table cart-table" >
                <colgroup>
                    <!-- <col width="80"> -->
                    <!-- <col width="200"> -->
                    <!-- <col width="100"> -->
                    <?php if(!isset($_GET['slug'])) { ?>
                    <!-- <col width="140"> -->
                    <?php } ?>
                </colgroup>
                <thead>
                <tr>
                    <th style="width:50px"><?php _e("Bild"); ?></th>
                    <th class="mw-cart-table-product" style="max-width:100px !important"><?php _e("Produktname"); ?></th>
                    <?php if(!isset($_GET['slug'])) { ?>
                        <!-- <th style="width:80px"><?php _e("MENGE"); ?></th> -->
                    <?php } ?>
                    <th><?php _e("Preis"); ?></th>
                    <th><?php _e("Servicepreis"); ?></th>
                    <th><?php _e("Gesamt"); ?></th>
                    <th><?php _e("Löschen"); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total = cart_sum();
                if(!isset($_GET['slug'])){
                //    @dump(collect(end($data))->toArray());
                $updatedAt = [];
                foreach ($data as $array) {
                    if (array_key_exists('updated_at',$array) && $array['updated_at']) {
                        $updatedAt[$array['id']] = $array['updated_at'];
                    }
                }

                $new_id= array_search(max($updatedAt),$updatedAt);
                // @dump($data,array_search(max($updatedAt),$updatedAt));
                foreach ($data as $item) :
                    if($item['id']==$new_id){
// @dump($item);
                    //$total += $item['price']* $item['qty'];
                    ?>
                    <tr class="mw-cart-item product-cart-item mw-cart-item-<?php print $item['id'] ?>">
                        <td><?php  if (isset($item['item_image']) and $item['item_image'] != false): ?>
                                <?php $p = $item['item_image']; ?>
                            <?php else:

                                $p = get_picture($item['rel_id']);

                                ?>
                            <?php endif;
//                            @dump($p);?>
                            <?php if ($p != false): ?>
                                <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $item['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>"/>
                            <?php endif; ?></td>
                        <td class="mw-cart-table-product"><?php print $item['title'] ?>
                            <?php if (isset($item['custom_fields'])): ?>
                                <?php print $item['custom_fields'] ?>
                            <?php endif ?></td>
                        <?php if(!isset($_GET['slug'])) { ?>
                            <!-- <td><input type="number" min="1" class="input-mini form-control input-sm" value="<?php print $item['qty'] ?>" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)"/> -->
                            </td>
                        <?php } ?>
                        <?php /* <td><?php print currency_format($item['price']); ?></td> */
                         $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'] )->where('user_id',user_id())->get();
                         $servicePrice = 0;
                         if($selectedUpselling->count()){
                             foreach($selectedUpselling as $selectValue){
                                $servicePrice = $servicePrice + $selectValue->service_price;
                             }
                             $taxam = 0; $tax= mw()->tax_manager->get();
                             !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                             $servicePrice = $servicePrice + ($taxam*$servicePrice)/100;
                             $item['price'] = $item['price'] + ($taxam*$item['price'])/100;
                         }
                         else{
                            $taxam = 0; $tax= mw()->tax_manager->get();
                            !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                            $item['price'] = $item['price'] + ($taxam*$item['price'])/100;
                         }
                        
                        ?>
                        <td class="mw-cart-table-price"><?php print currency_format($item['price']); ?></td>
                        <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>

                            <td class="mw-cart-table-price"><?php print currency_format(($item['price'] + $servicePrice) * $item['qty']); ?></td>

                        <td style="text-align:center;"><a title="<?php _e("Remove"); ?>" style="color:red;" class="icon-trash" href="javascript:mw.cart.remove('<?php print $item['id'] ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                    </tr>
                <?php } endforeach;
                }else{?>


                    <tr class="mw-cart-item mw-cart-item-<?php print $data['id'] ?>">
                        <td><?php  if (isset($data['item_image']) and $data['item_image'] != false): ?>
                                <?php $p = $data['item_image']; ?>
                            <?php else:

                                    $p = get_picture($data['id']);
                                ?>
                            <?php endif;
                            //                            @dump($p);?>
                            <?php if ($p != false): ?>
                                <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $data['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>"/>
                            <?php endif; ?></td>
                        <td class="mw-cart-table-product"><?php print $data['title'] ?>
                            <?php if (isset($data['custom_fields'])): ?>
                                <?php print $data['custom_fields'] ?>
                            <?php endif ?></td>



                            <td class="mw-cart-table-price"><?php print currency_format($price->value); ?></td>

                        </tr>

                <?php } ?>

                </tbody>
            </table>
            <?php endif; ?>

        </div>

            <?php
            if(!isset($params['checkout-link-enabled'])){
                $checkout_link_enanbled =  get_option('data-checkout-link-enabled', $params['id']);
            } else {
                $checkout_link_enanbled = $params['checkout-link-enabled'];
            }
            ?>

            <?php if($checkout_link_enanbled != 'n') :?>
                <?php $checkout_page =get_option('data-checkout-page', $params['id']); ?>
                <?php if($checkout_page != false and strtolower($checkout_page) != 'default' and intval($checkout_page) > 0){

                    $checkout_page_link = content_link($checkout_page).'/view:checkout';
                } else {
                    $checkout_page_link = checkout_url();

                }

                ?>
                <div class="mw-ui-col"><a href="<?php print $checkout_page_link; ?>" class="mw-cart-small-checkout">Einkaufswagen ansehen</a>  </div>
            <?php endif ; ?>

        <?php else : ?>


            <div class=""><h5 class="no-items">
                    <?php   _e('Your cart is empty') ?>
                </h5></div>
        <?php endif ; ?>
    </div>
    <div class="close-icon closeModal" data-dismiss="modal">
        <span class="material-icons">
            close
        </span>
    </div>

</div>
    <script type="text/javascript">

        $(document).ready(function(){
            $(".closeModal").click(function(){
                $("#shoppingCartModal").hide();

            });
        });
    </script>
<script>
    var lastname = localStorage.getItem("key");
    $(document).ready(function(){
        if(lastname == "value"){
        $("#quick_overview").show();
        }else{
            $("#quick_overview").hide();
        }
        localStorage.removeItem("key");


        $("#quick_overview-icon").on("click", function(){
        $("#quick_overview").show();
        $("#mw_alert").css("height","381px");
    });
    });

</script>
