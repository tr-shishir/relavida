<?php
/*

  type: layout

  name: Quick Checkout

  description: Quick Checkout

 */
?>

<style>
    .dropdown-menu.shopping-cart {
        min-width: 25rem;
    }

/* cart-modal */
.cart-modal-primary i {
    font-size: 80px;
    margin: 25px 0;
}

.cart-modal-primary h4 {
    font-size: 40px;
    color: #757575;
    font-weight: 800;
}

.cart-modal-primary p {
    font-size: 30px;
    margin-bottom: 50px;
}

.cart-modal-primary h5 {
    font-size: 28px;
    font-weight: 600;
    margin: 35px 0;
}
.cart-modal-primary a {
    font-size: 25px;
    font-weight: 700;
    letter-spacing: 1px;
    width: 50%;
    color: #fff;
    text-decoration: none;
}


@media screen and (max-width:767px){
    .cart-modal-primary h4 {
        font-size: 25px;
    }

    .cart-modal-primary p {
        font-size: 21px;
    }

    .cart-modal-primary h5 {
        font-size: 19px;
    }

    .cart-modal-primary a {
        font-size: 18px;
        width: 100%;
    }
}
@media screen and (max-width:526px){
        .cart-modal-primary i {
        font-size: 50px;
        margin: 20px 0;
    }

    .cart-modal-primary h4 {
        font-size: 19px;
    }

    .cart-modal-primary p {
        font-size: 15px;
        margin-bottom:30px;
    }

    .cart-modal-primary h5 {
        font-size: 15px;
        margin: 18px 0;
    }

    .cart-modal-primary a {
        font-size: 14px;
        width: 100%;
    }
}

@media screen and (max-width:414px){
    .cart-modal-primary h4 {
        margin-bottom: 10px;
    }
}


.blankCartBox {
    position: relative;
}
.checkoutloader:before {
    position: absolute;
    content: '';
    height: 100%;
    width: 100%;
    background-color: #fff;
    z-index: 1;
}
.checkoutloader:after {
    position: absolute;
    content: '';
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 60px;
    height: 60px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
    z-index: 9;
    top: 50%;
    right: 50%;
    transform: translate(50%,-50%);
  }
  .checkoutloaderWith5opacity:before {
      opacity: .5;
    }

  /* Safari */
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .bundle-cart-modal {
    position: relative;
    height: 420px;
    overflow-y: scroll;
}

.bundle-cart-modal::-webkit-scrollbar {
  width: 5px;
}

.bundle-cart-modall::-webkit-scrollbar-track {
  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
}

.bundle-cart-modal::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
}

.bundle-modal-product-link{
    text-decoration: none;
    color: #000;
}

.bundle-modal-product-link:hover{
    text-decoration: none;
    color: #0069d9;
}
</style>

<?php $total = 0;

$bumbs = true;
if(DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count() > 0){
    $serviceTag='withService';
 }else{
    $serviceTag='withoutService';
 }
?>

