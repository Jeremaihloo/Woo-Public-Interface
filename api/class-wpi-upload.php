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
        WPI_Log::get_instance()->log('wpi api upload image from url : '.json_encode($url));

        $server_now = new WPI_Server();

        if(isset($_POST['image_url'])){
            $url = $_POST['image_url'];
        }else{
            if(empty($url)){
                $server_now->response_failure('empty $url');
            }
        }
        $dir = wp_upload_dir();
        $file_name = get_url_file_name($url);

        $save_to = $dir['path'].'/'.$file_name;
        if(file_exists($save_to)) {
            $server_now->response_failure('file has exist !');
        }else{
            download_remote_file_with_curl($url,$save_to);
            $server_now->response_success('file saved !');
        }
    }

    public static function image(){

        WPI_Log::get_instance()->log('wpi api upload image : '.json_encode($_FILES));
        $server_now = new WPI_Server();

        $dir = wp_upload_dir();
        $img_types = array('image/gif','image/pjpeg','image/jpeg','image/png');

        if(!in_array($_FILES['img']['type'],$img_types)){
            $server_now->response_failure('type not allowed ');
        }else{
            $save_to = $dir['path'].'/'.$_FILES['img']['name'];
            if(file_exists($save_to)){
                $server_now->response_failure('file has exist !');
            }else{
                $result = move_uploaded_file($_FILES['img']['tmp_name'],$save_to);
                $server_now->response_success_with_data('image uploaded !','"'.$dir['url'].'/'.$_FILES['img']['name'].'"');
            }
        }
    }
}