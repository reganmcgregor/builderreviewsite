<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_RealEstate_Property_Meta::get_instance($post->ID);

$attachments = $meta_obj->get_post_meta('attachments');

if ( $meta_obj->check_post_meta_exist('attachments') && $attachments ) {
	$admin_url = WP_RealEstate_Ajax::get_endpoint('wp_realestate_ajax_download_attachment');
?>
	<div class="property-section property-attachments">
		<h3 class="title"><?php echo esc_html__( 'Documents', 'homez' ); ?></h3>
		<div class="attachments-inner clearfix">
			<?php foreach ($attachments as $id => $attachment_url) {
		        $file_info = pathinfo($attachment_url);
		        if ( $file_info ) {
		            $download_url = add_query_arg(array('file_id' => $id), $admin_url);
		        ?>
		            <div class="attachment-item">
		                
		                <span class="attachment-detail-name">
		                	<i class="flaticon-file"></i>
			                <?php if ( !empty($file_info['basename']) ) { ?>
			                    <span class="basename"><?php echo esc_html($file_info['basename']); ?></span>
			                <?php } ?>
			            </span>

			            <a href="<?php echo esc_url($download_url); ?>" class="attachment-detail-download-url">
			            	<?php esc_html_e( 'DOWNLOAD', 'homez' ); ?>
			            </a>
		            </div>
		        <?php }
		    }?>
		</div>

		<?php do_action('wp-realestate-single-property-attachments', $post); ?>
	</div>
<?php }