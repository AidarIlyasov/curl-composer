<?php

class Curl
{
    
    private $ch = null;
    private $response = null;

    public function __construct($url)
    {
        $this->ch = curl_init($url);
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36');
    }

    public function withMethod($method)
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        return $this;
    }

    public function payload($params)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE));
        return $this;
    }

    public function setOption($name, $value)
    {
        curl_setopt($this->ch, $name, $value);
        return $this;
    }

    public function headers($headers = [])
    {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    public function getJson()
    {
        $this->response = curl_exec($this->ch);
        return json_decode($this->response, true);
    }

    private function getXML()
    {
        $this->response = curl_exec($this->ch);
        $data = json_encode(simplexml_load_string($this->response));
        return json_decode($data, true);
    }

    public function run()
    {
        $this->response = curl_exec($this->ch);
        return $this->response;
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}