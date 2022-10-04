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

<div class="edit main-wrapper" rel="content" field="marcando_content">
    <module type="layouts" template="skin-1"/>
    <module type="layouts" template="skin-2"/>
    <module type="layouts" template="skin-3"/>
</div>

<?php include template_dir() . "footer.php"; ?>
