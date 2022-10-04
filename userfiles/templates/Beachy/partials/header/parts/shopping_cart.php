<?php if ($shopping_cart == 'true'): ?>
    <li class="dropdown btn-cart ml-4">
        <a href="#" class="dropdown-toggle preloader-cart-icon" onclick="carttoggolee('cart')"><i class="fa fa-shopping-cart"></i> <span id="shopping-cart-quantity" class="js-shopping-cart-quantity"><?php print cart_sum(false); ?></span></a>
    </li>
<?php endif; ?>

<script type="text/javascript">
//   function carttoggole() {
//         $("#cartModal").modal('show');
//     }

</script>
