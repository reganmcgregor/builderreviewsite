<?php

$meta_obj = WP_RealEstate_Property_Meta::get_instance($property_id);

$address = $meta_obj->get_post_meta( 'map_location_address' );
$latitude = $meta_obj->get_post_meta( 'map_location_latitude' );
$longitude = $meta_obj->get_post_meta( 'map_location_longitude' );

if ( $walkscore_api_key != '' && $address ) {
	$datas = wp_remote_get('http://api.walkscore.com/score?format=json&transit=1&bike=1&address='.urlencode($address).'&lat='.urlencode($latitude).'&lon='.urlencode($longitude).'&wsapikey='.urlencode($walkscore_api_key));

	if (is_array($datas)) {
        $datas = json_decode($datas['body'], true);
        ?>
        <ul class="walks-core-list">
            <?php if (isset($datas['status']) && $datas['status'] == 1) : ?>
                <?php if (isset($datas['walkscore'])) : ?>
                    <li>
                    	<div class="d-flex align-items-center">
                    		<div class="flex-shrink-0"><span class="walkscore-icon d-flex align-items-center justify-content-center"><i class="flaticon-walking"></i></span></div>
                    		<div class="flex-grow-1 inner-right">
                    			<h3 class="title-walks"><a href="<?php echo esc_url($datas['ws_link']); ?>" target="_blank"><?php esc_html_e('Walk Scores', 'homez'); ?></a></h3>
	                            <span class="walkscore-score"><?php echo trim($datas['walkscore']); ?> / 100 </span><address>(<?php echo trim($datas['description']); ?>)</address>
                    		</div>
                    	</div>
                    </li>
                <?php endif; ?>
                <?php if (isset($datas['transit']) && !empty($datas['transit']['score'])) : ?>
                    <li class="walkscore-transit">
                    	<div class="d-flex align-items-center">
                    		<div class="flex-shrink-0"><span class="walkscore-icon d-flex align-items-center justify-content-center"><i class="flaticon-bus"></i></span></div>
                    		<div class="flex-grow-1 inner-right">
                    			<h3 class="title-walks"><a href="<?php echo trim($datas['ws_link']); ?>" target="_blank"><?php esc_html_e('Transit Score', 'homez'); ?></a></h3>
	                            <span class="walkscore-score"><?php echo trim($datas['transit']['score']); ?> / 100 </span><address>(<?php echo trim($datas['transit']['description']); ?>)</address>
                    		</div>
                    	</div>
                    </li>
                <?php endif; ?>
                <?php if (isset($datas['bike']) && !empty($datas['bike']['score'])) : ?>
                    <li class="walkscore-bike">
                    	<div class="d-flex align-items-center">
                    		<div class="flex-shrink-0"><span class="walkscore-icon d-flex align-items-center justify-content-center"><i class="flaticon-bike"></i></span></div>
                    		<div class="flex-grow-1 inner-right">
                    			<h3 class="title-walks"><a href="<?php echo esc_url($datas['ws_link']); ?>" target="_blank"><?php esc_html_e('Bike Score', 'homez'); ?></a></h3>
	                            <span class="walkscore-score"><?php echo trim($datas['bike']['score']); ?> / 100 </span><address>(<?php echo trim($datas['bike']['description']); ?>)</address>
                    		</div>
                    	</div>
                    </li>
                <?php endif; ?>

            <?php else: ?>
                <li>
                    <?php  esc_html_e('An error occurred while fetching walk scores.', 'homez'); ?>
                </li>
            <?php endif; ?>
        </ul>
        <div class="bottom-walkscore">
            <a class="text-underline" href="https://www.walkscore.com" target="_blank">
                <?php echo esc_html__('More Details Here','homez'); ?>
            </a>
        </div>
        <?php
    }
}