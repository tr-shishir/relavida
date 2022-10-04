<?php
/*
type: layout
name: BattG Information
description: Information according to BattG
*/
$count= DB::table('legals')->where('term_name','info')->first();
?>
<div class="container">
    <?php if(isset($count->description)): ?>
        <p class="edit" field="content_body">
        <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
