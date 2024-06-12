<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
extract( $args );
global $post;
if ( !empty($post->post_type) && $post->post_type == 'property' ) {
	$author_id = $post->post_author;
	$avatar = $a_phone = '';
	if ( WP_RealEstate_User::is_agency($author_id) ) {
		$agency_id = WP_RealEstate_User::get_agency_by_user_id($author_id);
		$agency_post = get_post($agency_id);
		$author_email = homez_agency_display_email($agency_post, 'no-title', false);
		
		$avatar = '';
		ob_start();
		homez_agency_display_image($agency_post);
		$avatar = ob_get_clean();

		$a_title = get_the_title($agency_id);
		$a_title_html = '<a href="'.get_permalink($agency_id).'">'.get_the_title($agency_id).'</a>';
		$a_phone = homez_agency_display_phone($agency_post, 'no-title', false);

		$whatsapp = WP_RealEstate_Agency::get_post_meta( $agency_id, 'whatsapp' );

	} elseif ( WP_RealEstate_User::is_agent($author_id) ) {
		$agent_id = WP_RealEstate_User::get_agent_by_user_id($author_id);
		$agent_post = get_post($agent_id);
		$author_email = homez_agent_display_email($agent_post, 'no-title', false);

		$avatar = '';
		ob_start();
		homez_agent_display_image($agent_post);
		$avatar = ob_get_clean();

		$a_title = get_the_title($agent_id);
		$a_title_html = '<a href="'.get_permalink($agent_id).'">'.get_the_title($agent_id).'</a>';
		$a_phone = homez_agent_display_phone($agent_post, 'no-title', false);

		$whatsapp = WP_RealEstate_Agent::get_post_meta( $agent_id, 'whatsapp' );

	} else {
		$user_id = $post->post_author;
		$author_email = get_the_author_meta('user_email');
		$a_title = $a_title_html = get_user_meta( $user_id, 'first_name', true ).' '.get_user_meta( $user_id, 'last_name', true );
		$a_phone = get_user_meta($user_id, '_phone', true);
		$a_phone = homez_user_display_phone($a_phone, 'no-title', false);

		$whatsapp = '';
	}

	if ( ! empty( $author_email ) ) :
		$email = $phone = '';
		if ( is_user_logged_in() ) {
			$current_user_id = get_current_user_id();
			$userdata = get_userdata( $current_user_id );
			$email = $userdata->user_email;
		}

		$rand_id = homez_random_key();
	?>	

		<div class="contact-form-agent top-single-property <?php echo esc_attr(!empty($style) ? $style : ''); ?>">
			<div class="agent-content-wrapper d-flex align-items-center">
				<div class="agent-thumbnail">
					<?php if ( !empty($avatar) ) {
						echo trim($avatar);
					} else {
				        echo homez_get_avatar($post->post_author, 180);
					} ?>
				</div>
				<div class="agent-content">
					<h3><?php echo trim($a_title_html); ?></h3>
					<div class="phone"><?php echo trim($a_phone); ?></div>
					<div class="email"><?php echo trim($author_email); ?></div>
				</div>
			</div>
			
			<form method="post" action="?" class="contact-form-wrapper form-theme">
		    	<div class="row">
			        <div class="col-12">
				        <div class="form-group">
				            <input id="contact-form-name-<?php echo esc_attr($rand_id); ?>" placeholder="<?php esc_attr_e( 'Name', 'homez' ); ?>" type="text" class="form-control" name="name" required="required">
				        </div><!-- /.form-group -->
				    </div>
				    <div class="col-12">
				        <div class="form-group">
				            <input id="contact-form-email-<?php echo esc_attr($rand_id); ?>" placeholder="<?php esc_attr_e( 'Email', 'homez' ); ?>" type="email" class="form-control" name="email" required="required" value="<?php echo esc_attr($email); ?>">
				        </div><!-- /.form-group -->
				    </div>
				    <div class="col-12">
				        <div class="form-group">
				            <input id="contact-form-phone-<?php echo esc_attr($rand_id); ?>" placeholder="<?php esc_attr_e( 'Phone', 'homez' ); ?>" type="text" class="form-control style2" name="phone" required="required" value="<?php echo esc_attr($phone); ?>">
				        </div><!-- /.form-group -->
				    </div>
		        </div>
		        <div class="form-group">
		            <textarea id="contact-form-message-<?php echo esc_attr($rand_id); ?>" placeholder="<?php esc_attr_e( 'Message', 'homez' ); ?>" class="form-control" name="message" required="required"></textarea>
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
		      	<div class="action-bottom">
			        <button class="button btn btn-dark btn-outline w-100" name="contact-form"><?php echo esc_html__( 'Send Message', 'homez' ); ?><i class="flaticon-up-right-arrow next"></i></button>
                </div>
		    </form>
		    
		    <?php do_action('wp-realestate-single-property-contact-form', $post); ?>
		    
		</div>
	<?php
	endif;
	
}