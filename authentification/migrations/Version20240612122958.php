<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612122958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_model DROP CONSTRAINT fk_fd8975a04bd2a4c0');
        $this->addSql('ALTER TABLE report_model DROP CONSTRAINT fk_fd8975a07975b7e7');
        $this->addSql('DROP TABLE report_model');
        $this->addSql('ALTER TABLE report ADD model_id INT NOT NULL');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77847975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C42F77847975B7E7 ON report (model_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE report_model (report_id INT NOT NULL, model_id INT NOT NULL, PRIMARY KEY(report_id, model_id))');
        $this->addSql('CREATE INDEX idx_fd8975a07975b7e7 ON report_model (model_id)');
        $this->addSql('CREATE INDEX idx_fd8975a04bd2a4c0 ON report_model (report_id)');
        $this->addSql('ALTER TABLE report_model ADD CONSTRAINT fk_fd8975a04bd2a4c0 FOREIGN KEY (report_id) REFERENCES report (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report_model ADD CONSTRAINT fk_fd8975a07975b7e7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report DROP CONSTRAINT FK_C42F77847975B7E7');
        $this->addSql('DROP INDEX IDX_C42F77847975B7E7');
        $this->addSql('ALTER TABLE report DROP model_id');
    }
}
