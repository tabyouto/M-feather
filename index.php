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
                                            alt="<?php the_title(); ?>"
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
                        <li>
                            <div class="hot-article-thumb"><img src="https://static.fatesinger.com/2016/03/mp1vwq4unxkcz89e.jpg!avatar" alt=""></div>
                            <div class="list-item-info">
                                <h4><a href="https://fatesinger.com/74369">WordPress 插件网易云音乐</a></h4>
                                <p class="list-itemDescription">264 則留言, 23 個喜歡</p>
                            </div>
                        </li>
                        <li>
                            <div class="hot-article-thumb"><img src="https://static.fatesinger.com/2016/03/mp1vwq4unxkcz89e.jpg!avatar" alt=""></div>
                            <div class="list-item-info">
                                <h4><a href="https://fatesinger.com/74369">WordPress 插件网易云音乐</a></h4>
                                <p class="list-itemDescription">264 則留言, 23 個喜歡</p>
                            </div>
                        </li>
                        <li>
                            <div class="hot-article-thumb"><img src="https://static.fatesinger.com/2016/03/mp1vwq4unxkcz89e.jpg!avatar" alt=""></div>
                            <div class="list-item-info">
                                <h4><a href="https://fatesinger.com/74369">WordPress 插件网易云音乐</a></h4>
                                <p class="list-itemDescription">264 則留言, 23 個喜歡</p>
                            </div>
                        </li>
                        <li>
                            <div class="hot-article-thumb"><img src="https://static.fatesinger.com/2016/03/mp1vwq4unxkcz89e.jpg!avatar" alt=""></div>
                            <div class="list-item-info">
                                <h4><a href="https://fatesinger.com/74369">WordPress 插件网易云音乐</a></h4>
                                <p class="list-itemDescription">264 則留言, 23 個喜歡</p>
                            </div>
                        </li>
                        <li>
                            <div class="hot-article-thumb"><img src="https://static.fatesinger.com/2016/03/mp1vwq4unxkcz89e.jpg!avatar" alt=""></div>
                            <div class="list-item-info">
                                <h4><a href="https://fatesinger.com/74369">WordPress 插件网易云音乐</a></h4>
                                <p class="list-itemDescription">264 則留言, 23 個喜歡</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>