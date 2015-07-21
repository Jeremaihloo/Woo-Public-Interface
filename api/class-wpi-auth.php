<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-16
 * Time: 下午12:40
 */
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
            require_once ABSPATH . WPINC . '/class-phpass.php';
            $wp_hasher = new PasswordHash( 8, true );
            $hashed = $wp_hasher->HashPassword($pwd);
            if($wp_hasher->CheckPassword($uname,$hashed)){
                $server_now->response_success('login success !');
            }else{
                $server_now->response_failure('login failure ! please check your uname and pwd !');
            }
        }else{
            $server_now->response_failure('login failure ! please check your uname and pwd !');
        }
    }
}
