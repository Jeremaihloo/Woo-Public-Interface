<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
class WPI_API{
    private $server;
    public function __construct()
    {
        add_action( 'parse_request', array( $this, 'handle_api_requests'), 0 );
    }

    public function handle_api_requests(){
        WPI_Log::get_instance()->log('wpi api request : '.'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        global $wp;
        if(isset($_GET['wpi-api'])){
            $wp->query_vars['wpi-api'] = $_GET['wpi-api'];
        }
        if(isset($wp->query_vars['wpi-api'])){

            $this->server = new WPI_Server();

            $n = strpos($wp->query_vars['wpi-api'],'/');
            if(!empty($n)){
                $qs = explode('/',$wp->query_vars['wpi-api']);
                $api = $qs[0];
                $method = $qs[1];
                if(file_exists(WPI_DIR.'/api/class-wpi-'.$api.".php")){
                    include_once(WPI_DIR.'/api/class-wpi-'.$api.".php");
                    $args = array_splice($qs,2,2);
                    call_user_func_array(array($api,$method),$args);
                }else{
                    $this->server->response_failure('api not found !');
                }
            }else{
                $api = $wp->query_vars['wpi-api'];
                if(file_exists(WPI_DIR.'/api/class-wpi-'.$api.'.php')){
                    include_once(WPI_DIR.'/api/class-wpi-'.$api.'.php');
                }else{
                    $this->server->response_failure('api not found !');
                }
            }
            WPI_Log::get_instance()->close();
            die();
        }
    }
}
?>