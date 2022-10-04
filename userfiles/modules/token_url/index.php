<?php
/*
type: layout
name: IT Recht Kanzlei
description: IT Recht Kanzlei
*/
$count= DB::table('tokenurl')->first();

?>
<div class="container">
    <p class="edit" field="content_body">
    <?php echo $count->token ?>
    </p>
</div>
