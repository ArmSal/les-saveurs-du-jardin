<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260327114416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE magasin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, is_active TINYINT DEFAULT 1 NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE module_permission CHANGE role_name role_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user ADD magasin_entity_id INT DEFAULT NULL, CHANGE validation_horaire validation_horaire TINYINT DEFAULT 0 NOT NULL, CHANGE demande_conge demande_conge TINYINT DEFAULT 0 NOT NULL, CHANGE documents_rh documents_rh TINYINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649682472CA FOREIGN KEY (magasin_entity_id) REFERENCES magasin (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649682472CA ON user (magasin_entity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE magasin');
        $this->addSql('ALTER TABLE module_permission CHANGE role_name role_name VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649682472CA');
        $this->addSql('DROP INDEX IDX_8D93D649682472CA ON user');
        $this->addSql('ALTER TABLE user DROP magasin_entity_id, CHANGE validation_horaire validation_horaire VARCHAR(20) DEFAULT \'none\', CHANGE demande_conge demande_conge VARCHAR(20) DEFAULT \'none\', CHANGE documents_rh documents_rh VARCHAR(20) DEFAULT \'none\'');
    }
}
