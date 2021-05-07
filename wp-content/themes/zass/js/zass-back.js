/**
 * Backend Zass scripts
 */
(function ($) {
	"use strict";
	$(document).ready(function () {
        // Init wpColorPicker color picker for menu label colors
        $('input.zass-menu-colorpicker').wpColorPicker();

        // Init wpColorPicker color picker for theme options
        $('input.zass-theme-options-colorpicker').wpColorPicker({
            change: function(event, ui){
                $(this).closest('div.controls').find('div.zass_font_preview p').css({color: ui.color});
            }
        });

		// Proper position featured images metaboxes
		var featured_img_meta = $('#postimagediv');
		var featured_imgs_arr = new Array();
		if (featured_img_meta.length) {
			for (var i = 5; i >= 2; i--) {
				featured_imgs_arr[i] = $('#zass_featured_' + i);
				if (featured_imgs_arr[i].length) {
					featured_imgs_arr[i].detach().insertAfter(featured_img_meta);
				}
			}
		}

		// Proper position Portfolio Gallery Options metabox
		var prtfl_gallery_options_meta = $('#zass_portfolio_cz');
		if (prtfl_gallery_options_meta.length && featured_img_meta.length) {
			prtfl_gallery_options_meta.detach().insertBefore(featured_img_meta);
		}

		// Init fonticonpicker on menu edit
		$('#menu-to-edit a.item-edit').on('click', function () {
			$(this).parents("li.menu-item").find("input.zass-menu-icons").fontIconPicker({
				source: zass_back_js_params.font_awesome_icon_classes
			});
		});

	});
})(window.jQuery);