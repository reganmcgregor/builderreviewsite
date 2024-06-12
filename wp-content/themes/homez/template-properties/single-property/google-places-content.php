<ul class="nav nav-tabs tabs-yelp" role="tablist">
    <?php $j = 1; foreach ($terms as $term) { 
        $cate_title = !empty($term['google_places_title']) ? $term['google_places_title'] : $term['google_places_category'];
        $cate_icon = !empty($term['google_places_icon']) ? $term['google_places_icon'] : '';
        $cate_term = $term['google_places_category'];

        $google_places = WP_RealEstate_Property_Google_Places::get_instance();
        $businesses_data = $google_places->search($cate_term, $location, 1500);
        $businesses_data = json_decode($businesses_data);
        if ( !empty($businesses_data->results) ) {
            
            ?>
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
    <?php $count = 1; foreach ($terms as $term) { 
        $cate_title = !empty($term['google_places_title']) ? $term['google_places_title'] : $term['google_places_category'];
        $cate_icon = !empty($term['google_places_icon']) ? $term['google_places_icon'] : '';
        $cate_term = $term['google_places_category'];

        $google_places = WP_RealEstate_Property_Google_Places::get_instance();
        $businesses_data = $google_places->search($cate_term, $location, 1500);
        $businesses_data = json_decode($businesses_data);
        if ( !empty($businesses_data->results) ) { ?>

            <div class="tab-pane fade <?php echo esc_attr($count == 1?'show active':''); ?>" id="tab-<?php echo esc_attr($count); ?>" role="tabpanel">
                <div class="yelp-list">
                    <ul class="yelp-list-sub">
                        <?php
                        $i = 0;
                        foreach ($businesses_data->results as $data_business) {
                            if ( $i >= $limit ) {
                                break;
                            }
                            $business_name = isset($data_business->name) ? $data_business->name : '';
                            $business_total_reviews = isset($data_business->user_ratings_total) ? $data_business->user_ratings_total : '';
                            $business_rating = isset($data_business->rating) ? $data_business->rating : '';

                            ?>
                            <li>
                                <div class="yelp-list-inner">
                                    <div class="inner-left">
                                        <div class="yelp-item-title">
                                            <?php echo esc_html($business_name); ?>
                                            
                                        </div>
                                    </div>
                                    <div class="inner-right">
                                        <div class="rating">
                                            <div class="average-rating">
                                                <div class="average-inner" style="width: <?php echo round(($business_rating/5 * 100), 2).'%'; ?>"></div>
                                            </div>
                                        </div>
                                        <span class="rating-count"><?php echo sprintf(_n('%d Review', '%d Reviews', absint($business_total_reviews), 'homez'), absint($business_total_reviews)); ?></span>
                                    </div>
                                </div>
                            </li>
                        <?php
                            $i++;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    <?php $count++; } ?>
</div>