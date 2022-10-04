<?php if ($profile_link == 'true'): ?>
    <script>
        var $window = $(window), $document = $(document);
        $document.ready(function () {
            $('.js-register-modal').on('click', function () {
                $(".js-login-window").hide();
                $(".js-forgot-window").hide();
                $(".js-register-window").show();
                mw.load_module('captcha/templates/skin-1', '#captcha_register');
            });
            $('.js-login-modal').on('click', function () {
                $(".js-register-window").hide();
                $(".js-forgot-window").hide();
                $(".js-login-window").show();
                mw.load_module('captcha', '#captcha_login');
            });
        });
    </script>
    <ul class="list">
        <li class="mobile-profile">
            <a href="#" class="dropdown-toggle opacity-8" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-user-circle-o"></i> <span><?php _e("Hi"); ?>,<?php if (user_id()): ?> <?php print user_name(); ?> <?php else: ?> Guest <?php endif; ?> <span class="caret"></span></span></a>
            <ul class="dropdown-menu">
                <?php if (user_id()): ?>
                    <li><a href="#" data-toggle="modal" data-target="#loginModal">Profil</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#ordersModal">Meine Bestellungen</a></li>
                <?php else: ?>
                    <li><a href="#" class="js-login-modal" data-toggle="modal" data-target="#loginModal"><?php _e("Anmeldung"); ?></a></li>
                <?php endif; ?>

                <?php if (is_admin()): ?>
                    <li><a href="<?php print admin_url() ?>">Adminbereich</a></li>
                <?php endif; ?>

                <?php if (user_id()): ?>
                    <li><a href="<?php print api_link('logout') ?>">Ausloggen</a></li>
                <?php endif; ?>
            </ul>
        </li>
    </ul>
<?php endif; ?>