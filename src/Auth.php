<?php

namespace MilkyWay\BaseSdk;
use MilkyWay\BaseSdk\Enums\GrantType;

class Auth
{
	protected string $accessToken;
	protected string $refreshToken;
	protected string $clientId;
	protected string $clientSecret;

	public function __construct(string $clientId, string $clientSecret, string $refreshToken)
	{
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->refreshToken = $refreshToken;
	}


	public function endpoint() :string {
		return Constant::uri . "/1/oauth/token";
	}

	/**
	 * @return string access token
	 */
	public function accessToken(): string
	{
		if (!$this->accessToken) {
			$this->refreshToken();
		}
		return $this->accessToken;
	}

	private function refreshToken()
	{
		$data = [
			"grant_type" => GrantType::RefreshToken,
			"client_id" => $this->clientId,
			"client_secret" => $this->clientSecret,
			"refresh_token "=> $this->refreshToken
		];

		$response = Curl::new($this->endpoint())->query($data)->exec();

		//TODO: handle Error
		$this->accessToken = $response['access_token'];
	}

}