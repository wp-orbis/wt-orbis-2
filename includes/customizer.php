<?php

/**
 * Customizer
 */
function orbis_customize_register( $wp_customize ) {

	/**
	 * Slogan
	 */
	class orbis_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() {

			?>

			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" cols="30" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>

		<?php

		}
	}

	/**
	 * Section
	 */
	$wp_customize->add_section( 'general', array(
		'title' => __( 'General', 'orbis' )
	) );

	/**
	 * Settings
	 */
	$wp_customize->add_setting( 'orbis_slogan' );
	$wp_customize->add_control( new orbis_Customize_Textarea_Control( $wp_customize, 'orbis_slogan', array(
		'label'    => __( 'Slogan', 'orbis' ),
		'section'  => 'general',
		'settings' => 'orbis_slogan',
	) ) );

	$wp_customize->add_setting( 'orbis_logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'orbis_logo', array(
		'label'    => __( 'Logo', 'orbis' ),
		'section'  => 'general',
		'settings' => 'orbis_logo',
	) ) );

	$wp_customize->add_setting( 'orbis_logo_svg' );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'orbis_logo_svg', array(
		'label'    => __( 'Logo (SVG)', 'orbis' ),
		'section'  => 'general',
		'settings' => 'orbis_logo_svg',
	) ) );

	/**
	 * Colors
	 */
	$colors = array();

	$colors[] = array(
		'setting' => 'orbis_primary_color',
		'default' => '#0088cc',
		'label'   => __( 'Primary Color', 'orbis' ),
	);

	$colors[] = array(
		'setting' => 'orbis_secondary_color',
		'default' => '#f6f6f6',
		'label'   => __( 'Secondary Color', 'orbis' ),
	);

	foreach ( $colors as $color ) {
		// Settings
		$wp_customize->add_setting( $color['setting'], array(
			'default'    => $color['default'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		// Controls
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['setting'], array(
			'label'    => $color['label'],
			'section'  => 'colors',
			'settings' => $color['setting'],
		) ) );
	}
}

add_action( 'customize_register', 'orbis_customize_register' );
