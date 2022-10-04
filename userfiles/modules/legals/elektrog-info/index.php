<?php
/*
type: layout
name:ElektroG Note
description: Note according to ElektroG
*/
$count= DB::table('legals')->where('term_name','note')->first();
?>
<div class="container">
    <?php if(isset($count->description)): ?>
        <p class="edit" field="content_body">
            <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
