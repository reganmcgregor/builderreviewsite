<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( wp_realestate_get_option('enable_multi_currencies') !== 'yes' ) {
	return;
}
$current_currency = WP_RealEstate_Price::get_current_currency();
$currency_symbol = WP_RealEstate_Price::currency_symbol($current_currency);
$currencies = WP_RealEstate_Price::get_currencies_settings();


if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
	$url = "https://";
} else {
    $url = "http://";
}
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
$url .= $_SERVER['REQUEST_URI'];

$url_arr = parse_url($url);
$uquery = isset($url_arr['query']) ? $url_arr['query'] : '';
if ( $uquery ) {
	$url = str_replace(array($uquery,'?'), '', $url);
}
?>
<div class="currencies-wrapper">
    <a id="dropdownMenuButton1" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#">
        <?php echo esc_html($currency_symbol.' '.$current_currency); ?>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
    	<form class="properties-currencies" method="get" action="<?php echo esc_url($url); ?>">
			<ul class="currencies">
				<?php
				foreach ($currencies as $currency) {
					$currency_symbol = WP_RealEstate_Price::currency_symbol($currency['currency']);
					?>
					<li class="<?php echo esc_attr($current_currency == $currency['currency'] ? 'active' : ''); ?>">
						<label for="input-currency-<?php echo esc_attr($currency['currency']); ?>">
							<input id="input-currency-<?php echo esc_attr($currency['currency']); ?>" type="radio" name="currency" value="<?php echo esc_attr($currency['currency']); ?>" class="hidden">
							<?php  echo esc_html($currency_symbol.' '.$currency['currency']); ?>
						</label>
					</li>
					<?php
				}
				?>
			</ul>

			<?php WP_RealEstate_Mixes::query_string_form_fields(null, array('currency')); ?>
		</form>
    </div>
</div>