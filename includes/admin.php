<?php
/**
* All of the admin-facing funtionality will live here.
*/

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

/**
 * Initializes the theme options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
add_action('admin_init', 'caw_initialise_options');
function caw_initialise_options(){

  //Register a section first
  add_settings_section(
    'general_settings_section',       // ID used to identify this section and with which to register options
    'Admin Whitelabel Options',       // Title to be displayed on the administration page
    'caw_general_options_callback',   // Callback used to render the description of the section
    'general'                         // Page on which to add this section of options
  );

  //Next, we add the fields to turn on and off whitelabel functionality
  add_settings_field(
    'custom_login_page',                // ID used to identify the field throughout the plugin
    'Customise login page',             // The label to the left of the option interface element
    'caw_toggle_login_callback',        // The name of the function responsible for rendering the option interface
    'general',                          // The page on which this option will be displayed
    'general_settings_section',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
      'Select this setting to customise the login page.'
    )
  );

  add_settings_field(
    'custom_admin_footer',
    'Customise admin footer',
    'caw_toggle_footer_callback',
    'general',
    'general_settings_section',
    array(
      'Select this setting to customise the admin footer'
    )
  );

  //Finally we register the fields with wordpress
  register_setting(
    'general',
    'custom_login_page'
  );

  register_setting(
    'general',
    'custom_admin_footer'
  );

}//end caw_initialise_options

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
     // Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field
     $html = '<input type="checkbox" id="custom_login_page" name="custom_login_page" value="1" ' . checked(1, get_option('custom_login_page'), false) . '/>';

     // Here, we will take the first argument of the array and add it to a label next to the checkbox
     $html .= '<label for="custom_login_page"> ' . $args[0] . '</label>';

     echo $html;
   }//END caw_toggle_login_callback

   function caw_toggle_footer_callback($args){
     $html = '<input type="checkbox" id="custom_admin_footer" name="custom_admin_footer" value="1" ' . checked(1, get_option('custom_admin_footer'), false) . '/>';
     $html .= '<label for="custom_admin_footer"> ' . $args[0] . '</label>';
     echo $html;
   }
