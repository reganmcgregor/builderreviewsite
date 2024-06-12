<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$user_id = get_current_user_id();
$pdate = get_the_time( get_option('date_format'), $rpost );
$current = strtotime(date("Y-m-d"));
$date    = strtotime( get_the_time('Y-m-d', $rpost) );

$datediff = $date - $current;
$difference = floor($datediff/(60*60*24));
if ( $difference == 0 ) {
  $date = esc_html__('Today', 'homez');
} elseif ( $difference == -1 ) {
  $date = esc_html__('Yesterday', 'homez');
}
?>
<li class="<?php echo esc_attr($rpost->post_author == $user_id ? 'yourself-reply' : 'user-reply'); ?> author-id-<?php echo esc_attr($rpost->post_author); ?>">
  <div class="d-flex align-items-center w-100 info-header">
      <div class="avatar">
        <?php homez_private_message_user_avatar( $rpost->post_author ); ?>
      </div>
    <div class="info-author d-flex align-items-center w-100">
      <?php if ( $rpost->post_author != $user_id ) { ?>
        <h3 class="name-author"><?php echo esc_html( get_the_author_meta('display_name', $user_id)); ?></h3>
      <?php } else { ?>
        <h3 class="name-author"><?php echo esc_html__('You','homez') ?></h3>
      <?php } ?>
      <span class="post-date"><?php echo trim($pdate); ?>, <?php echo get_the_time( get_option('time_format'), $rpost ); ?></span>
    </div>
  </div>
  <div class="reply-content">
    <div class="post-content"><?php echo esc_html($rpost->post_content); ?></div>
  </div>
</li>