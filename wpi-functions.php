<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-21
 * Time: 下午1:48
 */
function download_remote_file_with_curl($file_url, $save_to)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch,CURLOPT_URL,$file_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $file_content = curl_exec($ch);
    curl_close($ch);

    $downloaded_file = fopen($save_to, 'w');
    fwrite($downloaded_file, $file_content);
    fclose($downloaded_file);

}
function get_file_extension($file){
    pathinfo($file, PATHINFO_EXTENSION);
}

function get_file_name($file){
    pathinfo($file,PATHINFO_FILENAME);
}

function get_url_file_name($url){
    $arr = explode('/',$url);
    $len = count($arr);
    $file_name = $arr[$len-1];
    return $file_name;
}