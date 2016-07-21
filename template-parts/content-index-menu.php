<!--首页内页导航-->

<header class="header">
	<h1 class="logo">
		<a href="http://tabyouto.com" title="front end web developer site"></a>
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
<!--			<li class="current-menu-item"><a href="">分类</a></li>-->
<!--			<li><a href="">书单</a></li>-->
<!--			<li><a href="">关于</a></li>-->
		</ul>
	</div>
	<div class="navto-search">
		<?php get_search_form( ); ?>
<!--		<a href=""><i class="iconfont">&#xe600;</i></a>-->
	</div>
</header>