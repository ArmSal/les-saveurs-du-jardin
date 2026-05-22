# Guide de Configuration AWS EC2 pour LSDJ

Ce guide vous explique comment préparer votre instance AWS pour qu'elle soit prête à recevoir le déploiement automatique depuis GitHub.

## 1. Choix de l'Instance
- **Type d'instance recommandé** : `t3.small` (2 vCPU, 2 Go RAM). 
  *Note : La `t2.micro` (1 Go RAM) est éligible à l'offre gratuite mais risque d'être trop juste pour faire tourner les 9 services Docker simultanément.*
- **OS** : `Ubuntu 22.04 LTS`.

## 2. Configuration du Security Group (Pare-feu)
Dans la console AWS, modifiez les "Inbound Rules" de votre instance :

| Type | Port | Source | Description |
| :--- | :--- | :--- | :--- |
| **SSH** | 22 | My IP / All | Accès pour SSH et GitHub Actions |
| **HTTP** | 80 | Custom (0.0.0.0/0) | Accès public à votre application (non sécurisé) |
| **HTTPS** | 443 | Custom (0.0.0.0/0) | Accès public sécurisé (SSL/TLS) |
| **Custom** | 3000 | My IP / All | Accès à Grafana pour la supervision |
| **Custom** | 9090 | My IP / All | Accès à Prometheus (optionnel) |
| **Custom** | 8081 | My IP / All | Accès à Adminer (optionnel) |

## 3. Installation des outils sur l'EC2
Connectez-vous à votre instance en SSH et lancez ces commandes :

```bash
# Mise à jour du système
sudo apt update && sudo apt upgrade -y

# Installation de Docker
sudo apt install docker.io -y
sudo systemctl start docker
sudo systemctl enable docker

# Autoriser l'utilisateur ubuntu à utiliser Docker sans sudo
sudo usermod -aG docker ubuntu
# (Important : déconnectez-vous et reconnectez-vous pour que cela prenne effet)

# Installation de Docker Compose (v2)
sudo apt install docker-compose-v2 -y

# Installation de Git
sudo apt install git -y
```

## 4. Préparation du dossier projet
Le pipeline GitHub attend que le projet soit dans un dossier spécifique :

```bash
cd ~
git clone https://github.com/VOTRE_NOM/VOTRE_DEPOT.git les-saveurs-du-jardin
cd les-saveurs-du-jardin/docker

# Créer le fichier .env sur le serveur (à faire une seule fois)
nano .env
# Copiez-y les variables de votre .env local (MYSQL_PASSWORD, etc.)
```

## 5. Configuration des Secrets GitHub
Dans votre dépôt GitHub, allez dans **Settings > Secrets and variables > Actions** et ajoutez :

1. `EC2_HOST` : L'IP publique de votre EC2 (ex: `13.38.12.34`).
2. `EC2_USER` : `ubuntu`.
3. `EC2_SSH_KEY` : Ouvrez votre fichier `.pem` avec un éditeur de texte, copiez **TOUT** le contenu (y compris les lignes BEGIN et END) et collez-le ici.
4. `MYSQL_PASSWORD_TEST` : `admin123` (pour les tests unitaires de la CI).
