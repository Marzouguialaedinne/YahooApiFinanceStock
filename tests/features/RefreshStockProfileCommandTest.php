<?php

namespace App\Tests\features;

use App\Entity\Stock;
use App\Http\FakeApiFinanceClient;
use App\Tests\DependentDatabase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class RefreshStockProfileCommandTest extends DependentDatabase
{
	public function testItRefreshStockCommandCreateRecordInDatabase(): void
	{
		// setup
		$application = new Application(static::$kernel);
		$command = $application->find('app:refresh-stock-profile');
		$commandTester = new CommandTester($command);

		FakeApiFinanceClient::$content = '{"symbol":"AMZN","region":"US","currency":"USD","shortName":"Amazon.com, Inc.","exchangeName":"NasdaqGS","price":130.36,"pricePreviousClose":127.9,"priceChange":2.46}';

		$commandStatus = $commandTester->execute([
			'symbol' => 'AMZN',
			'region' => 'US'
		]);

		// do something
		$recordStock = $this->entityManager
							->getRepository(Stock::class)
							->findOneBy(['symbol' => 'AMZN']);

		// make assertions
		$this->assertEquals('AMZN', $recordStock->getSymbol());
		$this->assertEquals('Amazon.com, Inc.', $recordStock->getShortName());
		$this->assertEquals('NasdaqGS', $recordStock->getExchangeName());
		$this->assertEquals('US', $recordStock->getRegion());
		$this->assertEquals('USD', $recordStock->getCurrency());
		$this->assertIsFloat($recordStock->getPrice());
		$this->assertIsFloat($recordStock->getPricePreviousClose());
		$this->assertIsFloat($recordStock->getPriceChange());
		$this->assertEquals(0, $commandStatus);
	}



	public function testItRefreshStockCommandUpdateRecordInDatabase(): void
	{
		// setup
		$application = new Application(static::$kernel);
		$command = $application->find('app:refresh-stock-profile');
		$commandTester = new CommandTester($command);

		$stock = new Stock();
		$stock->setSymbol('AMZN');
		$stock->setRegion('US');
		$stock->setShortName('Amazon.com, Inc.');
		$stock->setExchangeName('NasdaqGS');
		$stock->setCurrency('USD');
		$stock->setPrice(1000);
		$stock->setPricePreviousClose(1100);
		$stock->setPriceChange(-1000);

		$this->entityManager->persist($stock);
		$this->entityManager->flush();

		FakeApiFinanceClient::setContent([
			'price' => 2000,
			'pricePreviousClose' => 2100,
			'priceChange' => -100,
		]);

		$commandStatus = $commandTester->execute([
			'symbol' => 'AMZN',
			'region' => 'US'
		]);

		// do something
		$recordStock = $this->entityManager
			->getRepository(Stock::class)
			->findOneBy(['symbol' => 'AMZN']);

		// make assertions
		$this->assertEquals('AMZN', $recordStock->getSymbol());
		$this->assertEquals('Amazon.com, Inc.', $recordStock->getShortName());
		$this->assertEquals('NasdaqGS', $recordStock->getExchangeName());
		$this->assertEquals('US', $recordStock->getRegion());
		$this->assertEquals('USD', $recordStock->getCurrency());
		$this->assertEquals(2000, $recordStock->getPrice());
		$this->assertEquals(2100, $recordStock->getPricePreviousClose());
		$this->assertEquals(-100 ,$recordStock->getPriceChange());
		$this->assertEquals(0, $commandStatus);
	}
}