<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_navigation');
?>

<div class="woocommerce-MyAccount-content">
	<div class="myaccount_user">
		<?php $avatar_img = get_avatar(get_current_user_id()); ?>
		<?php if ($avatar_img) : ?>
			<span class="zass-account-avatar"><?php echo wp_kses_post($avatar_img) ?></span>
		<?php endif; ?>

		<?php
		/**
		 * My Account content.
         *
		 * @since 2.6.0
		 */
		do_action('woocommerce_account_content');
		?>
	</div>
</div>