<?php if (is_array($data)) :
    $upsellingCount=DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count();

    ?>
	<div class="product-cart-modal bundle-cart-modal">
    <table class="table <?php if($upsellingCount <= 0): ?>upsellingCartTable<?php endif; ?> table-bordered table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table cart-table <?php print($serviceTag) ?>" >
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
                    <th style="width:50px">Bild</th>
                    <th class="mw-cart-table-product" style="max-width:100px !important">Produktname</th>
                    <?php if(!isset($_GET['slug'])) { ?>
                        <th style="width:164px">Menge</th>
                    <?php } ?>
                    <th>Preis</th>
                    <th>Gesamt</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // $total = cart_sum();
                if(!isset($_GET['slug'])){
                $tax_data=collect($data);

                $tax_rels = $tax_data->pluck('rel_id');

                $default_tax = single_tax($tax_rels);

                foreach ($data as $item) :
                    if(DB::table('checkout_bumbs')->where('product_id',$item['rel_id'])->where('show_cart',1)->get()->count()){
                        $bumbs = false;
                    }
                    //$total += $item['price']* $item['qty'];
                    ?>
                    <tr class="mw-cart-item mw-cart-item-<?php print $item['id'] ?>">
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
                        <td class="mw-cart-table-product">
                            <a class="bundle-modal-product-link" href="<?php print $item['url'] ?>"><?php print $item['title'] ?></a>

                            <?php if (isset($item['custom_fields'])): ?>
                                <?php print $item['custom_fields'] ?>
                            <?php endif ?>
                        </td>
                            <?php if(!isset($_GET['slug'])) { ?>
                            <input type="hidden" min="1" id="id_val<?=$item['id']?>" class="input-mini form-control input-sm" value="<?php print $item['id'] ?>"/>

                            <td class="product-quantity_number">
                                <div class="input-group">
                                    <input type="button" value="-" class="button-minus" data-field="quantity" id="b_minus<?=$item['id']?>">
                                    <input type="number" step="1" max="" value="<?php print $item['qty'] ?>" name="quantity" id="qty<?=$item['id']?>" class="quantity-field" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)">
                                    <input type="button" value="+" class="button-plus" data-field="quantity" id="b_plus<?=$item['id']?>">
                                </div>
                            </td>
                            <?php } ?>
                        <?php /* <td><?php print currency_format($item['price']); ?></td> */ ?>

                        <td class="mw-cart-table-price"><?php
                            $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'] )->where('user_id',user_id())->get();
                            $servicePrice = 0;
                            if($selectedUpselling->count()){
                                foreach($selectedUpselling as $selectValue){
                                    $servicePrice = $servicePrice + $selectValue->service_price;
                                }
                                $servicePrice = $servicePrice + taxPrice($servicePrice);
                                $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id']);

                                print currency_format(roundPrice($item['price']));
                            }
                            else{
                                $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id']);
                                print currency_format(roundPrice($item['price']));
                            }
                            $total = $total + ((roundPrice($item['price']) +$servicePrice) * $item['qty']);
                           ?>
                        </td>
                            <?php if(DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count() > 0): ?>
                                <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>
                            <?php endif; ?>
                            <td class="mw-cart-table-price"><?php print currency_format((roundPrice($item['price']) +$servicePrice) * $item['qty']); ?></td>
                    </tr>
                <?php endforeach;
                }else{ foreach ($data as $dataaaa) : ?>


                    <tr class="mw-cart-item mw-cart-item-<?php print $dataaaa['id'] ?>">
                        <td><?php  if (isset($dataaaa['item_image']) and $dataaaa['item_image'] != false): ?>
                                <?php $p = $dataaaa['item_image']; ?>
                            <?php else:

                                    $p = get_picture($dataaaa['id']);
                                ?>
                            <?php endif;
                            //                            @dump($p);?>
                            <?php if ($p != false): ?>
                                <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $dataaaa['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>"/>
                            <?php endif; ?></td>
                        <td class="mw-cart-table-product"><?php print $dataaaa['title'] ?>
                            <?php if (isset($dataaaa['custom_fields'])): ?>
                                <?php print $dataaaa['custom_fields'] ?>
                            <?php endif ?></td>



                            <td class="mw-cart-table-price"><?php
                                $dataaaa['price'] = $dataaaa['price'] + taxPrice($dataaaa['price'],null,$dataaaa['id']);
                                print currency_format($dataaaa['price']); ?></td>

                        </tr>

                <?php endforeach;
            } ?>

                </tbody>
            </table>
			</div>

<?php endif; ?>

<?php if (is_ajax()) : ?>

    <script>
        $(document).ready(function () {
            //  cartModalBindButtons();

        });
    </script>

<?php endif; ?>


<script>
    $(".icon-trash").on("click", function(){
        if($(".product-cart-modal tbody tr").length == 1 ) {
            $(".product-cart-modal").addClass('checkoutloader');
            $(".products-amount").css("opacity","0");
        } else{
            $(".product-cart-modal").addClass('checkoutloader');
            $(".product-cart-modal").addClass('checkoutloaderWith5opacity');
            $(".products-amount").css("opacity",".5");
        }
     });

</script>
