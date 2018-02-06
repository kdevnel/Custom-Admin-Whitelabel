<?php
/**
* All of the public-facing funtionality will live here.
*/

/**
* Login Page Functionality
*/

add_action( 'login_enqueue_scripts', 'caw_login_page' );

function caw_login_page(){

  $display_options = get_option( 'caw_display_options' );

  if( isset( $display_options['custom_login_page'] ) ? $display_options['custom_login_page'] : 0 ){

    //Open output CSS container
    $outputCSS = '<style type="text/css">';

    //Customise the login body colour
    if( isset( $display_options['custom_login_background_colour'] ) ? $display_options['custom_login_background_colour'] : 0 ){
      $outputCSS .= '
        body {
            background:#ffffff !important;
        }';
    }//end if

    //Customise the login logo
    if( isset( $display_options['custom_login_logo'] ) ? $display_options['custom_login_logo'] : 0 ){
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
    if( isset( $display_options['custom_login_colours'] ) ? $display_options['custom_login_colours'] : 0 ){
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
