<?php
// bin/export-database.php - Usage: php bin/export-database.php
// Exports database for OVH migration

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

echo "=== DATABASE EXPORT FOR OVH ===\n\n";
echo "Database: $dbname\n";
echo "Host: $host:$port\n\n";

// Create export directory
$exportDir = __DIR__ . '/../db-export';
if (!is_dir($exportDir)) {
    mkdir($exportDir, 0755, true);
}

$timestamp = date('Y-m-d_H-i-s');
$exportFile = "$exportDir/{$dbname}_{$timestamp}.sql";

// Build mysqldump command
$cmd = sprintf(
    'mysqldump -h%s -P%d -u%s %s --databases %s > %s',
    escapeshellarg($host),
    $port,
    escapeshellarg($user),
    $pass ? '-p' . escapeshellarg($pass) : '',
    escapeshellarg($dbname),
    escapeshellarg($exportFile)
);

echo "Exporting database...\n";
echo "Command: $cmd\n\n";

exec($cmd . ' 2>&1', $output, $returnCode);

if ($returnCode === 0 && file_exists($exportFile) && filesize($exportFile) > 0) {
    $size = filesize($exportFile);
    echo "✓ Database exported successfully!\n";
    echo "File: $exportFile\n";
    echo "Size: " . number_format($size / 1024, 2) . " KB\n\n";
    
    // Create SQL instructions file
    $instructions = "# Database Import Instructions for OVH\n\n";
    $instructions .= "1. Upload this SQL file to your OVH server\n";
    $instructions .= "2. Access your OVH database (via phpMyAdmin or SSH)\n";
    $instructions .= "3. Import the SQL file:\n";
    $instructions .= "   mysql -u [ovh_username] -p [ovh_database_name] < {$dbname}_{$timestamp}.sql\n\n";
    $instructions .= "OR via phpMyAdmin:\n";
    $instructions .= "   - Go to Import tab\n";
    $instructions .= "   - Select the SQL file\n";
    $instructions .= "   - Click Go\n\n";
    
    file_put_contents($exportDir . '/IMPORT_INSTRUCTIONS.txt', $instructions);
    echo "✓ Created IMPORT_INSTRUCTIONS.txt\n\n";
} else {
    echo "✗ Export failed!\n";
    echo "Error output:\n";
    echo implode("\n", $output) . "\n";
    exit(1);
}

echo "=== EXPORT COMPLETE ===\n";
