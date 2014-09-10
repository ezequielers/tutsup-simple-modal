<form method="post" action="options.php">
	<?php 
	settings_fields( 'tutsup_modal' );
	do_settings_sections( 'tutsup_modal' );
	$tutsup_t_option = 'tutsup_modal';
	$tutsup_t_options = get_option( $tutsup_t_option );
	?>
	
	<h3><?php _e('Modal Options', 'tutsup'); ?></h3>
	<p><?php _e('Here you can configure your modal settings (HTML and CSS).', 'tutsup'); ?></p>

	<h3><?php _e('HTML and CSS Settings', 'tutsup'); ?></h3>

	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Modal HTML', 'tutsup'); ?>:</th> 
			<td><textarea class="widefat" rows="10" name="<?php echo $tutsup_t_option;?>[tutsup-modal-html]"><?php
			echo tutsup_check_option( $tutsup_t_options, 'tutsup-modal-html' ); ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('CSS for the HTML above', 'tutsup'); ?>:</th> 
			<td><textarea class="widefat" rows="10" name="<?php echo $tutsup_t_option;?>[tutsup-modal-css]"><?php
			echo tutsup_check_option( $tutsup_t_options, 'tutsup-modal-css' ); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Display modal after', 'tutsup'); ?>:</th> 
			<td><input size="5" type="number" value="<?php
			echo tutsup_check_option( $tutsup_t_options, 'tutsup-modal-seconds' ); ?>"
			name="<?php echo $tutsup_t_option;?>[tutsup-modal-seconds]"> 
			<small><?php _e('Seconds (Leave it blank for default behavior, which is when the user moves the mouse out of the body)', 'tutsup'); ?></small>
			</td>
		</tr>
	</table>
	
	<p>
		<?php submit_button(); ?>
	</p>
</form>