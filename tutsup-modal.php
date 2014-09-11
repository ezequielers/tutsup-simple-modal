<?php
/* 
Plugin Name: Tutsup Modal
Plugin URI: http://www.tutsup.com/
Description: This plugin allows you to create simple modals in your site/blog. You can put any custom HTML and CSS inside your modal, like subscription forms, warnings, advertisement, simple text, or whatever you want. It's really simple.
Version: 0.2.2
Author: Luiz Otávio Miranda
Author URI: http://www.tutsup.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


/**
 * Class Tutsup Modal Load Settings
 * 
 * Loads all the settings needed for the plugin.
 */
if ( ! class_exists('TutsupModalSettings') ) {

	class TutsupModalSettings
	{
		// Path to the languages file
		protected $languages_path;

		/**
		 * Loads the needed functions
		 */
		function __construct () {		
			/* Text domain */
			$this->languages_path = dirname( __FILE__ ) . '/languages';
			load_theme_textdomain('tutsup', $this->languages_path );	
			
			// Function to check and return an option
			if ( ! function_exists('tutsup_check_option') ) {
				function tutsup_check_option ( $option, $key ) {
					if ( isset( $option[$key] ) && ! empty( $option[$key] )  ) {
						return $option[$key];
					} else {
						return false;
					}
				}
			}

				
			/* Only Admin settings */
			if ( is_admin() ) {
				// Admin settings
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

				// Add the theme menu
				add_action('admin_menu', array( $this, 'tutsup_menu_options' ) );
				
				$plugin = plugin_basename( __FILE__ );
				add_filter( "plugin_action_links_$plugin", array( $this, 'plugin_add_settings_link' ) );
			} 
			
			// Isn't admin
			else {				
				// Plugin front-end HTML
				add_action( 'wp_footer', array( $this, 'load_plugin_html' ), 100000 );
				
			}
		}
		
		public function plugin_add_settings_link( $links ) {
			$settings_link = '<a href="options-general.php?page=tutsup-simple-modal">Config.</a>';
			array_push( $links, $settings_link );
			return $links;
		}
		
		/**
		 * Loads the menu options
		 */
		public function tutsup_menu_options() {
			// Creates a page for editing the theme options
			add_options_page(
				__('Tutsup Modal', 'tutsup'),
				__('Tutsup Modal', 'tutsup'),
				'manage_options', 
				'tutsup-simple-modal', 
				array( $this, 'tutsup_page' ) 
			);

			// Register the option
			add_action( 'admin_init', array( $this, 'register_mysettings' ) );
		}
		
		public function register_mysettings() {
			//register our settings
			register_setting( 'tutsup_modal', 'tutsup_modal' );
			register_setting( 'tutsup_modal_style', 'tutsup_modal_style' );
		}
		
		/**
		 * Loads the menu callback page
		 */
		public function tutsup_page() {	
			/**
			 * Configure the menu tabs
			 */
			function tab_settings( $current = 'theme' ) {
				$tabs = array(
					'tutsup-index'        => __('Main', 'tutsup'),
					'tutsup-modal-style'  => __('Modal Style', 'tutsup'),
				);
				
				echo '<div id="icon-themes" class="icon32"><br></div>';
				
				echo '<h2 class="nav-tab-wrapper">';
				foreach( $tabs as $tab => $name ){
					$class = ( $tab == $current ) ? ' nav-tab-active' : '';
					echo "<a class='nav-tab$class' href='?page=tutsup-simple-modal&tab=$tab'>$name</a>";
				}
				echo '</h2>';
			}
			
			// If you want to edit, go to the views folder
			require dirname( __FILE__ ) . '/views/settings.php';
		}
		
		/**
		 * Loads the styles and scripts needed
		 */
		public function enqueue_scripts() {
			// Upload box
			wp_enqueue_script('media-upload');
			
			// Thickbox
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			
			// Color picker
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'admin_settings', get_template_directory_uri() . '/js/admin_settings.js', array('wp-color-picker'), '1.0.0', true );
		}
		
		/**
		 * Loads plugin front-end HTML
		 */
		public function load_plugin_html() {			
			$tutsup_option = get_option('tutsup_modal');
			$tutsup_style = get_option('tutsup_modal_style');
			
			wp_enqueue_script('jquery');
			
			// Include the plugin HTML
			if ( tutsup_check_option( $tutsup_option, 'tutsup-modal-html' ) ) {
				require dirname( __FILE__ ) . '/views/tutsup-modal-html.php';
			}

		} // load_plugin_html
	}

	/* Loads the class */
	$tutsup_settings = new TutsupModalSettings();
}