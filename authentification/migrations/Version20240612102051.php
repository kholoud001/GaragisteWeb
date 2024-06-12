<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612102051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE mark_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE part_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE report_part_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mark (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, mark_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79572D94290F12B ON model (mark_id)');
        $this->addSql('CREATE TABLE part (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE report (id INT NOT NULL, registration_number VARCHAR(255) NOT NULL, previous_registration VARCHAR(255) NOT NULL, first_registration DATE NOT NULL, mc_maroc DATE NOT NULL, usage VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, validity_end DATE NOT NULL, type VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, fuel_type VARCHAR(255) NOT NULL, chassis_nbr VARCHAR(255) NOT NULL, cylinder_nbr VARCHAR(255) DEFAULT NULL, fiscal_power VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE report_model (report_id INT NOT NULL, model_id INT NOT NULL, PRIMARY KEY(report_id, model_id))');
        $this->addSql('CREATE INDEX IDX_FD8975A04BD2A4C0 ON report_model (report_id)');
        $this->addSql('CREATE INDEX IDX_FD8975A07975B7E7 ON report_model (model_id)');
        $this->addSql('CREATE TABLE report_part (id INT NOT NULL, report_id INT NOT NULL, part_id INT NOT NULL, damage TEXT DEFAULT NULL, damage_image TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3A239D3D4BD2A4C0 ON report_part (report_id)');
        $this->addSql('CREATE INDEX IDX_3A239D3D4CE34BEC ON report_part (part_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(50) NOT NULL, cell VARCHAR(15) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_archived BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D94290F12B FOREIGN KEY (mark_id) REFERENCES mark (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report_model ADD CONSTRAINT FK_FD8975A04BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report_model ADD CONSTRAINT FK_FD8975A07975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report_part ADD CONSTRAINT FK_3A239D3D4BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report_part ADD CONSTRAINT FK_3A239D3D4CE34BEC FOREIGN KEY (part_id) REFERENCES part (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE mark_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE part_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE report_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE report_part_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D94290F12B');
        $this->addSql('ALTER TABLE report_model DROP CONSTRAINT FK_FD8975A04BD2A4C0');
        $this->addSql('ALTER TABLE report_model DROP CONSTRAINT FK_FD8975A07975B7E7');
        $this->addSql('ALTER TABLE report_part DROP CONSTRAINT FK_3A239D3D4BD2A4C0');
        $this->addSql('ALTER TABLE report_part DROP CONSTRAINT FK_3A239D3D4CE34BEC');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE report_model');
        $this->addSql('DROP TABLE report_part');
        $this->addSql('DROP TABLE users');
    }
}
