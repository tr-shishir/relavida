<?php
/*
type: layout
name: agb
description: AGB
*/
$count= DB::table('legals')->where('term_name','agb')->first();

?>
<div class="container">
    <?php if(isset($count->description)): ?>
        <p class="edit" field="content_body">
        <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
