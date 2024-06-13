<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612131749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report ADD cartegrise_recto VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE report ADD cartegrise_verso VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE report ADD permis_recto VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE report ADD permis_verso VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE report DROP cartegrise_recto');
        $this->addSql('ALTER TABLE report DROP cartegrise_verso');
        $this->addSql('ALTER TABLE report DROP permis_recto');
        $this->addSql('ALTER TABLE report DROP permis_verso');
    }
}
