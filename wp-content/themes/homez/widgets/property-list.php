<?php
extract( $args );

extract( $args );
extract( $instance );

echo trim($before_widget);
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$style = !empty($style) ? $style : 'carousel';
$args = array(
    'limit' => $number_post,
    'get_properties_by' => $get_properties_by,
    'orderby' => $orderby,
    'order' => $order,
    'style' => $style,
);

$loop = homez_get_properties($args);
if ( $loop->have_posts() ):
?>
<div class="properties-list-simple">
    <?php if($style == 'list'){ ?>
    	<?php while ( $loop->have_posts() ): $loop->the_post(); ?>
    		<?php get_template_part( 'template-properties/properties-styles/inner', 'list-simple'); ?>
    	<?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php }else{ ?>
        <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
            <?php get_template_part( 'template-properties/properties-styles/inner', 'grid-v3'); ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php } ?>
</div>
<?php endif;
echo trim($after_widget);