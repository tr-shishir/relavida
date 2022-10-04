<style>
.widget-one {
    margin-top: 24px;
    margin-left: 20px;
    padding: 10px;
    background: #fff;
    box-shadow: 0 0 2px 2px #eaeaea;
}
.widget-one .form-check{
    margin-bottom:10px;
}
</style>

<?php
$header = $GLOBALS['custom_header'];
$sidebar = $GLOBALS['custom_sidebar'];
if (!@$header and !@$sidebar){
//    Config::set('custom.sidebar', 'sidebar');
    save_option('custom_sidebar', 'sidebar', 'category_customization');
}

?>
<div class="widget-one">
    <h2>Display Category</h2>
    <p>Default sibebar option is selected.If you want to show the category in the header then select the header option.Then it will show in the header part and hide in the sidebar part</p>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="flexRadioDefault" value="header" id="header" <?php (@$header == 'header') ? print 'checked' : print '';?>>
        <label class="form-check-label" for="flexRadioDefault1">
            Header
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="flexRadioDefault" value="sidebar" id="header" <?php (@$sidebar == 'sidebar') ? print 'checked' : print '';?>>
        <label class="form-check-label" for="flexRadioDefault2">
            Sidebar
        </label>
    </div>
</div>
<script>
    $('input[type=radio][name=flexRadioDefault]').change(function() {

            var blog_menu = $(this).val();
            console.log(blog_menu);
            $.post("<?= url('/') ?>/api/v1/blog_menu", {blog_menu: blog_menu}, (res) => {

                if (res.success) {

                }

            });

    });

</script>
