<?php
/**
 * Register second image field for WooCommerce categories
 * to be used in the category header
 */

add_action( 'product_cat_add_form_fields', 'zass_woocommerce_custom_cat_image_add', 11, 2 );
add_action( 'product_cat_edit_form_fields', 'zass_woocommerce_custom_cat_image_edit', 11, 2 );
add_action( 'created_term', 'zass_woocommerce_custom_cat_image_save', 10, 4 );
add_action( 'edit_term', 'zass_woocommerce_custom_cat_image_save', 10, 4 );

if ( ! function_exists( 'zass_woocommerce_custom_cat_image_add' ) ) {
	function zass_woocommerce_custom_cat_image_add() {
		?>
        <div class="form-field zass-term-header-img-wrap">
            <label><?php echo esc_html__( 'Title background image', 'zass-plugin' ); ?></label>
            <div id="zass_term_header_img" style="float: left; margin-right: 10px;"><img
                        src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px"/></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="zass_term_header_img_id" name="zass_term_header_img_id"/>
                <button type="button"
                        class="zass_term_header_img_upload_image_button button"><?php echo esc_html__( 'Upload/Add image', 'zass-plugin' ); ?></button>
                <button type="button"
                        class="zass_term_header_img_remove_image_button button"><?php echo esc_html__( 'Remove image', 'zass-plugin' ); ?></button>
            </div>
			<?php ob_start(); ?>
            <script type="text/javascript">
                // Only show the "remove image" button when needed
                if (!jQuery('#zass_term_header_img_id').val()) {
                    jQuery('.zass_term_header_img_remove_image_button').hide();
                }

                // Uploading files
                var zass_term_header_img_file_frame;

                jQuery(document).on('click', '.zass_term_header_img_upload_image_button', function (event) {

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if (zass_term_header_img_file_frame) {
                        zass_term_header_img_file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    zass_term_header_img_file_frame = wp.media.frames.downloadable_file = wp.media({
                        title: '<?php echo esc_html__( "Choose an image", "zass" ); ?>',
                        button: {
                            text: '<?php echo esc_html__( "Use image", "zass" ); ?>'
                        },
                        multiple: false
                    });

                    // When an image is selected, run a callback.
                    zass_term_header_img_file_frame.on('select', function () {
                        var attachment = zass_term_header_img_file_frame.state().get('selection').first().toJSON();

                        jQuery('#zass_term_header_img_id').val(attachment.id);
                        jQuery('#zass_term_header_img').find('img').attr('src', attachment.sizes.thumbnail.url);
                        jQuery('.zass_term_header_img_remove_image_button').show();
                    });

                    // Finally, open the modal.
                    zass_term_header_img_file_frame.open();
                });

                jQuery(document).on('click', '.zass_term_header_img_remove_image_button', function () {
                    jQuery('#zass_term_header_img').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
                    jQuery('#zass_term_header_img_id').val('');
                    jQuery('.zass_term_header_img_remove_image_button').hide();
                    return false;
                });

                jQuery(document).ajaxComplete(function (event, request, options) {
                    if (request && 4 === request.readyState && 200 === request.status
                        && options.data && 0 <= options.data.indexOf('action=add-tag')) {

                        var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                        if (!res || res.errors) {
                            return;
                        }
                        // Clear Thumbnail fields on submit
                        jQuery('#zass_term_header_img').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
                        jQuery('#zass_term_header_img_id').val('');
                        jQuery('.zass_term_header_img_remove_image_button').hide();
                        return;
                    }
                });

            </script>
			<?php $js_handle_header_img_on_cat_add = ob_get_clean(); ?>
			<?php wp_add_inline_script( 'zass-back', zass_strip_script_tag_from_js_block( $js_handle_header_img_on_cat_add ) ); ?>
            <div class="clear"></div>
        </div>
		<?php
	}
}

if ( ! function_exists( 'zass_woocommerce_custom_cat_image_edit' ) ) {
	function zass_woocommerce_custom_cat_image_edit( $term ) {

		$thumbnail_id = absint( get_term_meta( $term->term_id, 'zass_term_header_img_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = wc_placeholder_img_src();
		}
		?>
        <tr class="form-field">
            <th scope="row" valign="top"><label><?php echo esc_html__( 'Title background image', 'zass-plugin' ); ?></label></th>
            <td>
                <div id="zass_term_header_img" style="float: left; margin-right: 10px;"><img
                            src="<?php echo esc_url( $image ); ?>" width="60px" height="60px"/></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="zass_term_header_img_id" name="zass_term_header_img_id"
                           value="<?php echo $thumbnail_id; ?>"/>
                    <button type="button"
                            class="zass_term_header_img_upload_image_button button"><?php echo esc_html__( 'Upload/Add image', 'zass-plugin' ); ?></button>
                    <button type="button"
                            class="zass_term_header_img_remove_image_button button"><?php echo esc_html__( 'Remove image', 'zass-plugin' ); ?></button>
                </div>
				<?php ob_start(); ?>
                <script type="text/javascript">

                    // Only show the "remove image" button when needed
                    if ('0' === jQuery('#zass_term_header_img_id').val()) {
                        jQuery('.zass_term_header_img_remove_image_button').hide();
                    }

                    // Uploading files
                    var zass_term_header_img_file_frame;

                    jQuery(document).on('click', '.zass_term_header_img_upload_image_button', function (event) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if (zass_term_header_img_file_frame) {
                            zass_term_header_img_file_frame.open();
                            return;
                        }

                        // Create the media frame.
                        zass_term_header_img_file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php echo esc_html__( "Choose an image", "zass" ); ?>',
                            button: {
                                text: '<?php echo esc_html__( "Use image", "zass" ); ?>'
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
                        zass_term_header_img_file_frame.on('select', function () {
                            var attachment = zass_term_header_img_file_frame.state().get('selection').first().toJSON();

                            jQuery('#zass_term_header_img_id').val(attachment.id);
                            jQuery('#zass_term_header_img').find('img').attr('src', attachment.sizes.thumbnail.url);
                            jQuery('.zass_term_header_img_remove_image_button').show();
                        });

                        // Finally, open the modal.
                        zass_term_header_img_file_frame.open();
                    });

                    jQuery(document).on('click', '.zass_term_header_img_remove_image_button', function () {
                        jQuery('#zass_term_header_img').find('img').attr('src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>');
                        jQuery('#zass_term_header_img_id').val('');
                        jQuery('.zass_term_header_img_remove_image_button').hide();
                        return false;
                    });

                </script>
				<?php $js_handle_header_img_on_cat_edit = ob_get_clean(); ?>
				<?php wp_add_inline_script( 'zass-back', zass_strip_script_tag_from_js_block( $js_handle_header_img_on_cat_edit ) ); ?>
                <div class="clear"></div>
            </td>
        </tr>
		<?php
	}
}

if ( ! function_exists( 'zass_woocommerce_custom_cat_image_save' ) ) {
	function zass_woocommerce_custom_cat_image_save( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST['zass_term_header_img_id'] ) && 'product_cat' === $taxonomy ) {
			update_term_meta( $term_id, 'zass_term_header_img_id', absint( $_POST['zass_term_header_img_id'] ) );
		}
	}
}