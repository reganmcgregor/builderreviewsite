<?php
global $post;
$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
$valuation = $meta_obj->get_post_meta('valuation_group');
if ( $meta_obj->check_post_meta_exist('valuation_group') && is_array( $valuation ) && count( $valuation[0] ) > 0 ) {
?>
    <div class="property-section property-valuation">
        <h3><?php echo esc_html__('Valuation', 'homez'); ?></h3>
        <?php foreach ( $valuation as $group ) : ?>
            <div class="valuation-item clearfix">
                <div class="d-flex">
                    <div class="valuation-label"><?php echo empty( $group['valuation_key'] ) ? '' : esc_attr( $group['valuation_key'] ); ?></div>
                    <span class="percentage-valuation ms-auto"><?php echo empty( $group['valuation_value'] ) ? '' : esc_attr( $group['valuation_value'] ); ?> <?php esc_html_e('%', 'homez'); ?></span>
                </div>
                <div class="property-valuation-item progress" >
                    <div class="bar-valuation progress-bar progress-bar-success"
                         style="width: <?php echo esc_attr( $group[ 'valuation_value' ] ); ?>%"
                         data-percentage="<?php echo empty( $group['valuation_value'] ) ? '' : esc_attr( $group['valuation_value'] ); ?>">
                    </div>
                </div><!-- /.property-valuation-item -->
                
            </div>
        <?php endforeach; ?>

        <?php do_action('wp-realestate-single-property-valuation', $post); ?>
    </div><!-- /.property-valuation -->
<?php }