<form method="post" action="options.php">
	<?php 
	settings_fields( 'tutsup_modal_style' );
	do_settings_sections( 'tutsup_modal_style' );
	$tutsup_t_option = 'tutsup_modal_style';
	$tutsup_t_options = get_option( $tutsup_t_option );
	?>
	
	<h3><?php _e('Modal Style', 'tutsup'); ?></h3>
	<p><?php _e('Here you can change your modal style (CSS)', 'tutsup'); ?></p>

	<h3><?php _e('Width and height', 'tutsup'); ?></h3>

	<table class="form-table">

		<tr>
			<th scope="row"><?php _e('Width', 'tutsup'); ?>:</th> 
			<td><input type="number" value="<?php
			echo tutsup_check_option( $tutsup_t_options, 'width' ); ?>"
			name="<?php echo $tutsup_t_option;?>[width]"> px
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Height', 'tutsup'); ?>:</th> 
			<td><input type="number" value="<?php
			echo tutsup_check_option( $tutsup_t_options, 'height' ); ?>"
			name="<?php echo $tutsup_t_option;?>[height]"> px
			</td>
		</tr>
	</table>
	
	<p>
		<?php submit_button(); ?>
	</p>
</form>