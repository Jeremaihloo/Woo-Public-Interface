<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-17
 * Time: 下午1:30
 */

/**********重写规则************/
function rewrite_rules( $wp_rewrite ){
    $new_rules = array(
        'wpi-api\/v'.WPI::VERSION.'/?$' => 'index.php?wpi-api=doc',
        'wpi-api\/v'.WPI::VERSION.'\/auth\/check/?$' => 'index.php?wpi-api=auth',
    ); //添加翻译规则
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    //php数组相加
}
add_action('generate_rewrite_rules', 'rewrite_rules' );

/*******添加query_var变量***************/
function wpi_add_query_vars($query_vars){
    $query_vars[] = 'wpi-api'; //往数组中添加添加my_custom_page
    return $query_vars;
}
add_action('query_vars', 'wpi_add_query_vars');
add_filter('query_vars', 'wpi_add_query_vars');

/***************激活主题更新重写规则***********************/
function wpi_flush_rewrite_rules() {
    global $wp_rewrite;
    $wp_rewrite = new WP_Rewrite();
    $wp_rewrite->flush_rules();
}