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

        include_once('wpi-api.php');
        include_once('api/class-wpi-server.php');
        $this->wpi_api = new WPI_API();
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