<?php
//WooCommerce Hook

//add brands after product detail page
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
add_action( 'woocommerce_after_single_product', 'voisen_ourbrands', 100 );
add_action( 'woocommerce_archive_description', 'voisen_woocommerce_category_image', 2 );
// Add image to category description
function voisen_woocommerce_category_image() {
	if ( is_product_category() ){
		global $wp_query;
		
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		
		if ( $image ) {
			echo '<p class="category-image-desc"><img src="' . esc_url($image) . '" alt="" /></p>';
		}
	}
}
function voisen_ourbrands(){
	echo do_shortcode( '[ourbrands rows="1" colsnumber="6" style="carousel"]' );
}

//ajax cart delete
add_action( 'wp_footer', 'voisen_add_js_remove_product_wp_wcommerce');
function voisen_add_js_remove_product_wp_wcommerce(){ ?>
    <script type="text/javascript">
    jQuery(document).on('click', '.mini_cart_item .remove', function(e){
        var product_id = jQuery(this).data("product_id");
		jQuery(this).closest('li').remove();
		var a_href = jQuery(this).attr('href');
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: 'action=voisen_product_remove&' + (a_href.split('?')[1] || ''), 
			success: function(data){
				if(typeof(data) != 'object'){
					alert('Could not remove cart item.');
					return;
				}
				jQuery('.topcart .cart-toggler .qty').html(data.qty);
				jQuery('.topcart_content').css('height', 'auto');
				if(data.qty > 0){
					jQuery('.topcart_content .total .amount').html(data.subtotal);
				}else{
					jQuery('.topcart_content .cart_list').html('<li class="empty"><?php echo esc_html__('No products in the cart.', 'voisen') ?></li>');
					jQuery('.topcart_content .total').remove();
					jQuery('.topcart_content .buttons').remove();
				}
            }
        });
		e.preventDefault();
        return false;
    });
    </script>
<?php } 
add_action( 'wp_ajax_product_remove', 'voisen_product_remove' );
add_action( 'wp_ajax_nopriv_product_remove', 'voisen_product_remove' );
function voisen_product_remove(){
    global $wpdb, $woocommerce;
	$cart = WC()->instance()->cart;
	if(!empty($_POST['remove_item'])){
	   $cart->remove_cart_item(intval($_POST['remove_item']));
	}
    echo json_encode(array(
			'qty'=> $woocommerce->cart->get_cart_contents_count(), 
			'subtotal' => html_entity_decode(strip_tags($woocommerce->cart->get_cart_subtotal()))
		));
    die();
}

//quickview ajax
add_action( 'wp_ajax_product_quickview', 'voisen_product_quickview' );
add_action( 'wp_ajax_nopriv_product_quickview', 'voisen_product_quickview' );

function voisen_product_quickview() {
	global $product, $post, $woocommerce_loop, $voisen_opt;
	if($_POST['data']){
		$productid = intval( $_POST['data'] );
		$product = get_product( $productid );
		$post = get_post( $productid );
	}
	?>
	<div class="woocommerce product">
		<div class="product-images">
			<?php $image_link = wp_get_attachment_url( $product->get_image_id() );?>
			<div class="main-image images"><img src="<?php echo esc_attr($image_link);?>" alt="" /></div>
			<?php
			$attachment_ids = $product->get_gallery_attachment_ids();

			if ( $attachment_ids ) {
				?>
				<div class="quick-thumbnails">
					<?php $image_link = wp_get_attachment_url( $product->get_image_id() );?>
					<div>
						<a href="<?php echo esc_attr($image_link);?>">
							<?php echo wp_kses($product->get_image('shop_thumbnail'),array(
								'img'=>array(
									'src'=>array(),
									'alt'=>array(),
									'class'=>array(),
									'id'=>array()
								)
							));?>
						</a>
					</div>
					<?php

					$loop = 0;
					$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

					foreach ( $attachment_ids as $attachment_id ) {
						?>
						<div>
						<?php
						$classes = array( 'zoom' );

						if ( $loop == 0 || $loop % $columns == 0 )
							$classes[] = 'first';

						if ( ( $loop + 1 ) % $columns == 0 )
							$classes[] = 'last';

						$image_link = wp_get_attachment_url( $attachment_id );

						if ( ! $image_link )
							continue;

						$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
						$image_class = esc_attr( implode( ' ', $classes ) );
						$image_title = esc_attr( get_the_title( $attachment_id ) );

						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $product->ID, $image_class );

						$loop++;
						?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			} ?>
		</div>
		<div class="product-info">
			<h1><?php echo $product->get_title(); ?></h1>
			
			<div class="price-box" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<p class="price">
					<?php echo wp_kses($product->get_price_html(),array(
						'p'=>array(
							'class'=>array()
						),
						'span'=>array(
							'class'=>array()
						)
					));?>
				</p>
			</div>
			
			<a class="see-all" href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($voisen_opt['quickview_link_text']); ?></a>
			<div class="quick-add-to-cart">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
			<div class="quick-desc"><?php echo do_shortcode(get_post($productid)->post_excerpt); ?></div>
			<div class="social-sharing"><?php voisen_product_sharing(); ?></div>
		</div>
	</div>
	<?php
	die();
}

//add_filter( 'woocommerce_enqueue_styles', '__return_false' ); // Remove all woocommerce style layout

// Count number of products from shortcode
add_filter( 'woocommerce_shortcode_products_query', 'voisen_woocommerce_shortcode_count');
function voisen_woocommerce_shortcode_count( $args ) {
	global $voisen_opt, $voisen_productsfound;
	$voisen_productsfound = new WP_Query($args);
	$voisen_productsfound = $voisen_productsfound->post_count;
	return $args;
}

// number products per page
add_filter( 'loop_shop_per_page', 'voisen_shop_per_page', 20 );
function voisen_shop_per_page() {
	global $voisen_opt;
	return $voisen_opt['product_per_page'];
}

//WooProjects - Project organize
remove_action( 'projects_before_single_project_summary', 'projects_template_single_title', 10 );
add_action( 'projects_single_project_summary', 'projects_template_single_title', 5 );
remove_action( 'projects_before_single_project_summary', 'projects_template_single_short_description', 20 );
remove_action( 'projects_before_single_project_summary', 'projects_template_single_gallery', 40 );
add_action( 'projects_single_project_gallery', 'projects_template_single_gallery', 40 );
?>
