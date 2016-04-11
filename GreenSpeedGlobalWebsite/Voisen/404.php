<?php get_header(); ?> 

	<div class="page-404">
		<div class="container text-center">
			<article>
				<h1><?php esc_html_e('404', 'voisen'); ?></h1>
				<h2 class="page-title"><?php esc_html_e('Oops! Page Not Found.', 'voisen'); ?></h2>
				<div class="page-content">
					<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'voisen'); ?></p>

					<?php get_search_form(); ?>

				</div>
			</article>
		</div>

	</div>
	

<?php get_footer(); ?> 