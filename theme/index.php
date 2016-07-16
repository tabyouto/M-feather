<?php get_header(); ?>
	<section class="primary">
		<?php get_template_part( 'template-parts/content', 'menu' ); ?>
		<div class="post-content-wrap">
			<?php
				if (have_posts()): 
					while (have_posts()) : the_post(); ?>
					<article class="article-item">
						<h2 class="article-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="post-time"><?php the_time('Y-m-d' ); ?></div>
						<?php if( is_sticky() ): ?>  
							<i class="sticky-mark"></i>
						<?php endif; ?>
						<div class="entry-summary">
							<?php if(catch_first_image()!==""): ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><img src="<?php echo catch_first_image() ?>" alt="<?php the_title(); ?>" class="archive-thumbnail featured"></a>
							<?php endif; ?>
							<?php the_excerpt();?>					
							<!-- <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Continue Reading →</a> -->
						</div>
						<footer class="entry-meta">
							<?php hacker_entry_footer(); ?>
						</footer>
					</article>
			<?php
					endwhile;
				else: 
					echo "<p>没有文章</p>";
				endif;
			?>
		</div>
		<div class="pagenavi">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
	</section>
<?php get_footer(); ?>