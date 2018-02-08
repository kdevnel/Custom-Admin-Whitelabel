<?php
/**
* All of the admin-facing funtionality will live here.
*/

/**
* Include all admin files
*/
require_once plugin_dir_path( dirname(__FILE__) ) . '/admin/color-picker.php';

/**
* Add new menus
*/
function create_caw_admin_page(){
  add_submenu_page(
    'options-general.php',      // Register this submenu with the menu defined above
    'Whitelabel Options',       // The text to the display in the browser when this menu item is active
    'Whitelabel',               // The text for this menu item
    'administrator',            // Which type of users can see this menu
    'caw_options',              // The unique ID - the slug - for this menu item
    'caw_options_page_login'       // The function used to render this menu's page to the screen
  );
}//end create_caw_admin_page
add_action('admin_menu', 'create_caw_admin_page');

function caw_options_page_login(){ ?>

  <!-- Create a header -->
  <div class="wrap">
    <h2>Custom Whitelabel Options</h2>

    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'login_options'; ?>

    <h2 class="nav-tab-wrapper">
      <a href="?page=caw_options&tab=login_options" class="nav-tab <?php echo $active_tab == 'login_options' ? 'nav-tab-active' : '' ?>">Login Options</a>
      <a href="?page=caw_options&tab=admin_options" class="nav-tab <?php echo $active_tab == 'admin_options' ? 'nav-tab-active' : '' ?>">Admin Options</a>
      <a href="?page=caw_options&tab=input_examples" class="nav-tab <?php echo $active_tab == 'input_examples' ? 'nav-tab-active' : '' ?>">Input Examples</a>
    </h2>

    <!-- Display the form for handling the options -->
    <form method="post" action="options.php">
      <?php

        if( $active_tab == 'login_options' ){

          settings_fields('caw_login_options');
          do_settings_sections('caw_login_options');

        } else if( $active_tab == 'admin_options' ){

          settings_fields( 'caw_admin_options' );
          do_settings_sections( 'caw_admin_options' );

        } else {

          settings_fields( 'caw_input_examples_options' );
          do_settings_sections( 'caw_input_examples_options' );

        }//end if/else if/else

        submit_button();

      ?>
    </form>

  </div><!-- .wrap -->

<?php }//end caw_options_page_login

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

 /**
  * Provides default values for the Login Options.
  */
 function caw_default_login_options() {

 	$defaults = array(
 		'custom_login_logo'  =>  '',
 		'custom_login_colours' =>  '',
 		'custom_login_background_colour' =>  ''
 	);

 	return apply_filters( 'caw_default_login_options', $defaults );

} // end caw_default_login_options

/**
 * Provides default values for the Admin Options.
 */
function caw_default_admin_options() {

 $defaults = array(
   'custom_admin_footer'  =>	''
 );

 return apply_filters( 'caw_default_admin_options', $defaults );

} // end caw_default_admin_options

/**
 * Provides default values for the Input Options.
 */
function caw_default_input_examples_options() {

 $defaults = array(
   'input_element' => ''
 );

 return apply_filters( 'caw_default_admin_options', $defaults );

} // end caw_default_admin_options

