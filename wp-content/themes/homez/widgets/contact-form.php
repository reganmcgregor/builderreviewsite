<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
extract( $args );

global $post;
if ( !empty($post->post_type) && ($post->post_type == 'agent' || $post->post_type == 'agency') ) {

	if ( $post->post_type == 'agent' ) {
		$author_email = WP_RealEstate_Agent::get_post_meta( $post->ID, 'email' );
	} else {
		$author_email = WP_RealEstate_Agency::get_post_meta( $post->ID, 'email' );
	}

	if ( ! empty( $author_email ) ) :
		extract( $args );
		extract( $instance );

		echo trim($before_widget);
		$title = !empty($instance['title']) ? sprintf($instance['title'], $post->post_title) : '';
		$title = apply_filters('widget_title', $title);

		if ( $title ) {
		    echo trim($before_title)  . trim( $title ) . $after_title;
		}

		$email = $phone = '';
		if ( is_user_logged_in() ) {
			$current_user_id = get_current_user_id();
			$userdata = get_userdata( $current_user_id );
			$email = $userdata->user_email;
		}

		$rand_id = homez_random_key();
	?>	

		<div class="contact-form-agent">
		    <form method="post" action="?" class="contact-form-wrapper form-theme">
		    	<div class="row">
			        <div class="col-sm-12">
				        <div class="form-group">
				        	<label for="contact-form-name-<?php echo esc_attr($rand_id); ?>"><?php esc_attr_e( 'Name', 'homez' ); ?></label>
				            <input id="contact-form-name-<?php echo esc_attr($rand_id); ?>" type="text" class="form-control" name="name" required="required">
				        </div><!-- /.form-group -->
				    </div>
				    <div class="col-sm-12">
				        <div class="form-group">
				        	<label for="contact-form-email-<?php echo esc_attr($rand_id); ?>"><?php esc_attr_e( 'Email', 'homez' ); ?></label>
				            <input id="contact-form-email-<?php echo esc_attr($rand_id); ?>" type="email" class="form-control" name="email" required="required" value="<?php echo esc_attr($email); ?>">
				        </div><!-- /.form-group -->
				    </div>
				    <div class="col-sm-12">
				        <div class="form-group">
				        	<label for="contact-form-phone-<?php echo esc_attr($rand_id); ?>"><?php esc_attr_e( 'Phone', 'homez' ); ?></label>
				            <input id="contact-form-phone-<?php echo esc_attr($rand_id); ?>" type="text" class="form-control" name="phone" required="required" value="<?php echo esc_attr($phone); ?>">
				        </div><!-- /.form-group -->
				    </div>
		        </div>
		        <div class="form-group">
		        	<label for="contact-form-message-<?php echo esc_attr($rand_id); ?>"><?php esc_attr_e( 'Message', 'homez' ); ?></label>
		            <textarea id="contact-form-message-<?php echo esc_attr($rand_id); ?>" class="form-control" name="message" required="required"></textarea>
		        </div><!-- /.form-group -->

		        <?php if ( WP_RealEstate_Recaptcha::is_recaptcha_enabled() ) { ?>
		            <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_realestate_get_option( 'recaptcha_site_key' )); ?>"></div>
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
		        <button class="button btn btn-theme btn-inverse w-100" name="contact-form"><?php echo esc_html__( 'Send Message', 'homez' ); ?><i class="flaticon-up-right-arrow next"></i></button>
		    </form>
		    <?php //do_action('homez_after_contact_form', $post); ?>
		</div>
	<?php endif;
	echo trim($after_widget);
}

?>