<?php
/**
 * Project: webroot
 * Author: ZhangShX <normal@normalcoder.com>:
 * Time: 2017/10/23 上午1:54
 * Discript:
 */

namespace normalcoder\EasyGitee;

class Users extends Gitee
{
    public function __construct($options)
    {
        parent::__construct($options);

//        $this->access_token = $this->get_access_token_via_password("normal@normalcoder.com","78109661119");
//        var_dump($this->access_token);
    }


    public function getEmail()
    {
        $method = "GET";
        $uri = $this->api_path . '/user/emails';
        //$res = $this->get_access_token_via_password("normal@normalcoder.com", "78109661119");
//        $data = array('access_token' => $res['access_token']);
        $data = array('access_token' => "6dd1f3d7aebacf472e0d74b337886c38");
        var_dump($data);
        // 20d48c9474dc0c70ba71069d18aab5b0
        $demp = $this->httppost($uri, $method, $data);
        var_dump($demp);
        die();
    }


    public function updateEmail()
    {
        $method = "GET";
        $uri = $this->api_path . '/user/emails';
        //$res = $this->get_access_token_via_password("normal@normalcoder.com", "78109661119");
//        $data = array('access_token' => $res['access_token']);
        $data = array('access_token' => "6dd1f3d7aebacf472e0d74b337886c38");
        var_dump($data);
        // 20d48c9474dc0c70ba71069d18aab5b0
        $demp = $this->httppost($uri, $method, $data);
        var_dump($demp);
//        die();
    }


    public function demotest()
    {
        $method = "POST";
//        $uri = $this->api_path . '/user/emails';
        $uri = $this->api_path . '/user/emails?access_token=6dd1f3d7aebacf472e0d74b337886c38&email=normalcoder@163.com';
        echo $uri;
//        $data = [
//            'access_token' => "6dd1f3d7aebacf472e0d74b337886c38",
//            'email'        => 'normalcoder@163.com'
//        ];
        var_dump($data);
        $demp = $this->httppost($uri, $method, $data);
        var_dump($demp);
        die();
    }


    public function demo()
    {
        $method = "GET";
        $uri = $this->api_path . '/user/subscriptions/sentsin/fly';
        $data = array('access_token' => '833649c2875c4b42f7976ebd523ccd8a');

        return $this->httppost($uri, $method, $data);
    }


}