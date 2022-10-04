<?php

/*

type: layout

name: Bootstrap

description: Default

*/
?>

<link rel="stylesheet" type="text/css" href="<?php print $config['url_to_module'] ?>css/bootstrap.css" />
<script>
    mw.lib.require('bootstrap3ns');

</script>

<div>
    <div class="faq-holder bootstrap">
        <div class="row">
            <div class="container">
                <div class="col-xs-12 mb-3 edit" rel="module-<?php print $params['id']; ?>" field="title-content">
                    <h3>Hier kannst du einen Subtitel eingeben</h3>
                </div>
            </div>
        </div>

        <div class="">


            <div class="panel-group" id="faq-accordion">


                <?php
                $count = 0;
                foreach ($data as $slide) {
                if(@$slide['page_id'] == PAGE_ID && @$slide['module_id'] == @$params['parent-module-id']){

                    $count++;
                    ?>

                <?php if ($count == 1) {
                        $status = '';
                        $status_in = 'in';
                    } else {
                        $status = 'collapsed';
                        $status_in = '';
                    }
                    ?>
                <div class="panel panel-default">
                    <div class="container">
                        <div id="accordion">
                            <div class="card faq-card">
                                <div class="card-header faq-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link accordion-toggle <?php print $status; ?>"
                                            data-toggle="collapse" data-parent="#faq-accordion"
                                            href="#collapse-<?php print $params['id']; ?>-<?php print $count; ?>">
                                            <span><i class="fas fa-angle-double-right"></i></span>
                                            <span><?php print $slide['question']; ?></span>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse-<?php print $params['id']; ?>-<?php print $count; ?>" class="collapse collapse-<?php print $params['id']; ?>" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <?php print $slide['answer']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <?php }
                }?>


            </div>


        </div>
    </div>
</div>
