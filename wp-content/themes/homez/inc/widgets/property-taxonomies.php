<?php

class Homez_Widget_Property_Taxonomies extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'apus_widget_property_taxonomies',
            esc_html__('Apus Properties Taxonomies', 'homez'),
            array( 'description' => esc_html__( 'Show list of property taxonomies', 'homez' ), )
        );
        $this->widgetName = 'property_taxonomies';
    }

    public function widget( $args, $instance ) {
        get_template_part('widgets/property-taxonomies', '', array('args' => $args, 'instance' => $instance));
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Locations',
            'taxonomy' => '',
            'orderby' => '',
            'order' => '',
            'show_count' => '',
            'show_hierarchy' => '',
            'hide_empty' => '',
            'max_depth' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        $orderbys = array(
            '' => esc_html__('Default', 'homez'),
            'menu_order' => esc_html__('Menu order', 'homez'),
            'name' => esc_html__('Name', 'homez'),
        );

        $taxonomies = array(
            '' => esc_html__('Choose a taxonomy', 'homez'),
            'property_type' => esc_html__('Types', 'homez'),
            'property_location' => esc_html__('Locations', 'homez'),
            'property_amenity' => esc_html__('Amenities', 'homez'),
            'property_label' => esc_html__('Labels', 'homez'),
            'property_material' => esc_html__('Materials', 'homez'),
            'property_status' => esc_html__('Statuses', 'homez'),
        );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'homez' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>">
                <?php echo esc_html__('Taxonomy:', 'homez' ); ?>
            </label>
            <select id="<?php echo esc_attr($this->get_field_id('taxonomy')); ?>" name="<?php echo esc_attr($this->get_field_name('taxonomy')); ?>">
                <?php foreach ($taxonomies as $key => $title) { ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected($instance['taxonomy'], $key); ?> ><?php echo esc_html( $title ); ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
                <?php echo esc_html__('Order By:', 'homez' ); ?>
            </label>
            <select id="<?php echo esc_attr($this->get_field_id('orderby')); ?>" name="<?php echo esc_attr($this->get_field_name('orderby')); ?>">
                <?php foreach ($orderbys as $key => $title) { ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected($instance['orderby'], $key); ?> ><?php echo esc_html( $title ); ?></option>
                <?php } ?>
            </select>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_count'], 1 ); ?> id="<?php echo esc_attr($this->get_field_id('show_count')); ?>" name="<?php echo esc_attr($this->get_field_name('show_count')); ?>" value="1" />
            <label for="<?php echo esc_attr($this->get_field_id('show_count') ); ?>">
                <?php esc_html_e('Show count', 'homez'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_hierarchy'], 1 ); ?> id="<?php echo esc_attr($this->get_field_id('show_hierarchy')); ?>" name="<?php echo esc_attr($this->get_field_name('show_hierarchy')); ?>" value="1" />
            <label for="<?php echo esc_attr($this->get_field_id('show_hierarchy') ); ?>">
                <?php esc_html_e('Show hierarchy', 'homez'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['hide_empty'], 1 ); ?> id="<?php echo esc_attr($this->get_field_id('hide_empty')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_empty')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_id('hide_empty') ); ?>">
                <?php esc_html_e('Hide empty', 'homez'); ?>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'max_depth' )); ?>"><?php esc_html_e( 'Maximum depth:', 'homez' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max_depth' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_depth' )); ?>" type="text" value="<?php echo esc_attr( $instance['max_depth'] ); ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : '';
        $instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
        $instance['show_count'] = ( ! empty( $new_instance['show_count'] ) ) ? strip_tags( $new_instance['show_count'] ) : '';
        $instance['show_hierarchy'] = ( ! empty( $new_instance['show_hierarchy'] ) ) ? strip_tags( $new_instance['show_hierarchy'] ) : '';
        $instance['hide_empty'] = ( ! empty( $new_instance['hide_empty'] ) ) ? strip_tags( $new_instance['hide_empty'] ) : '';
        $instance['max_depth'] = ( ! empty( $new_instance['max_depth'] ) ) ? strip_tags( $new_instance['max_depth'] ) : '';
        return $instance;

    }
}
call_user_func( implode('_', array('register', 'widget') ), 'Homez_Widget_Property_Taxonomies' );