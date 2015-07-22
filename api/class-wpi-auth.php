<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-16
 * Time: 下午12:40
 */
if(!defined("ABSPATH")) exit;

class auth{
    private $server;

    public function __construct(){
        $this->server = new WPI_Server();
    }
    public static function check($uname,$pwd){
        $server_now = new WPI_Server();
        if(isset($_POST['uname'])){
            $uname = $_POST['uname'];
        }
        if(isset($_POST['pwd'])){
            $pwd = $_POST['pwd'];
        }
        if(!empty($uname)&&!empty($pwd)){

//            require_once ABSPATH . WPINC . '/class-phpass.php';
//            $wp_hasher = new PasswordHash( 8, true );
//            $hashed = $wp_hasher->HashPassword($pwd);
//
            $credentials = array('user_login'=>$uname,'user_password'=>$pwd);
            $user = wp_signon($credentials);

            if(!is_wp_error($user)){
                include_once(ABSPATH.'wp-blog-header.php');
                global $wpdb;
                include_once(ABSPATH.'wp-config.php');
                $table_prefix = preg_replace('/[0-9](.+?)*/','',$wpdb->prefix);

                $sql_id = sprintf("SELECT ID FROM %susers WHERE user_login='%s'",$table_prefix,$uname);
                $result_id = $wpdb->get_results("SELECT ID FROM ".$table_prefix."users WHERE user_login='".$uname."'");
                $sql_key = "SELECT meta_value FROM ".$table_prefix."usermeta WHERE user_id=".$result_id[0]->ID." AND meta_key='woocommerce_api_consumer_key'";
                $sql_screct = "SELECT meta_value FROM ".$table_prefix."usermeta WHERE user_id=".$result_id[0]->ID." AND meta_key='woocommerce_api_consumer_secret'";
                $result_key = $wpdb->get_results($sql_key);
                $result_screct = $wpdb->get_results($sql_screct);

                $server_now->response(sprintf('{"status":"success","msg":{"key":"%s","secret":"%s"},"code":1}',$result_key[0]->meta_value,$result_screct[0]->meta_value));
            }else{
                $server_now->response_failure('login failure ! please check your uname and pwd ! uname:'.$uname.'  pwd:'.$pwd);
            }
        }else{
            $server_now->response_failure('login failure ! please check your uname and pwd ! uname:'.$uname.'  pwd:'.$pwd);
        }
    }
}
