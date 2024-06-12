<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !empty($args['before_widget']) ) {
	echo trim( $args['before_widget'] );
}

if ( ! empty( $instance['title'] ) ) {
	echo trim( $args['before_title'] );
	echo esc_attr( $instance['title'] );
	echo trim( $args['after_title'] );
}
homez_load_select2();
?>

<form method="get" action="<?php echo WP_RealEstate_Mixes::get_agents_page_url(); ?>" class="form-theme filter-agent-form filter-listing-form">
	<?php $fields = WP_RealEstate_Agent_Filter::get_fields(); ?>
	<?php if ( ! empty( $instance['sort'] ) ) : ?>
		<?php
			$filtered_keys = array_filter( explode( ',', $instance['sort'] ) );
			$fields = array_merge( array_flip( $filtered_keys ), $fields );
		?>
	<?php endif; ?>

	<?php foreach ( $fields as $key => $field ) : ?>
		<?php
			if ( empty( $instance['hide_'.$key] ) && !empty($field['field_call_back']) && is_callable($field['field_call_back']) ) {
				call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
			}
		?>
	<?php endforeach; ?>

	<?php if ( ! empty( $instance['button_text'] ) ) : ?>
		<div class="form-group form-group-submit">
			<button class="button btn btn-theme"><i class="ti-search pre"></i><?php echo esc_attr( $instance['button_text'] ); ?></button>
		</div><!-- /.form-group -->
	<?php endif; ?>
</form>

<?php
if ( !empty($args['after_widget']) ) {
	echo trim( $args['after_widget'] );
}
?>