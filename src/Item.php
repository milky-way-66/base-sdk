<?php

namespace MilkyWay\BaseSdk;

use MilkyWay\BaseSdk\Enums\HttpMethod;
use MilkyWay\BaseSdk\Exceptions\ValidateException;

class Item extends Model
{
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }


    public function endpoint(): string
    {
        return "/1/items";
    }

    public function identify(){
        return [
            "item_id" => $this->entity['item_id']
        ];
    }

    public final array $feilds = [
        "title",
        "detail",
        "price",
        "stock",
        "item_tax_type",
        "visible",
        "identifier",
        "list_order",
        "variation",
        "variation_stock",
        "variation_identifier",
        "barcode",
    ];


    public function feilds()
    {
        return $this->feilds;
    }

    public function validate()
    {
        //TODO validate
    }

    public function image(int $number, string $url)
    {

        $this->validateImageData($number, $url);

        $data = [
            "item_id" => $this->entity["item_id"],
            "image_no" => $number,
            "image_url" => $url
        ];

        $response = Curl::new(Constant::uri . $this->endpoint() . "add_image")
            ->method(HttpMethod::Post)
            ->bearerAuth($this->auth->accessToken())
            ->body($data)
            ->exec();

        return json_decode($response);
    }

    public function deleteImage(int $number){
        $data = [
            "item_id" => $this->entity["item_id"],
            "image_no" => $number,
        ];

        $response = Curl::new(Constant::uri . $this->endpoint() . "delete_image")
            ->method(HttpMethod::Post)
            ->bearerAuth($this->auth->accessToken())
            ->body($data)
            ->exec();

        return json_decode($response);
    }

    const MIN_IMAGE_NUMBER = 1;
    const MAX_IMAGE_NUMBER = 20;
    public function validateImageData(int $number, string $url)
    {

        if ($number < self::MIN_IMAGE_NUMBER || $number > self::MAX_IMAGE_NUMBER) {
            throw new ValidateException("Invalid Image Number");
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new ValidateException("Invalid Image Url");
        }
    }
}