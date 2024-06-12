<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$register_title = !empty($register_title) ? $register_title : '';
?>
<div class="register-form-wrapper">
  	<div class="form-login-register-inner">
  		<?php if ( $register_title ) { ?>
	  		<h2 class="title-small"><?php echo trim($register_title); ?></h2>
	  	<?php } ?>
      	<form name="registerForm" method="post" class="register-form form-theme">
      		
			<div class="form-group">
				<label><?php echo esc_html__('User Name','homez'); ?></label>
				<input type="text" class="form-control" name="username" id="register-username">
			</div>
			<div class="form-group">
				<label><?php echo esc_html__('Email','homez'); ?></label>
				<input type="text" class="form-control" name="email" id="register-email">
			</div>

			<?php if ( version_compare(WP_REALESTATE_PLUGIN_VERSION, '1.3.0', '>=') && wp_realestate_get_option('users_requires_approval') == 'phone_approve' ) { ?>
				<div class="form-group d-flex align-items-center">
					<?php
					
						$cc_list = include WP_REALESTATE_PLUGIN_DIR.'includes/sms/countries-phone.php';
						if ( wp_realestate_get_option('phone_approve_default_country_code') == 'geolocation' ) {
							$default_cc = WP_RealEstate_SMS_Geolocation::get_phone_code();
						} else {
							$default_cc = wp_realestate_get_option('phone_approve_default_country_code_custom');
						}
					?>
						<select class="form-control" name="phone-cc" id="register-phone-cc" required>
							<option disabled><?php esc_html_e( 'Select Country Code', 'homez' ); ?></option>
							<?php foreach( $cc_list as $country_code => $country_phone_code ): ?>
								<option value="<?php echo esc_attr($country_phone_code); ?>" <?php selected($country_phone_code, $default_cc); ?>><?php echo esc_html($country_code.' '.$country_phone_code); ?></option>
							<?php endforeach; ?>
						</select>
						

					<input type="text" class="form-control" name="phone" id="register-phone" placeholder="<?php esc_attr_e('Phone','homez'); ?>" required>

				</div>

				<input type="hidden" class="form-control" name="step" id="register-step" value="1">
				<input type="hidden" class="form-control" name="form-token" id="register-form-token" value="<?php echo mt_rand( 1000, 9999 ); ?>">
			<?php } ?>

			<div class="form-group">
				<label><?php echo esc_html__('Password','homez'); ?></label>
				<input type="password" class="form-control" name="password" id="password">
			</div>

			<div class="form-group">
				<label><?php echo esc_html__('Re-enter Password','homez'); ?></label>
				<input type="password" class="form-control" name="confirmpassword" id="confirmpassword">
			</div>

			<div class="form-group">
				<label><?php echo esc_html__('Roles','homez'); ?></label>
				<select class="form-control" name="role">
					<option value=""><?php esc_html_e('Select Role', 'homez'); ?></option>
					<option value="subscriber"><?php esc_html_e('User', 'homez'); ?></option>

					<?php if ( homez_get_config('register_form_enable_agent', true) ) { ?>
						<option value="wp_realestate_agent"><?php esc_html_e('Agent', 'homez'); ?></option>
					<?php } ?>

					<?php if ( homez_get_config('register_form_enable_agency', true) ) { ?>
						<option value="wp_realestate_agency"><?php esc_html_e('Agency', 'homez'); ?></option>
					<?php } ?>
				</select>
			</div>

			<?php wp_nonce_field('ajax-register-nonce', 'security_register'); ?>

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

			<div class="form-group m-0">
				<button type="submit" class="btn btn-theme btn-inverse w-100" name="submitRegister">
					<?php echo esc_html__('REGISTER', 'homez'); ?><i class="flaticon-up-right-arrow next"></i>
				</button>
			</div>
      	</form>

      	<?php if ( version_compare(WP_REALESTATE_PLUGIN_VERSION, '1.3.0', '>=') && wp_realestate_get_option('users_requires_approval') == 'phone_approve' ) { ?>
	  		<form name="registerFormOTP" method="post" class="register-form-otp form-login-register-inner">

				<div class="sent-txt">
					<span class="no-txt"></span>
					<span class="no-change"> <?php esc_html_e( 'Change', 'homez' ); ?></span>
				</div>

				<div class="notice-cont">
					<div class="notice"></div>
				</div>

				<div class="form-group">
					<div class="otp-input-cont">
						<?php for ( $i= 0; $i < wp_realestate_get_option('phone_approve_otp_digits', 4); $i++ ): ?>
							<input type="text" maxlength="1" autocomplete="off" name="otp[]" class="otp-input">
						<?php endfor; ?>
					</div>
				</div>

				<button type="submit" class="btn btn-theme w-100"><?php esc_html_e( 'Verify', 'homez' ); ?></button>

				<div class="resend">
					<a href="javascript:void(0);" class="resend-link"><?php esc_html_e( 'Not received your code? Resend code', 'homez' ); ?></a>
					<span class="resend-timer"></span>
				</div>

			</form>
		<?php } ?>

		<?php do_action('register_form'); ?>

    </div>
</div>