<?php

namespace App\Helpers;
use Firebase\JWT\JWT;

class Token 
{
    private $key;
    private $data;
    private $algorithm;

    public function __construct($data = null) 
    {
        $this->key = 'fd65/5sd(4f54dsf4dsfds%&';
        $this->data = $data;
        $this->algorithm = array('HS256');
    }

    public function encode() 
    {
        return JWT::encode($this->data, $this->key);
    }

    public function decode($token)
    {
       return JWT::decode($token, $this->key, $this->algorithm);
    }
}