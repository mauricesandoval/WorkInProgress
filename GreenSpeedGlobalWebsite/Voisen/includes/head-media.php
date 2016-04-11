<?php
/**
* Theme stylesheet & javascript registration
*
* @package WordPress
* @subpackage Voisen_theme
* @since Voisen Themes 1.0
*/

// global ajaxurl
add_action('wp_head','voisen_ajaxurl');
function voisen_ajaxurl() {
?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo esc_js(admin_url('admin-ajax.php')); ?>';
	</script>
<?php
}

//Voisen theme style and script 
function voisen_register_script()
{
	global $voisen_opt;
	$default_font = "'Arial', Helvetica, sans-serif";
	$params = array(
		'heading_font'=> ((!empty($voisen_opt['headingfont']['font-family'])) ? $voisen_opt['headingfont']['font-family'] : $default_font),
		'heading_color'=> ((!empty($voisen_opt['headingfont']['color'])) ? $voisen_opt['headingfont']['color'] : '#181818'),
		'heading_font_weight'=> ((!empty($voisen_opt['headingfont']['font-weight'])) ? $voisen_opt['headingfont']['font-weight'] : '700'),
		'menu_font'=> ((!empty($voisen_opt['menufont']['font-family'])) ? $voisen_opt['menufont']['font-family'] : $default_font),
		'menu_font_size'=> ((!empty($voisen_opt['menufont']['font-size'])) ? $voisen_opt['menufont']['font-size'] : '14px'),
		'menu_font_weight'=> ((!empty($voisen_opt['menufont']['font-weight'])) ? $voisen_opt['menufont']['font-weight'] : '400'),
		'sub_menu_bg'=> ((!empty($voisen_opt['sub_menu_bg'])) ? $voisen_opt['sub_menu_bg'] : '#2c2c2c'),
		'sub_menu_color'=> ((!empty($voisen_opt['sub_menu_color'])) ? $voisen_opt['sub_menu_color'] : '#cfcfcf'),
		'body_font'=> ((!empty($voisen_opt['bodyfont']['font-family'])) ? $voisen_opt['bodyfont']['font-family'] : $default_font),
		'text_color'=> ((!empty($voisen_opt['bodyfont']['color'])) ? $voisen_opt['bodyfont']['color'] : '#6e6e6e'),
		'primary_color' => ((!empty($voisen_opt['primary_color'])) ? $voisen_opt['primary_color'] : '#1bb2c0'),
		'sale_color' => ((!empty($voisen_opt['sale_color'])) ? $voisen_opt['sale_color'] : '#f49835'),
		'saletext_color' => ((!empty($voisen_opt['saletext_color'])) ? $voisen_opt['saletext_color'] : '#f49835'),
		'rate_color' => ((!empty($voisen_opt['rate_color'])) ? $voisen_opt['rate_color'] : '#f49835'),
		'page_width' => (!empty($voisen_opt['box_layout_width'])) ? $voisen_opt['box_layout_width'] . 'px' : '1200px',
		'body_bg_color' => ((!empty($voisen_opt['background_opt']['background-color'])) ? $voisen_opt['background_opt']['background-color'] : '#fff'),
	);
	if( function_exists('compileLess') ){
		compileLess('theme.less', 'theme.css', $params);
	}
	wp_enqueue_style( 'base-style', get_template_directory_uri() . '/style.css'  );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css'  );
	wp_enqueue_style( 'bootstrap-theme-css', get_template_directory_uri() . '/css/bootstrap-theme.min.css'  );
	wp_enqueue_style( 'awesome-css', get_template_directory_uri() . '/css/font-awesome.min.css'  );
	wp_enqueue_style( 'owl-css', get_template_directory_uri() . '/owl-carousel/owl.carousel.css'  );
	wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/owl-carousel/owl.theme.css'  );
	wp_enqueue_style( 'owl-transitions', get_template_directory_uri() . '/owl-carousel/owl.transitions.css'  );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox.css' );
	if(file_exists( get_template_directory() . '/css/theme.css' )){
		wp_enqueue_style( 'theme-options', get_template_directory_uri() . '/css/theme.css'  );
	}

    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js' );
    wp_enqueue_script( 'owl-wow-js', get_template_directory_uri() . '/js/jquery.wow.min.js' );
    wp_enqueue_script( 'owl-modernizr-js', get_template_directory_uri() . '/js/modernizr.custom.js' );
    wp_enqueue_script( 'owl-carousel-js', get_template_directory_uri() . '/owl-carousel/owl.carousel.js' );
    wp_enqueue_script( 'auto-grid', get_template_directory_uri() . '/js/autoGrid.min.js' );
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/fancybox/jquery.fancybox.pack.js' );
    wp_enqueue_script( 'temp-js', get_template_directory_uri() . '/js/custom.js', false );
}
add_action( 'wp_enqueue_scripts', 'voisen_register_script' );

//Voisen theme gennerate title
function voisen_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) return $title;
	
	$title .= get_bloginfo( 'name', 'display' );
	
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'voisen' ), max( $paged, $page ) );
	
	return $title;
}

add_filter( 'wp_title', 'voisen_wp_title', 10, 2 );

if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function voisen_wp_render_title_tag() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'voisen_wp_render_title_tag' );
}

add_filter('body_class', 'voisen_effect_scroll');

function voisen_effect_scroll($classes){
	$classes[] = 'voisen-animate-scroll';
	return $classes;
}
?>