/**
 * Initializes the login options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function caw_initialise_login_options(){

  //If theme options don't exist then create them
  if( false == get_option( 'caw_login_options' ) ) {
    add_option( 'caw_login_options', apply_filters( 'caw_default_login_options', caw_default_login_options() ) );
  } // end if

  //Register a section first
  add_settings_section(
    'general_settings_section',       // ID used to identify this section and with which to register options
    'Login Page Options',             // Title to be displayed on the administration page
    'caw_general_options_callback',   // Callback used to render the description of the section
    'caw_login_options'             // Page on which to add this section of options
  );

  //Next, we add the fields to turn on and off whitelabel functionality
  add_settings_field(
    'custom_login_page',                // ID used to identify the field throughout the plugin
    'Customise login page',             // The label to the left of the option interface element
    'caw_toggle_login_callback',        // The name of the function responsible for rendering the option interface
    'caw_login_options',              // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
      'Select this setting to customise the login page.'
    )
  );

  add_settings_field(
    'custom_login_logo',
    'Customise login logo',
    'caw_toggle_login_logo_callback',
    'caw_login_options',
    'general_settings_section',
    array(
      'Select this setting to customise the login logo.'
    )
  );

  add_settings_field(
    'custom_login_colours',
    'Customise login colours',
    'caw_toggle_login_colours_callback',
    'caw_login_options',
    'general_settings_section',
    array(
      'Select this setting to customise the login button and element colours.'
    )
  );

  add_settings_field(
    'custom_login_background_colour',
    'Customise login background colour',
    'caw_toggle_login_background_colour_callback',
    'caw_login_options',
    'general_settings_section',
    array(
      'Select this setting to customise the login page background colour.'
    )
  );

  //Finally we register the fields with WordPress
  register_setting(
    'caw_login_options',
    'caw_login_options'
  );

}//end caw_initialise_login_options
add_action('admin_init', 'caw_initialise_login_options');

/**
 * Initializes the admin options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
 function caw_initialise_admin_options(){
   if( false == get_option( 'caw_admin_options' ) ) {
     add_option( 'caw_admin_options', apply_filters( 'caw_default_admin_options', caw_default_admin_options() ) );
   }//end if

   //We need to add a new section for the admin options group
   add_settings_section(
     'admin_settings_section',
     'General Admin Settings',
     'caw_admin_description_callback',
     'caw_admin_options'
   );

   add_settings_field(
     'custom_admin_footer',
     'Customise admin footer',
     'caw_toggle_footer_callback',
     'caw_admin_options',
     'admin_settings_section',
     array(
       'Select this setting to customise the admin footer.'
     )
   );

   add_settings_field(
     'custom_company_name',
     'Custom company name',
     'caw_input_company_callback',
     'caw_admin_options',
     'admin_settings_section',
     array(
       'Enter your own company name here.'
     )
   );

   //Finally we register the fields with WordPress
   register_setting(
     'caw_admin_options',
     'caw_admin_options',
     'caw_sanitize_admin_options'
   );

 }//end caw_initialise_admin_options
add_action('admin_init', 'caw_initialise_admin_options');

/**
 * Initializes the input examples options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
 function caw_initialise_input_examples_options(){
   if( false == get_option( 'caw_input_examples_options' ) ){
     add_option( 'caw_input_examples_options' );
   }//end if

   //We need to add a new section for the input examples options group
   add_settings_section(
     'input_examples_settings_section',
     'Input Examples',
     'caw_input_examples_description_callback',
     'caw_input_examples_options'
   );

   //Add the Fields
   add_settings_field(
     'input_element',
     'Input Element',
     'caw_input_element_callback',
     'caw_input_examples_options',
     'input_examples_settings_section'
   );

   //Radio fields
   add_settings_field(
     'radio_element',
     'Radio Element',
     'caw_radio_element_callback',
     'caw_input_examples_options',
     'input_examples_settings_section'
   );

   //Select box
   add_settings_field(
     'select_box',
     'Select Box',
     'caw_select_box_callback',
     'caw_input_examples_options',
     'input_examples_settings_section'
   );

   //Register the Fields
   register_setting(
     'caw_input_examples_options',
     'caw_input_examples_options',
     'caw_validate_input_examples'
   );

 }//end caw_initialise_input_examples_options
 add_action( 'admin_init', 'caw_initialise_input_examples_options' );

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the Login Options page.
 *
 * Called from 'caw_initialise_login_options'
 */
 function caw_general_options_callback(){
   echo '<p>Change the general settings for the Custom Admin whitelabel plugin.</p>';
 }//end caw_general_options_callback

 /**
  * This function provides a simple description for the Admin Options page.
  * Called from 'caw_initialise_admin_options'
  */
function caw_admin_description_callback(){
  echo '<p>These settings control the whitelabelling of the admin area.</p>';
}//end caw_admin_description_callback

/**
 * This function provides a simple description for the Input Examples Options page.
 * Called from 'caw_initialise_input_examples_options'
 */
function caw_input_examples_description_callback(){
 echo '<p>A sample of example inputs that can be used in WordPress option pages.</p>';
}//end caw_input_examples_description_callback

/* ------------------------------------------------------------------------ *
* Field Callbacks
* ------------------------------------------------------------------------ */

