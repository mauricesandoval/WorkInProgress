<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $voisen_opt, $voisen_productsfound;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
if($woocommerce_loop['columns'] > 1){
	$voisen_opt['product_per_row'] = $woocommerce_loop['columns'];
	$colwidth = round(12/$woocommerce_loop['columns']);
	$classes[] = ' item-col col-xs-12 col-sm-'.$colwidth;
}
if ( ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] ) && ( $woocommerce_loop['columns'] >= 2 ) ) {
	if( $voisen_opt['product_per_row'] != 1 ){
		echo '<div class="group">';
	}
} ?>
<div <?php post_class( $classes ); ?>>
	<div class="product-wrapper">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
		<div class="list-col4 <?php if($voisen_opt['default_view']=='list-view'){ echo ' col-xs-12 col-sm-4';} ?>">
			<div class="product-image">
			
				<?php if ( $product->is_on_sale() ) : ?>
					<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale"><span class="sale-bg"></span><span class="sale-text">' . esc_html__( 'Sale', 'voisen' ) . '</span></span>', $post, $product ); ?>
				<?php endif; ?>
						
				<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
					<?php 
					echo ''.$product->get_image('shop_catalog', array('class'=>'primary_image'));
					
					if(isset($voisen_opt['second_image'])){
						if($voisen_opt['second_image']){
							$attachment_ids = $product->get_gallery_attachment_ids();
							if ( $attachment_ids ) {
								echo wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), false, array('class'=>'secondary_image') );
							}
						}
					}
					?>
					<span class="shadow"></span>
				</a>
				<div class="quickviewbtn">
					<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php esc_html_e('Quick View', 'voisen');?></a>
				</div>
				<div class="actions">
					<ul class="add-to-links clearfix">
						<li>
							<?php echo do_shortcode('[add_to_cart id="'.$product->id.'"]') ?>
						</li>

						<li>	
							<?php if ( class_exists( 'YITH_WCWL' ) ) {
								echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
							} ?>
						</li>
						<li>
							<?php if( class_exists( 'YITH_Woocompare' ) ) {
							echo do_shortcode('[yith_compare_button]');
							} ?>
						</li>
					</ul>

				</div>
				
			</div>
		</div>
		<div class="list-col8 <?php if($voisen_opt['default_view']=='list-view'){ echo ' col-xs-12 col-sm-8';} ?>">
			<div class="gridview">
				<h2 class="product-name">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<div class="ratings"><?php echo ''.$product->get_rating_html(); ?></div>
				<div class="price-box"><?php echo ''.$product->get_price_html(); ?></div>

			</div>
		</div>
	</div>
</div>
<?php if ( ( ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] || $voisen_productsfound == $woocommerce_loop['loop'] ) && $woocommerce_loop['columns'] >= 2 )  ) {
	if( $voisen_opt['product_per_row'] != 1 ){
		echo '</div>';
	}
} ?>
