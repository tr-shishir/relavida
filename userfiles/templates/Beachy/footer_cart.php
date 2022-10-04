
<script>
    AddToCartModalContent = window.AddToCartModalContent || function (title) {
            var html = ''
                + '<section style="text-align: center;">'
                + '<h5>' + title + '</h5>'
                + '<p><?php _e("has been added to your cart"); ?></p><br />'
                + '<div><a href="javascript:;" onclick="mw.dialog.get(\'#AddToCartModal\').remove()" class="pull-left mt-2"><?php _e("Continue shopping"); ?></a>'
                + '<a href="<?php print checkout_url(); ?>" class="btn-d pull-right"><?php _e("Checkout"); ?></a></section><div class="clearfix"></div></div>';
            return html;
        }


    function cartModalBindButtons(step) {

        $('.js-show-step').off('click');
        $('.js-show-step').on('click', function () {
            var has_error = 0;
            var step = $(this).data('step');
            if (step == 'payment-method') {

                $('.js-delivery-address input').each(function () {
                    if (!this.checkValidity()) {
                        mw.notification.warning('<?php _e("Please fill the required fields"); ?>');
                        // ..alert($(this).prop('name') + ' is not valid');
                        $(this).addClass('error');
                        has_error = 1;
                    } else {
                        $(this).removeClass('error');
                    }

                });

                if (has_error) {
                    step = 'delivery-address'
                }
            }

            $('.js-show-step').removeClass('active');

            $('[data-step]').removeClass('active');
            $('[data-step="' + step + '"]').addClass('active').parent().removeClass('muted');


            step1 = '.js-' + step;
            $('.js-step-content').hide();
            $(step1).show();
            $(this).addClass('active');
        });
    }


    $(document).ready(function () {
        mw.on('mw.cart.add', function (event, data) {
            $("#shoppingCartModal").modal();
            $("#js-ajax-cart-checkout-process").reload_module()

        });
    });
</script>

<script>
            $(document).ready(function() {
                $(".login_register").on("click",function(){
                    mw.load_module('users/register', '#loginModalModuleRegister');
                });

                $('#loginModal').on('show.bs.modal', function(e) {
                    // $('#loginModalModuleLogin').reload_module();
                    mw.reload_module('users/register');
                    mw.load_module('captcha', '#captcha_login');

                })

                <?php if (isset($_GET['mw_payment_success'])) { ?>
                    $('#js-ajax-cart-checkout-process').attr('mw_payment_success', true);

                <?php } ?>

                $('.js-show-register-window').on('click', function() {
                    $('.js-login-window').hide();
                    $('.js-register-window').show();
                    mw.load_module('captcha/templates/skin-1', '#captcha_register');
                })
                $('.js-show-login-window').on('click', function() {

                    $('.js-register-window').hide();
                    $('.js-login-window').show();
                    mw.load_module('captcha', '#captcha_login');
                })

            });

            $(document).ready(function() {
                $('.header-cat ul').removeClass('nav');
                $('.header-cat ul').removeClass('nav-list');
                $('.header-cat ul li').removeClass('has-sub-menu');
                $('.header-cat ul').removeClass('active-parent');
                $('.header-cat ul li').removeClass('active-parent');
                $('.header-cat ul li a').removeClass('active-parent');
                $('.header-cat .well>ul').addClass('sm sm-simple sm-luminous');
                $('.header-cat .well>ul').smartmenus();
            });
        </script>


<?php if ($shopping_cart == 'true'): ?>


    <script>
        mw.require('shop.js');


    </script>


<?php endif; ?>


<!-- Login Modal -->
<div class="modal  login-modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="js-login-window">
                    <div class="icon"><i class="material-icons">person</i></div>

                    <div type="users/login" template="popup" id="loginModalModuleLogin"></div>
                </div>

                <div class="js-register-window" style="display:none;">
                    <div class="icon"><i class="material-icons">exit_to_app</i></div>

                    <div id="loginModalModuleRegister">

                    </div>

                    <p class="or"><span>or</span></p>

                    <div class="act login">
                        <a href="#" class="js-show-login-window"><span><i class="fa fa-backward" style="margin-right: 10px;" aria-hidden="true"></i>Zurück zur Anmeldung</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (user_id()): ?>
    <script>
        $(document).ready(function () {
            $('#ordersModal').on('shown.bs.modal', function (e) {
                mw.reload_module('#user_orders_modal')
            });
        });
    </script>
    <!-- Orders Modal -->
    <div class="modal fade my-orders-modal sinleOrder_modalStyle" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="ordersModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="overflow: unset;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div type="users/orders" id="user_orders_modal"></div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
