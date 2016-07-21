<!--文章内页导航-->

<header class="article-header">
	<h1 class="logo">
		<a href="http://tabyouto.com" title="front end web developer site"></a>
	</h1>
	<div class="navto-search">
		<a href=""><i class="iconfont">&#xe600;</i></a>
	</div>
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
<!--		<li class="current"><a href="">wordpress</a></li>-->
<!--		<li><a href="">前端</a></li>-->
<!--		<li><a href="">life</a></li>-->
	</ul>
</div>