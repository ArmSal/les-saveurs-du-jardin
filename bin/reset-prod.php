<?php
// bin/reset-prod.php - Usage: php bin/reset-prod.php

require __DIR__ . '/../vendor/autoload.php';

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

// Tables to clear
$tables = [
    'portal_commande_history',
    'portal_commande_item',
    'portal_commandes',
    'portal_monthly_validations',
    'portal_notifications',
    'portal_horaires',
    'portal_conges',
    'portal_shortcut',
    'portal_documents',
    'portal_document_folders',
    'module_permission',
    'portal_product',
    'portal_categorie_produit',
    'user',
    'role',
    'magasin',
];

echo "\n=== CLEARING ALL DATA & RESETTING INDEXES ===\n";

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$existingTables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    if (!in_array($table, $existingTables)) {
        echo "⊘ Skipping (not exists): $table\n";
        continue;
    }
    try {
        $pdo->exec("TRUNCATE TABLE $table");
        echo "✓ Cleared (Auto-increment reset): $table\n";
    } catch (PDOException $e) {
        echo "✗ Error clearing $table: " . $e->getMessage() . "\n";
    }
}
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

echo "\n=== CREATING ROLE HIERARCHY ===\n";

$rolesList = [
    ['ROLE_DIRECTEUR', 'Directeur', 1],
];

foreach ($rolesList as $roleData) {
    $stmt = $pdo->prepare("INSERT INTO role (name, label, priority) VALUES (?, ?, ?)");
    $stmt->execute($roleData);
    echo "✓ Created {$roleData[0]}\n";
}

echo "\n=== CREATING MAGASIN: OLIVET ===\n";

$stmt = $pdo->prepare("INSERT INTO magasin (id, nom, is_active) VALUES (1, 'Olivet', 1)");
$stmt->execute();
echo "✓ Created Magasin: Olivet\n";

echo "\n=== CONFIGURING ALL MODULE ACCESS (ACCES_TOTAL) ===\n";

$modules = [
    'dashboard', 'agenda', 'users', 'rh_validation', 'rh_conge', 
    'rh_documents', 'documents', 'maintenance_signalement', 
    'maintenance_suivi', 'produits', 'commandes', 'shortcuts', 'access_management'
];

foreach ($modules as $mod) {
    $stmt = $pdo->prepare("INSERT INTO module_permission (module_key, role_name, access_level, role_entity_id, role_label) VALUES (:mod, 'ROLE_DIRECTEUR', 'ACCES_TOTAL', 1, 'Directeur')");
    $stmt->execute([':mod' => $mod]);
    echo "  - Access granted for: $mod\n";
}

echo "\n=== CREATING PRODUCTION ADMIN USER ===\n";

$hasher = new NativePasswordHasher();
$passwordHash = $hasher->hash('admin123'); // Default password, user should change it

$stmt = $pdo->prepare("INSERT INTO user (
    email, roles, password, civility, nom, prenom, 
    is_active, magasin, client_number, role_entity_id, magasin_entity_id,
    validation_horaire, demande_conge, documents_rh, calendar_color
) VALUES (
    'admin@lsdj.fr', :roles, :password, 'Mr', 'Administrateur', 'System',
    1, 'Olivet', 'PROD-00001', 1, 1,
    1, 1, 1, '#4f46e5'
)");

$stmt->execute([
    ':roles' => json_encode(['ROLE_DIRECTEUR']),
    ':password' => $passwordHash
]);

echo "✓ Created Admin User: admin@lsdj.fr / admin123\n";

echo "\n=== PROD RESET COMPLETE ===\n";
echo "IMPORTANT: Please change the password upon first login.\n";
