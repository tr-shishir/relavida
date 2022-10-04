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
<script>
    $(document).ready(function () {
        $('.navigation-holder').addClass('not-transparent');
    })
</script>
<div class="edit" rel="content" field="bamboo_content">

    <module type="layouts" template="skin-16"/>
</div>

<?php include template_dir() . "footer.php"; ?>
