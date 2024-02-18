<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217142807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anime ALTER name TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE anime ALTER genre TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE anime ALTER description DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE anime ALTER name TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE anime ALTER genre TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE anime ALTER description SET NOT NULL');
    }
}
