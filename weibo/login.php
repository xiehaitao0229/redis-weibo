<?php
include 'lib.php';
include 'header.php';

/*
 * 登录页面
 * 0:接收表单数据,判断合法性
 * 1:查询用户名是否存在
 * 2:查询密码是否匹配
 * 3:登录成功
 4:设置cookie
 * */

if(isLogin()!=false){
    header('location:home.php');
    exit;
}

$username = P('username');
$password = P('password');

if(!$username || !$password){
    error('请输入用户信息');
}

$redis = connredis();
$userid = $redis->get('user:username:'.$username.':userid');
if(!$userid){
    error('填写的用户不存在');
}

$psw = $redis->get('user:userid:'.$userid.':password');

if($psw!==$password){
    error('密码错误!');
}

//  设置cookie，登录成功
setcookie('username',$username);
setcookie('userid',$userid);

header('location:home.php');


include 'footer.php';

?>