<?php
/**
 * Template for dispalying single post (read full post page).
 * 
 * @package voisen
 */

get_header();

/**
 * determine main column size from actived sidebar
 */
$voisen_opt = get_option( 'voisen_opt' );
?>
<div id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php voisen_breadcrumb(); ?>
			</div>
			<?php if($voisen_opt['sidebarblog_pos']=='left') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
				<div class="col-xs-12 <?php if ( is_active_sidebar( 'blog' ) ) : ?>col-md-9<?php endif; ?> content-area" id="main-column">
					<main id="main" class="site-main single-post-content">
						<?php 
						while (have_posts()) {
							the_post();
							voisen_set_post_view(get_the_ID());
							get_template_part('content', get_post_format());

							echo "\n\n";
							
							voisen_bootstrap_pagination();

							echo "\n\n";
							
							// If comments are open or we have at least one comment, load up the comment template
							if (comments_open() || '0' != get_comments_number()) {
								comments_template();
							}

							echo "\n\n";

						} //endwhile;
						?> 
					</main>
				</div>
			<?php if($voisen_opt['sidebarblog_pos']=='right') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?> 