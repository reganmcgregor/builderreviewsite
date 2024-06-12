<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$query_vars_pending = array(
	'post_type'     => 'property',
	'post_status'   => 'pending',
	'author'        => $user_id,
	'fields'		=> 'ids',
	'posts_per_page' => -1
);
$properties_pending = new WP_Query($query_vars_pending);
$count_properties_pending = $properties_pending->post_count;

$query_vars = array(
	'post_type'     => 'property',
	'post_status'   => 'publish',
	'author'        => $user_id,
	'fields'		=> 'ids',
	'posts_per_page' => -1
);
$properties = new WP_Query($query_vars);
$count_properties = $properties->post_count;

$favorite = WP_RealEstate_Favorite::get_property_favorites();
$favorite = is_array($favorite) ? count($favorite) : 0;

$user = wp_get_current_user();

$post_ids = array();
if ( WP_RealEstate_User::is_agent($user->ID) ) {
	$post_ids[] = WP_RealEstate_User::get_agent_by_user_id($user->ID);
} elseif ( WP_RealEstate_User::is_agency($user->ID) ) {
	$post_ids[] = WP_RealEstate_User::get_agency_by_user_id($user->ID);
}

if ( !empty($properties->posts) ) {
	$post_ids = array_merge($post_ids, $properties->posts);
}
$number = apply_filters('wp-realestate-dashboard-number-reviews', 3);
$args = array(
	'post_type' => array('property', 'agent', 'agency'),
	'status' => 'approve',
	'number'  => $number,
	'meta_query' => array(
        array(
           'key' => '_rating_avg',
           'value' => 0,
           'compare' => '>',
        )
    )
);
$comments = null;
if ( !empty($post_ids) ) {
	$comments = WP_RealEstate_Review::get_comments( $args, $post_ids );
}
?>

