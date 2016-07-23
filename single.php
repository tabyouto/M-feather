<?php get_header(); ?>
<?php get_template_part( 'template-parts/content', 'article-menu' ); ?>
<section class="article-wrap container">
    <?php if( have_posts() ): while ( have_posts() ): the_post(); ?>
        <header class="entry-header">
            <h2 class="entry-title"><?php the_title(); elegent_posted_on(); ?></h2>
            <div class="entry-meta">
                <time><?php echo date('M',get_the_time('U')).' '.get_the_time(' jS Y'); ?></time>
                <span class="middle-dot"></span>
                <span class="views"><?php if(function_exists('the_views')){ the_views();} ?> reads</span>
            </div>
        </header>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; endif; ?>
    <div class="Article__meta">
            <span>
                <a href="#" class="js-rating">
                    <i class="icon-heart"></i>
                    <span class="js-count">0</span>
                </a>
            </span>
        <span>
                <a href="#respond">
                <i class="icon-comments"></i>
                <span><?php echo comment_count($post->ID); ?></span></a>
            </span>
    </div>
</section>
<?php get_template_part( 'template-parts/content', 'about-me' ); ?>
<section class="article-wrap similarity-wrap">
    <h3>Related Posts</h3>
    <div class="similarity ">
        <ul>
            <?php joints_related_posts(); ?>
        </ul>
    </div>
</section>
<section class="comment-wrap">
    <?php comments_template(); ?>
</section>
<?php get_footer(); ?>
