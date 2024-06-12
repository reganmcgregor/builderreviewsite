<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<h1 class="title-profile"><?php esc_html_e('Change Password', 'homez'); ?></h1>
<div class="box-white-dashboard max-650">
	<form method="post" action="" class="change-password-form form-theme">
		<div class="clearfix">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="change-password-form-old-password"><?php echo esc_html__( 'Old password', 'homez' ); ?></label>
						<input id="change-password-form-old-password" class="form-control" type="password" name="old_password" required="required">
					</div><!-- /.form-control -->
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="change-password-form-new-password"><?php echo esc_html__( 'New password', 'homez' ); ?></label>
						<input id="change-password-form-new-password" class="form-control" type="password" name="new_password" required="required" minlength="8">
					</div><!-- /.form-control -->
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="change-password-form-retype-password"><?php echo esc_html__( 'Retype password', 'homez' ); ?></label>
						<input id="change-password-form-retype-password" class="form-control" type="password" name="retype_password" required="required" minlength="8">
					</div><!-- /.form-control -->
				</div>
			</div>
		</div>
		<button type="submit" name="change_password_form" class="button btn btn-theme btn-inverse"><?php echo esc_html__( 'Change Password', 'homez' ); ?><i class="flaticon-up-right-arrow next"></i></button>
	</form>
</div>