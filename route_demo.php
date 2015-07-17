<?php
/**
 * Created by PhpStorm.
 * User: lujiejie
 * Date: 15-7-17
 * Time: 下午1:20
 */

/**********重写规则************/
function rewrite_rules( $wp_rewrite ){
    $new_rules = array(
        'my-account/?$' => 'index.php?my_custom_page=hello_page',
    ); //添加翻译规则
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    //php数组相加
}
add_action('generate_rewrite_rules', 'rewrite_rules' );

/*******添加query_var变量***************/
function add_query_vars($query_vars){
    $query_vars[] = 'my_custom_page'; //往数组中添加添加my_custom_page

    return $query_vars;
}
add_action('query_vars', 'add_query_vars');

//模板载入规则
//function template_redirect(){
//    global $wp;
//    global $wp_query, $wp_rewrite;
//
//    //查询my_custom_page变量
//    $reditect_page =  $wp_query->query_vars['my_custom_page'];
//    //如果my_custom_page等于hello_page，则载入user/helloashu.php页面
//    //注意 my-account/被翻译成index.php?my_custom_page=hello_page了。
//    if ($reditect_page == "hello_page"){
//        include(TEMPLATEPATH.'/user/helloashu.php');
//        die();
//    }
//}
//add_action("template_redirect", 'template_redirect');

/***************激活主题更新重写规则***********************/
function flush_rewrite_rules() {
//    global $pagenow;
    global $wp_rewrite;
//    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        $wp_rewrite->flush_rules();
}
//add_action( 'load-themes.php', 'frosty_flush_rewrite_rules' );
