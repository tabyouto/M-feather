<header class="site-header">
	<h1 class="site-name"><a href="<?php echo home_url(); ?>"><?php bloginfo('name');?></a></h1>
</header>
<div class="index-menu">
	<ul>
		<li class="<?php if(is_home()||is_single()||is_404()) echo "current-menu-item"; ?>"><a href="<?php echo home_url(); ?>">首页</a></li>
		<?php wp_nav_menu(
			array(
				'theme_location' => 'second',
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