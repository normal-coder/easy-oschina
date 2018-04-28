<?php

/**
 * Project: webroot
 * Author: ZhangShX <normal@normalcoder.com>:
 * Time: 2017/10/23 上午2:59
 * Discript:
 */

namespace normalcoder\EasyGitee;

class Cache
{
    private $cacheDir;

    public function __construct()
    {
        $this->cacheDir = './Caches/';
    }

    public function get($filename)
    {
        $data = unserialize(file_get_contents($this->cacheDir . $filename));
        return $data;
    }


    public function set($filename, $data)
    {
        $file = fopen($this->cacheDir . $filename, "w") or die("Unable to open file!");
        $data = serialize($data);
        fwrite($file, $data);
        fclose($file);
    }
}