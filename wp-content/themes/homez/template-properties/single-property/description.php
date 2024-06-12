<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>
<div class="description inner">
	
    <h3 class="title"><?php esc_html_e('Overview', 'homez'); ?></h3>
    <div class="description-inner">
    	<div class="description-inner-wrapper">
        	<?php the_content(); ?>
        </div>
        <?php if ( homez_get_config('show_property_desc_view_more', true) ) { ?>
	        <div class="show-more-less-wrapper">
	        	<a href="javascript:void(0);" class="show-more"><?php esc_html_e('Show more', 'homez'); ?></a>
	        	<a href="javascript:void(0);" class="show-less"><?php esc_html_e('Show less', 'homez'); ?></a>
	        </div>
	    <?php } ?>
        <?php do_action('wp-realestate-single-property-description', $post); ?>
    </div>
</div>