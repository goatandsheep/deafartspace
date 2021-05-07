<?php
defined( 'ABSPATH' ) || exit;
/**
 * Widget to show the payment options on the shop.
 *
 * @author aatanasov
 */
class ZassPaymentOptionsWidget extends WP_Widget{
    public function __construct() {
        $widget_ops = array('description' =>esc_html__('Display a list of available payment methods and seal code', 'zass-plugin') );
        parent::__construct('zass_payment_options_widget', 'Zass Payment Options', $widget_ops);
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo wp_kses_post($before_widget);
        if ( ! empty( $title ) )
                echo wp_kses_post($before_title . $title . $after_title);

        foreach($instance as $field_name => $value) {
            if (!in_array($field_name, array('title', 'seal')) && $value): ?>
                <div class="<?php echo esc_attr($field_name) ?>_icon cards_icon"></div>
            <?php endif;
        }

        if(trim($instance['seal'] != '')): ?>
            <div id="seals"><?php echo wp_kses_post($instance['seal']) ?></div>
        <?php endif;
        echo wp_kses_post($after_widget);
    }

    public function form( $instance ) {
        //Defaults
        $defaults = array(
            'title'             => esc_html__( 'Payment Options', 'zass-plugin' ),
            'american-express'  => true,
            'cirrus'            => true,
            'maestro'           => true,
            'mastercard'        => true,
            'visa'              => true,
            'cash-on-delivery'  => true,
            'direct-debit'      => true,
            'paypal'            => true,
            'cheque'            => true,
            'google-checkout'   => false,
            'twocheckout'       => false,
            'delta'             => false,
            'discover'          => false,
            'moneybookers'      => false,
            'solo'              => false,
            'switch'            => false,
            'western-union'     => false,
            'sagepay'           => false,
            'seal'              => ''
        );

        $labels = array(
            'american-express'  => esc_html__( 'American Express', 'zass-plugin' ),
            'cirrus'            => esc_html__( 'Cirrus', 'zass-plugin' ),
            'maestro'           => esc_html__( 'Maestro', 'zass-plugin' ),
            'mastercard'        => esc_html__( 'Mastercard', 'zass-plugin' ),
            'visa'              => esc_html__( 'Visa', 'zass-plugin' ),
            'cash-on-delivery'  => esc_html__( 'Cash on delivery', 'zass-plugin' ),
            'direct-debit'      => esc_html__( 'Direct Debit', 'zass-plugin' ),
            'paypal'            => esc_html__( 'PayPal', 'zass-plugin' ),
            'cheque'            => esc_html__( 'Cheque', 'zass-plugin' ),
            'google-checkout'   => esc_html__( 'Google checkout', 'zass-plugin' ),
            'twocheckout'       => esc_html__( '2Checkout', 'zass-plugin' ),
            'delta'             => esc_html__( 'Delta', 'zass-plugin' ),
            'discover'          => esc_html__( 'Discover', 'zass-plugin' ),
            'moneybookers'      => esc_html__( 'Moneybookers', 'zass-plugin' ),
            'solo'              => esc_html__( 'SOLO', 'zass-plugin' ),
            'switch'            => esc_html__( 'Switch', 'zass-plugin' ),
            'western-union'     => esc_html__( 'Western Union', 'zass-plugin' ),
            'sagepay'           => esc_html__( 'Sage Pay', 'zass-plugin' )
        );

        $instance = wp_parse_args( (array) $instance, $defaults); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'zass-plugin' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <?php foreach ($instance as $field_name => $value): ?>
            <?php if(!in_array($field_name, array('title', 'seal'))): ?>
                <p>
                    <input class="checkbox" type="checkbox" <?php checked($value, true) ?> id="<?php echo esc_attr($this->get_field_id($field_name)); ?>" name="<?php echo esc_attr($this->get_field_name($field_name)); ?>" />&nbsp;
                    <label for="<?php echo esc_attr($this->get_field_id($field_name)); ?>"><?php echo esc_attr($labels[$field_name]); ?></label>
                </p>
            <?php endif;  ?>
        <?php endforeach;  ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'seal' )); ?>"><?php esc_html_e( 'Seal code:', 'zass-plugin' ); ?></label>
            <textarea class="widefat" rows="6" cols="10" id="<?php echo esc_attr($this->get_field_id('seal')); ?>" name="<?php echo esc_attr($this->get_field_name('seal')); ?>"><?php echo wp_kses_post($instance['seal']); ?></textarea>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['american-express'] = isset($new_instance['american-express']);
        $instance['cirrus'] = isset($new_instance['cirrus']);
        $instance['maestro'] = isset($new_instance['maestro']);
        $instance['mastercard'] = isset($new_instance['mastercard']);
        $instance['visa'] = isset($new_instance['visa']);
        $instance['cash-on-delivery'] = isset($new_instance['cash-on-delivery']);
        $instance['direct-debit'] = isset($new_instance['direct-debit']);
        $instance['paypal'] = isset($new_instance['paypal']);
        $instance['cheque'] = isset($new_instance['cheque']);
        $instance['google-checkout'] = isset($new_instance['google-checkout']);
        $instance['twocheckout'] = isset($new_instance['twocheckout']);
        $instance['delta'] = isset($new_instance['delta']);
        $instance['discover'] = isset($new_instance['discover']);
        $instance['moneybookers'] = isset($new_instance['moneybookers']);
        $instance['solo'] = isset($new_instance['solo']);
        $instance['switch'] = isset($new_instance['switch']);
        $instance['western-union'] = isset($new_instance['western-union']);
        $instance['sagepay'] = isset($new_instance['sagepay']);
        $instance['seal'] = wp_kses_post($new_instance['seal']);

        return $instance;
    }
}

add_action('widgets_init', 'zass_register_zass_payment_widget');
if ( ! function_exists( 'zass_register_zass_payment_widget' ) )
{
	function zass_register_zass_payment_widget()
	{
		register_widget('ZassPaymentOptionsWidget');
	}
}
?>
