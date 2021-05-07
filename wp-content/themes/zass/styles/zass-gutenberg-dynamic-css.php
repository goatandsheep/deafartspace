<?php
/**
 * Insert the customized css from selected options on wp_head hook + the custom css for Gutenberg
 */
add_action( 'admin_enqueue_scripts', 'zass_add_custom_gutenberg_css', 99 );

if ( ! function_exists( 'zass_add_custom_gutenberg_css' ) ) {

	function zass_add_custom_gutenberg_css() {
		ob_start();
		?>
		<style media="all" type="text/css">
		
		div.edit-post-visual-editor blockquote, div.edit-post-visual-editor q {
				border-left-color:<?php echo esc_attr(zass_get_option('accent_color')) ?> !important;
            }

            a, .editor-rich-text__tinymce a, .wp-block-freeform.block-library-rich-text__tinymce a {
                color: <?php echo esc_attr(zass_get_option('links_color')) ?>;
                text-decoration: none;
			}
			
			.editor-post-title {
				background-color: <?php echo esc_attr(zass_get_option('page_title_bckgr_color')) ?>;
				margin-bottom: 60px;
			}

			/* Page Title background */
            <?php $title_backgr = zass_get_option('page_title_default_bckgr_image'); ?>
           <?php if ($title_backgr): ?>
		   .editor-post-title {
                   background: url("<?php echo esc_url(wp_get_attachment_image_url($title_backgr, 'full')) ?>");
               }

           <?php endif; ?>

            /* Body font */
            <?php $body_font = zass_get_option('body_font'); ?>
            body.gutenberg-editor-page .edit-post-visual-editor, body.gutenberg-editor-page .edit-post-visual-editor p:not(.wp-block-cover-text), .editor-styles-wrapper, .editor-styles-wrapper p, .block-editor .editor-styles-wrapper {
                <?php if(!empty($body_font['face'])): ?>
                    font-family:<?php echo esc_attr($body_font['face']) ?> !important;
                <?php endif; ?>
                font-size:<?php echo esc_attr($body_font['size']) ?>;
                color:<?php echo esc_attr($body_font['color']) ?>;
            }
            
            .wp-block-freeform.block-library-rich-text__tinymce code {
                color:<?php echo esc_attr($body_font['color']) ?>;
            }
                /* Heading fonts */
            <?php $headings_font = zass_get_option('headings_font'); ?>
            <?php if(!empty($headings_font['face'])): ?>
                div.edit-post-visual-editor h1, body.gutenberg-editor-page .edit-post-visual-editor p.wp-block-cover-image-text, div.edit-post-visual-editor h2, div.edit-post-visual-editor h3, div.edit-post-visual-editor h4, div.edit-post-visual-editor h5, div.edit-post-visual-editor h6, div.edit-post-visual-editor blockquote, div.edit-post-visual-editor q, body.gutenberg-editor-page div.edit-post-visual-editor blockquote p, body.gutenberg-editor-page div.edit-post-visual-editor q p, div.edit-post-visual-editor  textarea.editor-post-title__input {
                    font-family:<?php echo esc_attr($headings_font['face']) ?>;
                }
                <?php $use_google_face_for = zass_get_option('use_google_face_for'); ?>
                <?php if ($use_google_face_for['buttons']): ?>
                a.button, input.button, .wcv-navigation ul.menu.horizontal li a, .wcv-pro-dashboard input[type="submit"], button.button, input[type="submit"], a.button-inline, .zass_banner_buton, #submit_btn, #submit, .wpcf7-submit, .col2-set.addresses header a.edit, div.product input.qty, .zass-pricing-table-button a, .vc_btn3, nav.woocommerce-MyAccount-navigation ul li a {
                    font-family:<?php echo esc_attr($headings_font['face']) ?>;
                }
                <?php endif; ?>
            <?php endif; ?>
            /* H1 */
            <?php
			$h1_font = zass_get_option('h1_font');
			$h1_style = json_decode($h1_font['style'], true);
			$h1_css_style = '';
			if ($h1_style) {
				$h1_css_style = 'font-weight:' . esc_attr($h1_style['font-weight'] . ';font-style:' . $h1_style['font-style'] . ';');
			}
			?>
            h1, .editor-block-list__block-edit .wp-block-heading h1, .wp-block-freeform.block-library-rich-text__tinymce h1, .edit-post-visual-editor .editor-post-title__block .editor-post-title__input, .zass-counter-h1, .zass-typed-h1, .zass-dropcap p:first-letter, .zass-dropcap h1:first-letter, .zass-dropcap h2:first-letter, .zass-dropcap h3:first-letter, .zass-dropcap h4:first-letter, .zass-dropcap h5:first-letter, .zass-dropcap h6:first-letter{color:<?php echo esc_attr($h1_font['color']) ?> !important;font-size:<?php echo esc_attr($h1_font['size']) ?>;<?php echo esc_attr($h1_css_style) ?>}
            /* H2 */
            <?php
			$h2_font = zass_get_option('h2_font');
			$h2_style = json_decode($h2_font['style'], true);
			$h2_css_style = '';
			if ($h2_style) {
				$h2_css_style = 'font-weight:' . esc_attr($h2_style['font-weight'] . ';font-style:' . $h2_style['font-style'] . ';');
			}
			?>
            h2, .editor-block-list__block-edit .wp-block-heading h2, .wp-block-freeform.block-library-rich-text__tinymce h2, body.gutenberg-editor-page .edit-post-visual-editor p.wp-block-cover-image-text, .zass-counter-h2, .zass-typed-h2, .icon_teaser h3:first-child, body.woocommerce-account #customer_login.col2-set .owl-nav, .woocommerce #customer_login.u-columns.col2-set .owl-nav, .related.products h2, .upsells.products h2, .similar_projects > h4, .zass-related-blog-posts > h4, .tribe-events-related-events-title {color:<?php echo esc_attr($h2_font['color']) ?>;font-size:<?php echo esc_attr($h2_font['size']) ?>;<?php echo esc_attr($h2_css_style) ?>}
			.wp-block-cover p.wp-block-cover-text {
				font-size: <?php echo esc_attr($h2_font['size']) ?> !important;
				<?php echo esc_attr($h2_css_style) ?>
			}
			
			/* H3 */
            <?php
			$h3_font = zass_get_option('h3_font');
			$h3_style = json_decode($h3_font['style'], true);
			$h3_css_style = '';
			if ($h3_style) {
				$h3_css_style = 'font-weight:' . esc_attr($h3_style['font-weight'] . ';font-style:' . $h3_style['font-style'] . ';');
			}
			?>
            h3, .editor-block-list__block-edit .wp-block-heading h3, .wp-block-freeform.block-library-rich-text__tinymce h3, .zass-counter-h3, .zass-typed-h3, .woocommerce p.cart-empty {color:<?php echo esc_attr($h3_font['color']) ?>;font-size:<?php echo esc_attr($h3_font['size']) ?>;<?php echo esc_attr($h3_css_style) ?>}
            /* H4 */
            <?php
			$h4_font = zass_get_option('h4_font');
			$h4_style = json_decode($h4_font['style'], true);
			$h4_css_style = '';
			if ($h4_style) {
				$h4_css_style = 'font-weight:' . esc_attr($h4_style['font-weight'] . ';font-style:' . $h4_style['font-style'] . ';');
			}
			?>
            h4, .editor-block-list__block-edit .wp-block-heading h4, .wp-block-freeform.block-library-rich-text__tinymce h4, .zass-counter-h4, .zass-typed-h4{color:<?php echo esc_attr($h4_font['color']) ?>;font-size:<?php echo esc_attr($h4_font['size']) ?>;<?php echo esc_attr($h4_css_style) ?>}
            /* H5 */
            <?php
			$h5_font = zass_get_option('h5_font');
			$h5_style = json_decode($h5_font['style'], true);
			$h5_css_style = '';
			if ($h5_style) {
				$h5_css_style = 'font-weight:' . esc_attr($h5_style['font-weight'] . ';font-style:' . $h5_style['font-style'] . ';');
			}
			?>
            h5, .editor-block-list__block-edit .wp-block-heading h5, .wp-block-freeform.block-library-rich-text__tinymce h5, .zass-counter-h5, .zass-typed-h5{color:<?php echo esc_attr($h5_font['color']) ?>;font-size:<?php echo esc_attr($h5_font['size']) ?>;<?php echo esc_attr($h5_css_style) ?>}
            /* H6 */
            <?php
			$h6_font = zass_get_option('h6_font');
			$h6_style = json_decode($h6_font['style'], true);
			$h6_css_style = '';
			if ($h6_style) {
				$h6_css_style = 'font-weight:' . esc_attr($h6_style['font-weight'] . ';font-style:' . $h6_style['font-style'] . ';');
			}
			?>
            h6, .editor-block-list__block-edit .wp-block-heading h6, .wp-block-freeform.block-library-rich-text__tinymce h6, .zass-counter-h6, .zass-typed-h6{color:<?php echo esc_attr($h6_font['color']) ?>;font-size:<?php echo esc_attr($h6_font['size']) ?>;<?php echo esc_attr($h6_css_style) ?>}
            .edit-post-visual-editor .editor-post-title__block .editor-post-title__input {color: <?php echo esc_attr(zass_get_option('page_title_color')) ?> !important;}
        </style>
		<?php
		$custom_gutenberg_css = ob_get_clean();
		$custom_gutenberg_css = trim( preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $custom_gutenberg_css ) );

		wp_add_inline_style( 'zass_block_editor_assets', $custom_gutenberg_css ); // All dynamic data escaped
	}

}