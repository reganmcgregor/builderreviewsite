<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;

if ( ! comments_open() ) {
	return;
}

?>
<?php if ( have_comments() ) : ?>
	<?php 
		$nb_reviews = WP_RealEstate_Review::get_total_reviews($post->ID);
		$rating = get_post_meta( $post->ID, '_average_rating', true );
	?>
	<div id="comments">
		<div class="review-title-wrapper">
			<?php if ( WP_RealEstate_Review::review_enable() ) { ?>
				<h3 class="comments-title">
					<?php
						echo round($rating, 2);
						comments_number( esc_html__('(0 Reviews)', 'homez'), esc_html__('(1 Review)', 'homez'), esc_html__('(% Reviews)', 'homez') );
					?>
				</h3>
			<?php } else { ?>
				<h3 class="comments-title">
					<?php comments_number( esc_html__('0 Comments', 'homez'), esc_html__('1 Comment', 'homez'), esc_html__('% Comments', 'homez') ); ?>
				</h3>
			<?php } ?>
		</div>
		
		<?php if ( WP_RealEstate_Review::review_enable() ) {
			$reviews = get_post_meta( $post->ID, '_average_ratings', true );
			$categories = wp_realestate_get_option('property_review_category');
			if ( !empty($categories) ) { ?>
				<ul class="list-category-rating list d-sm-flex align-items-center flex-wrap">
		    		<?php foreach ($categories as $category) {
			            $rate = isset($reviews[$category['key']]) ? $reviews[$category['key']] : 0;
			            ?>
			            <li class="rating-inner d-flex align-items-center">
			            	<div class="category-label">
			            		<?php echo !empty($category['name']) ? $category['name'] : ''; ?>
			            	</div>
			            	<div class="ms-auto d-flex align-items-center category-value">
				                <div class="percent-wrapper">
				                	<div class="percent" style="<?php echo esc_attr( 'width: ' . ( $rate * 20 ) . '%' ) ?>"></div>
				                </div>
				                <div class="value">
				                	<?php echo round($rate, 2); ?>
				                </div>
			                </div>
			            </li>
			        <?php } ?>
		        </ul>
	    	<?php } ?>
		<?php } ?>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => array( 'WP_RealEstate_Review', 'property_comments' ) ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			echo '<nav class="apus-pagination">';
			paginate_comments_links( apply_filters( 'wp_realestate_comment_pagination_args', array(
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
			) ) );
			echo '</nav>';
		endif; ?>
		
	</div>
<?php endif; ?>

<div id="reviews">

	<?php $commenter = wp_get_current_commenter(); ?>
	<div id="review_form_wrapper">
		<div id="review_form">
			<?php
				$comment_form = array(
					'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'homez' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'homez' ), get_the_title() ),
					'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'homez' ),
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'fields'               => array(
						'author' => '<div class="row"><div class="col-12 col-sm-6"><div class="form-group">'.
						            '<label class="for-control">'.esc_html__( 'Name', 'homez' ).'</label><input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></div></div>',
						'email'  => '<div class="col-12 col-sm-6"><div class="form-group">' .
						            '<label class="for-control">'.esc_html__( 'Email', 'homez' ).'</label><input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div></div></div>',
					),
					'label_submit'  => esc_html__( 'Submit Review', 'homez' ),
					'logged_in_as'  => '',
					'comment_field' => '',
					'title_reply_before' => '<h4 class="title comment-reply-title">',
					'title_reply_after'  => '</h4>',
					'class_submit' => 'btn btn-dark btn-outline'
				);

				$comment_form['must_log_in'] = '<div class="must-log-in">' . wp_kses(__( 'You must be <a href="javascript:void(0)">logged in</a> to post a review.', 'homez' ), array('a' => array('class' => array(), 'href' => array())) ) . '</div>';
				
				$comment_form['comment_field'] .= '<div class="form-group space-comment"><label  class="for-control">'.esc_html__( 'Review', 'homez' ).'</label><textarea id="comment" class="form-control" name="comment" cols="45" rows="5" aria-required="true" required></textarea></div>';
				
				homez_comment_form($comment_form);
			?>
		</div>
	</div>
</div>