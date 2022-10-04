<div class="img-holder right" style="background-image: url('<?php print thumbnail($slide['images'][0], 1920, 760); ?>');">
    <div class="container info-holder">
        <h1><?php echo $slide['primaryText']; ?></h1>
        <p><?php echo $slide['secondaryText']; ?></p>

        <?php if ($slide['seemoreText']): ?>
            <div class="button right m-t-20">
                <a class="btn btn-primary" href="<?php if (isset($slide['url'])) {
                    print $slide['url'];
                } ?>"><?php print $slide['seemoreText'] ?></a>
            </div>
        <?php endif; ?>
    </div>
</div>