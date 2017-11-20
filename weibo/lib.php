<?php
/*
 * 基础函数库
 * */

function P($key){
    return $_POST[$key];
}

function G($key){
    return $_GET[$key];
}

//  报错函数
function error($msg){
    echo "<div>";
    echo $msg;
    echo "</div>";
    include ('./footer.php');
    exit;
}

//  连接redis
function connredis(){
    static $redis = null;
    $redis = new Redis();
    $redis->connect('127.0.0.1',6379);
    if($redis!==null){
        return $redis;
    }
}

//  判断用户是否登录
function isLogin(){
    if(!$_COOKIE['userid'] || !$_COOKIE['username']){
        return false;
    }
    return array('userid'=>$_COOKIE['userid'],'username'=>$_COOKIE['username']);
}