<?php
// bin/prepare-for-production.php - Usage: php bin/prepare-for-production.php
// Prepares project for OVH deployment - clears dev data, cache, logs

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

echo "=== PREPARING PROJECT FOR PRODUCTION DEPLOYMENT ===\n\n";

// 1. Clear cache directories
$cacheDirs = [
    __DIR__ . '/../var/cache/dev',
    __DIR__ . '/../var/cache/prod',
    __DIR__ . '/../var/cache/test',
];

echo "1. Clearing cache directories...\n";
foreach ($cacheDirs as $dir) {
    if (is_dir($dir)) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $fileinfo) {
            if ($fileinfo->isDir()) {
                rmdir($fileinfo->getRealPath());
            } else {
                unlink($fileinfo->getRealPath());
            }
        }
        rmdir($dir);
        echo "   ✓ Cleared: $dir\n";
    }
}
echo "\n";

// 2. Clear log files
echo "2. Clearing log files...\n";
$logDir = __DIR__ . '/../var/log';
if (is_dir($logDir)) {
    foreach (glob($logDir . '/*') as $file) {
        if (is_file($file)) {
            unlink($file);
            echo "   ✓ Deleted: " . basename($file) . "\n";
        }
    }
}
echo "\n";

// 3. Ensure storage directories exist with proper structure
echo "3. Setting up storage directories...\n";
$storageDirs = [
    'documents',
    'documents_rh',
    'users',
    'products',
    'shortcuts',
];
foreach ($storageDirs as $subDir) {
    $fullPath = __DIR__ . '/../storage/' . $subDir;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
        echo "   ✓ Created: storage/$subDir/\n";
    } else {
        echo "   ✓ Exists: storage/$subDir/\n";
    }
}
echo "\n";

// 4. Clean temporary/session files
echo "4. Cleaning temporary files...\n";
$tempDirs = [
    __DIR__ . '/../var/sessions',
];
foreach ($tempDirs as $dir) {
    if (is_dir($dir)) {
        foreach (glob($dir . '/*') as $file) {
            if (is_file($file) && filemtime($file) < time() - 86400) {
                unlink($file);
            }
        }
        echo "   ✓ Cleaned: $dir\n";
    }
}
echo "\n";

// 5. Check .env configuration
echo "5. Checking environment configuration...\n";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    if (strpos($envContent, 'APP_ENV=dev') !== false) {
        echo "   ⚠ WARNING: APP_ENV is set to 'dev' - change to 'prod' for production\n";
    }
    if (strpos($envContent, 'APP_SECRET=') !== false) {
        if (preg_match('/APP_SECRET=$/m', $envContent) || preg_match('/APP_SECRET=\s*$/m', $envContent)) {
            echo "   ⚠ WARNING: APP_SECRET is empty - generate a secure secret for production\n";
        }
    }
    
    // Check if local env files exist
    if (file_exists(__DIR__ . '/../.env.local')) {
        echo "   ⚠ Found .env.local - this should NOT be uploaded to production\n";
    }
}
echo "\n";

// 6. List files to exclude from upload
echo "6. Files/Directories to EXCLUDE from FileZilla upload:\n";
$excludeList = [
    '.git/',
    '.gitignore',
    '.gitattributes',
    'var/cache/',
    'var/log/',
    'var/sessions/',
    '.env.local',
    '.env.dev',
    'compose.override.yaml',
];
foreach ($excludeList as $item) {
    echo "   ✗ EXCLUDE: $item\n";
}
echo "\n";

echo "=== PREPARATION COMPLETE ===\n\n";

echo "Next steps:\n";
echo "1. Run: php bin/console cache:clear --env=prod\n";
echo "2. Update .env for production (see DEPLOY.md)\n";
echo "3. Export database: php bin/export-database.php\n";
echo "4. Upload files via FileZilla (see filezilla-transfer.txt)\n";
echo "5. Import database on OVH server\n";
