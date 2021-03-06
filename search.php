<?php get_header(); ?>
	<section class="primary">
		<?php get_template_part( 'template-parts/content', 'index-menu' ); ?>
		<div class="fill-top"></div>
		<section class="container fill-all">
			<div class="main container">
				<div class="primary-wrap">
					<div class="layout-primary">
                        <div class="search-result">搜索 <strong><?php the_search_query(); ?></strong> 的文章</div>
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
							echo '<p style="color:#ddd;cursor:default;">没有文章</p>';
						endif;
						?>
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
		<div class="pagenavi">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div>
	</section>
<?php get_footer(); ?>