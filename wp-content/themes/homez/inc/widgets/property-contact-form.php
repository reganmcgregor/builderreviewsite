<?php

class Homez_Widget_Property_Contact_Form extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'apus_property_contact_form',
            esc_html__('Property Detail:: Contact Form', 'homez'),
            array( 'description' => esc_html__( 'Show property contact form', 'homez' ), )
        );
        $this->widgetName = 'property_contact_form';
    }
    
    public function widget( $args, $instance ) {
        get_template_part('widgets/property-contact-form', '', array('args' => $args, 'instance' => $instance));
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Contact %1s',
            'style' => 'grid',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        $style = array(
            'normal' => esc_html__('Normal', 'homez'),
            'popup' => esc_html__('Popup', 'homez'),
        );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'homez' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            <span class="desc"><?php esc_html_e('Enter %1s for property name', 'homez'); ?></span>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('style')); ?>">
                <?php echo esc_html__('Style:', 'homez' ); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>">
                <?php foreach ($style as $key => $title) { ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected($instance['style'], $key); ?> ><?php echo esc_html( $title ); ?></option>
                <?php } ?>
            </select>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
call_user_func( implode('_', array('register', 'widget') ), 'Homez_Widget_Property_Contact_Form' );