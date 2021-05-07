<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, maximum-scale=1" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php if (zass_get_option('show_preloader')): ?>
			<div class="mask">
				<div id="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (zass_get_option('add_to_cart_sound')): ?>
			<audio id="cart_add_sound" controls preload="auto" hidden="hidden">
				<source src="<?php echo get_template_directory_uri(); ?>/js/cart_add.wav" type="audio/wav">
			</audio>
		<?php endif; ?>

		<?php
		global $zass_is_blank;

		// Set main menu as mobile if no mobile menu was set
		$mobile_menu_id  = 'primary';
		if ( has_nav_menu('mobile') ) {
			$mobile_menu_id = "mobile";
		}

		if (!$zass_is_blank) {
			// Top mobile menu
			$zass_top_nav_mobile_args = array(
					'theme_location' => $mobile_menu_id,
					'container' => 'div',
					'container_id' => 'menu_mobile',
					'menu_id' => 'mobile-menu',
					'items_wrap' => '<a class="mob-close-toggle"></a><ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback_cb' => '',
			);
			wp_nav_menu($zass_top_nav_mobile_args);
		}

		// Are search or cart enabled or is accaunt page
		$zass_is_search_or_cart_or_account = false;
		if (zass_get_option('show_searchform') || (ZASS_IS_WOOCOMMERCE && zass_get_option('show_shopping_cart'))|| (ZASS_IS_WOOCOMMERCE && get_option( 'woocommerce_myaccount_page_id' ))) {
			$zass_is_search_or_cart_or_account = true;
		}

		$zass_is_left_header = false;

		$zass_general_layout = zass_get_option('general_layout');
		$zass_to_override = get_post_meta(get_queried_object_id(), 'zass_override_default_layout', true);
		$zass_specific_layout = get_post_meta(get_queried_object_id(), 'zass_layout', true);

		if ($zass_general_layout == 'zass_header_left' || $zass_to_override && $zass_specific_layout == 'zass_header_left') {
			$zass_is_left_header = true;
		}

		$zass_meta_show_pre_header = get_post_meta(get_queried_object_id(), 'zass_top_header', true);
		if (!$zass_meta_show_pre_header) {
			$zass_meta_show_pre_header = 'default';
		}

		$zass_featured_slider = get_post_meta(get_queried_object_id(), 'zass_rev_slider', true);
		if (!$zass_featured_slider) {
			$zass_featured_slider = 'none';
		}

		$zass_rev_slider_before_header = get_post_meta(get_queried_object_id(), 'zass_rev_slider_before_header', true);
		if (!$zass_rev_slider_before_header) {
			$zass_rev_slider_before_header = 0;
		}
		?>
		<!-- MAIN WRAPPER -->
		<div id="container">
			<!-- If it is not a blank page template -->
			<?php if (!$zass_is_blank): ?>
				<?php if (is_page() && $zass_featured_slider != 'none' && function_exists('putRevSlider') && $zass_rev_slider_before_header): ?>
					<!-- FEATURED REVOLUTION SLIDER -->
					<div class="zass-intro slideshow">
						<div class="inner">
							<?php putRevSlider($zass_featured_slider) ?>
						</div>
					</div>
					<!-- END OF FEATURED REVOLUTION SLIDER -->
				<?php endif; ?>
				<!-- Collapsible Pre-Header -->
				<?php if (zass_get_option('enable_pre_header') && is_active_sidebar('pre_header_sidebar')): ?>
					<div id="pre_header"> <a href="#" class="toggler" id="toggle_switch" title="<?php esc_attr_e('Show/Hide', 'zass') ?>"><?php esc_html_e('Slide toggle', 'zass') ?></a>
						<div id="togglerone" class="inner">
							<!-- Pre-Header widget area -->
							<?php dynamic_sidebar('pre_header_sidebar') ?>
							<div class="clear"></div>
						</div>
					</div>
				<?php endif; ?>
				<!-- END Collapsible Pre-Header -->
				<!-- HEADER -->
				<div id="header">
					<?php if (zass_get_option('enable_top_header') && $zass_meta_show_pre_header == 'default' || $zass_meta_show_pre_header == 'show'): ?>
						<div id="header_top" class="fixed">
							<div class="inner">
								<?php if (function_exists('icl_get_languages')): ?>
									<div id="language">
										<?php zass_language_selector_flags(); ?>
									</div>
								<?php endif; ?>
								<!--	Social profiles in header-->
								<?php if (zass_get_option('social_in_header')): ?>
									<?php get_template_part('partials/social-profiles'); ?>
								<?php endif; ?>
								<?php if (zass_get_option('top_bar_message') || zass_get_option('top_bar_message_phone') || zass_get_option('top_bar_message_email')): ?>
									<div class="zass-top-bar-message">
										<?php echo esc_html(zass_get_option('top_bar_message')) ?>
										<?php if (zass_get_option('top_bar_message_email')): ?>
											<span class="zass-top-bar-mail">
												<?php if ( zass_get_option( 'top_bar_message_email_link' ) ): ?><a href="mailto:<?php echo esc_html( zass_get_option( 'top_bar_message_email' ) ) ?>"><?php endif; ?>
													<?php echo esc_html(zass_get_option('top_bar_message_email')) ?>
												<?php if ( zass_get_option( 'top_bar_message_email_link' ) ): ?></a><?php endif; ?>
											</span>
										<?php endif; ?>
										<?php if (zass_get_option('top_bar_message_phone')): ?>
											<span class="zass-top-bar-phone">
												<?php if ( zass_get_option( 'top_bar_message_phone_link' ) ): ?><a href="tel:<?php echo preg_replace( "/[^0-9+-]/", "", esc_html( zass_get_option( 'top_bar_message_phone' ) ) ) ?>"><?php endif; ?>
													<?php echo esc_html( zass_get_option( 'top_bar_message_phone' ) ) ?>
												<?php if ( zass_get_option( 'top_bar_message_phone_link' ) ): ?></a><?php endif; ?>
											</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php
								/* Secondary menu */
								$zass_side_nav_args = array(
										'theme_location' => 'secondary',
										'container' => 'div',
										'container_id' => 'menu',
										'menu_class' => '',
										'menu_id' => 'topnav2',
										'fallback_cb' => '',
								);
								wp_nav_menu($zass_side_nav_args);
								?>
							</div>
						</div>
					<?php endif; ?>

					<div class="inner main_menu_holder fixed">
						<?php
						$zass_theme_logo_img = zass_get_option('theme_logo');
						$zass_transparent_theme_logo_img = zass_get_option('transparent_theme_logo');

						// If there is no secondary logo add 'persistent_logo' class to the main logo
						$zass_persistent_logo_class = $zass_transparent_theme_logo_img ? '' : 'persistent_logo';

						if (!$zass_theme_logo_img && !$zass_transparent_theme_logo_img && (get_bloginfo('name') || get_bloginfo('description'))) {
							$zass_is_text_logo = true;
						} else {
							$zass_is_text_logo = false;
						}
						?>
						<div <?php if ($zass_is_text_logo) echo 'class="zass_text_logo"' ?> id="logo">
							<a href="<?php echo esc_url(zass_wpml_get_home_url()); ?>"  title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
								<?php
								// Main logo
								if ($zass_theme_logo_img) {
									echo wp_get_attachment_image($zass_theme_logo_img, 'full', false, array('class' => esc_attr($zass_persistent_logo_class)));
								}

								// Secondary logo
								if ($zass_transparent_theme_logo_img) {
									echo wp_get_attachment_image($zass_transparent_theme_logo_img, 'full', false, array('class' => 'transparent_logo'));
								}
								?>
								<?php if ($zass_is_text_logo): ?>
									<span class="zass-logo-title"><?php bloginfo('name') ?></span>
									<span class="zass-logo-subtitle"><?php bloginfo('description') ?></span>
								<?php endif; ?>
							</a>
						</div>
						<a class="mob-menu-toggle" href="#"><i class="fa fa-bars"></i></a>

						<?php if ($zass_is_search_or_cart_or_account): ?>
							<div class="zass-search-cart-holder">
								<?php if (zass_get_option('show_searchform')): ?>
									<div id="search">
										<?php $zass_search_options = zass_get_option('search_options'); ?>
										<?php if (ZASS_IS_WOOCOMMERCE && isset($zass_search_options['only_products']) && $zass_search_options['only_products']): ?>
											<?php get_product_search_form(true) ?>
										<?php else: ?>
											<?php get_search_form(); ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<!-- SHOPPING CART -->
								<?php if (ZASS_IS_WOOCOMMERCE && zass_get_option('show_shopping_cart')): ?>
									<ul id="cart-module" class="site-header-cart">
										<?php zass_cart_link(); ?>
										<li>
											<?php the_widget('WC_Widget_Cart', 'title='); ?>
										</li>
									</ul>
								<?php endif; ?>
								<!-- END OF SHOPPING CART -->

								<?php if (ZASS_IS_WOOCOMMERCE && ZASS_IS_WISHLIST && zass_get_option('show_wish_in_header')): ?>
									<div class="zass-wishlist-counter">
										<a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" title="<?php echo esc_attr__('Wishlist', 'zass') ?>">
											<i class="fa fa-heart"></i>
											<span class="zass-wish-number"><?php echo esc_html(YITH_WCWL()->count_products()); ?></span>
										</a>
									</div>
								<?php endif; ?>

								<?php if (ZASS_IS_WOOCOMMERCE && zass_get_option('show_my_account') && get_option( 'woocommerce_myaccount_page_id' ) ): ?>
									<?php global $current_user; ?>
									<?php wp_get_current_user(); ?>
                                    <div id="zass-account-holder">
                                        <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'zass' ); ?>">
                                            <i class="fa fa-user"></i>
                                        </a>
                                    </div>
								<?php endif; ?>

							</div>
						<?php endif; ?>
						<?php
						// Top menu
						$zass_top_nav_args = array(
								'theme_location' => 'primary',
								'container' => 'div',
								'container_id' => 'main-menu',
								'container_class' => 'menu-main-menu-container',
								'menu_id' => 'main_nav',
								'fallback_cb' => '',
								'walker' => new ZassFrontWalker()
						);
						wp_nav_menu($zass_top_nav_args);
						?>
					</div>
				</div>
				<!-- END OF HEADER -->
			<?php endif; ?>