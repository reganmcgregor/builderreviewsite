<?php

class Homez_Widget_Mortgage_Calculator extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'apus_mortgage_calculator',
            esc_html__('Apus Mortgage Calculator Widget', 'homez'),
            array( 'description' => esc_html__( 'Show Mortgage Calculator', 'homez' ), )
        );
        $this->widgetName = 'mortgage_calculator';
    }

    public function widget( $args, $instance ) {
        get_template_part('widgets/mortgage-calculator', '', array('args' => $args, 'instance' => $instance));
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Mortgage Calculator'
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
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;

    }
}

call_user_func( implode('_', array('register', 'widget') ), 'Homez_Widget_Mortgage_Calculator' );