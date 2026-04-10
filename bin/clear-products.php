<?php
// bin/clear-products.php - Usage: php bin/clear-products.php
// Clears all product data and resets indexes

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Load .env
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// Get database connection
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
    echo "Connected to database: $dbname\n\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "=== CLEARING PRODUCT DATA ===\n\n";

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

// Tables to clear (order matters for FK constraints)
$tables = [
    'portal_commande_item',  // Has FK to portal_product
    'portal_product',
    'portal_categorie_produit',
];

foreach ($tables as $table) {
    try {
        $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        $pdo->exec("TRUNCATE TABLE $table");
        echo "✓ Cleared $table ($count rows deleted, index reset)\n";
    } catch (PDOException $e) {
        echo "✗ Error clearing $table: " . $e->getMessage() . "\n";
    }
}

$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

// Also delete product images
echo "\n=== CHECKING PRODUCT IMAGES ===\n";
$productsDir = __DIR__ . '/../storage/products';
if (is_dir($productsDir)) {
    $files = glob($productsDir . '/*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $count++;
        }
    }
    echo "✓ Deleted $count product images from storage/products/\n";
} else {
    echo "⊘ Products directory not found\n";
}

echo "\n=== PRODUCT DATA CLEARED ===\n";
echo "You can now:\n";
echo "1. Run migrations: php bin/console doctrine:migrations:migrate\n";
echo "2. Transfer product images via FileZilla to storage/products/\n";
