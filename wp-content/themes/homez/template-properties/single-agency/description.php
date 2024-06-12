<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;


?>
<div class="description inner">
	<h3 class="widget-title"><?php esc_html_e('About Me', 'homez'); ?></h3>
    <div class="description-inner">
        <?php the_content(); ?>
    </div>
</div>