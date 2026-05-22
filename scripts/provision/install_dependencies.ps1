Write-Host "=================================================="
Write-Host " Verification des dependances pour Windows 11"
Write-Host "=================================================="

# 1. Verification de Git
if (Get-Command git -ErrorAction SilentlyContinue) {
    Write-Host "[OK] Git est installe."
} else {
    Write-Host "[ATTENTION] Git n'est pas trouve !"
    Write-Host "Tentative d'installation de Git via winget..."
    winget install --id Git.Git -e --source winget
}

# 2. Verification de Docker
if (Get-Command docker -ErrorAction SilentlyContinue) {
    Write-Host "[OK] Docker est trouve."
} else {
    Write-Host "[ATTENTION] Docker n'est pas trouve !"
    Write-Host "Veuillez installer Docker Desktop depuis: https://www.docker.com/products/docker-desktop/"
    Write-Host "Ou tentez de l'installer en ligne de commande: winget install --id Docker.DockerDesktop -e --source winget"
}

# 3. Verification de l'etat de Docker
if (Get-Command docker -ErrorAction SilentlyContinue) {
    # On verifie si le service Docker est demarre
    $dockerInfo = docker info 2>$null
    if ($LASTEXITCODE -eq 0) {
        Write-Host "[OK] Le daemon Docker est en cours d'execution."
    } else {
        Write-Host "[ATTENTION] Docker est installe mais le service n'est pas demarre !"
        Write-Host "Veuillez lancer Docker Desktop."
    }
}

Write-Host "--------------------------------------------------"
Write-Host "Verification terminee."
Write-Host "=================================================="
