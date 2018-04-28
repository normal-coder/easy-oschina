<?php
/**
 * Project: webroot
 * Author: ZhangShX <normal@normalcoder.com>:
 * Time: 2017/10/22 下午11:18
 * Discript:
 */

namespace normalcoder\EasyOSC;

class OSChina
{

    protected $url;
    protected $api_path;
    protected $client_id;
    protected $client_secret;
    protected $access_token;
    protected $refresh_token;
    protected $code;
    protected $redirect_uri;
    protected $error;
    protected $debug;


    /**
     * constructor.
     * @param $options
     */
    public function __construct($options)
    {
//        var_dump($options);die();
//        $this[] = [
//            url           => isset($options['url']) ? $options['url'] : '',
//            api_path      => isset($options['api_path']) ? $options['api_path'] : '',
//            client_id     => isset($options['client_id']) ? $options['client_id'] : '',
//            client_secret => isset($options['client_secret']) ? $options['client_secret'] : '',
//            redirect_uri  => isset($options['redirect_uri']) ? $options['redirect_uri'] : '',
//            code          => isset($options['code']) ? $options['code'] : '',
//            debug         => isset($options['debug']) ? $options['debug'] : false,
//        ];
        $this->url = isset($options['url']) ? $options['url'] : '';
        $this->api_path = isset($options['api_path']) ? $options['api_path'] : '';
        $this->client_id = isset($options['client_id']) ? $options['client_id'] : '';
        $this->client_secret = isset($options['client_secret']) ? $options['client_secret'] : '';
        $this->redirect_uri = isset($options['redirect_uri']) ? $options['redirect_uri'] : '';
        $this->code = isset($options['code']) ? $options['code'] : '';
        $this->debug = isset($options['debug']) ? $options['debug'] : false;
    }


    /**
     * 网络请求
     * @param      $uri
     * @param      $queryType
     * @param null $data
     * @return bool|string
     */
    protected function httppost($uri, $queryType, $data = null)
    {
        //var_dump($this);die();
        $curl = curl_init(); //请求开始
        curl_setopt_array($curl, [
            CURLOPT_URL            => $this->url . $uri,
            CURLOPT_CUSTOMREQUEST  => $queryType,
            CURLOPT_RETURNTRANSFER => true,  //将curl_exec()获取的信息以字符串返回，而不是直接输出。
            CURLOPT_HEADER         => true,  //需要response header 头部信息
            CURLOPT_NOBODY         => false, //需要response body
            CURLINFO_HEADER_OUT    => true,  //允许查看请求header
            //CURLOPT_ENCODING       => "",
            //CURLOPT_MAXREDIRS      => 10,
            //CURLOPT_TIMEOUT        => 30,
            //CURLOPT_HTTP_VERSION   => 'CURL_HTTP_VERSION_1_1',
            //CURLOPT_USERAGENT      => [],// 设置 USER_AGENT
            //CURLOPT_HTTPHEADER     => [], //设置请求头
        ]);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        $curl_response = curl_exec($curl); //响应消息体
        $curl_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); // 获取HTTP响应状态码
        $curl_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE); // 获得响应头大小
        $curl_header = substr($curl_response, 0, $curl_header_size); // 获取头信息内容
        $curl_body = substr($curl_response, $curl_header_size);
        
