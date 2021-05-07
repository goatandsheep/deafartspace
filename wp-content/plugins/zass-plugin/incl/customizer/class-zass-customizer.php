<?php
/**
 * Adds options to the customizer for Zass.
 */

defined( 'ABSPATH' ) || exit;

class Zass_Customizer {
	function __construct() {
		add_action( 'customize_register', array( $this, 'add_sections' ) );
	}

	/**
	 * Add settings to the customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function add_sections( $wp_customize ) {
		$wp_customize->add_panel( 'zass_plugin', array(
			'priority'       => 200,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => esc_html__( 'Zass Options', 'zass-plugin' ),
		) );

		$this->add_social_share_section( $wp_customize );
	}

	/**
	 * Social share links section.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function add_social_share_section( $wp_customize ) {
		$wp_customize->add_section(
			'zass_social_share',
			array(
				'title'       => esc_html__( 'Social Share Links', 'zass-plugin' ),
				'description' => esc_html__( 'Configure globally the social networks share links. They can be overridden for each post, page or portfolio on the edit page.', 'zass-plugin' ),
				'priority'    => 10,
				'panel'       => 'zass_plugin',
			)
		);

		$wp_customize->add_setting(
			'zass_share_on_posts',
			array(
				'default'           => 'no',
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => array( $this, 'zass_bool_to_string' ),
				'sanitize_js_callback' => array( $this, 'zass_string_to_bool' )
			)
		);

		$wp_customize->add_control(
			'zass_share_on_posts_field',
			array(
				'label'    => esc_html__( 'Enable social share links on single post, page and portfolio.', 'zass-plugin' ),
				'section'  => 'zass_social_share',
				'settings' => 'zass_share_on_posts',
				'type'     => 'checkbox'
			)
		);

		if ( defined( 'ZASS_PLUGIN_IS_WOOCOMMERCE' ) && ZASS_PLUGIN_IS_WOOCOMMERCE ) {
			$wp_customize->add_setting(
				'zass_share_on_products',
				array(
					'default'           => zass_default_share_on_products(),
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( $this, 'zass_bool_to_string' ),
					'sanitize_js_callback' => array( $this, 'zass_string_to_bool' )
				)
			);

			$wp_customize->add_control(
				'zass_share_on_products_field',
				array(
					'label'    => esc_html__( 'Enable social share links on single product pages.', 'zass-plugin' ),
					'section'  => 'zass_social_share',
					'settings' => 'zass_share_on_products',
					'type'     => 'checkbox'
				)
			);
		}
	}

	public function zass_bool_to_string( $bool ) {
		if ( ! is_bool( $bool ) ) {
			$bool = $this->zass_string_to_bool($bool);
		}
		return true === $bool ? 'yes' : 'no';
	}

	public function zass_string_to_bool( $string ) {
		return is_bool( $string ) ? $string : ( 'yes' === $string || 1 === $string || 'true' === $string || '1' === $string );
	}
}

new Zass_Customizer();