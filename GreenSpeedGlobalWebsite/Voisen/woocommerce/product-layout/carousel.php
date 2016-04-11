<?php
	$_delay = 100;
?>
<div class="products-block shop-products products grid-view">
	<div data-owl="slide" data-desksmall="<?php echo esc_attr($desksmall) ?>" data-tabletsmall="<?php echo esc_attr($tabletsmall) ?>" data-mobile="<?php echo esc_attr($mobile_count) ?>" data-tablet="<?php echo esc_attr($tablet_count) ?>" data-margin="<?php echo esc_attr($margin) ?>" data-item-slide="<?php echo esc_attr($columns_count); ?>" data-ow-rtl="<?php echo is_rtl()?'true':'false'; ?>" class="owl-carousel owl-theme products-slide">
		<?php $index = 0; while ( $loop->have_posts() ) : $loop->the_post(); global $product; $index ++; ?>
			<?php if($rows > 1){ ?>
				<?php if ( (0 == ( $index - 1 ) % $rows ) || $index == 1) { ?>
					<div class="group">
				<?php } ?>
			<?php } ?>
			<div class="product wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms">
				<?php 
					if(isset($is_deals) && $is_deals){
						wc_get_template_part( 'content', 'product-deals' );
					}else{
						wc_get_template_part( 'content', 'product-inner' );
					}
				?>
			</div>
			<?php if($rows > 1){ ?>
				<?php if ( ( ( 0 == $index % $rows || $_total == $index )) ) { ?>
					</div>
				<?php } ?>
			<?php } ?>
			<?php $_delay+=100; ?>
		<?php endwhile; ?>
	</div>
</div>
