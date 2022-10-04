<?php
/*
type: layout
name: Bootstrap 4
description: Bootstrap 4
*/
?>
<style>

</style>
<ul class="pagination">
    <?php foreach ($pagination_links as $pagination_link): ?>
        <?php if ($pagination_link['attributes']['current']): ?>
            <li class="page-item active">
                <span class="page-link" id="page-item-<?php echo $pagination_link['title'];?>">
                     <?php echo $pagination_link['title']; ?>
                    <span class="sr-only"><?php _e('Current'); ?></span>
                </span>
            </li>
        <?php else: ?>
            <li class="page-item">
                <a class="page-link" id="page-item-<?php echo $pagination_link['title'];?>" data-page-number-dont-copy="<?php echo $pagination_link['attributes']['data-page-number']; ?>" href="<?php echo $pagination_link['attributes']['href']; ?>">
                    <?php echo $pagination_link['title'];?>
                </a>
            </li>
        <?php endif; ?>
        <script type="text/javascript">
            if($('#page-item-1').parent().hasClass('active')){
                $("#page-item-Last").addClass('page-item-last-hide');
                $(".pagination").addClass('pagination-left-padding');
            }
            $("#page-item-First").parent().addClass('page-first-item');
            $("#page-item-Previous").parent().addClass('page-prev-item');
            $("#page-item-Next").text("Weiter");
            $("#page-item-Last").text("Zurück");
            $("#page-item-Last").parent().addClass("page-item-Last-item");

        </script>
    <?php endforeach; ?>
</ul>
