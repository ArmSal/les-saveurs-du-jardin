<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$dbUrl = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');
if (!$dbUrl) {
    echo "Error: DATABASE_URL not found\n";
    exit(1);
}

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
    
    // 1. Create/Check Magasin Olivet
    echo "=== MAGASIN ===\n";
    $stmt = $pdo->prepare("SELECT id FROM magasin WHERE nom = ?");
    $stmt->execute(['Olivet']);
    $magasin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($magasin) {
        $magasinId = $magasin['id'];
        echo "✓ Magasin 'Olivet' exists (ID: $magasinId)\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO magasin (nom, is_active) VALUES (?, 1)");
        $stmt->execute(['Olivet']);
        $magasinId = $pdo->lastInsertId();
        echo "✓ Created Magasin 'Olivet' (ID: $magasinId)\n";
    }
    
    // 2. Create/Check Role DIRECTEUR
    echo "\n=== ROLE ===\n";
    $stmt = $pdo->prepare("SELECT id FROM role WHERE name = ?");
    $stmt->execute(['ROLE_DIRECTEUR']);
    $role = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($role) {
        $roleId = $role['id'];
        echo "✓ Role 'ROLE_DIRECTEUR' exists (ID: $roleId)\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO role (name, label, priority) VALUES (?, 'Directeur', 1)");
        $stmt->execute(['ROLE_DIRECTEUR']);
        $roleId = $pdo->lastInsertId();
        echo "✓ Created Role 'ROLE_DIRECTEUR' (ID: $roleId)\n";
    }
    
    // 3. Check if user exists
    echo "\n=== USER ===\n";
    $stmt = $pdo->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->execute(['ali@tuzen.pro']);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingUser) {
        echo "✗ User ali@tuzen.pro already exists (ID: {$existingUser['id']})\n";
        echo "  Updating user...\n";
        
        $hasher = new NativePasswordHasher();
        $passwordHash = $hasher->hash('superadmin12345!');
        
        $stmt = $pdo->prepare("UPDATE user SET 
            password = ?, 
            role_entity_id = ?, 
            magasin_entity_id = ?, 
            validation_horaire = 1, 
            demande_conge = 1, 
            documents_rh = 1,
            is_active = 1
            WHERE email = ?");
        $stmt->execute([$passwordHash, $roleId, $magasinId, 'ali@tuzen.pro']);
        
        $userId = $existingUser['id'];
        echo "✓ User updated\n";
    } else {
        // Create new user
        $hasher = new NativePasswordHasher();
        $passwordHash = $hasher->hash('superadmin12345!');
        
        $stmt = $pdo->prepare("INSERT INTO user (
            email, roles, password, civility, nom, prenom, 
            is_active, magasin, client_number, role_entity_id, magasin_entity_id,
            validation_horaire, demande_conge, documents_rh, calendar_color
        ) VALUES (
            ?, ?, ?, 'Mr', 'Ali', 'Tuzen',
            1, ?, 'CLI-00001', ?, ?, 
            1, 1, 1, '#4f46e5'
        )");
        
        $stmt->execute([
            'ali@tuzen.pro',
            json_encode(['ROLE_DIRECTEUR', 'ROLE_USER']),
            $passwordHash,
            'Olivet',
            $roleId,
            $magasinId
        ]);
        
        $userId = $pdo->lastInsertId();
        echo "✓ Created User ali@tuzen.pro (ID: $userId)\n";
    }
    
    // 4. Grant full module permissions
    echo "\n=== PERMISSIONS ===\n";
    
    // Get all modules
    $modules = [
        'dashboard', 'users', 'roles', 'access', 'settings',
        'produits', 'commandes', 'agenda', 'conges', 'horaires', 
        'validation_horaire', 'documents_rh', 'stock', 'stats'
    ];
    
    // Clear existing permissions for this role
    $stmt = $pdo->prepare("DELETE FROM module_permission WHERE role_name = ?");
    $stmt->execute(['ROLE_DIRECTEUR']);
    
    // Grant all permissions with ACCES_TOTAL
    $stmt = $pdo->prepare("INSERT INTO module_permission 
        (role_entity_id, module_key, role_name, role_label, access_level) 
        VALUES (?, ?, ?, 'Directeur', 'ACCES_TOTAL')");
    
    foreach ($modules as $module) {
        $stmt->execute([$roleId, $module, 'ROLE_DIRECTEUR']);
    }
    
    echo "✓ Granted full access (ACCES_TOTAL) to all modules\n";
    
    echo "\n=== USER CREATED/UPDATED ===\n";
    echo "Email:    ali@tuzen.pro\n";
    echo "Password: superadmin12345!\n";
    echo "Role:     ROLE_DIRECTEUR\n";
    echo "Magasin:  Olivet\n";
    echo "Modules:  Full access on all\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
