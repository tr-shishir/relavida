<div class="events">
    <?php if (!empty($data)): ?>
        <?php
            $title_character_limit = 200;
            if(is_array($show_fields) && in_array('title', $show_fields)){
                $character_limit_of_title = get_option('data-title-limit', $params['id']);
                if(!empty($character_limit_of_title)){
                    $title_character_limit = $character_limit_of_title;
                }
            }
        ?>
        <?php foreach ($data as $key => $item): ?>
            <?php
            $item = (array)$item;
            $post_time = strtotime(($item['created_at']));
            $current_time = strtotime((date("Y-m-d H:i:s")));
            if ($post_time <= $current_time) :
            ?>
            <?php
            $itemData = content_data($item['content_id']);
            $itemTags = content_tags($item['content_id']);
            ?>

            <div class="event">
                <?php if (!isset($show_fields) or $show_fields == false or in_array('thumbnail', $show_fields)): ?>
                    <div class="image">
                        <a href="<?php print $item['link'] ?>" itemprop="url">
                            <img src="<?php print thumbnail($item['image'], 140, 140, true); ?>"/>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="info">
                    <?php $blog_titile =  character_limiter($item['title'], $title_character_limit); ?>
                    <h5><?php print $blog_titile; ?></h5>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
