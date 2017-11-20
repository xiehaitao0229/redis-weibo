<?php
/*
 * 具体步骤：
 * 0：接收post参数，判断用户名/密码是否完整
 * 1：链接redis,查询该用户名，判断是否存在
 * 2：不存在，写入redis
 * 3:完成登录操作
 * */

//  userid生成
// incr global:userid

include('header.php');
include './lib.php';

$username = P('username');
$password = P('password');
$password2 = P('password2');

if (!$username || !$password || !$password2) {
    error('请输入完整注册信息');
}

//  判断密码是否一致
if ($password !== $password2) {
    error('2次输入密码不匹配');
}

$redis = connredis();

//  查询用户名是否已被注册

if ($redis->get('user:username:' . $username . ':userid')) {
    error('用户名已被注册，请更换');
}

//  获取userid
$userid = $redis->incr('global:userid');

//  写入用户注册信息到redis中
$redis->set('user:userid:' . $userid . ':username' , $username);
$redis->set('user:userid:' . $userid . ':password' , $password);
$redis->set('user:username:' . $username . ':userid' ,$userid);


include "footer.php";
?>