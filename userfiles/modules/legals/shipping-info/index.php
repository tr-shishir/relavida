<?php
/*
type: layout
name:Shipping information
description:Shipping information
*/
$count= \Cache::rememberForever('legals_shipping', function () {
            return DB::table('legals')->where('term_name','shipping')->select('description')->pluck('description')->first();
        });
?>
<div class="">
    <?php if(isset($count)): ?>
        <p class="">
        <?php echo $count ?>
        </p>
    <?php endif; ?>
</div>
