<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-21
 * Time: 上午11:20
 */
if(!defined("ABSPATH")) exit;

include_once(ABSPATH.'wp-includes/functions.php');

class upload{

    public static function image_from_url($url){
        if(isset($_POST['image_url'])){
            $url = $_POST['image_url'];
        }
        $dir = wp_upload_dir();
        $file_name = get_url_file_name($url);

        $server_now = new WPI_Server();
        $save_to = $dir['path'].'/'.$file_name;
        if(file_exists($save_to)) {
            $server_now->response_failure('file has exist !');
        }else{
            download_remote_file_with_curl($url,$save_to);
            $server_now->response_success('file saved !');
        }
    }
}