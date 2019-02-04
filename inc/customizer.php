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

	$wp_customize->add_setting( 'retina_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => false
		) );

	$wp_customize->add_setting( 'logo_placement', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'logo_placement' )
		) );

	$wp_customize->add_control('retina_logo', array(
		'label'   => _x('Use Retina Logo', 'conf', 'wp-atlatl'),
		'section' => 'title_tagline',
		'priority' => 9,
		'type'    => 'checkbox'
		) );

	$wp_customize->add_control( new Image_Customize_Radio_Control(
		$wp_customize, 'logo_placement', array(
			'settings' => 'logo_placement',
			'section'  => 'title_tagline',  // Site Title & Tagline
			'label'    => _x('Logo Placement', 'conf', 'wp-atlatl'),
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
		'title'    => _x('Layout', 'conf', 'wp-atlatl'),
		'priority' => 35,
		) );

	$wp_customize->add_setting( 'menu_position' , array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'menu_position' )
		) );
	$wp_customize->add_setting( 'container_position' , array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => atlatl_get_default( 'container_position' )
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
		$wp_customize, 'menu_position', array(
			'settings' => 'menu_position',
			'section'  => 'cust_layout',
			'label'    => _x('Menu Position', 'conf', 'wp-atlatl'),
			'prefix'   => 'cust-menu-',
			'choices'  => array(
				'pag' => _x('In Page', 'conf', 'wp-atlatl'),
				'top' => _x('On Top', 'conf', 'wp-atlatl'),
				) ) ) );

	$wp_customize->add_control( new Image_Customize_Radio_Control(
		$wp_customize, 'container_position', array(
			'settings' => 'container_position',
			'section'  => 'cust_layout',
			'label'    => _x('Container Position', 'conf', 'wp-atlatl'),
			'prefix'   => 'cust-cont-',
			'choices'  => array(
				'pag' => _x('Whole Page', 'conf', 'wp-atlatl'),
				'con' => _x('Content Only', 'conf', 'wp-atlatl'),
				) ) ) );

	$wp_customize->add_control( new Image_Customize_Radio_Control(
		$wp_customize, 'container_width', array(
			'settings' => 'container_width',
			'section'  => 'cust_layout',
			'label'    => _x('Container Width', 'conf', 'wp-atlatl'),
			'prefix'   => 'cust-wdth-',
			'choices'  => array(
				'cnt' => _x('Responsive fixed-width', 'conf', 'wp-atlatl'),
				'fld' => _x('Fluid', 'conf', 'wp-atlatl'),
				) ) ) );

	$wp_customize->add_control( new Image_Customize_Radio_Control(
		$wp_customize, 'content_position', array(
			'settings' => 'content_position',
			'section'  => 'cust_layout',
			'label'    => _x('Content Position', 'conf', 'wp-atlatl'),
			'prefix'   => 'cust-cpos-',
			'choices'  => array(
				'btm' => _x('Whole Page', 'conf', 'wp-atlatl'),
				'dlf' => _x('Narrow Right', 'conf', 'wp-atlatl'),
				'slf' => _x('Wide Right', 'conf', 'wp-atlatl'),
				'cnt' => _x('Centered', 'conf', 'wp-atlatl'),
				'drt' => _x('Narrow Left', 'conf', 'wp-atlatl'),
				'srt' => _x('Wide Left', 'conf', 'wp-atlatl'),
				) ) ) );
}

add_action( 'customize_register', 'atlatl_customize_register' );
