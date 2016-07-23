<!--首页内页导航-->

<header class="header">
	<h1 class="logo">
		<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"></a>
	</h1>
	<div class="container">
		<ul>
			<?php wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container' => ' ',
					'menu_class' => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_id'         => '',
					'items_wrap'=>'%3$s'
				)
			); ?>
		</ul>
	</div>
	<div class="navto-search">
		<?php get_search_form( ); ?>
	</div>
</header>