<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-20
 * Time: 下午1:37
 */
if(!defined("ABSPATH")) exit;


class WPI_Server{

    const SERVER_SUCCESS_TPL = '{"status":"success","msg":"%s","code":1}';
    const SERVER_FAILUER_TPL = '{"status":"failure","msg":"%s","code":0}';

    private $status_code = 200;
    public function __construct(){
        $this->contentType();
    }
    public function status($code){
        $this->status_code = $code;
        header('HTTP/1.1 '.$this->status_code);
    }
    public function response($data){
        $this->status(200);
        echo $data;
    }
    public function response_success($msg='do success !'){
        echo sprintf(self::SERVER_SUCCESS_TPL,$msg);
        $this->status(200);
    }
    public function response_failure($msg='do failure'){
        echo sprintf(self::SERVER_FAILUER_TPL,$msg);
        $this->status(404);
    }
    public function contentType($content_type="application/json"){
        header('Content-type: '.$content_type);
    }
}