<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260303101211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portal_commande_history (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(50) NOT NULL, changed_at DATETIME NOT NULL, commande_id INT NOT NULL, changed_by_id INT DEFAULT NULL, INDEX IDX_51E3F8E182EA2E54 (commande_id), INDEX IDX_51E3F8E1828AD0A0 (changed_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE portal_product (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, code_barre VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) NOT NULL, unite VARCHAR(50) NOT NULL, famille VARCHAR(255) NOT NULL, tva NUMERIC(5, 2) NOT NULL, prix NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE portal_commande_history ADD CONSTRAINT FK_51E3F8E182EA2E54 FOREIGN KEY (commande_id) REFERENCES portal_commandes (id)');
        $this->addSql('ALTER TABLE portal_commande_history ADD CONSTRAINT FK_51E3F8E1828AD0A0 FOREIGN KEY (changed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE portal_commande_item DROP FOREIGN KEY `FK_A97A373575F980C`');
        $this->addSql('ALTER TABLE portal_commande_item ADD CONSTRAINT FK_A97A37354584665A FOREIGN KEY (product_id) REFERENCES portal_product (id)');
        $this->addSql('ALTER TABLE portal_commande_item RENAME INDEX idx_a97a373575f980c TO IDX_A97A37354584665A');
        $this->addSql('ALTER TABLE user CHANGE is_active is_active TINYINT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portal_commande_history DROP FOREIGN KEY FK_51E3F8E182EA2E54');
        $this->addSql('ALTER TABLE portal_commande_history DROP FOREIGN KEY FK_51E3F8E1828AD0A0');
        $this->addSql('DROP TABLE portal_commande_history');
        $this->addSql('DROP TABLE portal_product');
        $this->addSql('ALTER TABLE portal_commande_item DROP FOREIGN KEY FK_A97A37354584665A');
        $this->addSql('ALTER TABLE portal_commande_item RENAME INDEX idx_a97a37354584665a TO IDX_A97A373575F980C');
        $this->addSql('ALTER TABLE user CHANGE is_active is_active TINYINT DEFAULT 1 NOT NULL');
    }
}
