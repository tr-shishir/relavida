<?php
/*
type: layout
name:Shipping information
description:Shipping information
*/
$count= DB::table('legals')->where('term_name','shipping')->first();
?>
<div class="">
    <?php if(isset($count->description)): ?>
        <p class="">
        <?php echo $count->description ?>
        </p>
    <?php endif; ?>
</div>