//        var_dump($curl_response);die();
        if (false === $curl_response) { // CURL异常错误
            $curl_error = curl_error($curl);
            if ($this->debug) { // 调试模式判断
                die("CURL_Error:" . "<br><pre>" . $curl_header . "</pre><br>");
            } else {
                $this->error = ['message' => $curl_error];
                return false;
            }
        }
        curl_close($curl);
        if ($this->debug) { //调试模式
            //响应头输出
            $curl_header_array = explode("\n", $curl_header);
            $curl_header_array_max = count($curl_header_array);
            for ($i = 0; $i < $curl_header_array_max; $i++) {
                if (!empty(trim($curl_header_array[$i]))) { //去除空行
                    $res_child = explode(':', $curl_header_array[$i]);
                    if ($i == 0) {
                        $response['General'] = $curl_header_array[$i];
                    } else {
                        $response[$res_child[0]] = trim($res_child[1]);
                    }
                }
            }
            $this->console_debug('CURL_Header', json_encode($response, JSON_UNESCAPED_UNICODE));
            //响应消息体输出
            $curl_body = trim($curl_body);
            if (empty(json_decode($curl_body)) && strlen($curl_body) !== 0) {
                echo $curl_body;
            } else {
                $this->console_debug('CURL_Response', $curl_body);
            }
        }
        $curl_response_code_type = substr($curl_response_code, 0, 1);
        switch (strval($curl_response_code_type)) { //根据HTTP响应状态码决定返回信息方式
            case '1': //消息
                //100 Continue
                //101 Switching Protocols
                //102 Processing
                break;
            case '2': //成功
                //200 OK
                //201 Created
                //202 Accepted
                //203 Non-Authoritative Information
                //204 No Content
                //205 Reset Content
                //206 Partial Content
                //207 Multi-Status
                return json_decode($curl_body, true);
                break;
            case '3': //重定向
                //300 Multiple Choices
                //301 Moved Permanently
                //302 Move temporarily
                //303 See Other
                //304 Not Modified
                //305 Use Proxy
                //306 Switch Proxy
                //307 Temporary Redirect
                break;
            case '4': //请求错误
                //400 Bad Request
                //401 Unauthorized
                //402 Payment Required
                //403 Forbidden
                //404 Not Found
                //405 Method Not Allowed
                //406 Not Acceptable
                //407 Proxy Authentication Required
                //408 Request Timeout
                //409 Conflict
                //410 Gone
                //411 Length Required
                //412 Precondition Failed
                //413 Request Entity Too Large
                //414 Request-URI Too Long
                //415 Unsupported Media Type
                //416 Requested Range Not Satisfiable
                //417 Expectation Failed
                //421 too many connections
                //422 Unprocessable Entity
                //423 Locked
                //424 Failed Dependency
                //425 Unordered Collection
                //426 Upgrade Required
                //449 Retry With
                //451 Unavailable For Legal Reasons
                $result = json_decode($curl_response, true);
                $this->error = [
                    'code'    => $curl_response_code,
                    'message' => $result['message']
                ];
                return false;
                break;
            case '5': //服务器错误

                //500 Internal Server Error
                //501 Not Implemented
                //502 Bad Gateway
                //503 Service Unavailable
                //504 Gateway Timeout
                //505 HTTP Version Not Supported
                //506 Variant Also Negotiates
                //507 Insufficient Storage
                //509 Bandwidth Limit Exceeded
                //510 Not Extended
                $this->error = [
                    'code'    => $curl_response_code,
                    'message' => "系统异常"
                ];
                return false;
                break;
            case '6': //服务器错误
                //600 Unparseable Response Headers
                $this->error = [
                    'code'    => $curl_response_code,
                    'message' => "系统异常"
                ];
                return false;
                break;
        }
        // TODO 处理异常情况
    }

    private function console_debug($groupName, $jsondata)
    {
        $console_script = "<script>" . "console.group('" . $groupName . "');";
        $console_script .= "var console_script" . time() . "= ";
        $console_script .= "[" . $jsondata . "];";
        $console_script .= "console.table(console_script" . time() . "[0]);";
        $console_script .= "console.groupEnd();";
        $console_script .= "</script>";
        echo $console_script;
    }

    /**
     * 错误信息获取
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function get_code()
    {
        $uri = 'https://gitee.com/oauth/authorize?' . 'client_id=' . $this->client_id . '&redirect_uri=' . $this->redirect_uri . '&response_type=' . 'code';
        header('Location:' . $uri);
    }


    public function get_access_token($code)
    {
        $data = [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => $this->client_id,
            'redirect_uri'  => $this->redirect_uri,
            'client_secret' => $this->client_secret,
        ];

        return $this->httppost('/oauth/token', 'POST', $data);
        //header('Location:' . $uri);
    }


//https://gitee.com/oauth/token?grant_type=authorization_code&code={code}&client_id={client_id}&redirect_uri={redirect_uri}&client_secret={client_secret}
//92175f0b694a2f010f9a122f8872af621e52fd96b2f66a1c1c78b9af07edb0cd

    public function get_access_token_via_password($email, $password)
    {
        $data = [
            'grant_type'    => 'password',
            'username'      => $email,
            'password'      => $password,
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'scope'         => 'user_info projects pull_requests issues notes keys hook groups gists',
        ];
        return $this->httppost('/oauth/token', 'POST', $data);
    }

    public function refresh_token()
    {
        $data = [
            'grant_type'    => 'refresh_token',
            'refresh_token' => '5535d1292f9e385d7a55b5d91dafee9a82e64eff61fca8298eb440a6f2bb9c08',
            //'scope'         => 'user_info projects pull_requests issues notes keys hook groups gists',
        ];
        return $this->httppost('/oauth/token', 'POST', $data);
    }





    //下午5：07
//        /Users/normal/webroot/gitee/Gateways/Gitee.php:246:
//        array (size=6)
//          'access_token' => string '6dd1f3d7aebacf472e0d74b337886c38' (length=32)
//          'token_type' => string 'bearer' (length=6)
//          'expires_in' => int 86400
//          'refresh_token' => string '01f5a0fad06a0b899ab6437c1e48e48cf038fc835697c5e4135e10c437311b83' (length=64)
//          'scope' => string 'user_info projects pull_requests issues notes keys hook groups gists' (length=68)
//            'created_at' => int 1509699979
}