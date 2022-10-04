<?php

/*

type: layout

name: Default

description: Full width background

*/
?>
<script>
    $(document).ready(function () {
        $('.parallax-wrapper.nums .count').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });
</script>
<style>

    .module-parallax {
        min-height: auto;
    }

    .parallax-wrapper.nums {
        background: #000;
        position: relative;
        height: <?php print $height; ?>px;
    }

    .parallax-wrapper.nums .parallax {
        background-size: cover;
        opacity: <?php print $alpha; ?>;
        z-index: 1;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        min-height: initial;
        background-position: top center;
    }

    .parallax-wrapper.nums .info-box-fluid {
        z-index: 2;
        display: table;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        min-height: initial;
        padding: 0;
    }

    .parallax-wrapper.nums .info-box-fluid p {
        color: #fff;
        font-size: 24px !important;
        text-align: center;
    }

    .parallax-wrapper.nums .info-box-fluid p.number {
        font-size: 72px !important;
        margin-bottom: 20px;
    }

    .parallax-wrapper.nums .info-box-fluid .module-btn {
        text-align: center;
    }

    .parallax-wrapper.nums .info-box-fluid .module-btn .btn-primary {
        text-align: center;
        font-size: 18px;
        color: #fff;
        background: transparent;
        border: 1px solid #fff;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        padding: 10px 40px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    .parallax-wrapper.nums .info-box-fluid .module-btn .btn-primary:hover {
        background-color: #b4b4b4;
        border: 1px solid #b4b4b4;
    }

    @media screen and (max-width: 1199px) {
        .parallax-wrapper.nums .parallax {
            background-size: cover;
        }

        .parallax-wrapper.nums .info-box-fluid p {
            font-size: 26px !important;
        }

        .parallax-wrapper.nums .info-box-fluid p.number {
            font-size: 46px !important;
        }
    }

    @media screen and (max-width: 991px) {
        .parallax-wrapper.nums .parallax {
            background-size: cover;
        }

        .parallax-wrapper.nums .info-box-fluid p {
            font-size: 22px !important;
        }

        .parallax-wrapper.nums .info-box-fluid p.number {
            font-size: 36px !important;
        }
    }

    @media screen and (max-width: 767px) {
        .parallax-wrapper.nums .parallax {
            background-size: cover;
        }

        .parallax-wrapper.nums .info-box-fluid p {
            font-size: 22px !important;
        }

        .parallax-wrapper.nums .info-box-fluid p.number {
            font-size: 30px !important;
        }
    }

</style>

<div class="module-parallax safe-mode nodrop">
    <div class="parallax-wrapper nums">
        <div class="info-box-fluid">
            <div class="middle-content">
                <div class="container">
                    <div class="edit plain-text" field="parallax_text" rel="<?php print $params['id']; ?>">
                        <div class="col-md-6 col-lg-3 cloneable" style="margin-bottom:30px;">
                            <div class="nk-ibox-1">
                                <div class="nk-ibox-icon">
                                    <i class="mw-wysiwyg-custom-icon  mw-icon-drop safe-element"></i>
                                </div>
                                <div class="nk-ibox-cont">
                                    <div class="nk-ibox-title">1548</div>
                                    <div class="nk-ibox-text">Projects Completed</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 cloneable" style="margin-bottom:30px;">
                            <div class="nk-ibox-1">
                                <div class="nk-ibox-icon">
                                    <i class="mw-wysiwyg-custom-icon  mw-icon-app-heart-outline safe-element"></i>
                                </div>
                                <div class="nk-ibox-cont">
                                    <div class="nk-ibox-title">1465</div>
                                    <div class="nk-ibox-text">Working Hours</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 cloneable" style="margin-bottom:30px;">
                            <div class="nk-ibox-1">
                                <div class="nk-ibox-icon">
                                    <i class="mw-wysiwyg-custom-icon  mw-icon-app-search safe-element"></i>
                                </div>
                                <div class="nk-ibox-cont">
                                    <div class="nk-ibox-title">612</div>
                                    <div class="nk-ibox-text">Positive Feedbacks</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 cloneable" style="margin-bottom:30px;">
                            <div class="nk-ibox-1">
                                <div class="nk-ibox-icon">
                                    <i class="mw-wysiwyg-custom-icon mw-icon-app-star-outline safe-element"></i>
                                </div>
                                <div class="nk-ibox-cont">
                                    <div class="nk-ibox-title">735</div>
                                    <div class="nk-ibox-text">Happy Clients</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="parallax" style="background-image: url(<?php print $parallax; ?>); "></div>
    </div>
</div>

<?php if (is_admin()): ?>
    <?php print notif(_e('Click here to edit the Parallax', true)); ?>
<?php endif; ?>
