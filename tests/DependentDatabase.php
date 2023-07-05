<?php

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DependentDatabase extends KernelTestCase
{
	protected EntityManager $entityManager;
	protected function setUp(): void
	{
		$kernel = static::bootKernel();
		DatabasePrimer::prime($kernel);

		$this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
	}
	protected function tearDown(): void
	{
		$this->entityManager->close();
	}

}