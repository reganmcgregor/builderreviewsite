<?php
extract( $args );

extract( $args );
extract( $instance );
$title = !empty($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
echo trim($before_widget);
if ( $title ) {
    echo trim($before_title)  .trim( $title ) . $after_title;
}
?>
<div class="widget-search">
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	  	<div class="input-group">
			<button type="submit" class="btn btn-search"><i class="flaticon-search"></i></button>
			<input type="text" placeholder="<?php esc_attr_e( 'What are you looking for?', 'homez' ); ?>" name="s" class="apus-search form-control"/>
	  	</div>
		<?php if ( isset($post_type) && $post_type ): ?>
			<input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" class="post_type" />
		<?php endif; ?>
	</form>
</div>
<?php echo trim($after_widget);