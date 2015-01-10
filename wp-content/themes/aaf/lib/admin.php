<?php

require_once dirname( __FILE__ ) . '/class.settings-api.php';

/**
 * WordPress settings API demo class
 *
 * @author Dario Novoa
 */
class _Bootstrap_Admin {

    private $settings_api;

    function __construct() {
        $this->settings_api = new AAF_Settings_API();

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_theme_page( 'Theme Options', 'Theme Options', 'delete_posts', 'theme-option', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'tp_settings',
                'title' => __( 'Basic Settings', 'AAF' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'tp_settings' => array(
                array(
                    'name' => 'footer_text',
                    'label' => __( 'Footer Message', 'AAF' ),
                    'type' => 'textarea',
                    'std' => ''
                ),
                array(
                    'name' => 'footer_js',
                    'label' => __( 'Footer JS', 'AAF' ),
                    'type' => 'textarea'
                ),
                array(
                    'name' => 'footer_css',
                    'label' => __( 'Footer CSS', 'AAF' ),
                    'type' => 'textarea'
                )
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';
        settings_errors();

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

}

$settings = new _Bootstrap_Admin();
