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

    public $wpi_api;

    private function __construct(){
        define('WPI_DIR',plugin_dir_path(__FILE__));
        define('WPI_URL',plugin_dir_url(__FILE__));

        register_activation_hook( __FILE__, array($this, 'activate') );
        register_deactivation_hook( __FILE__, array($this, 'deactivate') );
        add_action( 'generate_rewrite_rules', array($this, 'add_rewrite_rules') );
        add_filter( 'query_vars', array($this, 'query_vars') );

        include_once('wpi-api.php');
        include_once('api/class-wpi-server.php');
        include_once('wpi-functions.php');
        $this->wpi_api = new WPI_API();
    }

    function activate() {
        global $wp_rewrite;
        $wp_rewrite->flush_rules(); // force call to generate_rewrite_rules()
    }

    function deactivate() {
        remove_action( 'generate_rewrite_rules', array($this, 'add_rewrite_rules') );
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    /**********重写规则************/
    function add_rewrite_rules( $wp_rewrite ){
        $new_rules = array(
            'wpi-api\/v'.WPI::VERSION.'/?$' => 'index.php?wpi-api=doc',
            'wpi-api\/v'.WPI::VERSION.'\/auth\/check/?$' => 'index.php?wpi-api=auth/check',
            'wpi-api\/v'.WPI::VERSION.'\/upload\/image_from_url/?$' => 'index.php?wpi-api=upload/image_from_url',
        ); //添加翻译规则
        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
        //php数组相加
    }

    /*******添加query_var变量***************/
    function query_vars($query_vars){
        $query_vars[] = 'wpi-api'; //往数组中添加添加my_custom_page
        return $query_vars;
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'Woo Public Interface'), '1.0');
    }
}
    endif;

function WPI(){
    return WPI::getInstance();
}

$GLOBALS["wpi"] = WPI();