<?php

/*

type: layout

name: Default

description: Default


*/

?>


<style>
.blog-breadcrumb {
    position: relative;
}

.blog-breadcrumb .overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    left: 0;
    right: 0;
    background-color: #005c47b6;
    z-index: 15;
}
</style>

<?php if (isset($data) and is_array($data)): ?>
<nav aria-label="breadcrumb" class='blog-breadcrumb edit' field="layout-inner-module<?php print $params['id'] ?>"
    rel="content">
    <div class="overlay"></div>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php print  $homepage['url']; ?>"><?php print $homepage['title']; ?></a>
        </li>

        <?php foreach ($data as $item): ?>
        <?php if (!($item['is_active'])): ?>
        <li class="breadcrumb-item"><a href="<?php print($item['url']); ?>"><?php print($item['title']); ?></a></li>
        <?php else: ?>
        <li class="breadcrumb-item active" aria-current="page"><?php print($item['title']); ?></li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>