<div class="wrap">

	<?php
	// Get the current tab (default = theme)
	$tab = isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ? $_GET['tab'] : 'tutsup-index';
	?>

	<h2><?php _e('Tutsup Modal', 'tutsup'); ?></h2>

	<?php
	/* Include the HTML for the current tab */
	if ( $tab === 'tutsup-index' ): tab_settings('tutsup-index'); include('tutsup-index.php'); 
	//elseif ( $tab === 'theme' ): tab_settings('theme'); include('theme.php'); 
	endif;
	?>
	
</div>
