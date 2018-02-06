<?php
/**
* All of the admin-facing funtionality will live here.
*/

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
    'caw_options_page_display'       // The function used to render this menu's page to the screen
  );
}//end create_caw_admin_page
add_action('admin_menu', 'create_caw_admin_page');

function caw_options_page_display(){ ?>

  <!-- Create a header -->
  <div class="wrap">
    <h2>Custom Whitelabel Options</h2>

    <!-- Display the form for handling the options -->
    <form method="post" action="options.php">
      <?php settings_fields('caw_display_options'); ?>
      <?php do_settings_sections('caw_display_options'); ?>
      <?php submit_button(); ?>
    </form>

  </div><!-- .wrap -->

<?php }//end caw_options_page_display

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

 /**
  * Provides default values for the Display Options.
  */
 function caw_default_display_options() {

 	$defaults = array(
 		'custom_login_logo'		=>	'',
 		'custom_login_colours'		=>	'',
 		'custom_login_background_colour'		=>	'',
    'custom_admin_footer' =>  ''
 	);

 	return apply_filters( 'caw_default_display_options', $defaults );

 } // end sandbox_theme_default_display_options

/**
 * Initializes the theme options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function caw_initialise_options(){

  //If theme options don't exist then create them
  if( false == get_option( 'caw_display_options' ) ) {
    add_option( 'caw_display_options', apply_filters( 'caw_default_display_options', caw_default_display_options() ) );
  } // end if

  //Register a section first
  add_settings_section(
    'general_settings_section',       // ID used to identify this section and with which to register options
    'Login Page Options',             // Title to be displayed on the administration page
    'caw_general_options_callback',   // Callback used to render the description of the section
    'caw_display_options'             // Page on which to add this section of options
  );

  //Next, we add the fields to turn on and off whitelabel functionality
  add_settings_field(
    'custom_login_page',                // ID used to identify the field throughout the plugin
    'Customise login page',             // The label to the left of the option interface element
    'caw_toggle_login_callback',        // The name of the function responsible for rendering the option interface
    'caw_display_options',              // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
      'Select this setting to customise the login page.'
    )
  );

  add_settings_field(
    'custom_login_logo',
    'Customise login logo',
    'caw_toggle_login_logo_callback',
    'caw_display_options',
    'general_settings_section',
    array(
      'Select this setting to customise the login logo.'
    )
  );

  add_settings_field(
    'custom_login_colours',
    'Customise login colours',
    'caw_toggle_login_colours_callback',
    'caw_display_options',
    'general_settings_section',
    array(
      'Select this setting to customise the login button and element colours.'
    )
  );

  add_settings_field(
    'custom_login_background_colour',
    'Customise login background colour',
    'caw_toggle_login_background_colour_callback',
    'caw_display_options',
    'general_settings_section',
    array(
      'Select this setting to customise the login page background colour.'
    )
  );

  add_settings_field(
    'custom_admin_footer',
    'Customise admin footer',
    'caw_toggle_footer_callback',
    'caw_display_options',
    'general_settings_section',
    array(
      'Select this setting to customise the admin footer.'
    )
  );

  //Finally we register the fields with wordpress
  register_setting(
    'caw_display_options',
    'caw_display_options'
  );

}//end caw_initialise_options
add_action('admin_init', 'caw_initialise_options');

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the General Options page.
 *
 * It is called from the 'caw_initialise_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
 function caw_general_options_callback(){
   echo '<p>Change the general settings for the Custom Admin whitelabel plugin.</p>';
 }

 /* ------------------------------------------------------------------------ *
  * Field Callbacks
  * ------------------------------------------------------------------------ */

  /**
   * This function renders the interface elements for toggling a custom login page.
   *
   * It accepts an array of arguments and expects the first element in the array to be the description
   * to be displayed next to the checkbox.
   */
   function caw_toggle_login_callback($args){

     //First we read the options collection
     $options = get_option('caw_display_options');

     // Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
     $html = '<input type="checkbox" id="custom_login_page" name="caw_display_options[custom_login_page]" value="1" ' . checked(1, isset( $options['custom_login_page'] ) ? $options['custom_login_page'] : 0, false) . '/>';

     // Here, we will take the first argument of the array and add it to a label next to the checkbox
     $html .= '<label for="custom_login_page"> ' . $args[0] . '</label>';

     echo $html;

   }//END caw_toggle_login_callback

   function caw_toggle_login_logo_callback($args){

     $options = get_option('caw_display_options');

     $html = '<input type="checkbox" id="custom_login_logo" name="caw_display_options[custom_login_logo]" value="1" ' . checked(1, isset( $options['custom_login_logo'] ) ? $options['custom_login_logo'] : 0, false) . '/>';
     $html .= '<label for="custom_login_logo"> ' . $args[0] . '</label>';
     echo $html;
   }//end caw_toggle_login_logo_callback

   function caw_toggle_login_colours_callback($args){

     $options = get_option('caw_display_options');

     $html = '<input type="checkbox" id="custom_login_colours" name="caw_display_options[custom_login_colours]" value="1" ' . checked(1, isset( $options['custom_login_colours'] ) ? $options['custom_login_colours'] : 0, false) . '/>';
     $html .= '<label for="custom_login_colours"> ' . $args[0] . '</label>';
     echo $html;
   }//end caw_toggle_login_colours_callback

   function caw_toggle_login_background_colour_callback($args){

     $options = get_option('caw_display_options');

     $html = '<input type="checkbox" id="custom_login_background_colour" name="caw_display_options[custom_login_background_colour]" value="1" ' . checked(1, isset( $options['custom_login_background_colour']) ? $options['custom_login_background_colour'] : 0, false) . '/>';
     $html .= '<label for="custom_login_background_colour"> ' . $args[0] . '</label>';
     echo $html;
   }//end caw_toggle_login_background_colour_callback

   function caw_toggle_footer_callback($args){

     $options = get_option('caw_display_options');

     $html = '<input type="checkbox" id="custom_admin_footer" name="caw_display_options[custom_admin_footer]" value="1" ' . checked(1, isset( $options['custom_admin_footer'] ) ? $options['custom_admin_footer'] : 0, false) . '/>';
     $html .= '<label for="custom_admin_footer"> ' . $args[0] . '</label>';
     echo $html;
   }//end caw_toggle_footer_callback
