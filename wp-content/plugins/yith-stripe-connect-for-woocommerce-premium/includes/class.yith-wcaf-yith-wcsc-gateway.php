<?php
/*
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * YITH Stripe Connect to Affiliates Gateway class
 *
 * @author  Francisco Javier Mateo <francisco.mateo@yithemes.com>
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCSC_VERSION' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAF_YITH_WCSC' ) ) {
	/**
	 * YITH Stripe Connect to Affiliates Gateway class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAF_YITH_WCSC {

		/**
		 * Single instance of the class for each token
		 *
		 * @var \YITH_WCAF_YITH_WCSC
		 * @since 1.0.0
		 */
		protected static $instance = null;

		/* === PAYMENT METHODS === */

		/**
		 * Execute a mass payment
		 *
		 * @param $payments_id array Array of registered payments to credit to funds
		 *
		 * @return mixed Array with operation status and messages
		 * @since 1.0.0
		 */
		public function pay( $payments_id ) {

			$api_handler               = YITH_Stripe_Connect_API_Handler::instance();
			$stripe_connect_commission = YITH_Stripe_Connect_Commissions::instance();
			$stripe_connect_gateway    = YITH_Stripe_Connect()->get_gateway( false );

			// if single payment id, convert it to array
			if ( ! is_array( $payments_id ) ) {
				$payments_id = (array) $payments_id;
			}

			$currency       = get_woocommerce_currency();
			$status_message = array(
				'status' => true
			);
			foreach ( $payments_id as $payment_id ) {

				$payment     = YITH_WCAF_Payment_Handler()->get_payment( $payment_id );
				$destination = get_user_meta( $payment['user_id'], 'stripe_user_id', true );
				$user        = get_user_by( 'id', $payment['user_id'] );
				$commissions = YITH_WCAF_Payment_Handler()->get_payment_commissions( $payment_id );

				if ( ! empty( $destination ) ) {
					$args = array(
						'amount'      => yith_wcsc_get_amount( $payment['amount'] ),
						'currency'    => $currency,
						'destination' => $destination,
					);

					$transfer = $api_handler->create_transfer( $args );

					if ( isset( $transfer['error_transfer'] ) ) {

						// Prepare message
						$error_message = __( 'Please take a look at Stripe Connect log file for more details.', 'yith-stripe-connect-for-woocommerce' );

						// Display messages on order note and log file
						$stripe_connect_gateway->log( 'error', __( 'Affiliates\' payment: ', 'yith-stripe-connect-for-woocommerce' ) . $transfer['error_transfer'] );

						return array(
							'status'   => false,
							'messages' => $error_message
						);
					} elseif ( $transfer instanceof \Stripe\Transfer ) {
						YITH_WCAF_Payment_Handler()->add_note( array(
							'payment_id'   => $payment_id,
							'note_content' => __( 'Payment correctly issued to Stripe Connect', 'yith-stripe-connect-for-woocommerce' )
						) );

						YITH_WCAF_Payment_Handler()->change_payment_status( $payment_id, 'completed' );
						do_action( 'yith_wcaf_payment_sent', $payment );

						foreach ( $commissions as $affiliate_commission ) {
							//Prepare affiliate items.
							$integration_item = array(
								'plugin_integration'      => 'affiliates',
								'payment_id'              => $payment_id,
								'affiliate_commission_id' => $affiliate_commission['ID']
							);
							// Prepare the notes to commssion
							$notes = array(
								'transfer_id'         => $transfer->id,
								'destination_payment' => $transfer->destination
							);

							$sc_commission = array(
								'user_id'           => $payment['user_id'],
								'order_id'          => $affiliate_commission['order_id'],
								'order_item_id'     => $affiliate_commission['line_item_id'],
								'product_id'        => $affiliate_commission['product_id'],
								'commission'        => $affiliate_commission['amount'],
								'commission_status' => 'sc_transfer_success',
								'commission_type'   => 'percentage',
								'commission_rate'   => $affiliate_commission['rate'],
								'payment_retarded'  => 0,
								'purchased_date'    => $affiliate_commission['created_at'],
								'note'              => maybe_serialize( $notes ),
								'integration_item'  => maybe_serialize( $integration_item )
							);
							$stripe_connect_commission->insert( $sc_commission );
						}
					}

				} else {
					$status_message['status']   = false;
					$status_message['messages'] = sprintf( __( 'The destination account is not connected to any Stripe account.',
						'yith-stripe-connect-for-woocommerce' ), $user->display_name );
				}
			}

			if ( ! $status_message['status'] ) {
				$status_message['status']   = true;
				$status_message['messages'] = __( 'Payment sent', 'yith-stripe-connect-for-woocommerce' );
			}

			return $status_message;
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCAF_YITH_WCSC
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
}

/**
 * Unique access to instance of YITH_WCAF_YITH_WCSC class
 *
 * @return \YITH_WCAF_YITH_WCSC
 * @since 1.0.0
 */
function YITH_WCAF_YITH_WCSC() {
	return YITH_WCAF_YITH_WCSC::get_instance();
}