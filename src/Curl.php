<?php

namespace MilkyWay\BaseSdk;

use CurlHandle;
use MilkyWay\BaseSdk\Enums\HttpMethod;

class Curl
{

    private $url;
    protected CurlHandle $curl;

    public function __construct($url = Constant::uri)
    {
        $this->url = $url;
        $this->curl = curl_init($url);
        $this->setDefaultOtp();
    }

    public static function new(string $url = Constant::uri): Curl
    {
        return new Curl($url);
    }

    private function setDefaultOtp()
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * @return self
     */
    public function bearerAuth(string $accessToken): self
    {

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);

        return $this;
    }

    public function query(array $data): Curl
    {
        $url = $this->url . "?" . http_build_query($data);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        return $this;
    }

    public function body(array $data): self
    {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
        return $this;
    }

    public function method(HttpMethod $method = HttpMethod::Get): self
    {

        match ($method) {
            HttpMethod::Get => curl_setopt($this->curl, CURLOPT_HTTPGET, true),
            HttpMethod::Post => curl_setopt($this->curl, CURLOPT_POST, true),
            HttpMethod::Put => curl_setopt($this->curl, CURLOPT_PUT, true),
            HttpMethod::Patch => curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PATCH"),
            HttpMethod::Delete => curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE")
        };

        return $this;
    }

    public function exec(){
        $response = curl_exec($this->curl);
        curl_close($this->curl);

        return json_decode($response);
    }

}