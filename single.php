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
            <span class="post-like">
                <a href="javascript:;" class="js-rating <?php if(isset($_COOKIE['specs_zan_'.$post->ID])) echo 'is-active';?>" data-action="ding" data-id="<?php the_ID(); ?>">
                    <i class="icon-heart"></i>
                    <span class="js-count">
                        <?php if( get_post_meta($post->ID,'specs_zan',true) ){
                            echo get_post_meta($post->ID,'specs_zan',true);
                        } else {
                            echo '0';
                        }?>
                    </span>
                </a>
            </span>
            <span>
                <a href="#respond">
                <i class="icon-comments"></i>
                <span><?php echo comment_count($post->ID); ?></span></a>
            </span>
<!--            <div class="post-like">-->
<!--                <a href="javascript:;" data-action="ding" data-id="--><?php //the_ID(); ?><!--" class="specsZan --><?php //if(isset($_COOKIE['specs_zan_'.$post->ID])) echo 'done';?><!--">喜欢 <span class="count">-->
<!--            --><?php //if( get_post_meta($post->ID,'specs_zan',true) ){
//                echo get_post_meta($post->ID,'specs_zan',true);
//            } else {
//                echo '0';
//            }?><!--</span>-->
<!--                </a>-->
<!--            </div>-->
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
