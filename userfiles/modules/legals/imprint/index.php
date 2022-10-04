<?php
/*
type: layout
name:Impressum
description: Impressum (provider identification)
*/
$count= DB::table('legals')->where('term_name','imprint')->first();
?>
<div class="container">
    <?php if(isset($count->description)): ?>
        <p class="edit" field="content_body">
            <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
