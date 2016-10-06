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
	</section>
<?php endwhile; endif; ?>
	<?php get_template_part( 'template-parts/content', 'about-me' ); ?>
	<section class="comment-wrap">
		<?php comments_template(); ?>
	</section>
<?php get_footer();