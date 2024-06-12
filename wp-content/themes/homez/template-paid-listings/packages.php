<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( $packages ) : ?>
	<div class="widget-packages widget-subwoo woocommerce">
		<h2 class="title-profile"><?php esc_html_e( 'Packages', 'homez' ); ?></h2>
		<div class="row">
			<?php foreach ( $packages as $key => $package ) :
				$product = wc_get_product( $package );
				if ( ! $product->is_type( array( 'property_package', 'property_package_subscription' ) ) || ! $product->is_purchasable() ) {
					continue;
				}
				$package_icon = get_post_meta($product->get_id(), 'apus_product_package_icon_id', true);
				?>
				<div class="col-12 col-sm-6 col-md-4">
					<div class="subwoo-inner <?php echo esc_attr($product->is_featured()?'is_featured':''); ?>">
						<div class="item">
							<div class="header-sub">
								<div class="flex-grow-1">
									<h3 class="title"><?php echo trim($product->get_title()); ?></h3>
									<div class="price">
										<?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free', 'homez'); ?>
									</div>
								</div>
								<div class="ms-auto package_icon">
									<?php
									if ( $package_icon ) {
										echo homez_get_attachment_thumbnail($package_icon, 'full');
									}
									?>
								</div>
							</div>
							<div class="content">
                                <?php echo get_post_field('post_content', $product->get_id()); ?>
                            </div>
							<div class="bottom-sub">
								<div class="short-des"><?php echo apply_filters( 'the_excerpt', get_post_field('post_excerpt', $product->get_id()) ) ?></div>
								<div class="button-action">
									<div class="add-cart">
										<button class="button" type="submit" name="wjbwpl_property_package" value="<?php echo esc_attr($product->get_id()); ?>" id="package-<?php echo esc_attr($product->get_id()); ?>">
											<?php esc_html_e('Get Started', 'homez') ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach;
				wp_reset_postdata();
			?>
		</div>
	</div>
<?php endif; ?>