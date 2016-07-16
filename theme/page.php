<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 */

get_header(); ?>

	<section class="primary">
		<?php get_template_part( 'template-parts/content', 'menu' ); ?>
		<article class="post-content">
			<?php if( have_posts() ): while ( have_posts() ): the_post(); ?>
				<h2 class="post-title"><?php the_title(); elegent_posted_on(); ?></h2>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</article>
	</section>
	<?php get_template_part( 'template-parts/content', 'about-me' ); ?>
	<section class="comment-wrap">
		<?php comments_template(); ?>
	</section>
<?php
get_footer();