<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260422093438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_observations (id INT AUTO_INCREMENT NOT NULL, observation VARCHAR(150) DEFAULT NULL, ticket_restaurant SMALLINT UNSIGNED DEFAULT NULL, mois VARCHAR(7) DEFAULT NULL, is_active TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT NOT NULL, INDEX idx_user_observation_user (user_id), INDEX idx_user_observation_mois (mois), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE user_observations ADD CONSTRAINT FK_3B0D27AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_observations DROP FOREIGN KEY FK_3B0D27AAA76ED395');
        $this->addSql('DROP TABLE user_observations');
    }
}
