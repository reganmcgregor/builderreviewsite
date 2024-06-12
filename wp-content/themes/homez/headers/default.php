<header id="apus-header" class="apus-header header-default d-xl-block d-none" role="banner">
    <div class="<?php echo (homez_get_config('keep_header') ? 'main-sticky-header-wrapper' : ''); ?>">
        <div class="<?php echo (homez_get_config('keep_header') ? 'main-sticky-header' : ''); ?>">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-2">
                        <div class="logo-in-theme">
                            <?php get_template_part( 'template-parts/logo/logo' ); ?>
                        </div>
                    </div>
                    <div class="col-10 d-flex align-items-center">
                        <?php if ( has_nav_menu( 'primary' ) ) : ?>
                            <div class="main-menu">
                                <nav data-duration="400" class="apus-megamenu animate navbar navbar-expand-lg" role="navigation">
                                <?php
                                    $args = array(
                                        'theme_location' => 'primary',
                                        'container_class' => 'collapse navbar-collapse p-0',
                                        'menu_class' => 'nav navbar-nav megamenu effect1',
                                        'fallback_cb' => '',
                                        'menu_id' => 'primary-menu',
                                        'walker' => new Homez_Nav_Menu()
                                    );
                                    wp_nav_menu($args);
                                ?>
                                </nav>
                            </div>
                        <?php endif; ?>
                        <div class="header-right ms-auto">
                            <?php if ( defined('HOMEZ_WOOCOMMERCE_ACTIVED') && homez_get_config('show_cartbtn') ): ?>
                                <div class="pull-right">
                                    <?php get_template_part( 'woocommerce/cart/mini-cart-button' ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>