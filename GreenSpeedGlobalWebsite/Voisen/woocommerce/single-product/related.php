<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $voisen_opt;
$posts_per_page = ($voisen_opt['related_amount']) ? $voisen_opt['related_amount'] : 4; 

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = 1;

if ( $products->have_posts() ) :
?>
<div class="widget related_products_widget related products">
	<h3 class="widget-title"><span><?php echo esc_html($voisen_opt['related_title']); ?></span></h3>
	
	
		<?php woocommerce_product_loop_start(); ?>
			<div data-owl="slide" data-desksmall="3" data-tablet="2" data-mobile="1" data-tabletsmall="2" data-item-slide="4" data-margin="30" data-ow-rtl="false" class="owl-carousel owl-theme products-slide">
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>
			</div>
		<?php woocommerce_product_loop_end(); ?>
	
</div>

<?php endif;

wp_reset_postdata();
