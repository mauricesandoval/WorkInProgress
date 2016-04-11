<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<?php
global $voisen_opt, $voisen_shopclass, $wp_query, $woocommerce_loop;

$shoplayout = 'sidebar';
if(isset($voisen_opt['shop_layout']) && $voisen_opt['shop_layout']!=''){
	$shoplayout = $voisen_opt['shop_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$shoplayout = $_GET['layout'];
}
$shopsidebar = 'left';
if(isset($voisen_opt['sidebarshop_pos']) && $voisen_opt['sidebarshop_pos']!=''){
	$shopsidebar = $voisen_opt['sidebarshop_pos'];
}
if(isset($_GET['side']) && $_GET['side']!=''){
	$shopsidebar = $_GET['side'];
}
switch($shoplayout) {
	case 'fullwidth':
		$voisen_shopclass = 'shop-fullwidth';
		$shopcolclass = 12;
		$shopsidebar = 'none';
		$productcols = 4;
		break;
	default:
		$voisen_shopclass = 'shop-sidebar';
		$shopcolclass = 9;
		$productcols = 3;
}

$voisen_viewmode = 'grid-view';
if(isset($voisen_opt['default_view'])) {
	if($voisen_opt['default_view']=='list-view'){
		$voisen_viewmode = 'list-view';
	}
}
if(isset($_GET['view']) && $_GET['view']=='list-view'){
	$voisen_viewmode = $_GET['view'];
}
?>
<div class="main-container">
	<div class="page-content">
		<div class="container">
			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
			?>
		</div>
		<div class="shop_content">
				<div class="category-desc <?php echo esc_attr($shoplayout);?>">
					<?php do_action( 'woocommerce_archive_description' ); ?>
				</div>
				<div class="row">
					<?php if( $shopsidebar == 'left' ) :?>
						<?php get_sidebar('shop'); ?>
					<?php endif; ?>
					<div id="archive-product" class="col-xs-12 <?php echo 'col-md-'.$shopcolclass; ?>">
						
						<div class="archive-border">
							<?php if ( have_posts() ) : ?>
								
								<?php
									/**
									* remove message from 'woocommerce_before_shop_loop' and show here
									*/
									do_action( 'woocommerce_show_message' );
								?>
								<div class="shop-products products">
									<?php woocommerce_product_subcategories();
									//reset loop
									$woocommerce_loop['loop'] = 0; ?>
								</div>
								
								<div class="toolbar">
									<div class="view-mode">
										<label><?php esc_html_e('View on', 'voisen');?></label>
										<a href="javascript:void(0)" class="grid <?php if($voisen_viewmode=='grid-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'Grid', 'voisen' ); ?>"><i class="fa fa-th"></i></a>
										<a href="javascript:void(0)" class="list <?php if($voisen_viewmode=='list-view'){ echo ' active';} ?>" title="<?php echo esc_attr__( 'List', 'voisen' ); ?>"><i class="fa fa-th-list"></i></a>
									</div>
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 *
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 */
										do_action( 'woocommerce_before_shop_loop' );
									?>
									<div class="clearfix"></div>
								</div>
							<?php endif; ?>	
								
							<?php if ( have_posts() ) : ?>	
							
								<?php //woocommerce_product_loop_start(); ?>
								<div class="shop-products products row <?php echo esc_attr($voisen_viewmode);?> <?php echo esc_attr($shoplayout);?>">
									
									<?php $woocommerce_loop['columns'] = $productcols; ?>
									
									<?php while ( have_posts() ) : the_post(); ?>

										<?php wc_get_template_part( 'content', 'product-archive' ); ?>

									<?php endwhile; // end of the loop. ?>
								</div>
								<?php //woocommerce_product_loop_end(); ?>
								
								<div class="toolbar tb-bottom">
									<?php
										/**
										 * woocommerce_before_shop_loop hook
										 *
										 * @hooked woocommerce_result_count - 20
										 * @hooked woocommerce_catalog_ordering - 30
										 */
										do_action( 'woocommerce_after_shop_loop' );
										//do_action( 'woocommerce_before_shop_loop' );
									?>
									<div class="clearfix"></div>
								</div>
								
							<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

								<?php wc_get_template( 'loop/no-products-found.php' ); ?>

							<?php endif; ?>
						</div>
					</div>
					<?php if($shopsidebar == 'right') :?>
						<?php get_sidebar('shop'); ?>
					<?php endif; ?>
				</div>
				<?php 
					echo do_shortcode( '[ourbrands rows="1" colsnumber="6" style="carousel"]' );
				?>
		</div>
	</div>
</div>
<?php get_footer( 'shop' ); ?>