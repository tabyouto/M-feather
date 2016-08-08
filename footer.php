	<footer class="footer">
		<div class="footer-wrap container">
			<div class="rights-wrap">
				<?php
				printf( esc_html__( '&#169;2012-2016 All rights reserved %s', 'tabyouto' ),
					'<a href="'. esc_url('http://tabyouto.com/') .'" target="_blank">Tabyouto</a>'
				);
				?>
			</div>
		</div>
	</footer>
	<div class="back-to-top">
        <a href="javascript:;">
            <i class="iconfont">&#xe601;</i>
        </a>
    </div>
	<?php
	printf('This page loaded in %1$s seconds with %2$s database queries.', timer_stop(0,3), get_num_queries());
	?>
	<?php wp_footer(); ?>
</body>
</html>