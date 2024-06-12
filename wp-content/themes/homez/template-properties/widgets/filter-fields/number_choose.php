<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$number_style = isset($field['number_style']) ? $field['number_style'] : '';
$min_number = isset($field['min_number']) ? $field['min_number'] : 1;
$max_number = isset($field['max_number']) ? $field['max_number'] : 5;

$placeholder = !empty($field['placeholder']) ? $field['placeholder'] : sprintf(esc_html__('%s : Any', 'homez'), $field['name']);
?>
<div class="form-group form-group-<?php echo esc_attr($key); ?> <?php echo esc_attr($number_style); ?>">
    <?php if ( (!isset($field['show_title']) || $field['show_title']) && !empty($field['name']) ) { ?>
        <label class="heading-label">
            <?php echo trim($field['name']); ?>
        </label>
    <?php } ?>
    <div class="form-group-inner inner choose-wrapper">
        
        <ul class="number-choose-list">
            <li class="list-item"><input id="<?php echo esc_attr($args['widget_id'].'_'.$key.'_0'); ?>" type="radio" name="<?php echo esc_attr($name); ?>" value=""  <?php checked($selected, ''); ?>><label for="<?php echo esc_attr($args['widget_id'].'_'.$key.'_0'); ?>"><?php echo esc_attr_e( 'Any', 'homez' ); ?></label>
            </li>
            <?php if ( $min_number <= $max_number ) {
                if ( $number_style == 'number' ) {
                    for ( $i = $min_number; $i <= $max_number; $i++ ) : ?>
                        <li class="list-item"><input id="<?php echo esc_attr($args['widget_id'].'_'.$key.'_'.$i); ?>" type="radio" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr( $i ); ?>" <?php checked($selected, $i); ?>><label for="<?php echo esc_attr($args['widget_id'].'_'.$key.'_'.$i); ?>"><?php echo esc_attr( $i ); ?></label>
                        </li>
                    <?php endfor;
                } else {
                    for ( $i = $min_number; $i <= $max_number; $i++ ) : ?>
                        <li class="list-item"><input id="<?php echo esc_attr($args['widget_id'].'_'.$key.'_'.$i); ?>" type="radio" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr( $i ); ?>+" <?php checked($selected, $i.'+'); ?>><label for="<?php echo esc_attr($args['widget_id'].'_'.$key.'_'.$i); ?>"><?php echo esc_attr( $i ); ?>+</label>
                        </li>
                    <?php endfor;
                }
            } ?>
        </ul>
    </div>
</div><!-- /.form-group -->