/**
 * Functions to handle interface elements for toggling a custom login page.
 */
 function caw_toggle_login_callback($args){

   //First we read the options collection
   $options = get_option('caw_login_options');

   // Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
   $html = '<input type="checkbox" id="custom_login_page" name="caw_login_options[custom_login_page]" value="1" ' . checked(1, isset( $options['custom_login_page'] ) ? $options['custom_login_page'] : 0, false) . '/>';

   // Here, we will take the first argument of the array and add it to a label next to the checkbox
   $html .= '<label for="custom_login_page"> ' . $args[0] . '</label>';

   echo $html;

 }//END caw_toggle_login_callback

 function caw_toggle_login_logo_callback($args){

   $options = get_option('caw_login_options');

   $html = '<input type="checkbox" id="custom_login_logo" name="caw_login_options[custom_login_logo]" value="1" ' . checked(1, isset( $options['custom_login_logo'] ) ? $options['custom_login_logo'] : 0, false) . '/>';
   $html .= '<label for="custom_login_logo"> ' . $args[0] . '</label>';
   echo $html;
 }//end caw_toggle_login_logo_callback

 function caw_toggle_login_colours_callback($args){

   $options = get_option('caw_login_options');

   $html = '<input type="checkbox" id="custom_login_colours" name="caw_login_options[custom_login_colours]" value="1" ' . checked(1, isset( $options['custom_login_colours'] ) ? $options['custom_login_colours'] : 0, false) . '/>';
   $html .= '<label for="custom_login_colours"> ' . $args[0] . '</label>';
   echo $html;
 }//end caw_toggle_login_colours_callback

 function caw_toggle_login_background_colour_callback($args){

   $options = get_option('caw_login_options');

   $html = '<input type="checkbox" id="custom_login_background_colour" name="caw_login_options[custom_login_background_colour]" value="1" ' . checked(1, isset( $options['custom_login_background_colour']) ? $options['custom_login_background_colour'] : 0, false) . '/>';
   $html .= '<label for="custom_login_background_colour"> ' . $args[0] . '</label>';
   echo $html;
 }//end caw_toggle_login_background_colour_callback

 /**
  * Functions to handle interface elements for toggling a custom admin functionality.
  */
 function caw_toggle_footer_callback($args){

   $options = get_option('caw_admin_options');

   $html = '<input type="checkbox" id="custom_admin_footer" name="caw_admin_options[custom_admin_footer]" value="1" ' . checked(1, isset( $options['custom_admin_footer'] ) ? $options['custom_admin_footer'] : 0, false) . '/>';
   $html .= '<label for="custom_admin_footer"> ' . $args[0] . '</label>';
   echo $html;
 }//end caw_toggle_footer_callback

 function caw_input_company_callback($args){

   //First, read the admin options collection
   $options = get_option('caw_admin_options');

   //Then, we check the element is defined. If not then we set an empty string in it's place.
   $text = '';
   if( isset( $options['custom_company_name'] ) ){
     $text = $options['custom_company_name'];
   }//end if

   //Output the content
   echo '<input type="text" id="custom_company_name" name="caw_admin_options[custom_company_name]" value="' . $text . '" />';

 }//end caw_input_company_callback

 /**
  * Functions to handle interface elements for input examples.
  */
  function caw_input_element_callback( $args ){

    $options = get_option( 'caw_input_examples_options' );

    //Then, we check the element is defined. If not then we set an empty string in it's place.
    $text = '';
    if( isset( $options['input_element'] ) ){
      $text = $options['input_element'];
    }//end if

    //render the element
    echo '<input type="text" id="input_element" name="caw_input_examples_options[input_element]" value="' . $text . '" />';

  }

  function caw_radio_element_callback( $args ){

    $options = get_option( 'caw_input_examples_options' );

    $html = '<input type="radio" id="radio_example_one" name="caw_input_examples_options[radio_element]" value="1" ' . checked(1, $options['radio_element'], false) . ' />';
    $html .= '&nbsp;';
    $html .='<label for="radio_example_one">Option 1</label>';
    $html .= '&nbsp;';

    $html .= '<input type="radio" id="radio_example_two" name="caw_input_examples_options[radio_element]" value="2" ' . checked(2, $options['radio_element'], false) . ' />';
    $html .= '&nbsp;';
    $html .= '<label for="radio_example_two">Option 2</label>';

    echo $html;

  }

  function caw_select_box_callback( $args ){

    $options = get_option( 'caw_input_examples_options' );

    $html = '<select id="time_options" name="caw_input_examples_options[time_options]">';
      $html .= '<option value="default">Select a time option...</option>';
      $html .= '<option value="never"' . selected( $options['time_options'], 'never', false ) . '>Never</option>';
      $html .= '<option value="sometimes"' . selected( $options['time_options'], 'sometimes', false ) . '>Sometimes</option>';
      $html .= '<option value="always"' . selected( $options['time_options'], 'always', false ) . '>Always</option>';
    $html .= '</select>';

    echo $html;

  }

 /**
 *  Sanitize functionality
 */
function caw_sanitize_admin_options( $input ) {

  //Create an array to handle the updated Options
  $output = array();

  //Loop through each option and sanitize the contents
  foreach( $input as $key => $val ){

    if( isset( $input[$key] ) ){
      $output[$key] = strip_tags( stripslashes( $input[$key] ) );
    }//end if

  }//end foreach

  //Return the newly sanitized collection
  return apply_filters( 'caw_sanitize_admin_options', $output, $input );

}//end caw_sanitize_admin_options

function caw_validate_input_examples( $input ){

  //Create an array to store the validated Options
  $output = array();

  //loop throught the values
  foreach ($input as $key => $value) {

    //check if the current value contains data. If so, process.
    if( isset( $input[$key] ) ){

      //Strip HTML, PHP and properly handle quoted strings
      $output[$key] = strip_tags( stripslashes( $input[$key] ) );

    }//end if

  }//end foreach

  //Return the array and process any additional functions filtered by this action
  return apply_filters( 'caw_validate_input_examples', $output, $input );

}//end caw_validate_input_examples
