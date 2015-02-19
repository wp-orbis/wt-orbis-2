					<footer id="footer">
						<?php

						printf( __( '&copy; %1$s %2$s. WordPress theme by <a href="%3$s">Pronamic</a>.', 'orbis' ),
							date( 'Y' ),
							get_bloginfo( 'site-title' ),
							'http://pronamic.nl/'
						);

						?>
					</footer>
				</div>
			</div>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>