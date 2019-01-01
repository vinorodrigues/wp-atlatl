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
class My_Customize_Radio_Control extends WP_Customize_Control {

	public $type = 'radio';

	public $choices = NULL;

	public $prefix = '';

	public $suffix = '.png';

	public function enqueue() {
		wp_enqueue_style( 'bootstrap4_customizer', get_template_directory_uri() . '/css/customizer' . DOTMIN . '.css' );
	}

	public function render_content() {
		if (!is_null($this->choices)) :
			?>
			<div class="bs4-cust-radio-ctrl">
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

	$wp_customize->add_section( 'cust_layout', array(
		'title'    => 'Layout',
		'priority' => 35,
		) );

	$wp_customize->add_setting( 'content_position', array( 'default' => 0 ) );

	$wp_customize->add_control( new My_Customize_Radio_Control(
		$wp_customize, 'content_position', array(
			'settings' => 'content_position',
			'section'  => 'cust_layout',
			'label'    => 'Content Position',
			'prefix'   => 'cust-cpos-',
			'choices'  => array(
				0 => 'Right',
				1 => 'Center',
				2 => 'Left',
				) ) ) );

}

add_action( 'customize_register', 'atlatl_customize_register' );
