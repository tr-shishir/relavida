<?php

/*

type: layout
name: Blog
position: 24
*/


?>


<section class="blog-wrapper edit section-padding" field="layout-blog<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="section-head">
            <h3>NEUES AUS DEM YNERA RASEN BLOG</h3>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <a class="blog-post">
                    <div class="blog-thumb-wrapper">
                        <div class="blog-thumb bg-cover"
                            style="background-image: url(<?php print template_url(); ?>/assets/images/experiened-img.png)">
                        </div>
                    </div>
                    <div class="blog-content">
                        <span class="category"> NEWS & ANKÜNDIGUNGEN </span>
                        <h4 class="blog-title">
                            Terrasse reinigen mit Hausmitteln – Die 3 Schritte Anleitung für
                            Ihr Zuhause
                        </h4>
                        <div class="button button-secondary">
                            weiterlesen
                            <span class="icon">
                                <i class="fal fa-long-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>