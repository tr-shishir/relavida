<?php

/*

type: layout

name: Default

description: Default

*/
?>
<script>
    mw.lib.require('font_awesome');
</script>
<ul>
    <?php if ($social_links_has_enabled == false) {
        print lnotif('Social links');
    } ?>

    <?php if ($facebook_enabled) { ?>
       <li><a href="//facebook.com/<?php print $facebook_url; ?>" target="_blank"><i class="fa fa-facebook-official"></i></a></li>
    <?php } ?>

    <?php if ($twitter_enabled) { ?>
        <li><a href="//twitter.com/<?php print $twitter_url; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
    <?php } ?>

    <?php if ($googleplus_enabled) { ?>
        <li><a href="//plus.google.com/<?php print $googleplus_url; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
    <?php } ?>

    <?php if ($pinterest_enabled) { ?>
        <li><a href="//pinterest.com/<?php print $pinterest_url; ?>" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
    <?php } ?>

    <?php if ($youtube_enabled) { ?>
        <li><a href="//youtube.com/<?php print $youtube_url; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
    <?php } ?>

    <?php if ($instagram_enabled) { ?>
        <li><a href="https://instagram.com/<?php print $instagram_url; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
    <?php } ?>

    <?php if ($linkedin_enabled) { ?>
        <li><a href="//linkedin.com/<?php print $linkedin_url; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
    <?php } ?>
</ul>