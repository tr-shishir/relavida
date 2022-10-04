<?php

/*

type: layout
content_type: dynamic
name: Thank You
description: Showcase shop items in a sylish grid arrangement.
position: 4

*/

?>

<?php

// if(is_admin() == 1 || session_get('thank_you_status') == true){

// }
// else{
//     header("Location: ".site_url());
//     exit();
// }

// session_set('thank_you_status',false);
?>


<?php include template_dir() . "header.php"; ?>
    <div class="thank-you-page-wrapper edit" id="shop-content-<?php print CONTENT_ID; ?>" field="thank_you_page" rel="content">
        <section class="p-t-100 p-b-50 fx-particles">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <module type="shop/thank_you" />
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php include template_dir() . "footer.php"; ?>
