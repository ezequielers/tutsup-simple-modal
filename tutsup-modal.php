<?php
/* 
Plugin Name: Tutsup Modal
Plugin URI: http://www.tutsup.com/
Description: This plugin allows you to create simple modals in your site/blog. You can put any custom HTML and CSS inside your modal, like subscription forms, warnings, advertisement, simple text, or whatever you want. It's really simple.
Version: 0.1
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
			} 
			
			// Isn't admin
			else {
				// Plugin styles and scripts
				add_action( 'wp_footer', array( $this, 'enqueue_public_scripts' ), 1000 );
				
			}
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
				'tutsup_theme_options', 
				array( $this, 'tutsup_page' ) 
			);

			// Register the option
			add_action( 'admin_init', array( $this, 'register_mysettings' ) );
		}
		
		public function register_mysettings() {
			//register our settings
			register_setting( 'tutsup_modal', 'tutsup_modal' );
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
					'tutsup-index'  => __('Main', 'tutsup'),
				);
				
				echo '<div id="icon-themes" class="icon32"><br></div>';
				
				echo '<h2 class="nav-tab-wrapper">';
				foreach( $tabs as $tab => $name ){
					$class = ( $tab == $current ) ? ' nav-tab-active' : '';
					echo "<a class='nav-tab$class' href='?page=tutsup_theme_options&tab=$tab'>$name</a>";
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
		 * Loads the styles and scripts (public)
		 */
		public function enqueue_public_scripts() {			
			$tutsup_option = get_option('tutsup_modal');
			
?>

<?php if ( tutsup_check_option( $tutsup_option, 'tutsup-modal-html' ) ): ?>

<style>
.tutsup-modal-bg {
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;
	left: 0;
	background: rgba(0,0,0,.6);
	z-index: 999;
	display: none;
}
.tutsup-modal {
	width: 500px;
	height: 300px;
	position: fixed;
	top: 50%;
	left: 50%;
	margin-top: -150px;
	margin-left: -250px;
	background: #fff;
	z-index: 1000;
	box-shadow: 0 0 10px #000;
	display: none;
}
.tutsup-modal-inner{
	position: relative;
}
.tutsup-modal-content{
	margin: 20px;
	overflow: auto;
	height: 260px;
}
.tutsup-modal-close {
	display: block;
	font-size: 12px;
	line-height: 12px;
	padding: 5px;
	border-radius: 50%;
	background: #000;
	color: #fff;
	text-align: center;
	position: absolute;
	top: -30px;
	right: -13px;
	font-weight: 700;
	font-family: sans-serif;
	z-index: 1001;
	cursor: pointer;
}
<?php echo tutsup_check_option( $tutsup_option, 'tutsup-modal-css' );?>
</style>

<div class="tutsup-modal-bg"></div>
<div class="tutsup-modal">
	<div class="tutsup-modal-inner">
		<div class="tutsup-modal-close">&#10005;</div>
		<div class="tutsup-modal-content">
			<?php echo tutsup_check_option( $tutsup_option, 'tutsup-modal-html' );?>
		</div>
	</div>
</div>

<script>
function tutsup_modal_init($) {
	var tutsup_modal_cookies = document.cookie;
	
	if ( tutsup_modal_cookies.indexOf( 'tutsup-modal' ) == -1 ) {
		$('.tutsup-modal-bg').css('display', 'block');
		$('.tutsup-modal').css('display', 'block');
		document.cookie = 'tutsup-modal=1';
	}
}

jQuery(function($){
	$('.tutsup-modal-close').click(function(){
		$('.tutsup-modal-bg').css('display', 'none');
		$('.tutsup-modal').css('display', 'none');
		document.cookie = 'tutsup-modal=1';
	});

	<?php 
	$modal_seconds = tutsup_check_option( $tutsup_option, 'tutsup-modal-seconds' );
	
	if ( empty( $modal_seconds ) ): 
	?>
		$('body').mouseleave(function() {
			tutsup_modal_init($);
		});
	<?php else: ?>
		setTimeout(function(){
			tutsup_modal_init($);
		}, <?php echo ( (int)tutsup_check_option( $tutsup_option, 'tutsup-modal-seconds' ) ) * 1000; ?>);
	<?php endif; ?>
});
</script>

<?php endif; ?>

<?php
		} // enqueue_public_scripts
	}

	/* Loads the class */
	$tutsup_settings = new TutsupModalSettings();
}