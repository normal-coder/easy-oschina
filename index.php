<?php
/**
 * Project: webroot
 * Author: ZhangShX <normal@normalcoder.com>:
 * Time: 2017/10/22 下午11:15
 * Discript:
 */
//开启php.ini中的display_errors指令
ini_set('display_errors', 1);
//通过error_reporting()函数设置，输出所有级别的错误报告
error_reporting(E_ALL);

require 'EasyGitee.php';
//require 'Users.php';
//get_access_token
//https://gitee.com/oauth/token?grant_type=authorization_code&code={code}&client_id={client_id}&redirect_uri={redirect_uri}&client_secret={client_secret}

//Code有时间限制
$config = [
    'url'           => 'https://gitee.com',
    'api_path'      => '/api/v5',
    'client_id'     => '6e478098f4e335d3d0032fe0674c12de5408d73f499efd2536751901e34de663',
    'client_secret' => 'c5e98625c1d58668b17d7bde7b80c5a21b310e93b4bdaca143e07427367ec3ea',
    'redirect_uri'  => 'http://git.tingin.cn/',
    'code'          => 'f6d9f11bdc4fd724a1bbf3bbacfe04b07c8f8320e2acf8dec370cc3e8a1b5d3f',
    'debug'         => true,
];

$gitee = new \normalcoder\EasyGitee\EasyGitee($config);

$res = $gitee->access_token;
var_dump($res);
die();
//$res = $gitee->refresh_token();
//$res = $gitee->get_access_token_via_password("normal@normalcoder.com","78109661119");
//var_dump($res);
//$res = [
//    "access_token"  => "833649c2875c4b42f7976ebd523ccd8a",
//    "token_type"    => "bearer",
//    "expires_in"    => 86400,
//    "refresh_token" => "6522c3e8d341b29c705a33f2baae95ceb5f296e0acdb538eb66a59e6eff4dade",
//    "scope"         => "user_info projects pull_requests issues notes keys hook groups gists",
//    "created_at"    => 1509195703
//];
//var_dump($res);
//$cacheres = $gitee->Cache()->set("normal@normalcoder.com",$res);
//var_dump($cacheres);
//
//$cache = $gitee->Cache()->get("normal@normalcoder.com");
//var_dump($cache);
$user = $gitee->User();
var_dump($user);

//$user->get_code();

//$access_token = $user->get_access_token('34b6a5741d23827653d1e97dcc47f5e4931ec1f24d7f1775e5a5b2e960320702');
//var_dump($access_token);
die();
//$res = $user->getEmail();
//$res = $user->demo();
//var_dump($res);
//if ($res) {
//    var_dump($res);
//} else {
//    var_dump($user->getError());
//}

