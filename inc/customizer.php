<?php
/**
 * customizer.php
 *
 * @see: http://themefoundation.com/wordpress-theme-customizer/
 */

if ( !class_exists( 'WP_Customize_Control' ) )
	require_once ABSPATH . WPINC . '/class-wp-customize-control.php';

/**
 * Adds textarea support to the theme customizer
 */
class Image_Customize_Radio_Control extends WP_Customize_Control {

	public $type = 'radio';

	public $choices = NULL;

	public $prefix = '';

	public $suffix = '.svg';

	public function enqueue() {
		wp_enqueue_style( 'atlatl_customizer', get_template_directory_uri() . '/css/customizer' . DOTMIN . '.css' );
	}

	public function render_content() {
		if (!is_null($this->choices)) :
			?>
			<div class="atlatl-cust-radio-ctrl">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php
				foreach ( $this->choices as $value => $label ) : ?>
					<input class="image-select-input"
						type="radio"
						value="<?php echo esc_attr( $value ); ?>"
						id="<?php echo $this->id . $value; ?>"
						name="<?php echo $this->id; ?>"
						<?php $this->link(); checked( $this->value(), $value ); ?> />
					<label class="image-select-label"
						for="<?php echo $this->id . $value; ?>"><img
						src="<?php echo get_template_directory_uri() . '/img/' .
						  $this->prefix . esc_html($value) . $this->suffix; ?>"
						title="<?php echo $label; ?>"></label>
					<?php
				endforeach;
			?></div><?php
		endif;
	}
}

function atlatl_customize_register( $wp_customize ) {

	// ----- Site Identity -----

	$wp_customize->add_setting( 'logo_width', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'logo_width' )
		) );
	$wp_customize->add_setting( 'logo_height', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'logo_height' )
		) );

	$wp_customize->add_control( 'logo_width', array(
		'type'        => 'text',
		'section'     => 'title_tagline',  // Site Title & Tagline
		'label'       => 'Logo Width',
		'priority'    => 9,
		'description' => 'Set override logo image width (use valid css/style values)',
		) );

	$wp_customize->add_control( 'logo_height', array(
		'type'        => 'text',
		'section'     => 'title_tagline',  // Site Title & Tagline
		'label'       => 'Logo Height',
		'priority'    => 9,
		'description' => 'Set override logo image height (can also be a percentage)',
		) );

	$wp_customize->add_setting( 'logo_placement', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'logo_placement' )
		) );

	$wp_customize->add_control( new Image_Customize_Radio_Control(
		$wp_customize, 'logo_placement', array(
			'settings' => 'logo_placement',
			'section'  => 'title_tagline',  // Site Title & Tagline
			'label'    => 'Logo Placement',
			'priority' => 9,
			'prefix'   => 'cust-logo-',
			'choices'  => array(
				'lft' => 'Left',
				'mid' => 'Middle',
				'rgt' => 'Right',
				'nav' => 'Navbar',
				'off' => 'Disabled',
				) ) ) );

	// ----- Layout -----

	$wp_customize->add_section( 'cust_layout', array(
		'title'    => 'Layout',
		'priority' => 35,
		) );

	$wp_customize->add_setting( 'container_width' , array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'container_width' )
		) );
	$wp_customize->add_setting( 'content_position', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'content_position' )
		) );

	$wp_customize->add_control( new Image_Customize_Radio_Control(
		$wp_customize, 'container_width', array(
			'settings' => 'container_width',
			'section'  => 'cust_layout',
			'label'    => 'Container Width',
			'prefix'   => 'cust-wdth-',
			'choices'  => array(
				'cnt' => 'Responsive fixed-width',
				'fld' => 'Fluid',
				) ) ) );

	$wp_customize->add_control( new Image_Customize_Radio_Control(
		$wp_customize, 'content_position', array(
			'settings' => 'content_position',
			'section'  => 'cust_layout',
			'label'    => 'Content Position',
			'prefix'   => 'cust-cpos-',
			'choices'  => array(
				'btm' => 'Whole Page',
				'dlf' => 'Narrow Right',
				'slf' => 'Wide Right',
				'cnt' => 'Centered',
				'drt' => 'Narrow Left',
				'srt' => 'Wide Left',
				) ) ) );
}

add_action( 'customize_register', 'atlatl_customize_register' );
