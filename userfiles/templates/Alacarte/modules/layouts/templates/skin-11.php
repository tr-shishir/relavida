<?php

/*

type: layout

name: Accordions

position: 11

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-70';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-70';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-9 d-flex <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-11-<?php print $params['id'] ?>" rel="module">
    <div class="container align-self-center allow-drop">

        <module type="accordion"/>

        <!--<div class="row">
            <div class="col-lg-2">

                <ul class="nav flex-column" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                    </li>
                </ul>

            </div>
            <div class="col-lg-10">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="row">
                            <div class="col-lg-7 col-xl-7">
                                <div class="description">
                                    <h2><?php /*print _lang('Offer for desserts', 'templates/theplace'); */ ?></h2>
                                    <p><?php /*print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates/theplace'); */ ?></p>
                                    <p><?php /*print _lang('It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.', 'templates/theplace'); */ ?></p>
                                </div>
                            </div>

                            <div class="col-lg-5 col-xl-5 text-center">
                                <img src="<?php /*print template_url(); */ ?>assets/img/sections/cacke.png" alt=""/>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


                        <div class="row">
                            <div class="col-lg-7 col-xl-6 offset-xl-1">
                                <h2><?php /*print _lang('Today’s Best Offer', 'templates/theplace'); */ ?></h2>
                                <p><?php /*print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates/theplace'); */ ?></p>
                                <p><?php /*print _lang('It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.', 'templates/theplace'); */ ?></p>
                            </div>

                            <div class="col-lg-5 col-xl-5 text-center">
                                <img src="<?php /*print template_url(); */ ?>assets/img/sections/cacke.png" alt=""/>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">


                        <div class="row">
                            <div class="col-lg-7 col-xl-6 offset-xl-1">
                                <h2><?php /*print _lang('Offer for desserts', 'templates/theplace'); */ ?></h2>
                                <p><?php /*print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates/theplace'); */ ?></p>
                                <p><?php /*print _lang('It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.', 'templates/theplace'); */ ?></p>
                            </div>

                            <div class="col-lg-5 col-xl-5 text-center">
                                <img src="<?php /*print template_url(); */ ?>assets/img/sections/cacke.png" alt=""/>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>-->

    </div>
</section>