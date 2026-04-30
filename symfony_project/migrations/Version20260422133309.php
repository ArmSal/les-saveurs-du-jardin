<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260422133309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE observation_month_locks (id INT AUTO_INCREMENT NOT NULL, mois VARCHAR(7) NOT NULL, is_locked TINYINT NOT NULL, locked_at DATETIME DEFAULT NULL, locked_by_id INT DEFAULT NULL, INDEX IDX_2053BF697A88E00 (locked_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE observation_month_locks ADD CONSTRAINT FK_2053BF697A88E00 FOREIGN KEY (locked_by_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX uniq_week_lock ON portal_week_locks');
        $this->addSql('ALTER TABLE portal_week_locks CHANGE is_locked is_locked TINYINT NOT NULL');
        $this->addSql('ALTER TABLE user_observations CHANGE is_active is_active TINYINT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE observation_month_locks DROP FOREIGN KEY FK_2053BF697A88E00');
        $this->addSql('DROP TABLE observation_month_locks');
        $this->addSql('ALTER TABLE portal_week_locks CHANGE is_locked is_locked TINYINT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_week_lock ON portal_week_locks (magasin, week_number, year)');
        $this->addSql('ALTER TABLE user_observations CHANGE is_active is_active TINYINT DEFAULT 1 NOT NULL');
    }
}
