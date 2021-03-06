<?php get_header(); ?>
		<?php get_template_part( 'template-parts/content', 'index-menu' ); ?>
		<div class="fill-all">

			<section class="container category-fill-top">
				<div class="category-meta">
					<?php echo category_description( $category );?>
				</div>
			</section>
			<section class="container category-top">
				<!--        --><?php //get_template_part( 'template-parts/content', 'time' ); ?>
				<div class="main container">
					<div class="primary-wrap">
						<div class="layout-primary">
							<?php
							$cat = get_the_category();
							$cat_id = $cat[0]->cat_ID;
//							query_posts('order=date&cat=' . $cat_id );
							if (have_posts()):query_posts('showposts=10&cat=' . $cat_id);
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
					<?php //get_template_part( 'template-parts/widget', 'weibo' ); ?>
						<div class="widget">
							<h3 class="heading-title">热门文章</h3>
							<ul class="hot-article-item">
								<?php echo get_most_reply_post(); ?>
							</ul>
						</div>
					</div>
				</div>
			</section>
		</div>
<?php get_footer(); ?>