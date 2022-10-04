<?php

/*

type: layout

name: Default

description: Default comments template

*/

//$template_file = false;
?>

<?php $rand = rand(); ?>
















<?php if (is_array($comments)): ?>
    <!-- START: Comments -->
    <div id="comments"></div>
    <div class="nk-comments" id="comments-list-<?php print $data['id'] ?>">
        <div class="nk-gap-3"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <?php if ($form_title != false): ?>
                        <h3 class="nk-title"><?php print $form_title ?></h3>
                    <?php elseif ($display_comments_from != false and $display_comments_from == 'recent'): ?>
                        <h3 class="nk-title">
                            <?php _e("Letzte Kommentare"); ?>
                        </h3>
                    <?php else : ?>
                        <h3 class="nk-title">
                            <?php if ($post) { ?>
                                <?php _e("Kommentare zu"); ?>
                            <?php } else { ?>
                                <?php _e("Kommentare"); ?> <strong><?php print $post['title']; ?></strong>
                            <?php } ?>
                        </h3>
                    <?php endif; ?>


                    <div class="nk-gap-1"></div>
                    <?php foreach ($comments as $comment) : ?>
                        <?php
                        if (!$required_moderation or $comment['is_moderated'] == 1 or (!(mw()->user_manager->session_all() == false) and $comment['session_id'] == mw()->user_manager->session_id())) {
                            ?>
                            <div class="nk-comment">
                                <?php
                                $comment_author = get_user_by_id($comment['created_by']);
                                $my_comment = false;
                                if ($cur_user != false and $comment['created_by'] == $cur_user) {
                                    $my_comment = true;
                                }
                                ?>

                                <?php if ($avatars_enabled) { ?>
                                    <div class="nk-comment-avatar">
                                        <a href="#">
                                            <?php if (isset($comment_author['thumbnail']) and trim($comment_author['thumbnail']) != '') { ?>
                                                <img src="<?php print ($comment_author['thumbnail']); ?>" width="60" height="60" class="comment-image"
                                                     alt="<?php print addslashes($comment['comment_name']) ?>"/>
                                            <?php } else { ?>
                                                <?php if ($avatar_style == '4') { ?>
                                                    <img src="<?php print thumbnail(get_option('avatartype_custom', 'comments'), 60, 60); ?>" class="comment-image" width="60" height="60"
                                                         alt="<?php print addslashes($comment['comment_name']) ?>"/>
                                                <?php } else if ($avatar_style == '1' || $avatar_style == '3') { ?>
                                                    <img src="<?php print thumbnail($config['url_to_module'] . '/img/comment-default-' . $avatar_style . '.jpg', 60, 60); ?>" width="60" height="60"
                                                         class="comment-image" alt="<?php print addslashes($comment['comment_name']) ?>"/>
                                                <?php } else if ($avatar_style == '2') { ?>
                                                    <span class="comment-image random-color"> <span style="background-color: <?php print mw('format')->random_color(); ?>"> </span> </span>
                                                <?php } else if (isset($comment_author['thumbnail']) and $comment_author['thumbnail'] != '') { ?>
                                                    <img src="<?php print ($comment_author['thumbnail']); ?>" width="60" height="60" class="comment-image"
                                                         alt="<?php print addslashes($comment['comment_name']) ?>"/>
                                                <?php } else { ?>
                                                    <img src="<?php print thumbnail($config['url_to_module'] . '/img/comment-default-1.jpg', 60, 60); ?>" width="60" height="60" class="comment-image"
                                                         alt="<?php print addslashes($comment['comment_name']) ?>"/>
                                                <?php } ?>
                                            <?php } ?>
                                        </a>
                                    </div>
                                <?php } ?>

                                <div class="nk-comment-meta">
                                    <?php event_trigger('module.comments.item.before', $comment); ?>
                                    <div class="nk-comment-name">
                                        <?php if (isset($comment['comment_website'])): ?>
                                            <a href="<?php print mw('format')->prep_url($comment['comment_website']); ?>">
                                                <?php print $comment['comment_name'] ?>
                                            </a>
                                        <?php else: ?>
                                            <?php print $comment['comment_name'] ?>
                                        <?php endif; ?> <?php _e('sagt:'); ?>
                                    </div>
                                    <?php if (isset($comment['updated_at'])): ?>
                                        &nbsp;
                                        <div class="nk-comment-date"><?php print $comment['updated_at']; ?></div>
                                    <?php endif; ?>

                                    <?php event_trigger('module.comments.item.info', $comment); ?>
                                </div>

                                <div class="nk-comment-text">
                                    <?php if ($required_moderation != false and $comment['is_moderated'] == 0): ?>
                                        <em class="comment-require-moderation">
                                            <?php _e("Your comment requires moderation"); ?>
                                        </em><br/>
                                    <?php endif; ?>
                                    <?php print nl2br($comment['comment_body'], 1); ?>
                                    <?php if ($my_comment == true): ?>
                                    <?php endif; ?>
                                    <?php event_trigger('module.comments.item.body', $comment); ?>
                                </div>
                            </div>
                            <?php event_trigger('module.comments.item.after', $comment); ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="nk-gap-3"></div>
    </div>
    <!-- END: Comments -->


    <?php if ($paging != false and intval($paging) > 1 and isset($paging_param)): ?>
        <?php print paging("num={$paging}&paging_param={$paging_param}") ?>
    <?php endif; ?>
<?php else: ?>
    <div class="nk-comments">
        <div class="nk-gap-3"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h3 class="nk-title">
                        <?php _e("Keine Kommentare"); ?>
                    </h3>
                    <p>Sei der erste der kommentiert. </p>
                </div>
            </div>
        </div>
        <div class="nk-gap-3"></div>
    </div>
<?php endif; ?>

<?php if ($are_disabled == false) : ?>
    <?php if (!$login_required or $cur_user != false): ?>
        <!-- START: Reply -->
        <div class="nk-reply" id="comments-<?php print $data['id'] ?>">
            <?php event_trigger('module.comments.form.before', $data); ?>
            <div class="nk-gap-3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h3 class="nk-title">Hinterlasse einen Kommentar:</h3>
                        <div class="nk-gap-1"></div>
                        <form autocomplete="on" id="comments-form-<?php print $data['id'] ?>" class="nk-form">
                            <?php event_trigger('module.comments.form.start', $data); ?>
                            <input type="hidden" name="rel_id" value="<?php print $data['rel_id'] ?>">
                            <?php print csrf_form(); ?>
                            <input type="hidden" name="rel" value="<?php print $data['rel_type'] ?>">
                            <input type="hidden" name="module_id" value="<?php print $params['id'] ?>">

                            <?php if ($form_title != false): ?>
                                <input type="hidden" name="comment_subject" value="<?php print $form_title ?>">
                            <?php endif; ?>

                            <?php if ($cur_user == false) : ?>
                                <div class="row vertical-gap">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control required" name="comment_name" placeholder="<?php _e("Dein Name"); ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control required" name="comment_website" placeholder="<?php _e("Webseite"); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="email" class="form-control required" name="comment_email" placeholder="<?php _e("Deine E-Mail"); ?>" required>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="comments-user-profile">
                            <?php _e("You are commenting as"); ?> :
                                    <?php if (isset($cur_user_data['thumbnail']) and trim($cur_user_data['thumbnail']) != ''): ?>
                                        <span class="mw-user-thumb mw-user-thumb-small">
                                    <img style="vertical-align:middle" src="<?php print $cur_user_data['thumbnail'] ?>" height="24" width="24"/>
                                </span>
                                    <?php endif; ?>
                                    <span class="comments-user-profile-username"> <?php print user_name($cur_user_data['id']); ?> </span>
                            <small><a href="<?php print api_link('logout') ?>">( <?php _e("Ausloggen"); ?> )</a></small>
                        </span>
                            <?php endif; ?>


                            <div class="nk-gap-1"></div>
                            <div class="row vertical-gap">
                                <div class="col-md-12">
                                    <textarea class="form-control required" name="comment_body" rows="8" placeholder="<?php _e("Kommentar"); ?>" required></textarea>
                                </div>
                            </div>

                            <?php if (!$disable_captcha) { ?>
                                <module type="captcha"/>
                            <?php } ?>
                            <?php event_trigger('module.comments.form.end', $data); ?>

                            <div class="nk-gap-1"></div>
                            <div class="nk-form-response-success"></div>
                            <div class="nk-form-response-error"></div>
                            <button class="nk-btn" type="submit"><?php _e("Einen Kommentar hinzufügen"); ?></button>
                        </form>
                        <?php event_trigger('module.comments.form.after', $data); ?>
                    </div>
                </div>
            </div>
            <div class="nk-gap-3"></div>
        </div>
        <!-- END: Reply -->
    <?php else : ?>
        <div class="alert">
            <?php _e("Sie müssen"); ?>
            <a href='<?php print login_url(); ?>' class="comments-login-link">
                <?php _e("Einloggen"); ?>
            </a>
            <?php _e("oder"); ?>
            <a class="comments-register-link" href='<?php print register_url(); ?>'>
                <?php _e("registrieren"); ?>
            </a>
            <?php _e("einen Kommentar posten"); ?>.
        </div>
    <?php endif; ?>
<?php else: ?>
<?php endif; ?>
