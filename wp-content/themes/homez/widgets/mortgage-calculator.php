<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
extract( $args );

extract( $args );
extract( $instance );

echo trim($before_widget);
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

if ( function_exists('wp_realestate_get_option') ) {
	if ( method_exists('WP_RealEstate_Price', 'get_current_currency') ) {
		$current_currency = WP_RealEstate_Price::get_current_currency();
		$multi_currencies = WP_RealEstate_Price::get_currencies_settings();

		if ( !empty($multi_currencies) && !empty($multi_currencies[$current_currency]) ) {
			$currency_args = $multi_currencies[$current_currency];
		}

		if ( !empty($currency_args) ) {
			$currency_symbol = !empty($currency_args['custom_symbol']) ? $currency_args['custom_symbol'] : '';
			if ( empty($currency_symbol) ) {
				$currency = !empty($currency_args['currency']) ? $currency_args['currency'] : 'USD';
				$currency_symbol = WP_RealEstate_Price::currency_symbol($currency);
			}
		}
	} else {
		$currency_symbol = wp_realestate_get_option('currency_symbol');
	}
}
if ( empty($currency_symbol) ) {
	$currency_symbol = '$';
}

?>

<div class="apus-mortgage-calculator-widget form-theme">
	<div class="form-group">
		<input class="form-control" id="apus_mortgage_property_price" type="text" placeholder="<?php esc_html_e('Price', 'homez'); ?>">
		<span class="unit"><?php echo esc_attr($currency_symbol); ?></span>
	</div>
	<div class="form-group">
		<input class="form-control" id="apus_mortgage_deposit" type="text" placeholder="<?php esc_html_e('Deposit', 'homez'); ?>">
		<span class="unit"><?php echo esc_attr($currency_symbol); ?></span>
	</div>
	<div class="form-group">
		<input class="form-control" id="apus_mortgage_interest_rate" type="text" placeholder="<?php esc_html_e('Rate', 'homez'); ?>">
		<span class="unit"><?php esc_html_e('%', 'homez'); ?></span>
	</div>
	<div class="form-group">
		<input class="form-control" id="apus_mortgage_term_years" type="text" placeholder="<?php esc_html_e('Loan Term', 'homez'); ?>">
		<span class="unit"><?php esc_html_e('Year', 'homez'); ?></span>
	</div>
	<button id="btn_mortgage_get_results" class="btn btn-theme btn-inverse w-100"><i class="flaticon-search pre"></i><?php esc_html_e('Calculate', 'homez'); ?></button>
	<div class="apus_mortgage_results"></div>
</div>
<?php echo trim($after_widget);