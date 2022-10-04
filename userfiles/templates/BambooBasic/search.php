<?php

/*

type: layout
content_type: dynamic
name: Search

*/


?>

<?php include template_dir() . "header.php"; ?>
<script>
    $(document).ready(function () {
        $('.navigation-holder').addClass('not-transparent');
    })
</script>
<?php
$keywords = '';
if (isset($_GET['keywords'])) {
    if(@$_REQUEST['category_list']=='sku'){
        $keywords = htmlspecialchars($_GET['keywords']);
    }else{
        $keywords = mw()->url_manager->slug(htmlspecialchars($_GET['keywords']));
        $products_by_key = get_products('search_by_keyword='.$keywords);
        if(!$products_by_key){
            $keywords = $_GET['keywords'];
        }

    }
}

$searchType = '';
if (isset($_GET['search-type'])) {
    $searchType = htmlspecialchars($_GET['search-type']);
}
$products = count(get_products('search_by_keyword='.$keywords) ?? []);
if(@$_REQUEST['category_list']=='ean' || @$_REQUEST['category_list']=='sku'){
    $posts = 0;
}else{
    $posts = count((array)get_posts(['search_by_keyword' => $keywords,'is_rss'=>0]));
}

if(@$_REQUEST['category_list']=='ean'){
    $products = count(get_products('ean='.$keywords) ?? []);
}elseif(@$_REQUEST['category_list']=='sku'){
    $products = count(get_products('sku='.$keywords) ?? []);
}else{
    $products = count(get_products('search_by_keyword='.$keywords) ?? []);
}
?>
<?php if ($searchType == 'blog' OR $searchType == ''): ?>
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="m-auto allow-drop" style="max-width: 800px;">
                        <?php if($posts == 0 && $products == 0){
                            ?>
                            <h1 class="hr edit" field="search_header_empty" rel="content"><?php _e('No Results found'); ?><span class="text-primary">.</span></h1>
                            <?php
                        }else{ ?>
                            <h1 class="hr edit" field="search_header" rel="content"><?php _e('Results found'); ?><span class="text-primary">.</span></h1>
                            <?php
                        } ?>
                        <p class="lead"><em><?php _e('Keyword'); ?></em> &ldquo;<?php print $keywords; ?>&rdquo;</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section>
    <div class="container">
        <?php if ($searchType == 'blog' OR $searchType == ''): ?>
            <?php if(Config::get('custom.search_hit')==1){
                if($products != 0){?>
                    <div class="shop-search-wrapper">
                        <div class="shop-search-wrapper-header edit" field="search_product_header" rel="content" >
                            <h2 class="" style="margin-bottom:20px">Products</h2>
                        </div>
                        <module type="shop/products"
                                limit="18"
                            <?php if($_REQUEST['category_list']=='ean'){ ?>
                                ean="<?php print $keywords; ?>"
                            <?php }elseif($_REQUEST['category_list']=='sku'){ ?>
                                sku="<?php print $keywords; ?>"
                            <?php }else{ ?>
                                keyword="<?php print $keywords; ?>"
                            <?php } ?>
                                description-length="70"/>
                    </div>
                <?php }
                if($posts != 0){ ?>
                    <div class="shop-search-wrapper">
                        <div class="blog-search-wrapper-header edit" field="search_blog_header" rel="content" >
                            <h2 class="" style="margin-bottom:20px">Blog</h2>
                        </div>
                        <module type="posts" limit="18" keyword="<?php print $keywords; ?>" description-length="70"/>
                    </div>
                <?php }
            }else{
                if($posts != 0){?>
                    <div class="shop-search-wrapper">
                        <div class="blog-search-wrapper-header edit" field="search_blog_header" rel="content" >
                            <h2 class="" style="margin-bottom:20px">Blog</h2>
                        </div>
                        <module type="posts" limit="18" keyword="<?php print $keywords; ?>" description-length="70"/>
                    </div>
                <?php }
                if($products != 0){ ?>
                    <div class="shop-search-wrapper">
                        <div class="shop-search-wrapper-header edit" field="search_product_header" rel="content" >
                            <h2 class="" style="margin-bottom:20px">Products</h2>
                        </div>
                        <module type="shop/products"
                                limit="18"
                            <?php if(@$_REQUEST['category_list']=='ean'){ ?>
                                ean="<?php print $keywords; ?>"
                            <?php }elseif(@$_REQUEST['category_list']=='sku'){ ?>
                                sku="<?php print $keywords; ?>"
                            <?php }else{ ?>
                                keyword="<?php print $keywords; ?>"
                            <?php } ?>
                                description-length="70"/>
                    </div>
                <?php }
            } ?>
        <?php endif; ?>
    </div>
</section>


<?php include template_dir() . "footer.php"; ?>
