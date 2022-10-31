<?php
/**
 * Functions for adding Customization options to the theme
 * Custom colors, fonts, layout options, etc.
 * This file is included in functions.php
 */
add_action( 'customize_register', 'at_portfolio_customizer' );
function at_portfolio_customizer( $wp_customize ){
  // Custom footer section
  $wp_customize->add_section( 'at_portfolio_footer', array(
    'title' => 'Footer Settings',
    'priority' => 60,
    'capability' => 'edit_theme_options',
  ) );
  $wp_customize->add_setting( 'footer_bg_color', array(
    'default' => '#F1F1F1',
    'sanitize_callback' => 'wp_strip_all_tags',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize,
    'footer_bg_color_ui',
    array(
      'label' => 'Footer Background Color',
      'section' => 'at_portfolio_footer', //from above when the section was added
      'settings' => 'footer_bg_color', //from above when this setting was added
    )
  ) );

  //Custom Font Choice (radio button / text field example)
  $wp_customize->add_section( 'at_portfolio_fonts', array(
    'title' => 'Typography',
    'priority' => 80,
    'capability' => 'edit_theme_options',
  ) );
  $wp_customize->add_setting( 'heading_font', array(
    'default' => 'Poppins',
    'sanitize_callback' => 'wp_strip_all_tags',
  ) );
  $wp_customize->add_control( new WP_Customize_Control(
    $wp_customize,
    'heading_font_ui',
    array(
      'type' => 'radio', //text, checkbox, textarea, and select are other options for 'type'
      'label' => 'Heading Font',
      'section' => 'at_portfolio_fonts',
      'settings' => 'heading_font',
      'choices' => array(
        'Encode Sans SC' => 'Encode Sans SC - Strong and Obvious',
        'Encode Sans' => 'Encode Sans - Regular Case Version of Encode Sans SC',
        'Open Sans' => 'Open Sans - Clean and Readable',
      ),
    )
  ) );

  //Alternate version of the logo (add onto existing site identity section)
  $wp_customize->add_setting( 'alternate_logo', array(
    'default' => '',
    'sanitize_callback' => 'absint', //sanitize the media ID
  ) );
  $wp_customize->add_control( new WP_Customize_Media_Control(
    $wp_customize,
    'alternate_logo_ui',
    array(
      'label' => 'Alternate Logo',
      'mime' => 'image',
      'section' => 'title_tagline', //site identity section
      'settings' => 'alternate_logo',
    )
  ) );
}

/**
 * CSS Output
 * Make an embedded stylesheet for the <head>
 */
add_action( 'wp_head', 'at_portfolio_custom_css' );
function at_portfolio_custom_css(){
  ?>
  <style>
    .footer{
      background-color: <?php echo get_theme_mod( 'footer_bg_color' ); ?>;
    }
    h1, h2, h3{
      font-family: '<?php echo get_theme_mod( 'heading_font' ); ?>', 'Open Sans', sans-serif;
    }
  </style>
  <?php
}

/**
 * Enqueue the selected font CSS
 */
add_action( 'wp_enqueue_scripts', 'at_portfolio_customize_stylesheets' );
function at_portfolio_customize_stylesheets(){
  //which font did they choose? Convert any spaces to '+' for the Google URL
  $heading_font = str_replace( ' ', '+', get_theme_mod( 'heading_font' ) );
  $url = "https://fonts.googleapis.com/css2?family=$heading_font&display=swap";
  wp_enqueue_style( 'custom-google-font', $url );
}

//file input sanitization function
function at_portfolio_sanitize_file( $file, $setting ) {
          
  //allowed file types
  $mimes = array(
      'jpg|jpeg|jpe' => 'image/jpeg',
      'gif'          => 'image/gif',
      'png'          => 'image/png'
  );
    
  //check file type from file name
  $file_ext = wp_check_filetype( $file, $mimes );
    
  //if file has a valid mime type return it, otherwise return default
  return ( $file_ext['ext'] ? $file : $setting->default );
}
//no close