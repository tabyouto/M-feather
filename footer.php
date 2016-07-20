	<div class="index-footer"></div>
	<footer class="footer">
		<p class="footer-site-name">Just Now</p>
		<p> 
			<?php 
				printf( esc_html__( '&#169;2012-2016 All rights reserved %s', 'tabyouto' ), 
					'<a href="'. esc_url('http://tabyouto.com/') .'" target="_blank">Tabyouto</a>' 
				);
			?>
		</p>
		<p class="wp">
			<?php 
				printf( esc_html__( 'Powered by %s', 'hacker' ), 
					'<a href="'. esc_url('https://wordpress.org/') .'" target="_blank">WordPress</a>' 
				);
			?>
			<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/"><img alt="知识共享许可协议" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/3.0/80x15.png" /></a>
	</footer>
<?php wp_footer(); ?>
</body>
</html>