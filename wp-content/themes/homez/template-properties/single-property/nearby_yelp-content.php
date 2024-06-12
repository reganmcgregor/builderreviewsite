<ul class="nav nav-tabs tabs-yelp" role="tablist">
	<?php $j = 1; foreach ($terms as $term) { 
		$cate_title = !empty($term['yelp_title']) ? $term['yelp_title'] : $term['yelp_category'];
	    $cate_icon = !empty($term['yelp_icon']) ? $term['yelp_icon'] : '';
	    $cate_term = '';

	    if (array_key_exists($term['yelp_category'], $all_cats)) {
	        $cate_term = str_replace('-', '+', $term['yelp_category']);
	    }
	    $yelp = WP_RealEstate_Property_Yelp::get_instance();
	    $businesses_data = $yelp->query_api($cate_term, '', $latitude, $longitude);
	    if ( $businesses_data ) { ?>
			<li class="nav-item" role="presentation">
			    <a class="nav-link <?php echo esc_attr($j == 1?' active':''); ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab-<?php echo esc_attr($j); ?>">
			    	<?php if ( !empty($cate_icon) ) { ?>
						<div class="yelp-icon">
							<img src="<?php echo esc_url($cate_icon); ?>" alt="<?php esc_attr_e('Image', 'homez'); ?>">
						</div>
					<?php } ?>
					<?php echo esc_html($cate_title); ?>
			    </a>
			</li>
		<?php } ?>
	<?php $j++; } ?>
</ul>

<div class="tab-content-yelp tab-content">
	<?php $i = 1; foreach ($terms as $term) { 
		$cate_title = !empty($term['yelp_title']) ? $term['yelp_title'] : $term['yelp_category'];
	    $cate_icon = !empty($term['yelp_icon']) ? $term['yelp_icon'] : '';
	    $cate_term = '';

	    if (array_key_exists($term['yelp_category'], $all_cats)) {
	        $cate_term = str_replace('-', '+', $term['yelp_category']);
	    }
	    $yelp = WP_RealEstate_Property_Yelp::get_instance();
	    $businesses_data = $yelp->query_api($cate_term, '', $latitude, $longitude);
		?>
		<div class="tab-pane fade <?php echo esc_attr($i == 1?'show active':''); ?>" id="tab-<?php echo esc_attr($i); ?>" role="tabpanel">
			<div class="yelp-list">
				<ul class="yelp-list-sub">
					<?php
			        foreach ($businesses_data as $data_business) {
			            $business_url = isset($data_business->url) ? $data_business->url : '';
			            $business_name = isset($data_business->name) ? $data_business->name : '';
			            $business_total_reviews = isset($data_business->review_count) ? $data_business->review_count : '';
			            $business_rating = isset($data_business->rating) ? $data_business->rating : '';
			            $business_distance = isset($data_business->distance) ? $data_business->distance : '';

			            $distance_unit = wp_realestate_get_option('api_settings_yelp_distance_unit');
			            if ( $business_distance ) {
			            	if ( $distance_unit == 'km' ) {
			            		$business_distance = round(($business_distance * 0.001), 2);
			            		$distance_text = esc_html__('km', 'homez');
			            	} else {
			            		$business_distance = round(($business_distance * 0.001  * 0.621371192), 2);
			            		$distance_text = esc_html__('miles', 'homez');
			            	}
			            	
			            }

			            ?>
			            <li>
			            	<div class="yelp-list-inner d-flex align-items-center">
			            		<div class="yelp-circle d-flex align-items-center justify-content-center flex-shrink-0 <?php echo ( ($business_rating==5)?'perfect':'' ); ?>"><span><?php echo trim($business_rating); ?></span>/5</div>
			                    <div class="inner flex-grow-1 d-flex align-items-center">
				                    <div class="inner-left">
										<div class="yelp-item-title">
				                            <a href="<?php echo esc_url_raw($business_url); ?>" target="_blank"><?php echo esc_html($business_name); ?></a>
				                            <?php if ( !empty($business_distance) ) { ?>
				                            	<div class="distance"><?php echo sprintf('(%s %s)', $business_distance, $distance_text); ?></div>
				                            <?php } ?>
					                    </div>
									</div>
					                <div class="inner-right">
				                        <div class="rating">
				                            <div class="average-rating">
				                            	<div class="average-inner" style="width: <?php echo round(($business_rating/5 * 100), 2).'%'; ?>"></div>
				                            </div>
				                        </div>
					                </div>
				                </div>
			                </div>
			            </li>
			        <?php
			        }
			        ?>
				</ul>
			</div>
		</div>
	<?php $i++; } ?>
</div>