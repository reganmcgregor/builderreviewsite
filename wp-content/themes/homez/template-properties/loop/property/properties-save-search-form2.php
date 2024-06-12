<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email_frequency_default = WP_RealEstate_Saved_Search::get_email_frequency();

$rand_key = isset($rand_key) ? $rand_key : homez_random_key();
?>

<div id="saved-search-form-btn-wrapper-<?php echo esc_attr($rand_key); ?>" class="saved-search-form-wrapper mfp-hide" data-effect="fadeIn">
	<button type="button" class="mfp-close">×</button>
	<form method="get" action="" class="saved-search-form2 form-theme" data-parent-form-id="#filter-listing-form-<?php echo esc_attr($rand_key); ?>">
		<div class="form-group">
		    <label for="saved_search_title"><?php esc_html_e('Title', 'homez'); ?></label>
		    <input type="text" name="name" class="form-control" id="saved_search_title" placeholder="<?php esc_html_e('Title', 'homez'); ?>">
		</div><!-- /.form-group -->

		<div class="form-group space-30">
		    <label for="saved_search_email_frequency"><?php esc_html_e('Email Frequency', 'homez'); ?></label>
		    <div class="wrapper-select">
			    <select name="email_frequency" class="form-control" id="saved_search_email_frequency">
			        <?php if ( !empty($email_frequency_default) ) { ?>
			            <?php foreach ($email_frequency_default as $key => $value) {
			                if ( !empty($value['label']) && !empty($value['days']) ) {
			            ?>
			                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value['label']); ?></option>

			                <?php } ?>
			            <?php } ?>
			        <?php } ?>
			    </select>
		    </div>
		</div><!-- /.form-group -->

		<?php
			do_action('wp-realestate-add-saved-search-form');

			wp_nonce_field('wp-realestate-add-saved-search-nonce', 'nonce');
		?>

		<div class="form-group m-0">
			<button class="button btn btn-theme w-100"><?php esc_html_e('Save', 'homez'); ?><span class="next"><i class="flaticon-up-right-arrow"></i></span></button>
		</div><!-- /.form-group -->

	</form>
</div>