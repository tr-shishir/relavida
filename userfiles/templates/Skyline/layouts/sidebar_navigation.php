<?php

/*

type: layout
content_type: dynamic
name: FAQ Page
position: 3
description: Sidebar Navigation Page

*/


?>

<?php include template_dir() . "header.php"; ?>
<div class="fullwidth-with-sidebar">
    <div class="fwidht-sidebar">
        <div class="fw-sidebar-box">
            <module type="sidebar_navigation"/>
        </div>
    </div>
    <div class="fwidth-content edit" rel="content" field="sidebar_navigation_page">
        <module type="layouts" template="faq-heading-default"/>
    </div>
</div>
<script>
    $(window).on('load', function(){
        
        if ($(window).width() > 1024) {
            var headerHeight = $('header.nk-header').height();
            var headerHeightpx = headerHeight + 8 + 'px';
            //alert(headerHeightpx);
            $('.fwidht-sidebar').css('top',headerHeightpx);  
            $('.mw-live-edit .fwidht-sidebar').css('top', headerHeight+68+'px'); 
            $(document).scroll(function() {
                var scrollDistance = $(document).scrollTop(); 
                if ( scrollDistance >= 0 ) {
                    $('.fwidht-sidebar').css('top',headerHeightpx);
                    $('.mw-live-edit .fwidht-sidebar').css('top', headerHeight+63+'px'); 
                } 
                let j = 2;
                for(let i = 10; i <=60 ; i+=10){
                    if ( scrollDistance >= i ) { 
                        $('.fwidht-sidebar').css('top',headerHeight - j + 'px');
                        $('.mw-live-edit .fwidht-sidebar').css('top',headerHeight - j +50+ 'px'); 
                    }
                    j+=10;
                }
                 
            });
            
            
             
        }
        else {
            //alert('More than 960');
        }

        
    });
</script>
<?php include template_dir() . "footer.php"; ?>

<!-- This two file for sidebar navigation module -->
<?php include modules_path() . "sidebar_navigation/modal.php"; ?>
<?php include modules_path() . "sidebar_navigation/sidebar_nav_script.php"; ?>