<div class="user-dashboard-wrapper">
	<h1 class="title-profile"><?php esc_html_e('Hello ', 'homez'); echo esc_html($user->data->display_name); ?></h1>
	<div class="statistics row space-30">
		<div class="col-sm-3 col-12">
			<div class="posted-properties dashboard-box box-white-dashboard d-flex align-items-center">
				<div class="inner-right flex-grow-1">
					<h4><?php esc_html_e('Published', 'homez'); ?></h4>
					<div class="properties-count"><?php echo WP_RealEstate_Mixes::format_number($count_properties); ?></div>
				</div>
				<div class="inner-left d-flex align-items-center justify-content-center ms-auto flex-shrink-0">
					<i class="flaticon-home"></i>
				</div>
			</div>
		</div>
		<div class="col-sm-3 col-12">
			<div class="posted-properties dashboard-box box-white-dashboard d-flex align-items-center">
				<div class="inner-right flex-grow-1">
					<h4><?php esc_html_e('Pending', 'homez'); ?></h4>
					<div class="properties-count"><?php echo WP_RealEstate_Mixes::format_number($count_properties_pending); ?></div>
				</div>
				<div class="inner-left d-flex align-items-center justify-content-center ms-auto flex-shrink-0">
					<i class="flaticon-keywording"></i>
				</div>
			</div>
		</div>
		<div class="col-sm-3 col-12">
			<div class="favorite dashboard-box box-white-dashboard d-flex align-items-center">
				<div class="inner-right flex-grow-1">
					<h4><?php esc_html_e('Favorites', 'homez'); ?></h4>
					<div class="properties-count"><?php echo WP_RealEstate_Mixes::format_number($favorite); ?></div>
				</div>
				<div class="inner-left d-flex align-items-center justify-content-center ms-auto flex-shrink-0">
					<i class="flaticon-like"></i>
				</div>
			</div>
		</div>
		<div class="col-sm-3 col-12">
			<div class="favorite dashboard-box box-white-dashboard d-flex align-items-center">
				<div class="inner-right flex-grow-1">
					<h4><?php esc_html_e('Reviews', 'homez'); ?></h4>
					<div class="properties-count">
					<?php 
						if ( $comments ){
							echo count($comments);
						} else{
							echo 0;
						}
					?>
					</div>
				</div>
				<div class="inner-left d-flex align-items-center justify-content-center ms-auto flex-shrink-0">
					<i class="flaticon-review"></i>
				</div>
			</div>
		</div>
		
	</div>
	<div class="recent-wrapper-dashboard row">

		<?php
			$second_column_class = 'col-12';
			$query_vars = array(
				'post_type'     => 'property',
				'post_status'   => apply_filters('wp-realestate-my-properties-post-statuses', array( 'publish', 'expired', 'pending', 'pending_approve', 'pending_payment', 'draft', 'preview' )),
				'paged'         => 1,
				'author'        => get_current_user_id(),
				'orderby'		=> 'date',
				'order'			=> 'DESC',
				'fields'			=> 'ids'
			);

			$properties = new WP_Query($query_vars);
			if ( !empty($properties->posts) ) {
				$second_column_class = 'col-sm-4 col-12';
				homez_load_select2();
		?>
			<div class="col-12 <?php echo esc_attr(homez_is_wp_private_message() ? 'col-sm-8' : ''); ?>">
				<div class="box-white-dashboard">
					<h3 class="title"><?php echo esc_html__( 'Page Views', 'homez' ); ?></h3>
					
					<div class="page_views-wrapper">
						<canvas id="dashboard_property_chart_wrapper" data-property_id="<?php echo esc_attr($properties->posts[0]); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-realestate-property-chart-nonce' )); ?>"></canvas>
					</div>

					<div class="search-form-stats">
						<form class="stats-graph-search-form" method="post">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label><?php esc_html_e('Properties', 'homez'); ?></label>
										<select class="form-control" name="property_id">
											<?php foreach ($properties->posts as $post_id) { ?>
												<option value="<?php echo esc_attr($post_id); ?>"><?php echo esc_html(get_the_title($post_id)); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label><?php esc_html_e('Date', 'homez'); ?></label>
										<select class="form-control" name="nb_days">
											<option value="30"><?php esc_html_e('30 days', 'homez'); ?></option>
											<option value="15" selected><?php esc_html_e('15 days', 'homez'); ?></option>
											<option value="7"><?php esc_html_e('7 days', 'homez'); ?></option>
										</select>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if ( homez_is_wp_private_message() ) { ?>
			<div class="<?php echo esc_attr($second_column_class); ?>">
				<!-- recent message -->
				<?php
					$args = array(
						'post_per_page' => 5,
						'author' => $user->ID,
					);
					$loop = WP_Private_Message_Message::get_list_messages($args);
					if ( $loop->have_posts() ) {
						?>
						<div class="box-white-dashboard">
							<h3 class="title"><?php echo esc_html__('Recent Messages','homez') ?></h3>
							<ul class="list-message-small">
								<?php
								$dashboard_id = wp_private_message_get_option('message_dashboard_page_id');
								$dashboard_link = get_permalink($dashboard_id);

								while ( $loop->have_posts() ) : $loop->the_post();
									global $post;
									$args = array(
										'post_per_page' => 1,
										'paged' => 1,
										'parent' => $post->ID,
									);
									$reply_messages = WP_Private_Message_Message::get_list_reply_messages($args);
									$read = get_post_meta($post->ID, '_read_'.get_current_user_id(), true);
									$yourself_id = get_current_user_id();
									$sender = get_post_meta($post->ID, '_sender', true);
									$recipient = get_post_meta($post->ID, '_recipient', true);
									if ( $yourself_id == $sender ) {
										$recipient_id = $recipient;
									} else {
										$recipient_id = $sender;
									}
									if ( $read ) {
										$classes = ' read';
									} else {
										$classes = ' unread';
									}
									$url_link = add_query_arg( 'id', $post->ID, $dashboard_link );
									?>
									<li id="message-id-<?php echo esc_attr($post->ID); ?>" class="<?php echo esc_attr($classes); ?>">
										<a class="message-item-small" href="<?php echo esc_url($url_link); ?>">
											<div class="avatar">
												<?php homez_private_message_user_avatar( $recipient_id ); ?>
											</div>
											<div class="content">
												<h4 class="user-name"><?php echo esc_html( get_the_author_meta('display_name', $recipient_id)); ?>
													<span class="message-time"> -
														<?php if ( $reply_messages->have_posts() ) { ?>
															<?php foreach ($reply_messages->posts as $rpost) {?>
																	<?php echo human_time_diff(get_the_time('U', $rpost), current_time('timestamp')); ?>
															<?php } ?>
														<?php } else { ?>
																<?php echo human_time_diff(get_the_time('U', $post), current_time('timestamp')); ?>
														<?php } ?>
													</span>
												</h4>
												<div class="message-title"><?php echo esc_html($post->post_title); ?></div>
											</div>
										</a>
									</li>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							</ul>
						</div>
						<?php
					}
				?>
			</div>
		<?php } ?>
	</div>
</div>