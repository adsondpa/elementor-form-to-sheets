<?php
/**
 * Plugin Name: Elementor Formlarından Google Sheetse
 * Description: 
 * Plugin URI:  https://omerfarukyalcin.com/
 * Version:     1.0.0
 * Author:      Ömer Faruk Yalçın
 * Author URI:  https://omerfarukyalcin.com/
 * Text Domain: ofy-elementor-form-to-sheets
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 *
 *
 * @since 1.0.0
 * @param ElementorPro\Modules\Forms\Registrars\Form_Actions_Registrar $form_actions_registrar
 * @return void
 */
function add_new_sendy_form_action( $form_actions_registrar ) {

    include_once( __DIR__ .  '/form-actions/sheets-webhook.php' );

    $form_actions_registrar->register( new Ofy_Sheets_Action_After_Submit() );

}
add_action( 'elementor_pro/forms/actions/register', 'add_new_sendy_form_action' );
