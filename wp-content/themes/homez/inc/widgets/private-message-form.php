<?php

class Homez_Widget_Private_Message_Form extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'apus_private_message_form',
            esc_html__('Private Message Form', 'homez'),
            array( 'description' => esc_html__( 'Show property|agent|agency private message form', 'homez' ), )
        );
        $this->widgetName = 'private_message_form';
    }

    public function widget( $args, $instance ) {
        get_template_part('widgets/private-message-form', '', array('args' => $args, 'instance' => $instance));
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Send Message to %1s',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'homez' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            <span class="desc"><?php esc_html_e('Enter %1s for property|agent|agency name', 'homez'); ?></span>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
call_user_func( implode('_', array('register', 'widget') ), 'Homez_Widget_Private_Message_Form' );