<?php
/**
* All of the public-facing funtionality will live here.
*/

/**
* Login Page Functionality
*/

add_action( 'login_enqueue_scripts', 'caw_login_page' );

function caw_login_page(){

  $login_options = get_option( 'caw_login_options' );

  if( isset( $login_options['custom_login_page'] ) ? $login_options['custom_login_page'] : 0 ){

    //Open output CSS container
    $outputCSS = '<style type="text/css">';

    //Customise the login body colour
    if( isset( $login_options['custom_login_background_colour'] ) ? $login_options['custom_login_background_colour'] : 0 ){
      $outputCSS .= '
        body {
            background:#ffffff !important;
        }';
    }//end if

    //Customise the login logo
    if( isset( $login_options['custom_login_logo'] ) ? $login_options['custom_login_logo'] : 0 ){
      $outputCSS .= '
        #login h1 a, .login h1 a {
          background-image: url(' . MY_PLUGIN_PATH . 'images/default-login-logo.png);
          height:65px;
          width:320px;
          background-size: 320px 65px;
          background-repeat: no-repeat;
          padding-bottom: 30px;}';
    }//end if

    //Customise the login element colours
    if( isset( $login_options['custom_login_colours'] ) ? $login_options['custom_login_colours'] : 0 ){
      $outputCSS .= '
        #wp-submit {
          background: #8c00ba;
          border-color: #700194 #620182 #620182;
          box-shadow: 0 1px 0 #620182;
          color: #fff;
          text-decoration: none;
          text-shadow: 0 -1px 1px #620182, 1px 0 1px #620182, 0 1px 1px #620182, -1px 0 1px #620182;
        }
        .login #login_error, #login .message {border-left: 4px solid #8c00ba;}
        input[type=text]:focus, input[type=search]:focus, input[type=radio]:focus, input[type=tel]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, input[type=password]:focus, input[type=checkbox]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime]:focus, input[type=datetime-local]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, select:focus, textarea:focus{
          border-color: #8c01ba !important;
          box-shadow: 0 0 2px rgba(140,1,186,.8) !important;
        }
        .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover{
          color: #8c01ba !important;
        }';
    }//end if

    //Close the output CSS container
    $outputCSS .= '</style>';

    echo $outputCSS;

  }// end if

}//end caw_login_page

/**
* Dashboard Functionality
*/

//Admin footer override
$admin_options = get_option( 'caw_admin_options' );

if( isset( $admin_options['custom_admin_footer'] ) ? $admin_options['custom_admin_footer'] : 0 ){

  function caw_admin_page(){

    $admin_options = get_option( 'caw_admin_options' );

    echo '<span id="footer-note">From your friends at <a href="http://www.yourdomain.com/" target="_blank">' . sanitize_text_field( $admin_options['custom_company_name'] ) . '</a>.</span>';

  }//end caw_admin_page
  add_filter( 'admin_footer_text', 'caw_admin_page' );

}//end if

$input_examples = get_option( 'caw_input_examples_options' );

if( isset( $input_examples['input_element' ] ) ? $input_examples['input_element'] : 0){

  function caw_admin_input_tests(){

    $input_examples = get_option( 'caw_input_examples_options' );

    echo '<br>' . sanitize_text_field( $input_examples['input_element'] );

  }//end caw_admin_page
  add_filter( 'admin_footer_text', 'caw_admin_input_tests' );

}//end if

//Radio element test
if( isset( $input_examples['radio_element' ] ) ? $input_examples['radio_element'] : 0){

  function caw_admin_radio_test(){

    $input_examples = get_option( 'caw_input_examples_options' );

    if( $input_examples['radio_element'] == 1 ){
      echo '<br>Option 1 was selected';
    } elseif( $input_examples['radio_element'] == 2 ) {
      echo '<br>Option 2 was selected';
    } //end if

  }//end caw_admin_page
  add_filter( 'admin_footer_text', 'caw_admin_radio_test' );

}//end if

//Select box test
if( isset( $input_examples['time_options' ] ) ? $input_examples['time_options'] : 0){

  function caw_admin_select_test(){

    $input_examples = get_option( 'caw_input_examples_options' );

    if( $input_examples['time_options'] == 'never' ){
      echo '<br>Never show this';
    } elseif( $input_examples['time_options'] == 'sometimes' ) {
      echo '<br>Sometimes show this';
    } elseif( $input_examples['time_options'] == 'always' ){
      echo '<br>Always show this';
    } //end if

  }//end caw_admin_page
  add_filter( 'admin_footer_text', 'caw_admin_select_test' );

}//end if
