<?php
/**
 * The color picker specific functionality of the plugin
 * @since  1.0.0
 * @package  Custom_Admin_Whitelabel
 * @subpackage Custom_Admin_Whitelabel/admin
 */

/**
 * Main Class - CPA = Color Picker API
 */
class caw_color_picker_options {

  /*
   * Attributes
   */

  //Refers to a single instance of this class.
  private static $instance = null;

  //Saved options
  public $options;

  /**
   * Constructor
   */

  /**
   * Creates or returns an instance of this class
   *
   * @return  caw_color_picker_options A single instance of this class
   */
   public static function get_instance(){

     if( null == self::$instance ){
       self::$instance = new self;
     }

     return self::$instance;

   }//end get_instance

   /**
    * Initializes the plugin by setting localization, filters and admin functions
    */
    private function __construct(){
      // Add the page to the admin menu (TEMP)
      add_action( 'admin_menu', array( &$this, 'add_page' ) );

      // Register page options (TEMP)
      add_action( 'admin_init', array( &$this, 'register_page_options') );

      // Css rules for Color Picker
      wp_enqueue_style( 'wp-color-picker' );

      // Register javascript
      add_action('admin_enqueue_scripts', array( $this, 'enqueue_admin_js' ) );

      // Get registered option
      $this->options = get_option( 'caw_cpa_settings_options' );
    }

    /**
     * Functions
     */

    /**
    * Function that will add the options page under Setting Menu.
    */
    public function add_page() {
      // $page_title, $menu_title, $capability, $menu_slug, $callback_function
      add_options_page( 'Theme Options', 'Theme Options', 'manage_options', __FILE__, array( $this, 'display_page' ) );
    }

    /**
    * Function that will display the options page.
    */
    public function display_page() {
      ?>
        <div class="wrap">

            <h2>Theme Options</h2>
            <form method="post" action="options.php">
            <?php
                settings_fields(__FILE__);
                do_settings_sections(__FILE__);
                submit_button();
            ?>
            </form>
        </div> <!-- /wrap -->
      <?php
    }

    /**
    * Function that will register admin page options.
    */
    public function register_page_options() {

      // Add Section for option fields
      add_settings_section( 'cpa_section', 'Theme Options', array( $this, 'display_section' ), __FILE__ ); // id, title, display cb, page

      // Add Title Field
      add_settings_field( 'cpa_title_field', 'Blog Title', array( $this, 'title_settings_field' ), __FILE__, 'cpa_section' ); // id, title, display cb, page, section

      // Add Background Color Field
      add_settings_field( 'cpa_bg_field', 'Background Color', array( $this, 'bg_settings_field' ), __FILE__, 'cpa_section' ); // id, title, display cb, page, section

      // Register Settings
      register_setting( __FILE__, 'cpa_settings_options', array( $this, 'validate_options' ) ); // option group, option name, sanitize cb
    }

    /**
     * Function that will add javascript file for Color Picker.
     */
    public function enqueue_admin_js() {
      // Make sure to add the wp-color-picker dependecy to js file
      wp_enqueue_script( 'caw_color_picker_script', plugins_url( '/admin/js/color-picker.js', dirname(__FILE__) ), array( 'jquery', 'wp-color-picker' ), '', true  );
    }

    /**
    * Function that will validate all fields. - MAY NOT BE NEEDED
    */
    public function validate_options( $fields ) {

      $valid_fields = array();

      // Validate Title Field
      $title = trim( $fields['title'] );
      $valid_fields['title'] = strip_tags( stripslashes( $title ) );

      // Validate Background Color
      $background = trim( $fields['background'] );
      $background = strip_tags( stripslashes( $background ) );

      // Check if is a valid hex color
      if( FALSE === $this->check_color( $background ) ) {

         // Set the error message
         add_settings_error( 'cpa_settings_options', 'cpa_bg_error', 'Insert a valid color for Background', 'error' ); // $setting, $code, $message, $type

         // Get the previous valid value
         $valid_fields['background'] = $this->options['background'];

      } else {

         $valid_fields['background'] = $background;

      }

      return apply_filters( 'validate_options', $valid_fields, $fields);
    }

    /**
    * Function that will check if value is a valid HEX color.
    */
    public function check_color( $value ) {

      if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user inserts a HEX color with #
        return true;
      }

      return false;
    }

    /**
    * Callback function for settings section - MAY NOT BE NEEDED
    */
    public function display_section() { /* Leave blank */ }

    /**
    * Functions that display the fields. MAY NOT BE NEEDED
    */
    public function title_settings_field() {
      $val = ( isset( $this->options['title'] ) ) ? $this->options['title'] : '';
      echo '<input type="text" name="cpa_settings_options[title]" value="' . $val . '" />';
    }

    public function bg_settings_field( ) {
      $val = ( isset( $this->options['title'] ) ) ? $this->options['background'] : '';
      echo '<input type="text" name="cpa_settings_options[background]" value="' . $val . '" class="cpa-color-picker" >';
    }

} // end class

CAW_color_picker_options::get_instance();
