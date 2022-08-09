<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor form Sheets action.
 **
 * @since 1.0.0
 */
class Ofy_Sheets_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {

    /**
     * Get action name.
     *
     * Retrieve Sheets action name.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function get_name() {
        return 'ofy_sheets';
    }

    /**
     * Get action label.
     **
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function get_label() {
        return esc_html__( 'Form to Sheets', 'ofy-elementor-form-to-sheets' );
    }

    /**
     * Register action controls.
     *
     * Add input fields to allow the user to customize the action settings.
     *
     * @since 1.0.0
     * @access public
     * @param \Elementor\Widget_Base $widget
     */
    public function register_settings_section( $widget ) {

        $widget->start_controls_section(
            'section_ofy_sheets',
            [
                'label' => esc_html__( 'Form to Sheets', 'ofy-elementor-form-to-sheets' ),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );

        $widget->add_control(
            'sheets_webhook_url',
            [
                'label' => esc_html__( 'Webhook URL', 'ofy-elementor-form-to-sheets' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => '',
                'description' => esc_html__( 'Google Sheets App Script Webhook URLsi', 'ofy-elementor-form-to-sheets' ),
            ]
        );
        $widget->end_controls_section();

    }

    /**
     * Run action.
     *
     * @since 1.0.0
     * @access public
     * @param \ElementorPro\Modules\Forms\Classes\Form_Record  $record
     * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
     */
    public function run( $record, $ajax_handler ) {

        $settings = $record->get( 'form_settings' );

        if ( empty( $settings['sheets_webhook_url'] ) ) {
            return;
        }

        // Get submitted form data.
        $raw_fields = $record->get( 'fields' );

        // Normalize form data.
        $fields = [];
        foreach ( $raw_fields as $id => $field ) {
            $fields[ $id ] = $field['value'];
        }

        // Send the request.
        wp_remote_post(
            $settings['sheets_webhook_url'],
            [
                'body' => $fields,
            ]
        );

    }

    /**
     * On export.
     *
     * @since 1.0.0
     * @access public
     * @param array $element
     */
    public function on_export( $element ) {

        unset(
            $element['sheets_webhook_url'],
        );

        return $element;

    }

}