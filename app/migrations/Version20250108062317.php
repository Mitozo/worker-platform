<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108062317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD updated_at DATETIME on update CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE file_class CHANGE type type ENUM(\'PRODUCTION\', \'CORRECTION\', \'TEST\', \'FORMATION\')');
        $this->addSql('ALTER TABLE treatment ADD updated_at DATETIME on update CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE treatment DROP updated_at');
        $this->addSql('ALTER TABLE file DROP updated_at');
        $this->addSql('ALTER TABLE file_class CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
