<?php

class Homez_Widget_Agent_Information extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'apus_agent_information',
            esc_html__('Agent Detail:: Information', 'homez'),
            array( 'description' => esc_html__( 'Show agent information', 'homez' ), )
        );
        $this->widgetName = 'agent_information';
    }
    
    public function widget( $args, $instance ) {
        get_template_part('widgets/agent-information', '', array('args' => $args, 'instance' => $instance));
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Professional Information',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'homez' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
call_user_func( implode('_', array('register', 'widget') ), 'Homez_Widget_Agent_Information' );