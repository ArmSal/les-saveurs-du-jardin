<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$dbUrl = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');
$parsed = parse_url($dbUrl);
$host = $parsed['host'] ?? 'localhost';
$user = $parsed['user'] ?? 'root';
$pass = $parsed['pass'] ?? '';
$dbname = ltrim($parsed['path'] ?? '', '/');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get role DIRECTEUR id
    $stmt = $pdo->prepare("SELECT id FROM role WHERE name = 'ROLE_DIRECTEUR'");
    $stmt->execute();
    $role = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$role) {
        echo "Role ROLE_DIRECTEUR not found\n";
        exit(1);
    }
    
    $roleId = $role['id'];
    
    // Check if access permission exists
    $stmt = $pdo->prepare("SELECT id FROM module_permission WHERE role_entity_id = ? AND module_key = 'access'");
    $stmt->execute([$roleId]);
    
    if ($stmt->fetch()) {
        // Update to ACCES_TOTAL
        $stmt = $pdo->prepare("UPDATE module_permission SET access_level = 'ACCES_TOTAL' WHERE role_entity_id = ? AND module_key = 'access'");
        $stmt->execute([$roleId]);
        echo "✓ Updated access module permission to ACCES_TOTAL\n";
    } else {
        // Insert new permission
        $stmt = $pdo->prepare("INSERT INTO module_permission (role_entity_id, module_key, role_name, role_label, access_level) VALUES (?, 'access', 'ROLE_DIRECTEUR', 'Directeur', 'ACCES_TOTAL')");
        $stmt->execute([$roleId]);
        echo "✓ Added access module permission with ACCES_TOTAL\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
