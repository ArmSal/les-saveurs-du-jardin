<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260413124849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portal_week_locks (id INT AUTO_INCREMENT NOT NULL, magasin VARCHAR(255) NOT NULL, week_number INT NOT NULL, year INT NOT NULL, is_locked TINYINT NOT NULL, locked_at DATETIME DEFAULT NULL, locked_by_id INT DEFAULT NULL, INDEX IDX_868245C27A88E00 (locked_by_id), UNIQUE INDEX uniq_week_lock (magasin, week_number, year), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE portal_week_locks ADD CONSTRAINT FK_868245C27A88E00 FOREIGN KEY (locked_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portal_week_locks DROP FOREIGN KEY FK_868245C27A88E00');
        $this->addSql('DROP TABLE portal_week_locks');
    }
}
