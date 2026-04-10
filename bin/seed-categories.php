<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Entity\PortalProductCategory;
use App\Entity\PortalProduct;
use App\Entity\Magasin;
use Doctrine\ORM\EntityManagerInterface;

$kernel = new \App\Kernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();
$em = $container->get(EntityManagerInterface::class);

// Check if categories exist
$categoryRepo = $em->getRepository(PortalProductCategory::class);
$existing = $categoryRepo->findAll();

if (count($existing) > 0) {
    echo "Categories already exist: " . count($existing) . "\n";
    foreach ($existing as $cat) {
        echo "  - {$cat->getName()} (ID: {$cat->getId()})\n";
    }
    exit(0);
}

// Create default categories
$categories = [
    ['name' => 'Fruits & Légumes', 'description' => 'Produits frais du jardin'],
    ['name' => 'Produits Laitiers', 'description' => 'Fromages et produits laitiers'],
    ['name' => 'Boulangerie', 'description' => 'Pains et viennoiseries'],
    ['name' => 'Épicerie', 'description' => 'Produits secs et conserves'],
];

foreach ($categories as $catData) {
    $category = new PortalProductCategory();
    $category->setName($catData['name']);
    $category->setDescription($catData['description']);
    $em->persist($category);
    echo "Created category: {$catData['name']}\n";
}

$em->flush();

echo "\n✓ Categories created successfully!\n";

// Show all categories
$allCategories = $categoryRepo->findAll();
echo "\nTotal categories: " . count($allCategories) . "\n";
