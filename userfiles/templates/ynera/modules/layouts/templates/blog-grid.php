<?php

/*

type: layout

content_type: dynamic

name: blog grid

position: 23

*/

?>

<style>
    .blog-grid {}

.blog-grid .blog-sample {
    position: relative;
    display: block !important;
    height: auto;
    margin-bottom: 30px;
}

.blog-grid .blog-sample-image {min-width: unset;display: block !important;position: relative;width: 100%;height: 190px;-webkit-transition: -webkit-transform 0.3s ease-in-out;transition: -webkit-transform 0.3s ease-in-out;transition: transform 0.3s ease-in-out;transition: transform 0.3s ease-in-out, -webkit-transform 0.3s ease-in-out;}

.blog-grid .blog-sample-content {
    padding: 15px 10px 20px;
    
}

.blog-grid span.blog-grid-category {
    background-color: #6b6b6b;
    display: inline-block;
    line-height: 0;
    padding: 10px 5px;
    font-size: 12px;
    text-transform: uppercase;
    color: #ffffff;
    border-radius: 3px;
    -webkit-transition: background 0.3s ease-in-out;
    transition: background 0.3s ease-in-out;
}

.blog-grid .blog-sample-title {
    padding: 0px;
}

.blog-grid .blog-sample-title a {}

.blog-grid .blog-sample-title h4 {
    font-size: 19px;
    font-weight: 700;
    line-height: 29px;
}

.blog-grid .blog-sample-title p.readmore-grid-blog {
    color: #005c46;
    text-transform: uppercase;
    font-size: 14px;
    padding: 0px 15px;
    border: 2px solid #005c46;
    margin-top: 30px;
    display: inline-flex;
    border-radius: 5px;
}

.blog-grid .blog-sample-title p.readmore-grid-blog span.icon {}

.blog-grid .blog-sample-title p.readmore-grid-blog i {
    margin-left: 5px;
}


.blog-grid-container .blog-grid-title {
    text-align: center;
    margin-bottom: 20px;
    color: #3f3f3f;
}

.blog-grid-container .blog-grid span.blog-grid-category{
    display: none;  
}

.blog-grid .blog-sample-image-wrapper {
    overflow: hidden;
}

.blog-grid .blog-sample:hover .blog-sample-image {
    transform: scale(1.1)
}

.blog-grid .blog-sample-image::before {
    display: none;
}

.blog-grid .readmore-grid-blog:hover {
    background-color: #005c46;
    color: #fff !important;
    transition: all .3s ease;
}


@media (max-width: 991px) {
    .blog-grid-container .row.blog-posts {
        flex-wrap: wrap;
    }
}

@media (max-width: 767px) {
    .blog-grid-container .row.blog-posts {
        gap: 30px;
    }
}

</style>
<section class="section section-padding safe-mode nodrop" field="layout-shop-main-layout-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="blog-grid-container">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="blog-grid">
                        <div class="blog-grid-title">
                        <h3>NEUES AUS DEM YNERA RASEN BLOG Test</h3>
                        </div>
                        <module type="posts/" template="skin-2"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>