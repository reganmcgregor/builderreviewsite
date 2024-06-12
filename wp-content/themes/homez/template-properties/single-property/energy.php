<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
if ( $meta_obj->check_post_meta_exist('energy_class') && ($energy_class = $meta_obj->get_post_meta('energy_class')) ) {
    $options = array(
        'A+' => esc_html__('A+', 'homez'),
        'A' => esc_html__('A', 'homez'),
        'B' => esc_html__('B', 'homez'),
        'C' => esc_html__('C', 'homez'),
        'D' => esc_html__('D', 'homez'),
        'E' => esc_html__('E', 'homez'),
        'F' => esc_html__('F', 'homez'),
        'G' => esc_html__('G', 'homez'),
        'H' => esc_html__('H', 'homez'),
    );
?>
    <div class="property-detail-energy">
        <h3 class="title"><?php esc_html_e('Energy', 'homez'); ?></h3>
        <div class="inner">
            <div class="energy-inner-top">
                <ul class="list">
                    <li>
                        <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'energy_class' )); ?>:</div>
                        <div class="value"><?php echo trim($energy_class); ?></div>
                    </li>
                    <?php if ( $meta_obj->check_post_meta_exist('energy_index') && ($energy_index = $meta_obj->get_post_meta('energy_index')) ) { ?>
                        <li>
                            <div class="text"><?php echo esc_html($meta_obj->get_post_meta_title( 'energy_index' )); ?>:</div>
                            <div class="value"><?php echo trim($energy_index); ?></div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="energy-inner d-flex align-items-center">
                <?php foreach ($options as $key => $title) {
                    $classs = 'energy-'. strtolower($key);
                    if ( $key == 'A+' ) {
                        $classs = 'energy-aplus';
                    }
                ?>
                    <div class="energy-group <?php echo esc_attr($classs); ?>">
                        <?php echo esc_html($title); ?>
                        <?php if ( $energy_class == $key ) {
                            $energy_index = $meta_obj->get_post_meta('energy_index');
                            $energy_index_text = '';
                            if ( !empty($energy_index) ) {
                                $energy_index_text = $energy_index.' '.esc_html__('kWh/m²a', 'homez'). ' |';
                            }
                        ?>
                            <div class="indicator-energy">
                                <?php echo sprintf(esc_html__('%s Your energy class is %s', 'homez'), $energy_index_text, $title); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php do_action('wp-realestate-single-property-energy', $post); ?>
    </div>
<?php }