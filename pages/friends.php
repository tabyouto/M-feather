<?php
/**
 *
 * Template Name: 友情链接
 * 
 */

get_header(); ?>

	<section class="primary">
		<?php get_template_part( 'template-parts/content', 'menu' ); ?>
		<article class="post-content friends-link">
			<?php if( have_posts() ): while ( have_posts() ): the_post(); ?>
				<h2 class="post-title"><?php the_title(); elegent_posted_on(); ?></h2>
				<ul>
					<?php  wp_list_bookmarks(); ?>
				</ul>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</article>
	</section>
	<section class="about-me">
		<?php echo get_avatar( get_the_author_meta('ID'), 100); ?>
		<div class="my-word">
			<h3 class="my-title"><?php echo get_the_author(); ?></h3>
			<p>一步一步走，相信那一天会到来~</p>
		</div>
	</section>
	<section class="comment-wrap">
		<?php comments_template(); ?>
	</section>
<?php
get_footer();