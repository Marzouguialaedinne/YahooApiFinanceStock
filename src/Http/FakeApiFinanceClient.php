<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class FakeApiFinanceClient implements FinanceApiInterface
{
	public static $statusCode = 200;
	public static $content = '';


	public static function setContent(array $data): void
	{
		self::$content = json_encode(array_merge([
			'symbol' => 'AMZN',
			'region' => 'US',
			'currency' => 'USD',
			'shortName' => 'Amazon.com, Inc.',
			'exchangeName' => 'NasdaqGS',
			'price'    => 130.36,
			'pricePreviousClose' => 127.9,
			'priceChange'    => 2.46,
		], $data));
	}

	public function fetchProfile(string $symbol, string $region = 'US'): JsonResponse
	{
		return new JsonResponse(self::$content, self::$statusCode, [], json: true);
	}
}