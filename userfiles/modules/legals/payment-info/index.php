<?php
/*
type: layout
name:Payment information
description: Payment information
*/
$count= DB::table('legals')->where('term_name','payment')->first();
?>
<div class="container">
    <?php if(isset($count->description)): ?>
        <p class="edit" field="content_body">
        <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
