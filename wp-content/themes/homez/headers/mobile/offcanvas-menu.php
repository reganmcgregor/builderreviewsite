<nav id="navbar-offcanvas" class="navbar hidden-lg" role="navigation">
    <ul>
        <?php
            $args = array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'nav navbar-nav',
                'fallback_cb'     => false,
                'walker' => new Homez_Mobile_Menu(),
                'items_wrap' => '%3$s',
            );
            wp_nav_menu($args);
        ?>
        
        
    </ul>

    <?php if ( homez_get_config('header_mobile_add_listing_btn', true) && homez_is_wp_realestate_activated() ) {
            $page_id = wp_realestate_get_option('submit_property_form_page_id');
            $submit_url = $page_id ? get_permalink($page_id) : home_url( '/' );
        ?>  
            <span class="mobile-submit text-center">
                <a href="<?php echo esc_url($submit_url); ?>" class="w-100 btn btn-theme btn-inverse btn-submit"><?php esc_html_e('Submit Property', 'homez'); ?><i class="flaticon-up-right-arrow next"></i></a>
            </span>
        <?php } ?>
</nav>