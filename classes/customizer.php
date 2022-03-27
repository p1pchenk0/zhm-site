<?php
if ( ! class_exists( 'Zhm_Customize' ) ) {
  class Zhm_Customize {
    static $primary_color = '#0713a5';
    static $header_color = '#6dd8fd';

    public static function set_defaults($defaults) {
      $primary_color = $defaults['primary_color'];
      $header_color = $defaults['header_color'];
    }

    public static function register( $wp_customize ) {
      // Header & Footer Background Color.
			$wp_customize->add_setting(
				'header_color',
				array(
					'default'           => Zhm_Customize::$header_color,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'header_color',
					array(
						'label'   => 'Колір шапки',
						'section' => 'colors',
					)
				)
			);

      $wp_customize->add_setting(
				'primary_color',
				array(
					'default'           => Zhm_Customize::$primary_color,
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'primary_color',
					array(
						'label'   => 'Головний колір',
						'section' => 'colors',
					)
				)
			);

      $wp_customize->add_section('socials', array(
        'title' => 'Соціальні мережі'
      ));

      $wp_customize->add_setting(
				'youtube_link',
				array(
					'default'           => '',
					'transport'         => 'postMessage',
				)
			);

      $wp_customize->add_control(
        'youtube_link',
				array(
					'label'   => 'Youtube',
					'section' => 'socials',
				)
			);

      $wp_customize->add_setting(
				'facebook_link',
				array(
					'default'           => '',
					'transport'         => 'postMessage',
				)
			);

      $wp_customize->add_control(
        'facebook_link',
				array(
					'label'   => 'Facebook',
					'section' => 'socials',
				)
			);

      // $wp_customize->add_setting(
			// 	'header_background_color',
			// 	array(
			// 		'default'           => '#6dd8fd',
			// 		'sanitize_callback' => 'sanitize_hex_color',
			// 		'transport'         => 'postMessage',
			// 	)
			// );
      //
			// $wp_customize->add_control(
			// 	new WP_Customize_Color_Control(
			// 		$wp_customize,
			// 		'header_background_color',
			// 		array(
			// 			'label'   => 'Колір шапки',
			// 			'section' => 'colors',
			// 		)
			// 	)
			// );
    }
  }
}

?>
