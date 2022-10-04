<div class="edit error-page" rel="content" field="error_page_content">
    <h1>404</h1>
    <h2>Page Not Found</h2>
    <a href="<?php print site_url(); ?>" class="btn btn-primary">Go Home</a>
</div>

<script type="text/javascript">
$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php print site_url(); ?>";
    }, 6000);
})
</script>