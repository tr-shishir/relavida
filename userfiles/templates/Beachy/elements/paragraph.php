<?php if(is_logged() != false): ?>
    <div class="element" id="element-<?php print CONTENT_ID; ?>">
    <p>Regular text<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>

        <?php else: ?>
            <div class="element">
            <?php
            $limit = blog_word_limit();
?>
    <p><?php print character_limiter($post['content'],$limit); ?></p>
    </div>
    <style>
    .blog-login {
    text-align: right;
}
</style>
    <div class="blog-login">
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Einloggen und Bericht in voller Länge kostenfrei lesen</a>
    </div>
    <?php endif; ?>