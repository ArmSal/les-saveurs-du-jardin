<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408093855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trans_et_log (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, observation VARCHAR(200) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, camion_id INT NOT NULL, INDEX IDX_106ADB463A706D3 (camion_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE trans_et_log_magasin (trans_et_log_id INT NOT NULL, magasin_id INT NOT NULL, INDEX IDX_AF5E9931DDFDA0C0 (trans_et_log_id), INDEX IDX_AF5E993120096AE3 (magasin_id), PRIMARY KEY (trans_et_log_id, magasin_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE trans_et_log_camion (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, immatriculation VARCHAR(50) NOT NULL, is_active TINYINT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_785F15B3BE73422E (immatriculation), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE trans_et_log ADD CONSTRAINT FK_106ADB463A706D3 FOREIGN KEY (camion_id) REFERENCES trans_et_log_camion (id)');
        $this->addSql('ALTER TABLE trans_et_log_magasin ADD CONSTRAINT FK_AF5E9931DDFDA0C0 FOREIGN KEY (trans_et_log_id) REFERENCES trans_et_log (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trans_et_log_magasin ADD CONSTRAINT FK_AF5E993120096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trans_et_log DROP FOREIGN KEY FK_106ADB463A706D3');
        $this->addSql('ALTER TABLE trans_et_log_magasin DROP FOREIGN KEY FK_AF5E9931DDFDA0C0');
        $this->addSql('ALTER TABLE trans_et_log_magasin DROP FOREIGN KEY FK_AF5E993120096AE3');
        $this->addSql('DROP TABLE trans_et_log');
        $this->addSql('DROP TABLE trans_et_log_magasin');
        $this->addSql('DROP TABLE trans_et_log_camion');
    }
}
