<!--文章内页导航-->

<header class="article-header">
	<h1 class="logo">
		<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"></a>
	</h1>
</header>
<div class="article-nav container">
	<ul>
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