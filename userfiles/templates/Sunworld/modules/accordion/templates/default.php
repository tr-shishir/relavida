<?php
if ($json == false) {
    print lnotif(_e('Click to edit accordion', true));

    return;
}

if (isset($json) == false or count($json) == 0) {
    $json = array(0 => $defaults);
}
?>


<div id="mw-accordion-module-<?php print $params['id'] ?>">
    <div class="panel-group accordions" id="accordion-<?php print $params['id']; ?>" role="tablist" aria-multiselectable="true">
        <?php foreach ($json as $key => $slide): ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="accordion-<?php print $params['id'] . '-' . $key; ?>">
                    <h4 class="panel-title">
                        <a <?php if ($key != 0): ?>class="collapsed"<?php endif; ?> role="button" data-toggle="collapse" data-parent="#accordion-<?php print $params['id']; ?>" href="#collapse-<?php print $params['id'] . '-' . $key; ?>" aria-expanded="true"
                           aria-controls="collapse-<?php print $params['id'] . '-' . $key; ?>">
                            <?php print isset($slide['icon']) ? $slide['icon'] . ' ' : ''; ?><?php print isset($slide['title']) ? $slide['title'] : ''; ?>
                        </a>
                    </h4>
                </div>
                <div id="collapse-<?php print $params['id'] . '-' . $key; ?>" class="panel-collapse collapse <?php if ($key == 0): ?>in<?php endif; ?>" role="tabpanel" aria-labelledby="accordion-<?php print $params['id'] . '-' . $key; ?>">
                    <div class="panel-body">
                        <div class="edit allow-drop" field="accordion-item-<?php print $key ?>" rel="module-<?php print $params['id'] ?>">
                            <div class="element">
                                <?php print isset($slide['content']) ? $slide['content'] : 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                        squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth
                        nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.' ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>