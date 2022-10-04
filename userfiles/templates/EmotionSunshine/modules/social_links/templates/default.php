<?php

/*

type: layout

name: Default

description: Default

*/
?>

<?php if ($social_links_has_enabled == false) {
    print lnotif('Social links');
} ?>

<ul class="socials">
    <?php if ($facebook_enabled) { ?>
        <li>
            <a href="//facebook.com/<?php print $facebook_url; ?>" target="_blank">
                <i class="fa fa-facebook"></i>
            </a>
        </li>
    <?php } ?>

    <?php if ($twitter_enabled) { ?>
        <li>
            <a href="//twitter.com/<?php print $twitter_url; ?>" target="_blank">
                <i class="fa fa-twitter"></i>
            </a>
        </li>
    <?php } ?>

    <?php if ($pinterest_enabled) { ?>
        <li>
            <a href="//pinterest.com/<?php print $pinterest_url; ?>" target="_blank">
                <i class="fa fa-pinterest"></i>
            </a>
        </li>
    <?php } ?>

    <?php if ($youtube_enabled) { ?>
        <li>
            <a href="//youtube.com/<?php print $youtube_url; ?>" target="_blank">
                <i class="fa fa-youtube"></i>
            </a>
        </li>
    <?php } ?>

    <?php if ($instagram_enabled) { ?>
        <li>
            <a href="https://instagram.com/<?php print $instagram_url; ?>" target="_blank">
                <i class="fa fa-instagram"></i>
            </a>
        </li>
    <?php } ?>

    <?php if ($linkedin_enabled) { ?>
        <li>
            <a href="//linkedin.com/<?php print $linkedin_url; ?>" target="_blank">
                <i class="fa fa-linkedin"></i>
            </a>
        </li>
    <?php } ?>

    <?php if ($soundcloud_enabled) { ?>
        <li>
            <a href="//soundcloud.com/<?php print $soundcloud_url; ?>" target="_blank"><i class="fa fa-soundcloud"></i></a>
        </li>
    <?php } ?>

    <?php if ($mixcloud_enabled) { ?>
        <li>
            <a href="//mixcloud.com/<?php print $mixcloud_url; ?>" target="_blank"><i class="fa fa-mixcloud"></i></a>
        </li>
    <?php } ?>

    <?php if ($rss_enabled) { ?>
        <li>
            <a href="<?php site_url(); ?>rss" target="_blank">
                <i class="fa fa-rss"></i>
            </a>
        </li>
    <?php } ?>
</ul>