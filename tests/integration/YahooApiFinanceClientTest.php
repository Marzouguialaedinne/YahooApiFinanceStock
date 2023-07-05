<?php

namespace App\Tests\integration;

use App\Tests\DependentDatabase;

class YahooApiFinanceClientTest extends DependentDatabase
{
	public function testItYahooApiFinanceClientGetCorreclyValue(): void
	{
		$yahooApiFinanceClient = static::$kernel->getContainer()->get('yahoo-api-finance-client');
		$response = $yahooApiFinanceClient->fetchProfile('AMZN', 'US');

		$stockProfile = json_decode($response->getContent());

		// make assertions
		$this->assertEquals('AMZN', $stockProfile->symbol);
		$this->assertEquals('Amazon.com, Inc.', $stockProfile->shortName);
		$this->assertEquals('NasdaqGS', $stockProfile->exchangeName);
		$this->assertEquals('US', $stockProfile->region);
		$this->assertEquals('USD', $stockProfile->currency);
		$this->assertIsFloat($stockProfile->price);
		$this->assertIsFloat($stockProfile->pricePreviousClose);
		$this->assertIsFloat($stockProfile->priceChange);
	}

}