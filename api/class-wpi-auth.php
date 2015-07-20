<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-16
 * Time: 下午12:40
 */
class Authentication{
    public function __construct(){

    }
    public function auth($uname,$pwd){
        return false;
    }
}
$A = new Authentication();
if(isset($_POST['uname'])&&isset($_POST['pwd'])){
    if($A->auth($_POST['uname'],$_POST['pwd'])){
        echo "{msg:'success'}";
    }
}
