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
<div class="edit main-wrapper" rel="content" field="ynera_content">
    <module type="layouts" template="hero/hero" />
    <module type="layouts" template="benifits/benifits" />
    <module type="layouts" template="discover/discover" />
    <module type="layouts" template="experienced/experienced" />
    <module type="layouts" template="blog/blog" />


</div>

<?php include template_dir() . "footer.php"; ?>