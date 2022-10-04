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

<div class="edit" rel="content" field="snow_content">
    <module type="layouts" template="skin-1"/>
    <module type="layouts" template="skin-2"/>
    <module type="layouts" template="skin-6"/>
    <module type="layouts" template="skin-5"/>
    <module type="layouts" template="skin-3"/>
    <module type="layouts" template="skin-4"/>
</div>

<?php include template_dir() . "footer.php"; ?>
