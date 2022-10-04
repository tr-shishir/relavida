<?php

/*

  type: layout
  content_type: static
  name: Error 404
  position: 11
  description: Error 404

*/

?>
<?php include template_dir() . "header.php"; ?>


<div class="edit error-page" rel="content" field="error_page_content">
    <h1>404</h1>
    <h2>Page Not Found</h2>
    <a href="<?php print site_url(); ?>" class="btn btn-primary">Go Home</a>
</div>
<?php include template_dir() . "footer.php"; ?>

<script type="text/javascript">
$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php print site_url(); ?>";
    }, 6000);
})
</script>