param (
    [string]$TargetHost = "localhost"
)

Write-Host "=================================================="
Write-Host " Verification de l'état des Services"
Write-Host "=================================================="

# 1. Afficher l'état des conteneurs
if ($TargetHost -eq "localhost") {
    if (Test-Path "docker") {
        Write-Host "Conteneurs Docker Compose en cours d'exécution (Local) :"
        Push-Location docker
        docker compose ps
        Pop-Location
    } else {
        Write-Host "[ERREUR] Le dossier docker/ est introuvable."
    }
}

# 2. Fonction simple de test d'URL HTTP
function Tester-Url {
    param (
        [string]$Nom,
        [string]$Url
    )
    
    try {
        $reponse = Invoke-WebRequest -Uri $Url -UseBasicParsing -TimeoutSec 3 -ErrorAction Stop
        $statut = $reponse.StatusCode
        Write-Host "[OK] $Nom ($Url) répond correctement (Code: $statut)"
    } catch {
        Write-Host "[ERREUR] Impossible de contacter $Nom sur $Url !"
    }
}

Write-Host ""
Write-Host "Vérification des ports et interfaces Web sur $TargetHost :"
Tester-Url -Nom "Application Web Symfony" -Url "http://$TargetHost:80"
Tester-Url -Nom "Adminer (Base de données)" -Url "http://$TargetHost:8081"
Tester-Url -Nom "Prometheus (Métriques)" -Url "http://$TargetHost:9090"
Tester-Url -Nom "Alertmanager (Alertes)" -Url "http://$TargetHost:9093"
Tester-Url -Nom "Grafana (Dashboards)" -Url "http://$TargetHost:3000"
Tester-Url -Nom "cAdvisor (Statistiques Docker)" -Url "http://$TargetHost:8082"
Tester-Url -Nom "Node Exporter (Métriques Système)" -Url "http://$TargetHost:9100"

Write-Host "--------------------------------------------------"
Write-Host "Vérification terminée."
Write-Host "=================================================="
