<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;


$author_id = $post->post_author;
$avatar = $a_phone = '';
if ( WP_RealEstate_User::is_agency($author_id) ) {
    $agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
    $agency_post = get_post($agency_id);

    $author_email = homez_agency_display_email($agency_post, 'no-title', false);
    
} elseif ( WP_RealEstate_User::is_agent($author_id) ) {
    $agent_id = WP_RealEstate_User::get_agent_by_user_id($author_id);
    $agent_post = get_post($agent_id);
    $author_email = homez_agent_display_email($agent_post, 'no-title', false);

} else {
    $user_id = $post->post_author;
    $author_email = get_the_author_meta('user_email');
}

if ( ! empty( $author_email ) ) :
    
    $email = $phone = '';
    if ( is_user_logged_in() ) {
        $current_user_id = get_current_user_id();
        $userdata = get_userdata( $current_user_id );
        $email = $userdata->user_email;
    }

    $rand_id = homez_random_key();

    wp_enqueue_script( 'jquery-datetimepicker', get_template_directory_uri() . '/js/jquery.datetimepicker.full.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_style( 'jquery-datetimepicker', get_template_directory_uri() . '/css/jquery.datetimepicker.min.css', array(), '1.0.0' );
?>

    <div class="property-section property-schedule-a-tour">
        <h3 class="title"><?php esc_html_e('Schedule A Tour', 'homez'); ?></h3>
        <div class="inner">
            <form method="post" action="?" class="schedule-a-tour-form-wrapper form-theme">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="schedule-form-date-<?php echo esc_attr($rand_id); ?>" class="for-control"><?php esc_html_e( 'Date', 'homez' ); ?></label>
                            <input id="schedule-form-date-<?php echo esc_attr($rand_id); ?>" type="text" class="form-control" name="date" required="required" data-date_format="<?php echo esc_attr(get_option('date_format')); ?>">
                        </div><!-- /.form-group -->
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="schedule-form-time-<?php echo esc_attr($rand_id); ?>" class="for-control"><?php esc_html_e( 'Time', 'homez' ); ?></label>
                            <select class="form-control style2" name="time" required="required">
                                <option value=""></option>

                                <?php foreach (range(0, 86399, 1800) as $time) {
                                    $value = gmdate( 'H:i', $time);
                                ?>
                                    <option value="<?php echo esc_attr( $value ) ?>"><?php echo esc_html( gmdate( get_option( 'time_format' ), $time ) ) ?></option>
                                <?php }
                                    $value = gmdate( 'H:i', 86399);
                                ?>
                                <option value="<?php echo esc_attr( $value ) ?>"><?php echo esc_html( gmdate( get_option( 'time_format' ), 86399 ) ) ?></option>
                            </select>
                        </div><!-- /.form-group -->
                    </div>
                </div>

                <h5><?php esc_html_e('Your Information', 'homez'); ?></h5>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="schedule-form-name-<?php echo esc_attr($rand_id); ?>" class="for-control"><?php esc_html_e( 'Name', 'homez' ); ?></label>
                            <input id="schedule-form-name-<?php echo esc_attr($rand_id); ?>" type="text" class="form-control" name="name" required="required">
                        </div><!-- /.form-group -->
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="schedule-form-phone-<?php echo esc_attr($rand_id); ?>" class="for-control"><?php esc_html_e( 'Phone', 'homez' ); ?></label>
                            <input id="schedule-form-phone-<?php echo esc_attr($rand_id); ?>" type="text" class="form-control style2" name="phone" required="required" value="<?php echo esc_attr($phone); ?>">
                        </div><!-- /.form-group -->
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="schedule-form-email-<?php echo esc_attr($rand_id); ?>" class="for-control"><?php esc_html_e( 'Email', 'homez' ); ?></label>
                            <input id="schedule-form-email-<?php echo esc_attr($rand_id); ?>" type="email" class="form-control" name="email" required="required" value="<?php echo esc_attr($email); ?>">
                        </div><!-- /.form-group -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group space-30">
                            <label for="schedule-form-message-<?php echo esc_attr($rand_id); ?>" class="for-control"><?php esc_html_e( 'Message', 'homez' ); ?></label>
                            <textarea id="schedule-form-message-<?php echo esc_attr($rand_id); ?>" class="form-control" name="message"></textarea>
                        </div><!-- /.form-group -->
                    </div>
                </div>

                <?php if ( WP_RealEstate_Recaptcha::is_recaptcha_enabled() ) { ?>
                    <div id="recaptcha-schedule-a-tour-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_realestate_get_option( 'recaptcha_site_key' )); ?>"></div>
                <?php } ?>

                <?php
                    $page_id = wp_realestate_get_option('terms_conditions_page_id');
                    if ( !empty($page_id) ) {
                        $page_id = WP_RealEstate_Mixes::get_lang_post_id($page_id);
                        $page_url = get_permalink($page_id);
                    ?>
                    <div class="form-group">
                        <label for="register-terms-and-conditions">
                            <input type="checkbox" name="terms_and_conditions" value="on" id="register-terms-and-conditions" required>
                            <?php
                                echo sprintf(wp_kses(__('I have read and accept the <a href="%s">Terms and Privacy Policy</a>', 'homez'), array('a' => array('href' => array())) ), esc_url($page_url));
                            ?>
                        </label>
                    </div>
                <?php } ?>

                <input type="hidden" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
                <button class="button btn btn-dark btn-outline" name="schedule-a-tour-form"><?php esc_html_e( 'SUBMIT A TOUR REQUEST', 'homez' ); ?><i class="flaticon-up-right-arrow next"></i></button>
            </form>
        </div>

        <?php do_action('wp-realestate-single-property-schedule-a-tour', $post); ?>
    </div>
<?php endif;
