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
	<?php wp_footer(); ?>
</body>
</html>