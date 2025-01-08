<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108063447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file CHANGE updated_at updated_at DATETIME on update CURRENT_TIMESTAMP, CHANGE updated_by updated_by VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE file_class CHANGE type type ENUM(\'PRODUCTION\', \'CORRECTION\', \'TEST\', \'FORMATION\')');
        $this->addSql('ALTER TABLE file_data CHANGE updated_at updated_at DATETIME on update CURRENT_TIMESTAMP, CHANGE updated_by updated_by VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE file_details CHANGE updated_at updated_at DATETIME on update CURRENT_TIMESTAMP, CHANGE updated_by updated_by VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE treatment CHANGE updated_at updated_at DATETIME on update CURRENT_TIMESTAMP, CHANGE updated_by updated_by VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE treatment CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE updated_by updated_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL');
        $this->addSql('ALTER TABLE file CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE updated_by updated_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL');
        $this->addSql('ALTER TABLE file_details CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE updated_by updated_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL');
        $this->addSql('ALTER TABLE file_class CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE file_data CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE updated_by updated_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL');
    }
}
