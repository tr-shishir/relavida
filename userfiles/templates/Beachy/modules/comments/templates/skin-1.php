<?php

/*

type: layout

name: Skin 1

description: Skin 1 comments template

*/

?>


<?php $rand = rand(); ?>
<div class="container m-b-40">
    <div class="row shop-inner-reviews">
        <div class="col-xl-6 mx-auto">
            <div class="bg-silver p-30">
                <div class="row">
                    <div class="col-12">
                        <div class="reviews bg-silver p-30">
                            <h4>Letzte Kommentare</h4>

                            <?php if (is_array($comments)): ?>
                                <div id="comments-list-<?php print $data['id'] ?>">
                                    <?php foreach ($comments as $comment) : ?>
                                        <?php
                                        $required_moderation = get_option('require_moderation', 'comments') == 'y';
                                        if (!$required_moderation or $comment['is_moderated'] == 1 or (!(mw()->user_manager->session_all() == false) and $comment['session_id'] == mw()->user_manager->session_id())) {
                                            ?>
                                            <?php
                                            $avatars_enabled = get_option('avatar_enabled', 'comments') == 'y';
                                            $comment_author = get_user_by_id($comment['created_by']);
                                            $my_comment = false;
                                            if ($cur_user != false and $comment['created_by'] == $cur_user) {
                                                $my_comment = true;
                                            }

                                            if (isset($comment['comment_website'])) {
                                                $website_url = mw('format')->prep_url($comment['comment_website']);
                                            } else {
                                                $website_url = 'javascript:;';
                                            }
                                            ?>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="review" id="comment-<?php print $comment['id'] ?>">
                                                        <div class="avatar-holder">
                                                            <div class="avatar" style="background-image: url('<?php print template_url(); ?>assets/img/avatar.png');"></div>
                                                        </div>
                                                        <div class="info">
                                                            <h4><?php print $comment['comment_name'] ?> <?php print _e('says'); ?>:</h4>
                                                            <?php if ($required_moderation != false and $comment['is_moderated'] == 0): ?>
                                                                <em class="comment-require-moderation">
                                                                    <?php _e("Your comment requires moderation"); ?>
                                                                </em><br/>
                                                            <?php endif; ?>

                                                            <p><?php print nl2br($comment['comment_body'], 1); ?></p>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <?php event_trigger('module.comments.item.before', $comment); ?>
                                                </div>
                                            </div>

                                            <?php event_trigger('module.comments.item.body.after', $comment); ?>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </div>

                                <?php if ($paging != false and intval($paging) > 1 and isset($paging_param)): ?>
                                    <?php print paging("num={$paging}&paging_param={$paging_param}") ?>
                                <?php endif; ?>

                            <?php else: ?>
                                <div class="row m-t-50">
                                    <div class="col-md-12">
                                        <div class="text-center m-b-50">
                                            <p class="bold">Keine Kommentare</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($are_disabled == false) : ?>
                                <?php if (!$login_required or $cur_user != false): ?>
                                    <a href="javascript:;" class="js-show-review-form btn btn-custom-one btn-block">Hinterlasse einen Kommentar</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function () {
                        $('.js-show-review-form').on('click', function () {
                            $(this).hide();
                            $('.js-review-form').slideDown();
                        });
                    });
                </script>

                <?php if ($are_disabled == false) : ?>
                    <?php if (!$login_required or $cur_user != false): ?>
                        <div class="row leave-review js-review-form m-t-20" style="display: none;">
                            <div class="col-12">
                                <div class="right-side-x">
                                    <div class="reviews">
                                        <h4><?php _e("Hinterlasse einen Kommentar"); ?></h4>
                                    </div>

                                    <div class="form">
                                        <form autocomplete="on" id="comments-form-<?php print $data['id'] ?>">
                                            <?php event_trigger('module.comments.form.start', $data); ?>
                                            <input type="hidden" name="rel_id" value="<?php print $data['rel_id'] ?>">
                                            <?php print csrf_form(); ?>
                                            <input type="hidden" name="rel" value="<?php print $data['rel_type'] ?>">
                                            <input type="hidden" name="module_id" value="<?php print $params['id'] ?>">
                                            <?php if ($form_title != false): ?>
                                                <input type="hidden" name="comment_subject" value="<?php print $form_title ?>">
                                            <?php endif; ?>

                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if ($cur_user == false) : ?>
                                                        <div class="form-group">
                                                            <label class="control-label" for="comment_name">Name</label>
                                                            <input class="form-control" id="comment_name" name="comment_name" type="text" placeholder="Vollst??ndiger Name">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label" for="comment_email">Email</label>
                                                            <input class="form-control" id="comment_email" name="comment_email" type="email" placeholder="E-Mail-Addresse">
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="comments-user-profile" style="margin-bottom: 5px;">

                                                            Sie kommentieren als:
                                                            <span class="comments-user-profile-username"> <?php print user_name($cur_user_data['id']); ?> </span>
                                                            <a href="<?php print api_link('logout') ?>" class="mw-ui-btn mw-ui-btn-outline mw-ui-btn-small mw-ui-btn-default float-right"><?php _e("Ausloggen"); ?></a>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!$disable_captcha) { ?>
                                                        <!--<module type="captcha"/>-->
                                                    <?php } ?>

                                                    <div class="form-group">
                                                        <label class="control-label" for="comment_body">Botschaft</label>
                                                        <textarea class="form-control" id="comment_body" name="comment_body" placeholder="Schreiben Sie ihre Nachricht hier"></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-custom-one btn-block">Nachricht senden</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="alert">
                            Sie m??ssen
                            <a href='<?php print login_url(); ?>' class="comments-login-link">
                                Einloggen
                            </a>
                                oder
                            <a class="comments-register-link" href='<?php print register_url(); ?>'>
                                registrieren
                            </a>
                            einen Kommentar posten
                            .
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>