<?php
/**
 * Displaying archive page (category, tag, archives post, author's post)
 *
 * @package WordPress
 * @subpackage Voisen_theme
 * @since Voisen Themes 1.0
 */

get_header(); 

/**
 * determine main column size from actived sidebar
 */
$voisen_opt = get_option( 'voisen_opt' );

$bloglayout = 'nosidebar';
if(isset($voisen_opt['blog_layout']) && $voisen_opt['blog_layout']!=''){
	$bloglayout = $voisen_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$bloglayout = $_GET['layout'];
}
$blogsidebar = 'right';
if(isset($voisen_opt['sidebarblog_pos']) && $voisen_opt['sidebarblog_pos']!=''){
	$blogsidebar = $voisen_opt['sidebarblog_pos'];
}

switch($bloglayout) {
	case 'sidebar':
		$blogclass = 'blog-sidebar';
		$blogcolclass = 9;
		$voisen_postthumb = 'sozo-category-thumb'; //750x510px
		break;
	default:
		$blogclass = 'blog-nosidebar';
		$blogcolclass = 12;
		$blogsidebar = 'none';
		$voisen_postthumb = 'sozo-post-thumb'; //500x500px
}
if(isset($_GET['side']) && $_GET['side']!=''){
	$blogsidebar = $_GET['side'];
	$blogcolclass = 9;
}
?> 
<div id="main-content">
	<div class="container">
		<header class="entry-header">
			<div class="container">
				<h1 class="entry-title"><?php if(isset($voisen_opt)) { echo esc_html($voisen_opt['blog_header_text']); } else { esc_html_e('Blog', 'voisen');}  ?></h1>
			</div>
		</header>
		<div class="row">
			<div class="col-xs-12">
				<?php voisen_breadcrumb(); ?>
			</div>
			<?php if($blogsidebar == 'left') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
				<div class="col-xs-12 <?php echo 'col-md-'.$blogcolclass; ?>" id="main-column">
					<main id="main" class="blog-page site-main">
						<?php if (have_posts()) { ?> 

						<header class="page-header">
							<h1 class="page-title">
								<?php
								if (is_category()) :
									single_cat_title();

								elseif (is_tag()) :
									single_tag_title();

								elseif (is_author()) :
									/* Queue the first post, that way we know
									 * what author we're dealing with (if that is the case).
									 */
									the_post();
									printf(esc_html__('Author: %s', 'voisen'), '<span class="vcard">' . get_the_author() . '</span>');
									/* Since we called the_post() above, we need to
									 * rewind the loop back to the beginning that way
									 * we can run the loop properly, in full.
									 */
									rewind_posts();

								elseif (is_day()) :
									printf(esc_html__('Day: %s', 'voisen'), '<span>' . get_the_date() . '</span>');

								elseif (is_month()) :
									printf(esc_html__('Month: %s', 'voisen'), '<span>' . get_the_date(esc_html__('F Y', 'voisen')) . '</span>');

								elseif (is_year()) :
									printf(esc_html__('Year: %s', 'voisen'), '<span>' . get_the_date(esc_html__('Y', 'voisen')) . '</span>');

								elseif (is_tax('post_format', 'post-format-aside')) :
									esc_html_e('Asides', 'voisen');

								elseif (is_tax('post_format', 'post-format-image')) :
									esc_html_e('Images', 'voisen');

								elseif (is_tax('post_format', 'post-format-video')) :
									esc_html_e('Videos', 'voisen');

								elseif (is_tax('post_format', 'post-format-quote')) :
									esc_html_e('Quotes', 'voisen');

								elseif (is_tax('post_format', 'post-format-link')) :
									esc_html_e('Links', 'voisen');

								else :
									esc_html_e('Archives', 'voisen');

								endif;
								?> 
							</h1>
							
							<?php
							// Show an optional term description.
							$term_description = term_description();
							if (!empty($term_description)) {
								printf('<div class="taxonomy-description">%s</div>', $term_description);
							} //endif;
							?>
						</header><!-- .page-header -->
						
						<?php 
						/* Start the Loop */
						while (have_posts()) {
							the_post();

							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part('content', get_post_format());
						} //endwhile; 
						?> 

						<?php voisen_bootstrap_pagination(); ?> 

						<?php } else { ?> 

						<?php get_template_part('no-results', 'archive'); ?> 

						<?php } //endif; ?> 
					</main>
				</div>
			<?php if($blogsidebar == 'right') :?>
				<?php get_sidebar('blog'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?> 