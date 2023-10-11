<?php

namespace MilkyWay\BaseSdk;

use MilkyWay\BaseSdk\Enums\HttpMethod;
use MilkyWay\BaseSdk\Exceptions\ValidateException;
use MilkyWay\BaseSdk\Traits\AuthTrait;

class Item
{
    use AuthTrait;

    protected array $entity;

    public static function new(): self
    {
        return new Item();
    }

    public function endpoint(): string
    {
        return "/1/items";
    }

    public final array $feilds = [
        "item_id",
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

    public function fill(array $data): self
    {
        $result = [];
        foreach ($this->feilds as $feild) {
            if (array_key_exists($feild, $data)) {
                $result[$feild] = $data;
            }
        }

        $this->entity = $result;
        return $this;
    }

    public function save()
    {
        $this->validate();

        $response = Curl::new(Constant::uri . $this->endpoint() . "/add")
            ->bearerAuth($this->auth->accessToken())
            ->method(HttpMethod::Post)
            ->body($this->entity)
            ->exec();

        $this->fill(json_decode($response));
        return $this->entity;
    }

    public function delete()
    {

        $response = Curl::new(Constant::uri . $this->endpoint() . "/delete")
            ->bearerAuth($this->auth->accessToken())
            ->method(HttpMethod::Post)
            ->body([
                "item_id" => $this->entity['item_id']
            ])
            ->exec();

        return json_decode($response);
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

    public function deleteImage(int $number)
    {
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