<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107154723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file CHANGE createdby created_by VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE file_class CHANGE type type ENUM(\'EXTRACTION\', \'ANALYSIS\', \'TEST\', \'DELIVERY\')');
        $this->addSql('ALTER TABLE treatment CHANGE createdby created_by VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE treatment CHANGE created_by createdby VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE file CHANGE created_by createdby VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE file_class CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
