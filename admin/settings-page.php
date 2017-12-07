<?php
add_action( 'admin_menu', 'fpfi_add_admin_menu' );
add_action( 'admin_init', 'fpfi_settings_init' );

function fpfi_add_admin_menu() { 
	add_submenu_page( 'tools.php', 'First Picture as First Image', 'First Picture as First Image', 'manage_options', 'first_picture_as_first_image', 'fpfi_options_page' );
}

function fpfi_settings_init() { 
	register_setting( 'fpfi-settings', 'fpfi_settings' );

	add_settings_section(
		'fpfi_settings_section', 
		__( 'Change settings below', 'fpfi' ), 
		'fpfi_settings_section_callback', 
		'fpfi-settings'
	);

	add_settings_field( 
		'fpfi_post_type', 
		__( 'Choose post type', 'fpfi' ), 
		'fpfi_post_type_render', 
		'fpfi-settings', 
		'fpfi_settings_section' 
	);
}

function fpfi_post_type_render() { 
	$options = get_option( 'fpfi_settings' );
	$posts = array('Post', 'Page');
	?>
	<select name='fpfi_settings[fpfi_post_type]'>
		<?php if ( 'page' == $options['fpfi_post_type'] ) : ?>
			<option value='page' <?php selected( $options['fpfi_post_type'], 2 ); ?>><?php _e( $posts[1], 'fpfi' )?></option>
			<option value='post' <?php selected( $options['fpfi_post_type'], 1 ); ?>><?php _e( $posts[0], 'fpfi' )?></option>
		<?php else: ?>
			<option value='post' <?php selected( $options['fpfi_post_type'], 1 ); ?>><?php _e( $posts[0], 'fpfi' )?></option>
			<option value='page' <?php selected( $options['fpfi_post_type'], 2 ); ?>><?php _e( $posts[1], 'fpfi' )?></option>
		<?php endif; ?>
	</select>
<?php
}

function fpfi_settings_section_callback() {
	return;
}

function fpfi_options_page() { ?>
	<form action='options.php' method='post'>

		<h2>First Picture as First Image</h2>

		<?php
		settings_fields( 'fpfi-settings' );
		do_settings_sections( 'fpfi-settings' );
		submit_button();
		if ( $_GET['settings-updated'] ) :
			$op = get_option( 'fpfi_settings' );
			check_thumbnail_image($op);
endif; ?>

	</form>
	<?php
}