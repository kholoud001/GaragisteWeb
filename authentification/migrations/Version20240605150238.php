<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605150238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD username VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE users ADD cell VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD reset_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_1483A5E9F85E0677');
        $this->addSql('ALTER TABLE users DROP username');
        $this->addSql('ALTER TABLE users DROP cell');
        $this->addSql('ALTER TABLE users DROP reset_token');
    }
}
