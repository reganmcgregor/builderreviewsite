<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$phone = homez_agent_display_phone($post, 'icon', false, true);
$fax = homez_agent_display_meta_data($post, 'fax', '', 'flaticon-printer', false);
$email = homez_agent_display_email($post, 'title', false);
$website = homez_agent_display_website($post, 'title', false);
$job = homez_agent_display_job($post, false);
$socials = homez_agent_display_socials($post, '', false);
?>
<div class="wrapper-top-author">
    <div class="top-author-inner">
        <div class="container">
            <div class="col-12 col-lg-8">
                <div class="agent-detail-header top-detail-member">
                    <div class="d-md-flex align-items-center">

                        <?php if ( has_post_thumbnail() ) { ?>
                            <div class="member-thumbnail-wrapper flex-shrink-0">
                                <div class="d-flex align-items-center justify-content-center">
                                    <?php homez_agent_display_image($post,'170x170'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="member-information flex-grow-1 d-flex align-items-center">
                            <div class="inner">
                                
                                <div class="title-wrapper d-md-flex align-items-center">
                                    <?php the_title( '<h1 class="member-title">', '</h1>' ); ?>
                                    <?php homez_agent_display_featured_icon($post); ?>
                                </div>
                                <?php echo trim($job); ?>
                                <?php if ( $fax || $phone ) { ?>
                                    <div class="member-metas d-flex align-items-center flex-wrap">
                                        <?php homez_agent_display_rating($post); ?>
                                        <?php echo trim($phone); ?>
                                        <?php echo trim($fax); ?>
                                    </div>
                                <?php } ?>
                                <?php echo trim($socials); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4"></div>
        </div>
    </div>
</div>