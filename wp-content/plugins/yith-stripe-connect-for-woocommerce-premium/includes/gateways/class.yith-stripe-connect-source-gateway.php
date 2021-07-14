<?php
/*
* This file belongs to the YITH Framework.
*
* This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.gnu.org/licenses/gpl-3.0.txt
*/
if ( ! defined( 'YITH_WCSC_VERSION' ) ) {
	exit( 'Direct access forbidden.' );
}

/**
 *
 *
 * @class      YITH_Stripe_Connect_Sources_Gateway
 * @package    Yithemes
 * @since      Version 1.1.0
 * @author     Your Inspiration Themes
 *
 */

if ( ! class_exists( 'YITH_Stripe_Connect_Sources_Gateway' ) ) {

	/**
	 * Class YITH_Stripe_Connect_Sources_Gateway
	 *
	 * This class replace YITH_Stripe_Connect_Gateway when the plugin YITH WooCommerce Subscription Premium from 1.4.6 is installed.
	 *
	 * @since  1.1.0
	 * @author Emanuela Castorina <emanuela.castorina@yithemes.com>
	 */
	class YITH_Stripe_Connect_Source_Gateway extends YITH_Stripe_Connect_Gateway {

		/**
		 * Whether currently processing renew needs additional actions by the customer
		 * (An email will be sent when registering failed attempt, if this flag is true)
		 *
		 * @var bool
		 */
		protected $_renew_needs_action = false;

		/**
		 * Instance of YITH_Stripe_Connect_Source_Gateway
		 *
		 * @var YITH_Stripe_Connect_Source_Gateway
		 */
		protected static $_instance = null;

		/**
		 * Return the instance of Gateway
		 *
		 * @return null|YITH_Stripe_Connect_Gateway|YITH_Stripe_Connect_Source_Gateway
		 * @author Emanuela Castorina <emanuela.castorina@yithemes.com>
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Construct
		 *
		 * @since  1.1.0
		 */
		public function __construct() {
			parent::__construct();

			$this->save_cards = 'yes';
			$this->supports   = array(
				'products',
				'tokenization',
				'yith_subscriptions',
				'yith_subscriptions_scheduling',
				'yith_subscriptions_pause',
				'yith_subscriptions_multiple',
				'yith_subscriptions_payment_date',
				'yith_subscriptions_recurring_amount',
			);

			// Pay the renew orders.
			add_action( 'ywsbs_pay_renew_order_with_' . $this->id, array( $this, 'pay_renew_order' ), 10, 2 );
		}

		/**
		 * Pay the order.
		 *
		 * If on cart there are subscription products proceed with this class, otherwise call the parent class.
		 *
		 * @param WC_Order $order Order to pay.
		 *
		 * @return array|bool|WP_Error
		 * @throws Stripe\Exception\ApiErrorException|Exception When an error occurs with payments.
		 * @author Emanuela Castorina <emanuela.castorina@yithemes.com>
		 * @since  1.1.0
		 */
		public function pay( $order = null ) {
			$result = parent::pay( $order );

			$order_contains_subscription = $order ? $this->order_contains_subscription( $order ) : false;

			if ( $order_contains_subscription ) {
				if ( $result && ! is_wp_error( $result ) ) {
					// if we cannot retrieve subscriptions from order meta, check session.
					if ( empty( $subscriptions ) && ! is_null( WC()->session ) ) {
						$order_args = WC()->session->get( 'ywsbs_order_args', array() );
						if ( isset( $order_args['subscriptions'] ) ) {
							$subscriptions = $order_args['subscriptions'];
						}

						WC()->session->set( 'ywsbs_order_args', array() );
					}

					$intent = $this->get_intent( $order );

					if ( ! is_user_logged_in() ) {
						$this->attach_payment_method( $this->customer, $intent->payment_method );
					}

					foreach ( $subscriptions as $subscription_id ) {
						update_post_meta( $subscription_id, 'yith_stripe_connect_customer_id', $this->customer );
						update_post_meta( $subscription_id, 'yith_stripe_connect_source_id', $intent->payment_method );
					}

					$charge_id = $order->get_transaction_id();

					if ( $charge_id ) {
						foreach ( $subscriptions as $subscription_id ) {
							// translators: 1. Subscription id. 2. Order id. 3. Charge id.
							$this->log( 'info', sprintf( __( 'Stripe Connect processed successfully. Subscription %1$s. Order %2$s. (Transaction ID: %3$s)', 'yith-stripe-connect-for-woocommerce' ), $subscription_id, $order->get_id(), $charge_id ) );

							update_post_meta( $subscription_id, 'transaction_id', $charge_id );

						}
					}
				} else {
					ywsbs_register_failed_payment( $order, $result->get_error_message() );

					return $result;
				}
			}

			return true;
		}

		/**
		 * Pay the renew order.
		 *
		 * It is triggered by ywsbs_pay_renew_order_with_{gateway_id} action
		 *
		 * @param WC_Order $order    Renew order to pay.
		 * @param bool     $manually Wheter renew is performed manually.
		 *
		 * @return array|bool|WP_Error
		 * @throws Stripe\Exception\ApiErrorException When an error occurs with payment.
		 * @author Emanuela Castorina <emanuela.castorina@yithemes.com>
		 * @since  1.1.0
		 */
		public function pay_renew_order( $order = null, $manually = false ) {

			if ( is_null( $order ) ) {
				return false;
			}

			$is_a_renew      = $order->get_meta( 'is_a_renew' );
			$subscriptions   = $order->get_meta( 'subscriptions' );
			$subscription_id = $subscriptions ? $subscriptions[0] : false;

			if ( ! $subscription_id ) {
				// translators: 1. Order id.
				$error_msg = sprintf( __( 'Sorry, any subscription is found for this order: %s', 'yith-stripe-connect-for-woocommerce' ), $order->get_id() );
				$this->log( 'error', $error_msg );

				return false;
			}

			$yith_stripe_connect_source_id = get_post_meta( $subscription_id, 'yith_stripe_connect_source_id' );

			if ( 'yes' !== $is_a_renew || ! $yith_stripe_connect_source_id ) {
				return false;
			}


			// Initialize SDK and set private key.
			$this->init_stripe_connect_api();

			$amount                 = $order->get_total();
			$order_id               = $order->get_id();
			// translators: 1. Order number.
			$general_failed_message = sprintf( __( 'Failed payment for order #%s', 'yith-stripe-connect-for-woocommerce' ), $order->get_order_number() );

			if ( 0 == $amount ) {
				// Payment complete.
				$order->payment_complete();

				return true;
			}

			if ( $amount * 100 < 50 ) {
				$error_msg = __( 'Sorry, the minimum order total allowed to use this payment method is 0.50.', 'yith-stripe-connect-for-woocommerce' );
				$this->log( 'error', $error_msg );
				if ( $manually ) {
					wc_add_notice( $general_failed_message, 'error' );
				} else {
					ywsbs_register_failed_payment( $order, $error_msg );
				}

				return false;
			}

			$user_id = get_post_meta( $subscription_id, 'user_id', true );

			if ( 0 != $user_id ) {
				$local_customer = YITH_Stripe_Connect_Customer()->get_usermeta_info( $user_id );
				$stripe_user_id = isset( $local_customer['id'] ) ? $local_customer['id'] : false;
				$source_id      = $this->get_valid_source_id( $user_id, $local_customer, $subscription_id );
			}

			if ( ! $stripe_user_id ) {
				$stripe_user_id = get_post_meta( $subscription_id, 'yith_stripe_connect_customer_id', true );
				$source_id      = $yith_stripe_connect_source_id;
			}

			if ( ! $stripe_user_id ) {
				// translators: 1. Renew order id. 2. Subscription id.
				$error_msg = sprintf( __( 'Sorry, couldn\'t find any user registered to pay the order renew %1$s for subscription %2$s .', 'yith-stripe-connect-for-woocommerce' ), $order_id, $subscription_id );

				if ( $manually ) {
					wc_add_notice( $general_failed_message, 'error' );
				} else {
					ywsbs_register_failed_payment( $order, $error_msg );
				}

				$this->log( 'warning', $error_msg );

				return false;
			}

			$source_id = is_array( $source_id ) ? array_shift( $source_id ) : $source_id;

			if ( ! $source_id ) {
				// translators: 1. Renew order id. 2. Subscription id.
				$error_msg = sprintf( __( 'Sorry, any card is registered to pay the order renew %1$s for subscription %2$s .', 'yith-stripe-connect-for-woocommerce' ), $order_id, $subscription_id );
				if ( $manually ) {
					wc_add_notice( $general_failed_message, 'error' );
				} else {
					ywsbs_register_failed_payment( $order, $error_msg );
				}

				$this->log( 'warning', $error_msg );

				return false;
			}

			$customer = $this->api_handler->get_customer( $stripe_user_id );

			$this->customer = $stripe_user_id;
			$this->token    = $source_id;

			try {
				$intent = $this->api_handler->create_intent(
					array(
						'amount'               => yith_wcsc_get_amount( $order->get_total() ),
						'currency'             => $order->get_currency(),
						// translators: 1. Blog name. 2. Order number.
						'description'          => apply_filters( 'yith_stripe_connect_charge_description', sprintf( __( '%1$s - Order %2$s', 'yith-stripe-connect-for-woocommerce' ), esc_html( get_bloginfo( 'name' ) ), $order->get_order_number() ), esc_html( get_bloginfo( 'name' ) ), $order->get_order_number() ),
						'metadata'             => apply_filters(
							'yith_wcstripe_connect_metadata',
							array(
								'order_id'    => $order_id,
								'order_email' => yit_get_prop( $order, 'billing_email' ),
								'instance'    => $this->instance_url,
							),
							'charge'
						),
						'customer'             => $stripe_user_id,
						'payment_method_types' => array( 'card' ),
						'payment_method'       => $source_id,
						'off_session'          => true,
						'confirm'              => true,
						'transfer_group'       => $order->get_id(),
					)
				);
			} catch ( Stripe\Exception\ApiErrorException $e ) {
				$body = $e->getJsonBody();
				$err  = $body['error'];

				if (
					isset( $err['payment_intent'] ) &&
					isset( $err['payment_intent']['status'] ) &&
					in_array( $err['payment_intent']['status'], array( 'requires_action', 'requires_payment_method' ) ) &&
					(
						! empty( $err['payment_intent']['next_action'] ) && isset( $err['payment_intent']['next_action']->type ) && 'use_stripe_sdk' === $err['payment_intent']['next_action']->type ||
						'authentication_required' === $err['code']
					)
				) {
					$this->_renew_needs_action = true;

					$this->register_failed_renew( $order, __( 'Please, validate your payment method before proceeding further', 'yith-stripe-connect-for-woocommerce' ) );

					return false;
				} else {
					$this->register_failed_renew( $order, $err['message'] );

					return false;
				}
			} catch ( Exception $e ) {
				$this->register_failed_renew( $order, __( 'Sorry, There was an error while processing payment; please, try again', 'yith-stripe-connect-for-woocommerce' ) );

				return false;
			}

			// register intent for the order.
			$order->update_meta_data( 'intent_id', $intent->id );

			// retrieve charge to use for next steps.
			$charge = end( $intent->charges->data );

			// update renew order.
			$order->update_meta_data( 'yith_stripe_connect_source_id', $source_id );
			$order->update_meta_data( 'yith_stripe_connect_customer_id', $customer->id );
			$order->save();

			// update stored customer id.
			YITH_Stripe_Connect_Customer()->update_usermeta_info(
				$user_id,
				array(
					'id' => $customer->id,
				)
			);

			// Payment complete.
			$is_payment_complete = $order->payment_complete( $charge->id );

			if ( $is_payment_complete ) {
				do_action( 'yith_wcsc_payment_complete', $order->get_id(), $charge->id );

				if ( $manually ) {
					// translators: 1. Order number.
					wc_add_notice( sprintf( __( 'Payment approved for order #%s', 'yith-stripe-connect-for-woocommerce' ), $order->get_order_number() ), 'success' );
				}

				// Add order note.
				// translators: 1. Charge id.
				$order->add_order_note( sprintf( __( 'Stripe Connect payment approved (ID: %s)', 'yith-stripe-connect-for-woocommerce' ), $charge->id ) );
			}

			// Return thank you page redirect.
			return true;
		}

		/**
		 * Get a valid token useful to pay the renew order.
		 *
		 * @param int   $user_id         User id.
		 * @param array $local_customer  Local informations about Stripe customer.
		 * @param int   $subscription_id Subscription id.
		 *
		 * @return bool|string
		 * @author Emanuela Castorina <emanuela.castorina@yithemes.com>
		 * @since  1.1.0
		 */
		public function get_valid_source_id( $user_id, $local_customer, $subscription_id ) {

			// check first if the default payment token is valid.
			$default_payment_method = WC_Payment_Tokens::get_customer_default_token( $user_id );

			if ( $default_payment_method && $default_payment_method->get_gateway_id() == $this->id ) {
				$token = $default_payment_method->get_token();
				// update the default source on Stripe Connect Customer.
				if ( isset( $local_customer['default_source'] ) && ! empty( $local_customer['default_source'] ) && $token != $local_customer['default_source'] ) {
					YITH_Stripe_Connect_Customer()->update_usermeta_info(
						$user_id,
						array(
							'default_source' => $token,
						)
					);
				}

				return $token;
			}

			// check if in local customer there's registered a valid token.
			$registered_payments = WC_Payment_Tokens::get_customer_tokens( $user_id, $this->id );
			$source_id           = get_post_meta( $subscription_id, 'yith_stripe_connect_source_id', true );

			if ( isset( $local_customer['default_source'] ) ) {
				foreach ( $registered_payments as $registered_payment ) {
					$registered_token = $registered_payment->get_token();
					if ( $registered_token == $local_customer['default_source'] ) {
						return $registered_token;
					}
				}

				if ( $source_id == $local_customer['default_source'] ) {
					return false;
				}
			}

			// Check if in subscription there's registered a valid token.
			if ( ! empty( $source_id ) ) {
				foreach ( $registered_payments as $registered_payment ) {
					$registered_token = $registered_payment->get_token();
					if ( $registered_token == $source_id ) {
						if ( isset( $local_customer['default_source'] ) && ! empty( $local_customer['default_source'] ) && $registered_token != $local_customer['default_source'] ) {
							YITH_Stripe_Connect_Customer()->update_usermeta_info(
								$user_id,
								array(
									'default_source' => $registered_token,
								)
							);
						}

						return $registered_token;
					}
				}
			}

			return false;
		}

		/**
		 * Register failed renew attempt for an order, and related error message
		 *
		 * @param $order   \WC_Order Renew order.
		 * @param $message string Error message to log.
		 *
		 * @return void
		 */
		public function register_failed_renew( $order, $message ) {
			ywsbs_register_failed_payment( $order, $message );

			/**
			 * Required in order to make sure that the order object is up to date after
			 * subscription register failed attempt
			 */
			$order = wc_get_order( $order->get_id() );

			if ( $this->_renew_needs_action && ! $order->has_status( 'cancelled' ) ) {
				do_action( 'yith_stripe_connect_renew_intent_requires_action', $order );
			}

			$this->log( 'info', $message );
		}

		/**
		 * Get a link to the transaction on the 3rd party gateway site (if applicable).
		 *
		 * @param  WC_Order $order the order object.
		 * @return string transaction URL, or empty string.
		 */
		public function get_transaction_url( $order ) {
			$return_url     = '';
			$transaction_id = $order->get_transaction_id();

			if ( ! empty( $this->view_transaction_url ) && ! empty( $transaction_id ) && ! $order->get_meta( '_yith_wcstripe_alt_flow', true ) ) {
				$return_url = sprintf( $this->view_transaction_url, $transaction_id );
			}

			return apply_filters( 'woocommerce_get_transaction_url', $return_url, $order, $this );
		}
	}
}