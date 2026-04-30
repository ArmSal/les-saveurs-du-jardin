<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add user_observations module permissions for all existing roles.
 * ROLE_DIRECTEUR always has ACCES_TOTAL via AccessHelper, other roles default to AUCUN_ACCES.
 */
final class Version20260422224600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user_observations module permissions for all existing roles';
    }

    public function up(Schema $schema): void
    {
        // Get all existing roles
        $roles = $this->connection->fetchAllAssociative('SELECT id, name, label FROM role');

        foreach ($roles as $role) {
            // Check if a permission already exists for this module+role
            $existing = $this->connection->fetchOne(
                'SELECT COUNT(*) FROM module_permission WHERE module_key = ? AND role_name = ?',
                ['user_observations', $role['name']]
            );

            if ((int) $existing === 0) {
                $this->connection->executeStatement(
                    'INSERT INTO module_permission (module_key, role_name, role_entity_id, role_label, access_level) VALUES (?, ?, ?, ?, ?)',
                    [
                        'user_observations',
                        $role['name'],
                        $role['id'],
                        $role['label'],
                        'AUCUN_ACCES',
                    ]
                );
            }
        }
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement(
            "DELETE FROM module_permission WHERE module_key = 'user_observations'"
        );
    }
}
