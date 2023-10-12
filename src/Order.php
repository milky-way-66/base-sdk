<?php

namespace MilkyWay\BaseSdk;

use MilkyWay\BaseSdk\Traits\AuthTrait;

class Order
{
    use AuthTrait;

    public function endpoint(): string
    {
        return "/1/orders";
    }

    public final array $feilds = [
        "start_ordered",
        "end_ordered",
        "limit",
        "offset",
    ];

    public static function new(): self
    {
        return new self();
    }

    public function list(array $data)
    {
        $response = Curl::new(Constant::uri . $this->endpoint())
            ->query($data)
            ->bearerAuth($this->auth->accessToken())
            ->method(HttpMethod::Get)
            ->exec();

        return json_decode($response);
    }

    public function detail(string $id){
        $response = Curl::new(Constant::uri . $this->endpoint() . "/detail/$id")
        ->bearerAuth($this->auth->accessToken())
        ->method(HttpMethod::Get)
        ->exec();
    
        return json_decode($response);
    }
}