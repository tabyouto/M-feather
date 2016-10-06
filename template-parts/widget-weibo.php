<div class="widget">
    <h3 class="heading-title">我的随语</h3>
    <ul>
        <?php
        require_once (ABSPATH . WPINC . '/class-feed.php');
        $feed = new SimplePie();
        $feed->set_feed_url('http://localhost/sinarss2.php?id=1737203591');
        $feed->set_cache_location($_SERVER['DOCUMENT_ROOT'] . '/wp-content/cache');
        $feed->set_file_class('WP_SimplePie_File');
        $feed->set_cache_duration(3600);
        $feed->init();
        $feed->handle_content_type();
        $items = $feed->get_items(0,8);
        foreach($items as $item) {
            echo '<li><a rel="nofollow" target="_blank" href="'.$item->get_link().'" >'.$item->get_description().'</a>'.'</li>';
        }
        ?>
    </ul>
    <ul class="weibo-item">
        <li><i class="weibo-icon"></i>想买鞋子，但是箱子装不下了。<span class="middle-dot"></span><span class="weibo-time">发布于19 hours前</span></li>
        <li><i class="weibo-icon"></i>想买鞋子，但是箱子装不下了。<span class="middle-dot"></span><span class="weibo-time">发布于19 hours前</span></li>
        <li><i class="weibo-icon"></i>想买鞋子，但是箱子装不下了。<span class="middle-dot"></span><span class="weibo-time">发布于19 hours前</span></li>
        <li><i class="weibo-icon"></i>想买鞋子，但是箱子装不下了。<span class="middle-dot"></span><span class="weibo-time">发布于19 hours前</span></li>
    </ul>
</div>