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
  .product-cart-modal{
      position: relative;
  }
</style>

<?php $total = 0;

$bumbs = true;
if(DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count() > 0){
    $serviceTag='withService';
 }else{
    $serviceTag='withoutService';
 }


$tax_data=collect($data);
$tax_rels = $tax_data->pluck('rel_id');
$default_tax = single_tax($tax_rels);

?>

<?php if (is_array($data)) :
    $upsellingCount=DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count();

    ?>
	<div class="product-cart-modal">
    <table class="table <?php if($upsellingCount <= 0): ?>upsellingCartTable<?php endif; ?> table-bordered table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table table-responsive cart-table <?php print($serviceTag) ?>" >
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
                    <?php if($upsellingCount > 0): ?>
                        <th>Servicepreis</th>
                    <?php endif; ?>
                    <th>Gesamt</th>
                    <th>Löschen</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // $total = cart_sum();
                if(!isset($_GET['slug'])){
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
                        <td class="mw-cart-table-product"><?php print $item['title'] ?>
                            <?php if (isset($item['custom_fields'])): ?>
                                <?php print $item['custom_fields'] ?>
                            <?php endif ?></td>
                            <?php if(!isset($_GET['slug'])) { ?>
                            <input type="hidden" min="1" id="id_val<?=$item['id']?>" class="input-mini form-control input-sm" value="<?php print $item['id'] ?>"/>

                            <td class="product-quantity_number">
                                <div class="input-group">
                                    <input type="button" value="-" class="button-minus" data-field="quantity" id="minus<?=$item['id']?>">
                                    <input type="number" step="1" max="" value="<?php print $item['qty'] ?>" name="quantity" id="qty<?=$item['id']?>" class="quantity-field" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)">
                                    <input type="button" value="+" class="button-plus" data-field="quantity" id="plus<?=$item['id']?>">
                                </div>
                            </td>
                        <?php } ?>
                        <?php /* <td><?php print currency_format($item['price']); ?></td> */ ?>

                        <script>

                            $("#plus<?=$item['id']?>").on('click', function(e) {
                                var currentVal = $("#qty<?=$item['id']?>").val()
                                var id = $("#id_val<?=$item['id']?>").val();
                                currentVal = parseInt(currentVal)+1;
                                mw.cart.qty(id,currentVal);
                            });
                            $("#minus<?=$item['id']?>").on('click', function(e) {
                                var currentVal = $("#qty<?=$item['id']?>").val()
                                var id = $("#id_val<?=$item['id']?>").val();
                                currentVal = parseInt(currentVal)-1;
                                mw.cart.qty(id,currentVal);
                            });
                            </script>
                        <td class="mw-cart-table-price"><?php
                            $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'] )->where('user_id',user_id())->get();
                            $servicePrice = 0;
                            if($selectedUpselling->count()){
                                foreach($selectedUpselling as $selectValue){
                                    $servicePrice = $servicePrice + $selectValue->service_price;
                                }
                                $servicePrice = $servicePrice + taxPrice($servicePrice);
                                $item['price'] = $item['price'] + taxPrice($item['price']);

                                print currency_format(roundPrice($item['price']));
                            }
                            else{
                                $item['price'] = $item['price'] + taxPrice($item['price']);
                                print currency_format(roundPrice($item['price']));
                            }
                            $total = $total + ((roundPrice($item['price']) +$servicePrice) * $item['qty']);
                           ?>
                        </td>
                            <?php if(DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count() > 0): ?>
                                <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>
                            <?php endif; ?>
                            <td class="mw-cart-table-price"><?php print currency_format((roundPrice($item['price']) +$servicePrice) * $item['qty']); ?></td>

                        <td style="text-align:center;"><a title="<?php _e("Remove"); ?>" style="color:red;" class="icon-trash" href="javascript:mw.cart.remove('<?php print $item['id'] ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
                                $dataaaa['price'] = $dataaaa['price'] + taxPrice($dataaaa['price']);
                                print currency_format($dataaaa['price']); ?></td>

                        </tr>

                <?php endforeach;
            } ?>

                </tbody>
            </table>
			</div>
<?php else: ?>
    <?php
        $product_limit = DB::table('content')->where('content_type','product')->where('is_active',1)->where('is_deleted',0)->get()->count() ?? 0;
    ?>
    <div class="col-12 edit blankCartBox" field="related_products_ck" rel="inherit" >
            <div class="cart-modal-primary text-center">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <h4>Ihr Warenkorb ist noch leer.</h4>
                <p class="lead">Über <?php print $product_limit;  ?> Produkte warten auf Sie!</p>
                <hr>
                <?php if(!is_logged()):
                ?>
                    <h5>Mit Ihrem Kundenkonto einkaufen?</h5>
                    <a class="btn btn-secondary btn-lg"  data-dismiss="modal" id="login_Modal" href="" data-toggle="modal" data-target="#loginModal">Jetzt anmelden</a>
                <?php endif;
                ?>
            </div>
    </div>
<?php endif; ?>

<?php if (is_ajax()) : ?>

    <script>
        $(document).ready(function () {
            //  cartModalBindButtons();

        });
    </script>

<?php endif; ?>

<?php if(DB::table('checkout_bumbs')->where('show_cart',1)->get()->count()): ?>
    <?php if($bumbs): ?>
    <module type="shop/Checkout_Bumbs" template="cart_bumbs" />
    <?php endif; ?>
<?php endif; ?>

<div class="products-amount">
    <div class="row">
        <?php if (is_array($data)): ?>
            <div class="col-sm-6 total">
                <p style="margin-bottom:10px;text-align:left"><strong><?php _e("Gesamtbetrag: "); ?> <br class="d-none d-sm-block"> <?php
                        // $taxam = 0; $tax= mw()->tax_manager->get();
                        // !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                        // $total = $total + ($taxam*$total)/100;
                        print currency_format($total);


                        ?></strong></p>
                <div class="product-tax-text" style="display:flex;align-items:center;font-size: 12px;">

                    <span class="edit">
                        inkl. <?php print (int)$default_tax;?>% MwSt.
                    </span>
                    <span data-toggle="modal" data-target="#termModal" style="margin-left:5px;display:inline-block;">
                        zzgl. Versand
                    </span>
                </div>
            </div>
            <div class="col-sm-6" style="text-align: right;">
                <a href="<?php echo site_url('checkout') ?>" class="btn btn-primary btn-md btn-block">zur Kasse</a>
            </div>
        <?php endif; ?>
    </div>

</div>


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
