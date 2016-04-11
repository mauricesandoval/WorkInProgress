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
	<div class="header-container second">
		<div class="header">
			<div class="container-fluid">
					<div class="col-md-2 col-xs-5">
					
						<?php if( isset($voisen_opt['logo_main']['url']) ){ ?>
							<div class="logo text-left"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($voisen_opt['logo_main']['url']); ?>" alt="" /></a></div>
						<?php
						} else { ?>
							<h1 class="logo text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
						} ?>

					</div>
					<div class="col-md-7 visible-lg visible-md">
						<div class="nav-menus">
							<div class="nav-desktop visible-lg visible-md">
								<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-xs-7 clearfix">
						<?php if(class_exists('WC_Widget_Cart')) { ?>
						<div class="shoping_cart pull-right">
							<?php the_widget('WC_Widget_Cart'); ?>
						</div>
						<?php } ?>
						<div class="link-hover pull-right">
							<ul id="nav">

								<?php if(isset($voisen_opt['top_menu']) && $voisen_opt['top_menu']!=''){ ?>
								<li>
									<label><?php esc_html_e('Setting', 'voisen');?></label>
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
									<?php if (is_active_sidebar('top_header')) { ?> 
								<?php dynamic_sidebar('top_header'); ?> 
							<?php } ?>
									
									
								</li>
								<?php } ?>
							</ul>
							
						</div>
						<?php if(class_exists('WC_Widget_Product_Search')) { ?>
						<div class="search-switcher  pull-right">
							<div class="dropdown-switcher">
								<?php the_widget('WC_Widget_Product_Search', array('title' => '')); ?>
							</div>
						</div>
						<?php } ?>
						
						
						
					</div>
			</div>

			<div class="nav-menus visible-xs visible-sm">
				<div class="container-fluid">
					<div class="nav-mobile ">
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
		</div>
	</div>