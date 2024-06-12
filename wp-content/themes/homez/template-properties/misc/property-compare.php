<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !empty($property_ids) && is_array($property_ids) ) {
	$query_args = array(
		'post_type'         => 'property',
		'posts_per_page'    => -1,
		'paged'    			=> 1,
		'post_status'       => 'publish',
		'post__in'       	=> $property_ids,
		'fields'			=> 'ids'
	);

	$properties = new WP_Query($query_args);
	if ( $properties->have_posts() ) {
		?>
		<div class="wrapper-compare">
			<table class="compare-tables">
				<thead>
					<tr class="compare-top">
						<th>
							
						</th>
						<?php
						foreach ($properties->posts as $property_id) {
							$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($property_id);
							?>
							<th>
								<h3 class="property-title"><a href="<?php echo esc_url(get_permalink( $property_id )); ?>"><?php echo get_the_title( $property_id ) ?></a></h3>
							</th>
							<?php
						}
						?>
					</tr>
					<tr>
						<th>
							
						</th>
						<?php
						foreach ($properties->posts as $property_id) {
							$obj_property_meta = WP_RealEstate_Property_Meta::get_instance($property_id);
							$price = $obj_property_meta->get_price_html();
							$address = $obj_property_meta->get_post_meta( 'address' );
							?>
							<th>
								<div class="thumb">
									<?php if ( has_post_thumbnail( $property_id ) ) : ?>
										<?php echo get_the_post_thumbnail( $property_id, 'homez-property-grid' ); ?>
						            <?php endif; ?>
						            <a href="javascript:void(0);" class="btn-remove-property-compare btn-action-icon" data-property_id="<?php echo esc_attr($property_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-realestate-remove-property-compare-nonce' )); ?>">
										<i class="flaticon-bin"></i>
									</a>
								</div>
								<?php if ( $price ) { ?>
					                <div class="property-price"><?php echo trim($price); ?></div>
					            <?php } ?>
					            <?php if ( $address ) { ?>
					                <div class="property-address"><?php echo trim($address); ?></div>
					            <?php } ?>
							</th>
							<?php
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
						$compare_fields = WP_RealEstate_Compare::compare_fields();
						$count = 0;
						foreach ($compare_fields as $key => $field) {
							if( $key == 'title' || $key == 'price' || $key == 'address' ){
								continue;
							}
							if ( wp_realestate_get_option('enable_compare_'.$field['id'], 'on') == 'on' ) {
								?>
								<tr class="<?php echo esc_attr($count%2 == 0 ? 'tr-0' : 'tr-1'); ?>">
									<td><?php echo trim($field['name']); ?></td>
									<?php foreach ($properties->posts as $property_id) { ?>
										<td>
											<?php
												$val = WP_RealEstate_Compare::get_data($key, $property_id, $field);
												if ( is_array($val) ) {
													echo implode(', ', $val);
												} else {
													echo trim($val);
												}
											?>
										</td>
									<?php } ?>
								</tr>
								<?php
								$count++;
							}
						}
					?>
				</tbody>
			</table>
		</div>
		<?php
	}
} else {
?>
	<div class="not-found not-found-compare"><?php esc_html_e('No properties found.', 'homez'); ?></div>
<?php
}