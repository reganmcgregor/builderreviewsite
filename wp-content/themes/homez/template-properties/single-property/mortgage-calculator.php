<?php

global $post;
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


$down_payment = homez_get_config('mortgage_calculator_down_payment', '10000');
$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);
$price = $meta_obj->get_post_meta( 'price' );

if ( empty( $price ) || ! is_numeric( $price ) ) {
	$price = homez_get_config('mortgage_calculator_total_amount', '70000');
} elseif ( $price < $down_payment ) {
	$price = homez_get_config('mortgage_calculator_total_amount', '70000');
}

?>

<div class="apus-mortgage-calculator">
	<h3 class="title"><?php esc_html_e('Mortgage Calculator', 'homez'); ?></h3>
	<div class="row apus-mortgage-wrapper ">
		<div class="col-12 apus-mortgage-inner">
			<div class="apus_mortgage_results">

				<div class="mortgage-calculator-chart-wrapper">
					<?php
						$principal_interest_color = homez_get_config('mortgage_calculator_principal_interest_color', '#82DDD0');
						$property_tax_color = homez_get_config('mortgage_calculator_property_tax_color', '#80A1CC');
						$home_insurance_color = homez_get_config('mortgage_calculator_home_insurance_color', '#F5DD86');
					?>
					<canvas class="mortgage-calculator-chart d-none" id="mortgage-calculator-chart" width="270" height="270" data-principal_interest="<?php echo esc_attr($principal_interest_color); ?>" data-property_tax="<?php echo esc_attr($property_tax_color); ?>" data-home_insurance="<?php echo esc_attr($home_insurance_color); ?>"></canvas>

					<div class="monthly-payment-wrap d-flex align-items-center">
						<div class="monthly-payment monthly-payment-val">
							<?php echo WP_RealEstate_Price::format_price( $price ); ?>
						</div>
						<div class="space">/</div>
						<div class="monthly-requency"><?php esc_html_e('Monthly', 'homez'); ?></div>
					</div>

					<div class="d-flex align-items-center flex-wrap calculator-chart-percent">
						<div class="principal-interest-st" style="background-color: <?php echo esc_attr($principal_interest_color); ?>;"></div>
						<div class="property-tax-st" style="background-color: <?php echo esc_attr($property_tax_color); ?>;"></div>
						<div class="home-insurance-st" style="background-color: <?php echo esc_attr($home_insurance_color); ?>;"></div>
					</div>
					
				</div><!-- mortgage-calculator-chart -->
				<ul class="list list-result-calculator d-md-flex flex-wrap justify-content-between">
					<li class="d-flex align-items-center">
						<span class="name-result"><?php esc_html_e('Principal & Interest', 'homez'); ?></span> 
						<span class="principal-interest-val"></span>
					</li>

					<li class="d-flex align-items-center">
						<span class="name-result"><?php esc_html_e('Property Tax', 'homez'); ?></span> 
						<span class="property-tax-val"></span>
					</li>

					<li class="d-flex align-items-center"> 
						<span class="name-result"><?php esc_html_e('Home Insurance', 'homez'); ?></span> 
						<span class="home-insurance-val"></span>
					</li>

				</ul>
			</div>
		</div>
		<div class="col-12 apus-mortgage-inner-bottom">
			<form method="post" class="mortgage-calculator-form form-theme">
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="total-amount-id" class="for-control"><?php esc_html_e( 'Total Amount ', 'homez' ); echo trim('('.$currency_symbol).')'; ?></label>
							<input id="total-amount-id" class="form-control total-amount" type="text" value="<?php echo esc_attr($price); ?>">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="down-payment-id" class="for-control"><?php esc_html_e( 'Down Payment ', 'homez' ); echo trim('('.$currency_symbol).')'; ?></label>
							<input id="down-payment-id" class="form-control down-payment" type="text" value="<?php echo esc_attr($down_payment); ?>">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="interest-rate-id" class="for-control"><?php esc_html_e( 'Interest Rate %', 'homez' ); ?></label>
							<input id="interest-rate-id" class="form-control interest-rate" type="text" value="<?php echo esc_attr(homez_get_config('mortgage_calculator_interest_rate', '3.5')); ?>">
						</div>
					</div>

					<div class="col-6">
						<div class="form-group">
							<label for="loan-terms-id" class="for-control"><?php esc_html_e( 'Loan Terms (Years)', 'homez' ); ?></label>
							<input id="loan-terms-id" class="form-control loan-terms" type="text" value="<?php echo esc_attr(homez_get_config('mortgage_calculator_loan_terms', '15')); ?>">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="property-tax-id" class="for-control"><?php esc_html_e( 'Property Tax ', 'homez' ); echo trim('('.$currency_symbol).')'; ?></label>
							<input id="property-tax-id" class="form-control property-tax" type="text" value="<?php echo esc_attr(homez_get_config('mortgage_calculator_property_tax', '3000')); ?>">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="home-insurance-id" class="for-control"><?php esc_html_e( 'Home Insurance ', 'homez' ); echo trim('('.$currency_symbol).')'; ?></label>
							<input id="home-insurance-id" class="form-control home-insurance" type="text" value="<?php echo esc_attr(homez_get_config('mortgage_calculator_home_insurance', '1000')); ?>">
						</div>
					</div>
				</div>
				<div class="wrapper-submit">
					<button class="btn btn-dark btn-outline btn-mortgage-calculator" type="button"><?php esc_html_e('CALCULATE', 'homez'); ?><i class="flaticon-up-right-arrow next"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>