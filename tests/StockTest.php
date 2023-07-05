<?php

namespace App\Tests;

use App\Entity\Stock;

class StockTest extends DependentDatabase
{
	public function testICanCreateStockInDatabaseMemory(): void
	{
		// setup
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

		// do something
		/** @var Stock $recordStock */
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

	}

}