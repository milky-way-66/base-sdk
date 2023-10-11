<?php

namespace MilkyWay\BaseSdk;
use MilkyWay\BaseSdk\Interfaces\Model as ModelInterface;
use MilkyWay\BaseSdk\Traits\AuthTrait;
use MilkyWay\BaseSdk\Traits\FilllDataTrait;

abstract class Model implements ModelInterface
{	
    use AuthTrait, FilllDataTrait;	

    protected array $entity;

    public function __construct(array $data = [])
	{
        $this->fill($data);
	}

    public function save()
	{
		$this->validate();

		$response = Curl::new(Constant::uri .  $this->endpoint() . "/add")
			->bearerAuth($this->auth->accessToken())
			->method(HttpMethod::Post)
			->body($this->data())
			->exec();
		$this->entity =	json_decode($response);
		return $this->entity;
	}
}