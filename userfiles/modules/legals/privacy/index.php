<?php
/*
type: layout
name:Datenschutz
description:Datenschutz
*/
$count= DB::table('legals')->where('term_name','pp')->first();

?>
<div class="container">
    <?php if(isset($count->description)): ?>
        <p class="edit" field="content_body">
        <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
