<?php

namespace MilkyWay\BaseSdk;

use MilkyWay\BaseSdk\Enums\HttpMethod;
use MilkyWay\BaseSdk\Interfaces\Model;

class Base
{
	protected string $refreshToken;
	protected string $clientId;
	protected string $clientSecret;

	protected Auth $auth;

	public function __construct(string $clientId, string $clientSecret, string $refreshToken)
	{
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->refreshToken = $refreshToken;

		$this->initAuth();
	}

	/**
	 * @return self new Base instance
	 */
	public static function new(string $clientId, string $clientSecret, string $refreshToken): self
	{
		return new Base(
			clientId: $clientId,
			clientSecret: $clientSecret,
			refreshToken: $refreshToken
		);
	}

	public function initAuth()
	{
		$this->auth = new Auth(
			clientId: $this->clientId,
			clientSecret: $this->clientSecret,
			refreshToken: $this->refreshToken
		);
	}

	public function saveItem(array $data)
	{
		$item = new Item($data);
		$item->validate();

		$item->auth($this->auth)
			->save();
	}
}