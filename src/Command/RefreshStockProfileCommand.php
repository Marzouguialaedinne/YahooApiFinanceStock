<?php

namespace App\Command;

use App\Entity\Stock;
use App\Http\FinanceApiInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:refresh-stock-profile',
    description: 'Add a short description for your command',
)]
class RefreshStockProfileCommand extends Command
{
	public function __construct(
		public EntityManagerInterface $entityManager,
		public FinanceApiInterface $financeApi,
		public SerializerInterface $serializer
	)
	{
		parent::__construct(null);
	}

	protected function configure(): void
    {
        $this
            ->addArgument('symbol', InputArgument::REQUIRED, 'The value of symbol is required')
	        ->addArgument('region', InputArgument::OPTIONAL, 'The region is optional')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
	    $response = $this->financeApi->fetchProfile(
			$input->getArgument('symbol'),
		    $input->getArgument('region')
	    );

		$symbol = json_decode($response->getContent())->symbol ?? null;

		if($stock = $this->entityManager->getRepository(Stock::class)->findOneBy(['symbol' => $symbol])) {
			$output->writeln('Updated !');
			$this->serializer->deserialize($response->getContent(), Stock::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $stock]);
		} else {
			$stock = $this->serializer->deserialize($response->getContent(), Stock::class, 'json');
		}

		$this->entityManager->persist($stock);
		$this->entityManager->flush();

		$output->writeln('Stock was created success !');
        return Command::SUCCESS;
    }
}
