<?php

function aweber_customize_register($wp_customize){

    $wp_customize->add_section(
	'header_section',
		array(
			'title' => __('Logo','aweber'),
			'capability' => 'edit_theme_options',
			'description' =>  __('Allows you to edit your theme\'s layout.','aweber')
			)
	);

	$wp_customize->add_section(
		'sm_section',
		array(
			'title' =>  __('Social Media','aweber'),
			'capability' => 'edit_theme_options',
			'description' =>  __('Allows you to set your social media URLs','aweber')
			)
	);

	$socials = array('twitter','facebook','google-plus','instagram','pinterest','linkedin','vimeo','youtube');

	for($i=0;$i<count($socials);$i++) {
		$name = str_replace('-',' ',ucfirst($socials[$i]));
		$wp_customize->add_setting('aweber_'.$socials[$i], array(
	    'capability' => 'edit_theme_options',
	    'type'       => 'theme_mod',
	    'sanitize_callback' => 'aweber_sanitize_customizer_val',
		));
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			'aweber_'.$socials[$i],
			array(
			    'settings' => 'aweber_'.$socials[$i],
			    'label'    => sprintf( __( '%s URL' ,'aweber' ), $name ),
			    'section'  => 'sm_section',
			    'type'     => 'text',
			)
		));
	}

	$wp_customize->add_section(
		'featured_text_section',
		array(
			'title' =>  __('Featured Text','aweber'),
			'capability' => 'edit_theme_options',
			'description' =>  __('Allows you to set your footer settings','aweber')
		)
	);

	$wp_customize->add_setting(
		'aweber_hometext',
		array(
		    'capability' => 'edit_theme_options',
		    'type'       => 'theme_mod',
		    'sanitize_callback' => 'aweber_sanitize_customizer_val',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'aweber_hometext',
		array(
		    'settings' => 'aweber_hometext',
		    'label'    => __('Featured Text','aweber'),
		    'section'  => 'featured_text_section',
		    'type'     => 'textarea',
		)
	));

	$wp_customize->add_section(
		'copyright_section',
		array(
			'title' =>  __('Copyright Text','aweber'),
			'capability' => 'edit_theme_options',
			'description' =>  __('Allows you to set your footer settings','aweber')
		)
	);

	$wp_customize->add_setting(
		'aweber_copyright',
		array(
    		'capability' => 'edit_theme_options',
    		'type' => 'theme_mod',
    		'sanitize_callback' => 'aweber_sanitize_customizer_val',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'aweber_copyright',
		array(
		    'settings' => 'aweber_copyright',
		    'label'    => __('Copyright Text','aweber'),
		    'section'  => 'copyright_section',
		    'type'     => 'textarea',
		)
	));

}
add_action('customize_register', 'aweber_customize_register');

function aweber_setting($name, $default = false) {
	return get_theme_mod( $name, $default );
}

function aweber_sanitize_customizer_val($value){
	if (!filter_var($value, FILTER_VALIDATE_URL) === false) //check if URL
		return esc_url_raw($value);
	else
		return sanitize_text_field($value);
}
