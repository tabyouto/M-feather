<?php get_header(); ?>
<?php get_template_part( 'template-parts/content', 'index-menu' ); ?>
    <section class="container fill-top">
<!--        --><?php //get_template_part( 'template-parts/content', 'time' ); ?>
        <div class="main container">
            <div class="primary-wrap">
                <div class="layout-primary">
                    <h3>最新文章</h3>
                    <?php
                        if (have_posts()):
                        while (have_posts()) : the_post(); ?>
                            <article class="layout-primary-list">
                                <?php if(catch_first_image()!==""): ?>
                                    <a
                                        href="<?php the_permalink();  ?>"
                                        title="<?php the_title(); ?>"
                                        class="article-thumbnails">
                                        <img
                                            data-original="<?php echo catch_first_image() ?>"
                                            data-original-height='10px'
                                            data-original-width='10px'
                                            alt="<?php the_title(); ?>"
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/images/loading.jpg"
                                            style="width: 140px;height: 120px;">
                                    </a>
                                <?php endif; ?>
                                <h2 class="block-title">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="block-content">
                                    <?php the_excerpt();?>
                                </div>
                                <div class="block-post-meta">
                                    <time><?php echo date('M',get_the_time('U')).' '.get_the_time(' jS Y'); ?></time>
                                    <span class="middle-dot"></span>
                                    <?php if(function_exists('the_views')){ the_views();} ?> reads
                                </div>
                            </article>
                            <?php
                        endwhile;
                    else:
                        echo "<p>没有文章</p>";
                    endif;
                    ?>
                </div>
                <div class="layout-primary pagenavi">
                    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
                </div>
            </div>
            <div class="layout-second">
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
                <div class="widget">
                    <h3 class="heading-title">热门文章</h3>
                    <ul class="hot-article-item">
                        <?php echo get_most_reply_post(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>