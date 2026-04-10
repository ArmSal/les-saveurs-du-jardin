<?php
// bin/reset-database.php - Run with: php bin/reset-database.php

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Magasin;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

// Load .env
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// Get database connection from env
$dbUrl = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');
if (!$dbUrl) {
    echo "Error: DATABASE_URL not found in .env\n";
    exit(1);
}

// Parse connection
$parsed = parse_url($dbUrl);
$host = $parsed['host'] ?? 'localhost';
$port = $parsed['port'] ?? 3306;
$user = $parsed['user'] ?? 'root';
$pass = $parsed['pass'] ?? '';
$dbname = ltrim($parsed['path'] ?? '', '/');

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to database: $dbname\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Tables to clear (in order due to foreign keys)
$tables = [
    'commande_history',
    'commande_item',
    'commande',
    'portal_monthly_validation',
    'portal_notification',
    'portal_horaire',
    'portal_conge',
    'portal_shortcut',
    'portal_document',
    'portal_document_folder',
    'module_permission',
    'portal_product',
    'portal_categorie_produit',
    'user',
    'role',
    'magasin',
];

echo "\n=== CLEARING TABLES ===\n";

// Disable foreign key checks
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

// Get existing tables
$existingTables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    if (!in_array($table, $existingTables)) {
        echo "⊘ Skipping (not exists): $table\n";
        continue;
    }
    try {
        $pdo->exec("TRUNCATE TABLE $table");
        echo "✓ Cleared: $table\n";
    } catch (PDOException $e) {
        echo "✗ Error clearing $table: " . $e->getMessage() . "\n";
    }
}

// Re-enable foreign key checks
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

echo "\n=== CREATING ROLE_DIRECTEUR ===\n";

// Create ROLE_DIRECTEUR
$stmt = $pdo->prepare("INSERT INTO role (id, name, label, priority) VALUES (1, 'ROLE_DIRECTEUR', 'Directeur', 1)");
$stmt->execute();
echo "✓ Created ROLE_DIRECTEUR\n";

echo "\n=== CREATING MAGASIN ===\n";

// Create a default magasin
$stmt = $pdo->prepare("INSERT INTO magasin (id, nom, is_active) VALUES (1, 'Siège Social', 1)");
$stmt->execute();
echo "✓ Created Magasin: Siège Social\n";

echo "\n=== CREATING ADMIN USER ===\n";

// Create password hash (Symfony default: auto with bcrypt)
$hasher = new NativePasswordHasher();
$passwordHash = $hasher->hash('admin123');

// Create user with id 99
$stmt = $pdo->prepare("INSERT INTO user (
    id, email, roles, password, civility, nom, prenom, 
    is_active, magasin, client_number, role_entity_id, magasin_entity_id,
    validation_horaire, demande_conge, documents_rh, calendar_color
) VALUES (
    99, 'directeur@lsdj.fr', :roles, :password, 'Mr', 'Directeur', 'System',
    1, 'Siège Social', 'CLI-00001', 1, 1,
    1, 1, 1, '#4f46e5'
)");

$stmt->execute([
    ':roles' => json_encode(['ROLE_DIRECTEUR', 'ROLE_USER']),
    ':password' => $passwordHash
]);

echo "✓ Created User ID 99: directeur@lsdj.fr / admin123\n";
echo "  - Nom: Directeur System\n";
echo "  - Role: ROLE_DIRECTEUR\n";
echo "  - Magasin: Siège Social\n";

echo "\n=== DATABASE RESET COMPLETE ===\n";
echo "Login credentials:\n";
echo "  Email: directeur@lsdj.fr\n";
echo "  Password: admin123\n";
