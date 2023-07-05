<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705153111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock CHANGE symbol symbol VARCHAR(5) NOT NULL, CHANGE short_name short_name VARCHAR(50) NOT NULL, CHANGE exchange_name exchange_name VARCHAR(50) NOT NULL, CHANGE region region VARCHAR(5) NOT NULL, CHANGE previous_close price_previous_close DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock CHANGE symbol symbol VARCHAR(10) NOT NULL, CHANGE region region VARCHAR(10) NOT NULL, CHANGE short_name short_name VARCHAR(20) NOT NULL, CHANGE exchange_name exchange_name VARCHAR(20) NOT NULL, CHANGE price_previous_close previous_close DOUBLE PRECISION NOT NULL');
    }
}
