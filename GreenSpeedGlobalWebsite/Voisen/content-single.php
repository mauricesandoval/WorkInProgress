<?php
/**
 * The template for displaying post detail
 *
 * @package WordPress
 * @subpackage Voisen_theme
 * @since Voisen Themes 1.0
 */
?>
<?php
$voisen_opt = get_option( 'voisen_opt' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta">
			<?php voisen_bootstrap_post_on(); ?> 
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?> 
		<div class="clearfix"></div>
		<?php
		/**
		 * This wp_link_pages option adapt to use bootstrap pagination style.
		 * The other part of this pager is in inc/template-tags.php function name voisen_bootstrap_link_pages_link() which is called by wp_link_pages_link filter.
		 */
		wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__('Pages:', 'voisen') . ' <ul class="pagination">',
			'after'  => '</ul></div>',
			'separator' => ''
		));
		?> 
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list(esc_html__(', ', 'voisen'));

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list('', esc_html__(', ', 'voisen'));
			
			echo voisen_bootstrap_categories_list($category_list);
			if ($tag_list) {
				echo ' ';
				echo voisen_bootstrap_tags_list($tag_list);
			}
			echo ' ';
			printf(wp_kses(__('<span class="glyphicon glyphicon-link"></span> <a href="%1$s" title="Permalink to %2$s" rel="bookmark">permalink</a>.', 'voisen'), array('span', 'a')), get_permalink(), the_title_attribute('echo=0'));
		?> 

		<?php voisen_bootstrap_edit_post_link(); ?> 
	</footer><!-- .entry-meta -->
</article><!-- #post -->