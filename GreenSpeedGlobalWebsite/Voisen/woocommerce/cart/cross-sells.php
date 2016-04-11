<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $voisen_opt;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

//$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );
$woocommerce_loop['columns'] = 1; //apply for carousel work
if ( $products->have_posts() ) : ?>

	<div class="cross-sells">

		<h3 class="widget-title">
			<span>
				<?php if (!empty($voisen_opt['crosssells_title'])){ ?>
					<?php echo esc_html($voisen_opt['crosssells_title']); ?>
				<?php }else{ ?>
					<?php esc_html_e( 'You may be interested in&hellip;', 'voisen' ) ?>
				<?php } ?>
			</span>
		</h3>

		<?php woocommerce_product_loop_start(); ?>
			<div data-owl="slide" data-item-slide="2" data-margin="20" data-mobile="1" data-tablet="2" data-ow-rtl="false" class="owl-carousel owl-theme cross-sells-slide">
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>
			</div>
		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_query();
