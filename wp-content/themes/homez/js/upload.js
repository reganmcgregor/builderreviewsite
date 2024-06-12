jQuery(document).ready(function($){
	"use strict";
	var homez_upload;
	var homez_selector;

	function homez_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		homez_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( homez_upload ) {
			homez_upload.open();
			return;
		} else {
			// Create the media frame.
			homez_upload = wp.media.frames.homez_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			homez_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = homez_upload.state().get('selection').first();

				homez_upload.close();
				homez_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					homez_selector.find('.homez_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		homez_upload.open();
	}

	function homez_remove_file(selector) {
		selector.find('.homez_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.homez_upload_image_action .remove-image', function(event) {
		homez_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.homez_upload_image_action .add-image', function(event) {
		homez_add_file(event, $(this).parent().parent());
	});

});