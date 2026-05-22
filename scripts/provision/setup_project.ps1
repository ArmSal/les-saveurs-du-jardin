Write-Host "=================================================="
Write-Host " Preparation et Lancement de l'Application"
Write-Host "=================================================="

# 1. Creation du fichier docker/.env
$envFile = "docker/.env"
$envExample = "docker/.env.example"

if (Test-Path $envFile) {
    Write-Host "[OK] Le fichier docker/.env existe deja."
} else {
    if (Test-Path $envExample) {
        Write-Host "Creation du fichier docker/.env depuis l'exemple..."
        Copy-Item $envExample $envFile
        Write-Host "[OK] Fichier docker/.env cree avec succes."
        Write-Host "[!] Pensez a modifier les mots de passe par defaut dans docker/.env si necessaire."
    } else {
        Write-Host "[ERREUR] Le fichier exemple $envExample est introuvable !"
    }
}

# 2. Lancement des conteneurs Docker
if (Test-Path "docker") {
    Write-Host "Demarrage des conteneurs Docker Compose..."
    Push-Location docker
    docker compose up -d --build
    Pop-Location
    Write-Host "[OK] Les conteneurs demarrent."
} else {
    Write-Host "[ERREUR] Le dossier docker/ est introuvable !"
}

Write-Host "--------------------------------------------------"
Write-Host "Initialisation terminee."
Write-Host "=================================================="
