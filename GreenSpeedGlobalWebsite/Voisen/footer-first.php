<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Voisen_Themes
 * @since Voisen Themes 1.0
 */
?>
<?php 
$voisen_opt = get_option( 'voisen_opt' );
$ft_col_class = '';
?>
	<div class="footer">
		
		<?php if(isset($voisen_opt)) { ?>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					
					<?php if(isset($voisen_opt['about_us']) && $voisen_opt['about_us']!=''){ ?>
						<div class="col-md-3 col-sm-6">
							<div class="widget widget_contact_us">
							
							<?php echo wp_kses($voisen_opt['about_us'], array(
									'a' => array(
								'href' => array(),
								'title' => array()
								),
								'div' => array(
									'class' => array(),
								),
								'img' => array(
									'src' => array(),
									'alt' => array()
								),
								'h3' => array(
									'class' => array(),
								),
								'ul' => array(),
								'li' => array(),
								'i' => array(
									'class' => array()
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'p' => array(),
								)); ?>
							</div>
							
							<div class="widget widget-social">
								<h3 class="widget-title"><?php echo esc_html($voisen_opt['follow_us']);?></h3>
								<?php
								if(isset($voisen_opt['social_icons'])) {
									echo '<ul class="social-icons">';
									foreach($voisen_opt['social_icons'] as $key=>$value ) {
										if($value!=''){
											if($key=='vimeo'){
												echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
											} else {
												echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
											}
										}
									}
									echo '</ul>';
								}
								?>
							</div>

						</div>
					<?php } ?>
			
					<?php
					if( isset($voisen_opt['footer_menu1']) && $voisen_opt['footer_menu1']!='' ) {
						$menu1_object = wp_get_nav_menu_object( $voisen_opt['footer_menu1'] );
						$menu1_args = array(
							'menu_class'      => 'nav_menu',
							'menu'         => $voisen_opt['footer_menu1'],
						); ?>
						<div class="col-sm-6  col-md-2">
							<div class="widget widget_menu">
								<h3 class="widget-title"><?php echo esc_html($menu1_object->name); ?></h3>
								<?php wp_nav_menu( $menu1_args ); ?>
							</div>
						</div>
					<?php }
					if( isset($voisen_opt['footer_menu2']) && $voisen_opt['footer_menu2']!='' ) {
						$menu2_object = wp_get_nav_menu_object( $voisen_opt['footer_menu2'] );
						$menu2_args = array(
							'menu_class'      => 'nav_menu',
							'menu'         => $voisen_opt['footer_menu2'],
						); ?>
						<div class="col-sm-6  col-md-2">
							<div class="widget widget_menu">
								<h3 class="widget-title"><?php echo esc_html($menu2_object->name); ?></h3>
								<?php wp_nav_menu( $menu2_args ); ?>
							</div>
						</div>
					<?php }

					if( isset($voisen_opt['footer_menu3']) && $voisen_opt['footer_menu3']!='' ) {
						$menu3_object = wp_get_nav_menu_object( $voisen_opt['footer_menu3'] );
						$menu3_args = array(
							'menu_class'      => 'nav_menu',
							'menu'         => $voisen_opt['footer_menu3'],
						); ?>
						<div class="col-sm-6  col-md-2">
							<div class="widget widget_menu">
								<h3 class="widget-title"><?php echo esc_html($menu3_object->name); ?></h3>
								<?php wp_nav_menu( $menu3_args ); ?>
							</div>
						</div>
					<?php }?>

					<div class="col-md-3 col-sm-6">
						<div class="widget-product-tags">
							<?php 
							if(class_exists('WC_Widget_Product_Tag_Cloud')) {
								the_widget('WC_Widget_Product_Tag_Cloud');
							}
							?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">

						<div class="widget-copyright">
							<?php 
							if( isset($voisen_opt['copyright']) && $voisen_opt['copyright']!='' ) {
								echo wp_kses($voisen_opt['copyright'], array(
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
								));
							} else {
								echo 'Copyright <a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo('name').'</a> '.date('Y').'. All Rights Reserved';
							}
							?>
						</div>
					</div>
					<div class="col-sm-6">
					
						<div class="widget-payment text-right">
							<?php if(isset($voisen_opt['payment_icons']) && $voisen_opt['payment_icons']!='' ) {
								echo wp_kses($voisen_opt['payment_icons'], array(
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'img' => array(
										'src' => array(),
										'alt' => array()
									),
								)); 
							} ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>