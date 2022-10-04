<?php
/*
type: layout
name:Cancellation policy
description: Cancellation policy with cancellation form
*/
$count= DB::table('legals')->where('term_name','cancle')->first();
?>
<div class="container">
    <?php if(isset($count->description)): ?>
        <p class="edit" field="content_body">
        <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
