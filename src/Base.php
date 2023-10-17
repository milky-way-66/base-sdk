<?php

namespace MilkyWay\BaseSdk;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use stdClass;

class Base
{

    private Client $client;

    private string $clientId;
    private string $clientSecret;
    private string $refreshToken;
    private string $accessToken;

    const BASE_URI = "https://api.thebase.in/1/";

    public function setAuth(string $clientId, string $clientSecret, string $refreshToken): self
    {

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->refreshToken = $refreshToken;
        return $this;
    }

    public function setAccessToken(string $accessToken) : Base{
        $this->accessToken = $accessToken;
        return $this;
    }

    public function refreshToken(): void
    {
        $params = [
            "grant_type" => "refresh_token",
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "refresh_token" => $this->refreshToken,
        ];

        $response = $this->client()->post(
            self::BASE_URI . 'oauth/token',
            [
                RequestOptions::QUERY => $params
            ]
        );

        $data = json_decode($response->getBody()->getContents());

        $this->accessToken = $data->access_token;
    }

    public function accessToken(): string
    {
        if (!isset($this->accessToken)) {
            $this->refreshToken();
        }
        return $this->accessToken;
    }

    public function client(): Client
    {
        if (!isset($this->client)) {
            $this->client = new Client();
        }
        return $this->client;
    }

    public function headers()
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->accessToken()
        ];
    }


    public function createItem(array $data): stdClass
    {
        $response = $this->client()->post(
            self::BASE_URI . 'items/add',
            [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::FORM_PARAMS => $data
            ]
        );

        return json_decode($response->getBody()->getContents())->item;
    }

    public function deleteItem(int $itemId): stdClass
    {
        $response = $this->client()->post(
            self::BASE_URI . 'items/delete',
            [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::FORM_PARAMS => [
                    "item_id" => $itemId
                ]
            ]
        );

        return json_decode($response->getBody()->getContents());
    }

    public function saveItemImage(int $itemId, int $number, string $url): stdClass
    {
        $response = $this->client()->post(
            self::BASE_URI . 'items/add_image',
            [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::FORM_PARAMS => [
                    "item_id" => $itemId,
                    "image_no" => $number,
                    "image_url" => $url
                ]
            ]
        );

        return json_decode($response->getBody()->getContents())->item;
    }
    
    public function delereItemImage(int $itemId, int $number): stdClass
    {
        $response = $this->client()->post(
            self::BASE_URI . 'items/delete_image',
            [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::FORM_PARAMS => [
                    "item_id" => $itemId,
                    "image_no" => $number,
                ]
            ]
        );

        return json_decode($response->getBody()->getContents())->item;
    }

    public function orders(string $start = null, string $end = null, int $limit = null, int $offset = null){

        $data = [
			"start_ordered" => $start,
			"end_ordered" => $end,
			"limit" => $limit,
			"offset" => $offset
		];


        $response = $this->client()->get(
            self::BASE_URI . 'orders',
            [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => $data
            ]
        );

        return json_decode($response->getBody()->getContents())->orders;
    }

    public function order(string $id){

        $response = $this->client()->get(
            self::BASE_URI . "orders/detail/$id",
            [
                RequestOptions::HEADERS => $this->headers(),
            ]
        );

        return json_decode($response->getBody()->getContents());
    }
}