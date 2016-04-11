<?php
/**
 * The Header template for our theme
 *
 * @package WordPress
 * @subpackage Voisen_theme
 * @since Voisen Themes 1.0
 */
?>
<?php 

$voisen_opt = get_option( 'voisen_opt' );

if(get_post_meta( get_the_ID(), 'voisen_header_page', true )){
	$voisen_opt['header_layout'] = get_post_meta( get_the_ID(), 'voisen_header_page', true );
}
if(get_post_meta( get_the_ID(), 'voisen_layout_page', true )){
	$voisen_opt['page_layout'] = get_post_meta( get_the_ID(), 'voisen_layout_page', true );
}
if(get_post_meta( get_the_ID(), 'voisen_logo_page', true )){
	$voisen_opt['logo_main']['url'] = get_post_meta( get_the_ID(), 'voisen_logo_page', true );
}
update_option('voisen_opt', $voisen_opt);
?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		if(isset($voisen_opt['opt-favicon']) && $voisen_opt['opt-favicon']!="") { 
			if(is_ssl()){
				$voisen_opt['opt-favicon'] = str_replace('http:', 'https:', $voisen_opt['opt-favicon']);
			}
		?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($voisen_opt['opt-favicon']['url']);?>">
		<?php }
	}
	?>
	<?php wp_head(); ?>
</head>
<?php
	$layout = (isset($voisen_opt['page_layout']) && $voisen_opt['page_layout'] == 'box') ? ' box-layout':'';
?>
<body <?php body_class(); ?>>
<div class="main-wrapper<?php echo esc_attr($layout); ?>">
<?php do_action('before'); ?> 
	<header>
	<?php
		if ( $voisen_opt['header_layout']=='default' || !isset($voisen_opt['header_layout'])) {
			get_header('first');
		} else {
			get_header($voisen_opt['header_layout']);
		}
	?>
	</header>
	<div id="content" class="site-content">