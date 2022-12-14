<script type="text/javascript">
    mw.require('<?php print modules_url() ?>comments/edit_comments.js');
</script>
<script>
    commentToggle = window.commentToggle || function (e, comment_id) {
            var item = mw.tools.firstParentOrCurrentWithAllClasses(e.target, ['comment-holder']);
            if (!mw.tools.hasClass(item, 'active')) {
                var curr = $('.order-data-more', item);
                $('.order-data-more').not(curr).stop().slideUp();
                $('.comment-holder').not(item).removeClass('active');
                $(curr).stop().slideToggle();
                $(item).toggleClass('active');

                $.ajax({
                    url: "<?php print api_url('mark_comment_post_notifications_as_read') ?>",
                    method: "POST", //First change type to method here

                    data: {
                        comment_id: comment_id, // Second add quotes on the value.
                    },
                    success: function (response) {

                    },
                    error: function () {

                    }


                });

            }
        }


</script>


<div class="comments-holder">
    <?php if (is_array($data) and !empty($data)): ?>
        <div class="mw-admin-comments-search-holder">
            <?php foreach ($data as $item) { ?>
                <div class="comment-holder comment-holder-comment-n-<?php print $item['id'] ?> comment-holder-comment-rel-id-<?php print $item['rel_id'] ?>" id="comment-n-<?php print $item['id'] ?>">
                    <?php if (isset($item['rel_type']) and $item['rel_type'] == 'content'): ?>
                        <module type="comments/comments_list" id="mw_comments_for_post_<?php print $item['rel_id'] ?><?php print $item['id'] ?>" content_id="<?php print $item['rel_id'] ?>" search-keyword="<?php print $kw ?>"/>
                    <?php elseif (isset($item['rel_type']) and $item['rel_type']): ?>
                        <module type="comments/comments_list" search-keyword="<?php print $kw ?>" id="mw_comments_for_post_<?php print $item['rel_id'] ?><?php print $item['id'] ?>" rel_id="<?php print $item['rel_id'] ?>" rel_type="<?php print $item['rel_type'] ?>"/>
                    <?php endif; ?>
                </div>
            <?php }; ?>
        </div>

        <div class="text-center">
            <a href="<?php print admin_url('view:modules/load_module:comments'); ?>#content_id=0" class="btn btn-link"><?php _e("See all comments"); ?></a>
        </div>
    <?php else: ?>
        <div class="icon-title">
            <i class="mdi mdi-comment-account"></i> <h5><?php _e("you-dont-have-any-comments"); ?></h5>
        </div>
    <?php endif; ?>

    <?php if (!isset($params['no_paging'])): ?>
        <?php if (isset($page_count) and $page_count): ?>
            <ul class="pagination justify-content-center">
                <?php print paging('num=' . $page_count . '&paging_param=' . $paging_param); ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</div>
