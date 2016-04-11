<?php
/**
 * Voisen Themes functions and definitions
 *
 * @package WordPress
 * @subpackage Voisen_theme
 * @since Voisen Themes 1.0
 */
//Plugin-Activation
require_once( get_template_directory().'/class-tgm-plugin-activation.php' );

 //Init the Redux Framework
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) && file_exists( get_template_directory().'/theme-config.php' ) ) {
	require_once( get_template_directory().'/theme-config.php' );
}
// require system parts
$load_files = array(
	'theme-helper.php',
	'custom-fields.php',
	'widgets.php',
	'head-media.php',
	'bootstrap-extras.php',
	'bootstrap-tags.php',
	'woo-hook.php',
);
if(class_exists('Vc_Manager')){
	$load_files[] = 'composer-shortcodes.php';
}
appthemes_load_files( get_template_directory() . '/includes/', $load_files);
function appthemes_load_files( $path, $files = array() ) {
	foreach ( $files as $file_path ) {
		require_once $path . $file_path;
	}
}
// theme setup
function voisen_setup(){
		// Load languages
		load_theme_textdomain( 'voisen', get_template_directory() . '/languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// This theme supports a variety of post formats.
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		if ( ! isset( $content_width ) ) $content_width = 625;
		
		add_theme_support( 'title-tag' );
		
		// This theme uses a custom image size for featured images, displayed on "standard" posts.
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 1170, 9999 ); // Unlimited height, soft crop
		add_image_size( 'voisen-category-thumb', 1170, 650, true ); // (cropped)
		add_image_size( 'voisen-category-full', 1170, 650, true ); // (cropped)
		add_image_size( 'voisen-post-thumb', 1170, 650, true ); // (cropped)
		add_image_size( 'voisen-post-thumbwide', 590, 350, true ); // (cropped)
}
add_action( 'after_setup_theme', 'voisen_setup');

//register new menu location
function voisen_register_menu(){
	register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'voisen' ) );
	//register_nav_menu( 'categories', esc_html__( 'Categories Menu', 'voisen' ) );
	register_nav_menu( 'mobilemenu', esc_html__( 'Mobile Menu', 'voisen' ) );
}
add_action( 'init', 'voisen_register_menu' );

add_action( 'after_setup_theme', 'voisen_woocommerce_support' );
function voisen_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
/*
* Theme support
 */
add_theme_support( 'custom-background', array() );
add_theme_support( 'custom-header', array() );
/**
* TGM-Plugin-Activation
*/
add_action( 'tgmpa_register', 'voisen_register_required_plugins'); 
function voisen_register_required_plugins(){
	$plugins = array(
				array(
					'name'               => 'LionThemes Helper',
					'slug'               => 'lionthemes-helper',
					'source'             => get_template_directory() . '/plugins/lionthemes-helper.zip',
					'required'           => true,
					'external_url'       => '',
					'force_activation' => false,
					'force_deactivation' => false,
				),
				array(
					'name'               => 'Mega Main Menu',
					'slug'               => 'mega_main_menu',
					'source'             => get_template_directory() . '/plugins/mega_main_menu.zip',
					'required'           => true,
					'external_url'       => '',
				),
				array(
					'name'               => 'Revolution Slider',
					'slug'               => 'revslider',
					'source'             => get_template_directory() . '/plugins/revslider.zip',
					'required'           => true,
					'external_url'       => '',
				),
				array(
					'name'               => 'Visual Composer',
					'slug'               => 'js_composer',
					'source'             => get_template_directory() . '/plugins/js_composer.zip',
					'required'           => true,
					'external_url'       => '',
				),
				// Plugins from the Online WordPress Plugin
				array(
					'name'               => 'Redux Framework',
					'slug'               => 'redux-framework',
					'required'           => true,
					'force_activation'   => false,
					'force_deactivation' => false,
				),
				array(
					'name'      => 'Contact Form 7',
					'slug'      => 'contact-form-7',
					'required'  => true,
				),
				array(
					'name'      => 'MailPoet Newsletters',
					'slug'      => 'wysija-newsletters',
					'required'  => true,
				),
				array(
					'name'      => 'Projects',
					'slug'      => 'projects-by-woothemes',
					'required'  => false,
				),
				array(
					'name'      => 'Shortcodes Ultimate',
					'slug'      => 'shortcodes-ultimate',
					'required'  => true,
				),
				array(
					'name'      => 'Testimonials',
					'slug'      => 'testimonials-by-woothemes',
					'required'  => false,
				),
				array(
					'name'      => 'TinyMCE Advanced',
					'slug'      => 'tinymce-advanced',
					'required'  => false,
				),
				array(
					'name'      => 'Widget Importer & Exporter',
					'slug'      => 'widget-importer-exporter',
					'required'  => false,
				),
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
					'required'  => true,
				),
				array(
					'name'      => 'YITH WooCommerce Compare',
					'slug'      => 'yith-woocommerce-compare',
					'required'  => true,
				),
				array(
					'name'      => 'YITH WooCommerce Wishlist',
					'slug'      => 'yith-woocommerce-wishlist',
					'required'  => true,
				),
				array(
					'name'      => 'YITH WooCommerce Zoom Magnifier',
					'slug'      => 'yith-woocommerce-zoom-magnifier',
					'required'  => true,
				),
			);
			
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'voisen' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'voisen' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'voisen' ), // %s = plugin name.
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'voisen' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'voisen' ),
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'voisen' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'voisen' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'voisen' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'voisen' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'voisen' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'voisen' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'voisen' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'voisen' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'voisen' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'voisen' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'voisen' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'voisen' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);
	tgmpa( $plugins, $config );
}
//hide ReduxFramework Demo link and ADS
function voisen_remove_admin_notice_rudux() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'voisen_remove_admin_notice_rudux');

//show_admin_bar(false);