<?php get_header(); ?>
	<section class="primary">
		<?php get_template_part( 'template-parts/content', 'menu' ); ?>
		<article class="post-content">
			<?php if( have_posts() ): while ( have_posts() ): the_post(); ?>
				<h2 class="post-title"><?php the_title(); elegent_posted_on(); ?></h2>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</article>
	</section>
	<section class="similarity">
		<ul>
			<?php joints_related_posts(); ?>
		</ul>
	</section>
	<?php get_template_part( 'template-parts/content', 'about-me' ); ?>
	<section class="comment-wrap">
		<?php comments_template(); ?>
	</section>
	<section class="ad">
		这里是ad
	</section>
<?php get_footer(); ?>
