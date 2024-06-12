<?php

class Homez_Widget_Property_Schedule_Tour extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'apus_property_schedule_tour',
            esc_html__('Property Detail:: Schedule A Tour', 'homez'),
            array( 'description' => esc_html__( 'Show property schedule a tour', 'homez' ), )
        );
        $this->widgetName = 'property_schedule_tour';
    }
    
    public function widget( $args, $instance ) {
        get_template_part('widgets/property-schedule-tour', '', array('args' => $args, 'instance' => $instance));
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Contact %1s',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'homez' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            <span class="desc"><?php esc_html_e('Enter %1s for property name', 'homez'); ?></span>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
call_user_func( implode('_', array('register', 'widget') ), 'Homez_Widget_Property_Schedule_Tour' );