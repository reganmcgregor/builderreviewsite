<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
homez_load_select2();
$rand = homez_random_key();

$login_title = !empty($login_title) ? $login_title : '';
$reset_password_title = !empty($reset_password_title) ? $reset_password_title : '';
?>
<div class="login-form-wrapper">
	
	<div id="login-form-wrapper-<?php echo esc_attr($rand); ?>" class="form-container form-login-register-inner ">
		<?php if ( $login_title ) { ?>
			<h2 class="title-small"><?php echo trim($login_title); ?></h2>
		<?php } ?>
		<form class="login-form form-theme" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
			<div class="form-group">
				<label for="username_or_email"><?php esc_html_e('Username Or Email', 'homez'); ?></label>
				<input autocomplete="off" type="text" name="username" class="form-control" id="username_or_email">
			</div>
			<div class="form-group">
				<label for="login_password"><?php echo esc_html__('Password','homez'); ?></label>
				<input name="password" type="password" class="password required form-control" id="login_password">
			</div>
			<div class="row form-group">
				<div class="col-6">
					<label for="user-remember-field">
						<input type="checkbox" name="remember" id="user-remember-field" value="true"> <?php echo esc_html__('Keep me signed in','homez'); ?>
					</label>
				</div>
				<div class="col-6 text-end">
					<a href="#forgot-password-form-wrapper-<?php echo esc_attr($rand); ?>" class="back-link" title="<?php esc_attr_e('Forgot Password','homez'); ?>"><?php echo esc_html__("Lost Your Password?",'homez'); ?></a>
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-theme btn-inverse w-100" type="submit"><?php echo esc_html__('Sign In','homez'); ?><i class="flaticon-up-right-arrow next"></i></button>
			</div>
			<?php do_action('login_form'); ?>
			<?php
				wp_nonce_field('ajax-login-nonce', 'security_login');
			?>
		</form>

		<?php if ( defined('HOMEZ_DEMO_MODE') && HOMEZ_DEMO_MODE ) { ?>
			<div class="sign-in-demo-notice">
				Username: <strong>agency</strong> or <strong>agent</strong><br>
				Password: <strong>demo</strong>
			</div>
		<?php } ?>

	</div>
	<!-- reset form -->
	<div id="forgot-password-form-wrapper-<?php echo esc_attr($rand); ?>" class="form-container form-login-register-inner form-forgot-password-inner">
		<?php if ( $reset_password_title ) { ?>
			<h2 class="title-small"><?php echo trim($reset_password_title); ?></h2>
		<?php } ?>
		<form name="forgotpasswordform" class="forgotpassword-form form-theme" action="<?php echo esc_url( site_url('wp-login.php?action=lostpassword', 'login_post') ); ?>" method="post">
			<div class="lostpassword-fields">
				<div class="form-group">
					<label for="lostpassword_username"><?php echo esc_html__('Username or E-mail','homez'); ?></label>
					<input type="text" name="user_login" class="user_login form-control" id="lostpassword_username">
				</div>
				<?php
					do_action('lostpassword_form');
					wp_nonce_field('ajax-lostpassword-nonce', 'security_lostpassword');
				?>

				<?php if ( version_compare(WP_REALESTATE_PLUGIN_VERSION, '1.1.0', '>=') && WP_RealEstate_Recaptcha::is_recaptcha_enabled() ) { ?>
		            <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_realestate_get_option( 'recaptcha_site_key' )); ?>"></div>
		      	<?php } ?>

				<div class="form-group">
					<button class="btn btn-dark w-100" type="submit"><?php echo esc_html__('Get New Password', 'homez'); ?><i class="flaticon-up-right-arrow next"></i></button>
					<input type="button" class="btn btn-danger w-100 btn-cancel mt-2" value="<?php esc_attr_e('Cancel', 'homez'); ?>" tabindex="101" />
				</div>
			</div>
			<div class="lostpassword-link"><a href="#login-form-wrapper-<?php echo esc_attr($rand); ?>" class="back-link"><?php echo esc_html__('Back To Login', 'homez'); ?></a></div>
		</form>
	</div>
</div>