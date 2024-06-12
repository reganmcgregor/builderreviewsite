<?php
if ( !function_exists ('homez_custom_styles') ) {
	function homez_custom_styles() {
		global $post;	
		
		ob_start();	
		?>
		
			<?php if ( homez_get_config('main_color') != "" ) {
				$main_color = homez_get_config('main_color');
			} else {
				$main_color = '#EB6753';
			}
			if ( homez_get_config('second_color') != "" ) {
				$second_color = homez_get_config('second_color');
			} else {
				$second_color = '#181A20';
			}

			if ( homez_get_config('main_hover_color') != "" ) {
				$main_hover_color = homez_get_config('main_hover_color');
			} else {
				$main_hover_color = '#EE4C34';
			}

			if ( homez_get_config('second_hover_color') != "" ) {
				$second_hover_color = homez_get_config('second_hover_color');
			} else {
				$second_hover_color = '#EB6753';
			}

			if ( homez_get_config('text_color') != "" ) {
				$text_color = homez_get_config('text_color');
			} else {
				$text_color = '#181A20';
			}

			if ( homez_get_config('link_color') != "" ) {
				$link_color = homez_get_config('link_color');
			} else {
				$link_color = '#181A20';
			}

			if ( homez_get_config('link_hover_color') != "" ) {
				$link_hover_color = homez_get_config('link_hover_color');
			} else {
				$link_hover_color = '#181A20';
			}

			if ( homez_get_config('heading_color') != "" ) {
				$heading_color = homez_get_config('heading_color');
			} else {
				$heading_color = '#181A20';
			}

			$main_color_rgb = homez_hex2rgb($main_color);
			$second_color_rgb = homez_hex2rgb($second_color);
			
			// font
			$main_font = homez_get_config('main-font');
			$main_font = !empty($main_font) ? json_decode($main_font, true) : array();
			$main_font_family = !empty($main_font['fontfamily']) ? $main_font['fontfamily'] : 'Poppins';
			$main_font_weight = !empty($main_font['fontweight']) ? $main_font['fontweight'] : 400;
			$main_font_size = !empty(homez_get_config('main-font-size')) ? homez_get_config('main-font-size').'px' : '14px';

			$main_font_arr = explode(',', $main_font_family);
			if ( count($main_font_arr) == 1 ) {
				$main_font_family = "'".$main_font_family."'";
			}

			$heading_font = homez_get_config('heading-font');
			$heading_font = !empty($heading_font) ? json_decode($heading_font, true) : array();
			$heading_font_family = !empty($heading_font['fontfamily']) ? $heading_font['fontfamily'] : 'Poppins';
			$heading_font_weight = !empty($heading_font['fontweight']) ? $heading_font['fontweight'] : 600;

			$heading_font_arr = explode(',', $heading_font_family);
			if ( count($heading_font_arr) == 1 ) {
				$heading_font_family = "'".$heading_font_family."'";
			}
			?>
			:root {
			  --homez-theme-color: <?php echo trim($main_color); ?>;
			  --homez-second-color: <?php echo trim($second_color); ?>;
			  --homez-text-color: <?php echo trim($text_color); ?>;
			  --homez-link-color: <?php echo trim($link_color); ?>;
			  --homez-link_hover_color: <?php echo trim($link_hover_color); ?>;
			  --homez-heading-color: <?php echo trim($heading_color); ?>;
			  --homez-theme-hover-color: <?php echo trim($main_hover_color); ?>;
			  --homez-second-hover-color: <?php echo trim($second_hover_color); ?>;

			  --homez-main-font: <?php echo trim($main_font_family); ?>;
			  --homez-main-font-size: <?php echo trim($main_font_size); ?>;
			  --homez-main-font-weight: <?php echo trim($main_font_weight); ?>;
			  --homez-heading-font: <?php echo trim($heading_font_family); ?>;
			  --homez-heading-font-weight: <?php echo trim($heading_font_weight); ?>;

			  --homez-theme-color-005: <?php echo homez_generate_rgba($main_color_rgb, 0.05); ?>
			  --homez-theme-color-007: <?php echo homez_generate_rgba($main_color_rgb, 0.07); ?>
			  --homez-theme-color-010: <?php echo homez_generate_rgba($main_color_rgb, 0.1); ?>
			  --homez-theme-color-015: <?php echo homez_generate_rgba($main_color_rgb, 0.15); ?>
			  --homez-theme-color-020: <?php echo homez_generate_rgba($main_color_rgb, 0.2); ?>
			  --homez-second-color-050: <?php echo homez_generate_rgba($second_color_rgb, 0.5); ?>
			}
			
			<?php if (  homez_get_config('header_mobile_color') != "" ) : ?>
				#apus-header-mobile {
					background-color: <?php echo esc_html( homez_get_config('header_mobile_color') ); ?>;
				}
			<?php endif; ?>

	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}
		
		return implode($new_lines);
	}
}