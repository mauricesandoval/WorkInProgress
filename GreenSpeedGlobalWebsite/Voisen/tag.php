<?php
/**
 * The template for displaying Tag pages
 *
 * @package WordPress
 * @subpackage Voisen_theme
 * @since Voisen Themes 1.0
 */

get_header();
$voisen_opt = get_option( 'voisen_opt' );
?>
<div class="main-container page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php voisen_breadcrumb(); ?>
			</div>
			<?php if($voisen_opt['sidebarblog_pos']=='left') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
			<div class="col-xs-12 <?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>col-md-9<?php endif; ?>">
				<div class="page-content blog-page">
					<?php if ( have_posts() ) : ?>
						<header class="archive-header">
							<h1 class="archive-title"><?php printf( esc_html__( 'Tag Archives: %s', 'voisen' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

						<?php if ( tag_description() ) : // Show an optional tag description ?>
							<div class="archive-meta"><?php echo tag_description(); ?></div>
						<?php endif; ?>
						</header><!-- .archive-header -->

						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * this in a child theme then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

						endwhile;
						?>
						
						<div class="pagination">
							<?php voisen_bootstrap_pagination(); ?>
						</div>
						
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php if($voisen_opt['sidebarblog_pos']=='right') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
		</div>
		
	</div>
</div>
<?php get_footer(); ?>