<?php

/*

  type: layout
  content_type: static
  name: Home
  position: 11
  description: Home layout

*/

?>
<?php include template_dir() . "header.php"; ?>

<div class="edit main-wrapper home-page-area" rel="content" field="emotionss_content">
    <module type="layouts" template="skin-2"/>
    <module type="layouts" template="skin-3"/>
    <module type="layouts" template="home-cat"/>
    <module type="layouts" template="home-brand"/>
    <module type="layouts" template="home-brand-responsive"/>
    <module type="layouts" template="skin-4"/>
    <module type="layouts" template="home-banner"/>
    <module type="layouts" template="home-feature-1"/>
    <module type="layouts" template="home-feature-2"/>
</div>

<?php include template_dir() . "footer.php"; ?>
