<?php
/*
Plugin Name: Woo Public Interface
Plugin URI: 没有
Description: Woo Public Interface
Version: 1.0
Author: 卢杰杰
Author URI: lujiejie.com
License: A "Slug" license name e.g. GPL2
*/
if(!defined("ABSPATH")) exit;

if(!class_exists("WPI")):

final class WPI{

    const VERSION = 1;

    protected static $_instance;

    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'Woo Public Interface' ), '1.0' );
    }

    private function __construct(){

        define('PATH',dirname(dirname(__FILE__)).'/');
        define('API_DIR',plugin_dir_path(__FILE__));
        define('API_URL',plugin_dir_url(__FILE__));

        $this->includes();

        $this->init_route();
    }

    public function includes(){
        //for use global var $wpdb
//        require_once(PATH."../../../wp-blog-header.php");
//        global $wpdb;
//
//        require_once(API_DIR."class-wpi-auth.php");

    }

    public function init_route(){

        include_once('wpi-rewrite.php');
        flush_rewrite_rules();

    }

    /**
     * add_query_vars function.
     *
     * @access public
     * @since 2.0
     * @param $vars
     * @return array
     */
    public function add_query_vars( $vars ) {
        $vars[] = 'wpi-api';
        $vars[] = 'wpi-api-route';
        return $vars;
    }

    public function add_endpoint(){
        add_rewrite_rule("^wpi-api\/?$","/wp-content/plugin/wpi/wpi-api.php?wpi-api-route=/",'top');
        // REST API
//        add_rewrite_rule( '^wpi-api\/v' . self::VERSION . '/?$', 'index.php?wpi-api-route=/', 'top' );
//        add_rewrite_rule( '^wpi-api\/v' . self::VERSION .'(.*)?', 'index.php?wpi-api-route=$matches[1]', 'top' );
    }

    /**
     * API request - Trigger any API requests
     *
     * @access public
     * @since 2.0
     * @return void
     */
//    public function handle_api_requests() {
//        global $wp;
//
//        if ( ! empty( $_GET['wc-api'] ) )
//            $wp->query_vars['wc-api'] = $_GET['wc-api'];
//
//        if ( ! empty( $_GET['wc-api-route'] ) )
//            $wp->query_vars['wc-api-route'] = $_GET['wc-api-route'];
//
//        // REST API request
//        if ( ! empty( $wp->query_vars['wc-api-route'] ) ) {
//
//            define( 'WC_API_REQUEST', true );
//
//            // load required files
//            $this->includes();
//
//            $this->server = new WC_API_Server( $wp->query_vars['wc-api-route'] );
//
//            // load API resource classes
//            $this->register_resources( $this->server );
//
//            // Fire off the request
//            $this->server->serve_request();
//
//            exit;
//        }
//
//        // legacy API requests
//        if ( ! empty( $wp->query_vars['wc-api'] ) ) {
//
//            // Buffer, we won't want any output here
//            ob_start();
//
//            // Get API trigger
//            $api = strtolower( esc_attr( $wp->query_vars['wc-api'] ) );
//
//            // Load class if exists
//            if ( class_exists( $api ) )
//                $api_class = new $api();
//
//            // Trigger actions
//            do_action( 'woocommerce_api_' . $api );
//
//            // Done, clear buffer and exit
//            ob_end_clean();
//            die('1');
//        }
//    }
}

endif;

function WPI(){
    return WPI::getInstance();
}

$GLOBALS["wpi"] = WPI();