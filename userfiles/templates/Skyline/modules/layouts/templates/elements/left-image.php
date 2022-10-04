<?php

/*

type: layout

name: Left Image - Right Text

position: 7

*/

?>

<section class="section left-iamge-layout allow-drop edit" field="layout-elements-left-image-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="element-layout-image" style="background-image: url('<?php print elements_url() ?>images/default-8.jpg');">
                </div>
            </div>
            <div class="col-md-6">
                <div class="element-layout-content">
                    <h3>Our Experience</h3>
                    <p>
                        It is a long est`ablished fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a
                        more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.
                    </p>
                    <module type="btn" text="Button" />
                </div>
            </div>
        </div>
    </div>
</section>