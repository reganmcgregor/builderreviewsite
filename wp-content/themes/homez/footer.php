<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Homez
 * @since Homez 1.0
 */
$footer = apply_filters( 'homez_get_footer_layout', 'default' );
global $post;
?>
	</div><!-- .site-content -->
		<?php if ( !empty($footer) ): ?>
			<?php homez_display_footer_builder($footer); ?>
		<?php else: ?>
			<footer id="apus-footer" class="apus-footer " role="contentinfo">
				<div class="footer-default">
					<div class="apus-footer-inner">
						<div class="apus-copyright">
							<div class="container">
								<div class="copyright-content clearfix">
									<div class="text-copyright text-center">
										<?php
											
											$allowed_html_array = array( 'a' => array('href' => array()) );
											echo wp_kses(sprintf(__('&copy; %s - Homez. All Rights Reserved. <br/> Powered by <a href="//themeforest.net/user/apustheme">ApusTheme</a>', 'homez'), date("Y")), $allowed_html_array);
										?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer><!-- .site-footer -->
		<?php endif; ?>
	<?php
	if ( homez_get_config('back_to_top') ) { ?>
		<a href="#" id="back-to-top" class="add-fix-top d-flex align-items-center justify-content-center">
			<svg width="11" height="13" viewBox="0 0 11 13" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			<path d="M4.91531 0.303338C4.91508 0.303563 4.91483 0.303818 4.9146 0.304044L0.397167 4.82148C0.0459076 5.17587 0.0484487 5.74792 0.402842 6.09918C0.43085 6.12693 0.460637 6.15283 0.492033 6.17671C0.869832 6.43 1.37508 6.37472 1.68915 6.04571L4.19181 3.55208C4.32451 3.41952 4.43578 3.26712 4.52159 3.10034L4.66614 2.82477L4.66615 11.7015C4.64703 12.1561 4.95786 12.5584 5.40249 12.6547C5.89503 12.7346 6.35908 12.4001 6.43896 11.9075C6.44734 11.8558 6.45121 11.8035 6.45053 11.7512L6.45053 2.84284L6.54088 3.03709C6.6294 3.22663 6.75015 3.39933 6.89776 3.54756L9.3959 6.04571C9.70998 6.37472 10.2152 6.43 10.593 6.17671C10.9956 5.88192 11.083 5.31659 10.7882 4.91397C10.7644 4.88145 10.7384 4.85053 10.7105 4.82148L6.19304 0.304044C5.8404 -0.0489667 5.26835 -0.0492766 4.91531 0.303338Z" fill="currentColor"/>
			</svg>
		</a>
	<?php
	}
	?>
</div><!-- .site -->
<?php wp_footer(); ?>
</body>
</html>