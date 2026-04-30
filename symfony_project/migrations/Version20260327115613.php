<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260327115613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE validation_horaire validation_horaire TINYINT DEFAULT 0 NOT NULL, CHANGE demande_conge demande_conge TINYINT DEFAULT 0 NOT NULL, CHANGE documents_rh documents_rh TINYINT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE validation_horaire validation_horaire VARCHAR(20) DEFAULT \'none\', CHANGE demande_conge demande_conge VARCHAR(20) DEFAULT \'none\', CHANGE documents_rh documents_rh VARCHAR(20) DEFAULT \'none\'');
    }
}
