<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Voisen_Themes
 * @since Voisen Themes 1.0
 */
?>
<?php $voisen_opt = get_option( 'voisen_opt' ); ?>
	<div class="header-container third">
		<div class="top-bar">
			<div class="container">
				<div class="row">
					<div class="col-sm-5">
						<?php if(isset($voisen_opt['welcome_message']) && $voisen_opt['welcome_message']!=''){ ?>
							<p class="welcome-message pull-left">
								<?php echo wp_kses($voisen_opt['welcome_message'], array(
								  'strong' => array(),
								 )); ?>
						
							</p>
						<?php } ?> 
					</div>
					<div class="col-sm-7">

						<?php if(isset($voisen_opt['top_menu']) && $voisen_opt['top_menu']!=''){ ?>
							<div class="pull-right top-menu">
								<p class="current">
									<?php esc_html_e('my account', 'voisen');?><i class="fa fa-angle-down"></i>
								</p>
								<?php if( isset($voisen_opt['top_menu']) ) {
									$menu_object = wp_get_nav_menu_object( $voisen_opt['top_menu'] );
									$menu_args = array(
										'menu_class'      => 'nav_menu',
										'menu'         => $voisen_opt['top_menu'],
									); ?>
									<div>
										<?php wp_nav_menu( $menu_args ); ?>
									</div>
								<?php } ?>
							</div>
						<?php } ?> 
						
						<?php if (is_active_sidebar('top_header')) { ?> 
							<div class="widgets-top pull-right">
							<?php dynamic_sidebar('top_header'); ?> 
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<?php if(class_exists('WC_Widget_Product_Search')) { ?>
						<div class="top-search pull-left">
							<?php the_widget('WC_Widget_Product_Search', array('title' => '')); ?>
						</div>
						<?php } ?>
					</div>
					<div class="col-sm-4">
						<?php if( isset($voisen_opt['logo_main']['url']) ){ ?>
							<div class="logo text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($voisen_opt['logo_main']['url']); ?>" alt="" /></a></div>
						<?php
						} else { ?>
							<h1 class="logo text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
						} ?>
					</div>
					<div class="col-sm-4">
						<?php if(class_exists('WC_Widget_Cart')) { ?>
							<div class="shoping_cart">
							<?php the_widget('WC_Widget_Cart'); ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="nav-menus">
			<div class="container">
				<div class="nav-desktop visible-lg visible-md">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
				</div>
				
				<div class="nav-mobile visible-xs visible-sm">
					<div class="mobile-menu-overlay"></div>
					<div class="toggle-menu"><i class="fa fa-bars"></i></div>
					<div class="mobile-navigation">
						<?php if(class_exists('WC_Widget_Product_Search')) { ?>
							<div class="mobile-search-product">
								<?php the_widget('WC_Widget_Product_Search', array('title' => '')); ?>
							</div>
						<?php } ?>
						<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu mobile-menu' ) ); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="clearfix"></div>
	</div>