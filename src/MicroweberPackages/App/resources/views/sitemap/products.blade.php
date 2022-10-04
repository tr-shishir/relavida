 <?php 
Illuminate\Pagination\Paginator::useBootstrap();

 echo "This XML file does not appear to have any style information associated with it. The document tree is shown below.";
 echo "<br>";?>
 <div class="hr"></div>
 <style>
     .hr{
         margin-top: 4px;
        border-bottom: 2px solid black;
        margin-bottom: 6px;
     }
     .url{
         margin-left: 30px;
         color: rgb(136, 18, 128);
     }
     .url-color{
         color: rgb(136, 18, 128);
     }
     .loc{
         margin-left: 50px;
     }
     .urlset{
        color: rgb(136, 18, 128);
     }
     .link-color{
        color: rgb(26, 26, 166);
     }
     li.page-item {
        display: inline-block !IMPORTANT;
        background: #ddd;
        height: 25px;
        width: 25px;
        text-align: center;
        line-height: 25px;
        font-size: 15px;
    }

    li.page-item a.page-link {
        text-decoration: none !important;
    }
 </style>
    <!-- // foreach($products as $product){?> -->
        <div class="urlset">
            <?php echo htmlentities('<urlset xmlns="');?>
            <span class="link-color"><?php echo "http://www.sitemaps.org/schemas/sitemap/0.9";?></span>
            <?php echo htmlentities('" xmlns:xhtml="');?>
            <span class="link-color"><?php echo "http://www.w3.org/1999/xhtml";?></span>
            <?php echo htmlentities('">'); ?>
        </div>
        @foreach($products as $product)
            <div class="url">
                <?php echo htmlentities("<url>"); ?>
            </div>
            <div class="loc">
                <span class="url-color"><?php echo htmlentities("<loc>"); ?></span>
                <?php echo $product->link();?>
                <span class="url-color"><?php echo htmlentities("</loc>"); ?></span>
            </div>
            <div class="loc">
                <span class="url-color"><?php echo htmlentities("<lastmod>"); ?></span>
                <?php echo $product->updated_at->format('Y-m-d');?>
                <span class="url-color"><?php echo htmlentities("</lastmod>"); ?></span>
            </div>
            <div class="url">
                <?php echo htmlentities("</url>"); ?>
            </div>
        @endforeach
        <div class="urlset">
            <?php echo htmlentities("</urlset>"); ?>
        </div>
        <div class="link">
            {{ $products->links() }}
        </div>
        


