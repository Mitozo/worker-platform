<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108063221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD updated_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL, CHANGE updated_at updated_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE file_class CHANGE type type ENUM(\'PRODUCTION\', \'CORRECTION\', \'TEST\', \'FORMATION\')');
        $this->addSql('ALTER TABLE file_data ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL, ADD updated_at DATETIME on update CURRENT_TIMESTAMP, ADD updated_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL');
        $this->addSql('ALTER TABLE file_details ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL, ADD updated_at DATETIME on update CURRENT_TIMESTAMP, ADD updated_by VARCHAR(20) DEFAULT \'Administrator\' NOT NULL');
        $this->addSql('ALTER TABLE treatment ADD updated_by VARCHAR(20) NOT NULL, CHANGE updated_at updated_at DATETIME on update CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE treatment DROP updated_by, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE file DROP updated_by, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE file_details DROP created_at, DROP created_by, DROP updated_at, DROP updated_by');
        $this->addSql('ALTER TABLE file_class CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE file_data DROP created_at, DROP created_by, DROP updated_at, DROP updated_by');
    }
}
