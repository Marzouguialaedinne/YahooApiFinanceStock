<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YahooApiFinanceClient implements FinanceApiInterface
{
	const URL = 'https://apidojo-yahoo-finance-v1.p.rapidapi.com/stock/v2/get-profile';
	const X_API_Host = 'apidojo-yahoo-finance-v1.p.rapidapi.com';
	public function __construct(
		public HttpClientInterface $httpClient,
		public $rapidApiKey
	)
	{
	}

	public function fetchProfile(string $symbol, string $region = 'US'): JsonResponse
	{
		$response = $this->httpClient->request('GET', self::URL, [
			'query' => [
				'symbol' => $symbol,
				'region' => $region
			],
			'headers' => [
				'X-RapidAPI-Key' => $this->rapidApiKey,
				'X-RapidAPI-Host' => self::X_API_Host
			]
		]);

		if($response->getStatusCode() !== 200) {
			throw new \Exception('Failed to Connect Finance Api !', $response->getStatusCode());
		}

		$stockProfile = json_decode($response->getContent())->price;

		$stockAsArray = [
			'symbol'             => $symbol,
			'region'             => $region,
			'currency'           => $stockProfile->currency,
			'shortName'          => $stockProfile->shortName,
			'exchangeName'       => $stockProfile->exchangeName,
			'price'              => $stockProfile->regularMarketPrice->raw,
			'pricePreviousClose' => $stockProfile->regularMarketPreviousClose->raw,
			'priceChange'        =>  $stockProfile->regularMarketPrice->raw - $stockProfile->regularMarketPreviousClose->raw
		];

		return new JsonResponse($stockAsArray, $response->getStatusCode());
	}

}