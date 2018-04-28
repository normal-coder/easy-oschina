<?php
/**
 * Project: webroot
 * Author: ZhangShX <normal@normalcoder.com>:
 * Time: 2017/10/22 下午11:18
 * Discript:
 */

namespace normalcoder\EasyOSC;

require 'Cache.php';
require 'Gateways/OSChina.php';
require 'Gateways/Users.php';


class EasyOSC
{
    protected $config;

    /**
     * constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->config = $options;
        $this->access_token = $this->get_access_token();
    }


    public function get_access_token()
    {
        return "demo";
    }


    public function User()
    {
//        $res = [
//            "access_token"  => "833649c2875c  4b42f7976ebd523ccd8a",
//            "token_type"    => "bearer",
//            "expires_in"    => 86400,
//            "refresh_token" => "6522c3e8d341b29c705a33f2baae95ceb5f296e0acdb538eb66a59e6eff4dade",
//            "scope"         => "user_info projects pull_requests issues notes keys hook groups gists",
//            "created_at"    => 1509195703
//        ];
//        var_dump($this->config);die();
        return new Users($this->config);
    }

    public function Cache()
    {
        return new Cache();
    }

}