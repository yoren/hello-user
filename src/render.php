<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo sprintf( esc_html__( 'Hello %s!', 'hello-user' ), wp_get_current_user()->display_name ); ?>
</p>
