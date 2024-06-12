<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
extract( $args );
global $post;
if ( !empty($post->post_type) && ($post->post_type == 'agent' || $post->post_type == 'agency' || $post->post_type == 'property' ) ) {
	$user_id = $post->post_author;
	if ( $post->post_type == 'agency' ) {
		$author_name = $post->post_title;
	} elseif ( $post->post_type == 'agent' ) {
		$author_name = $post->post_title;
	} else {
		if ( WP_RealEstate_User::is_agency($user_id) ) {
			$agency_id = WP_RealEstate_User::get_agency_by_user_id($user_id);

			$author_name = get_the_title($agency_id);
		} elseif ( WP_RealEstate_User::is_agent($user_id) ) {
			$agent_id = WP_RealEstate_User::get_agent_by_user_id($user_id);
			
			$author_name = get_the_title($agent_id);
		} else {
			$author_name = get_the_author_meta('display_name');
		}
	}

	extract( $args );
	extract( $instance );

	echo trim($before_widget);
	$title = !empty($instance['title']) ? sprintf($instance['title'], $author_name) : '';
	$title = apply_filters('widget_title', $title);

	if ( $title ) {
	    echo trim($before_title)  . trim( $title ) . $after_title;
	}

	$rand_id = homez_random_key();
	?>
		<div class="contact-form-agent">
		    <?php
			if ( is_user_logged_in() ) {
				?>
				<a href="#click-popup-contact" class="btn btn-dark btn-outline w-100 click-popup"><?php echo esc_html__( 'Send Message', 'homez' ); ?><i class="flaticon-up-right-arrow next"></i></a>
				<div id="click-popup-contact" class="mfp-hide">
					<div class="popup-property-contact">
						<span class="close-advance-popup"><i class="ti-close"></i></span>
						<form id="send-message-form" class="send-message-form form-theme" action="?" method="post">
			                <div class="form-group">
			                	<label for="send-message-form-subject-<?php echo esc_attr($rand_id); ?>"><?php esc_attr_e( 'Subject', 'homez' ); ?></label>
			                    <input id="send-message-form-subject-<?php echo esc_attr($rand_id); ?>" type="text" class="form-control" name="subject" required="required">
			                </div><!-- /.form-group -->
			                <div class="form-group">
			                	<label for="send-message-form-message-<?php echo esc_attr($rand_id); ?>"><?php esc_attr_e( 'Enter text here...', 'homez' ); ?></label>
			                    <textarea id="send-message-form-message-<?php echo esc_attr($rand_id); ?>" class="form-control" name="message" required="required"></textarea>
			                </div><!-- /.form-group -->

			                <?php wp_nonce_field( 'wp-private-message-send-message', 'wp-private-message-send-message-nonce' ); ?>
			              	<input type="hidden" name="recipient" value="<?php echo esc_attr($user_id); ?>">
			              	<input type="hidden" name="action" value="wp_private_message_send_message">
			                <button class="button btn btn-theme btn-inverse w-100 send-message-btn"><?php echo esc_html__( 'Send Message', 'homez' ); ?><i class="flaticon-up-right-arrow next"></i></button>
			        	</form>
			        </div>
		        </div>
				<?php
			} else {
				$login_url = '';
				if ( function_exists('wp_realestate_get_option') ) {
					$login_register_page_id = wp_realestate_get_option('login_register_page_id');
					$login_url = get_permalink( $login_register_page_id );
				}
				?>
				<a href="<?php echo esc_url($login_url); ?>" class="login"><?php esc_html_e('Please login to send a private message', 'homez'); ?></a>
				<?php
			}
			?>
		</div>
	<?php
	echo trim($after_widget);
}

?>