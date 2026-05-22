# Architecture Technique - LSDJ

![Schéma d'Architecture Technique](./architecture_schema_visual.png)

## 1. Infrastructure Cloud (AWS)
L'infrastructure est provisionnée via **Terraform** sur AWS.

```mermaid
graph TD
  subgraph "Public Internet"
    User((Utilisateur))
    Discord[Discord Notification]
  end

  subgraph "AWS Cloud (eu-west-3)"
    subgraph "VPC (10.0.0.0/16)"
      subgraph "Public Subnet (10.0.1.0/24)"
        EC2["EC2 Instance (Docker Engine)"]
        
        subgraph "Docker Stack"
          NGINX["Nginx (Port 80 / 443)"]
          APP["Symfony App (PHP 8.2)"]
          DB_SVC["MySQL Container (Port 3307)"]
          
          subgraph "Monitoring & Alerting"
            PROM["Prometheus (9090)"]
            GRAF["Grafana (3000)"]
            AM["Alertmanager (9093)"]
            EXP["Exporters (Nginx, PHP, MySQL, Node)"]
          end
        end
      end
    end
  end

  User -->|HTTP:80 / HTTPS:443| NGINX
  NGINX --> APP
  APP -->|SQL:3306| DB_SVC
  
  EXP -->|Scrape| NGINX
  EXP -->|Scrape| APP
  EXP -->|Scrape| DB_SVC
  PROM -->|Scrape| EXP
  
  GRAF -->|Query| PROM
  PROM -->|Alerts| AM
  AM -->|Webhook| Discord
```

## 2. Pipeline CI/CD & Déploiement
Le flux de livraison est automatisé via **GitHub Actions**.

```mermaid
sequenceDiagram
  participant Dev as Développeur
  participant GH as GitHub Actions (CI/CD)
  participant AWS as Infrastructure Cloud (AWS)

  Dev->>GH: Git Push
  GH->>GH: PHP Security Check
  GH->>GH: Tests Unitaires (PHPUnit)
  GH->>GH: Build Docker Image (Stage: prod)
  GH->>GH: Scan de vulnérabilités (Trivy)
  GH->>AWS: Provisionnement (Terraform)
  GH->>AWS: Déploiement (Ansible)
  GH->>AWS: Configure (Ansible)
  GH->>AWS: Deploy Docker Compose
  AWS-->>Dev: Green Deployment
```

## 3. Système de Supervision
La pile de monitoring est hébergée sur l'EC2 via Docker.

*  **Prometheus** : Collecte les métriques (Scraping).
*  **Grafana** : Visualisation des données (Dashboards).
*  **Node Exporter** : Métriques système (CPU, Disque, RAM).
*  **Alerting** : Seuils critiques configurés (CPU > 80%, Disque > 90%).

