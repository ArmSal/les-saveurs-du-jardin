# Architecture Technique - LSDJ

## 🏗️ 1. Infrastructure Cloud (AWS)
L'infrastructure est provisionnée via **Terraform** sur AWS.

```mermaid
graph TD
    subgraph "AWS Cloud (eu-west-3)"
        subgraph "VPC (10.0.0.0/16)"
            subgraph "Public Subnet (10.0.1.0/24)"
                EC2["EC2 Instance (Docker Engine)"]
                NGINX["Nginx Container (Port 8080)"]
                APP["Symfony App (PHP 8.2)"]
                PROM["Prometheus (Monitoring)"]
                GRAF["Grafana (Dashboards)"]
            end
            
            subgraph "Private Subnets (10.0.2.0/24)"
                DB[(AWS RDS: MySQL 8.0)]
                SG_RDS["Security Group (allow 3306 from EC2)"]
            end
        end
    end

    User((Utilisateur)) -->|Port 8080| NGINX
    NGINX --> APP
    APP -->|SQL| DB
    PROM -->|Metrics| APP
    PROM -->|Metrics| EC2
    GRAF -->|Visualize| PROM
```

## 🚀 2. Pipeline CI/CD & Déploiement
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
    AWS-->>Dev: Green Deployment ✅
```

## 📊 3. Système de Supervision (BC03)
La pile de monitoring est hébergée sur l'EC2 via Docker.

*   **Prometheus** : Collecte les métriques (Scraping).
*   **Grafana** : Visualisation des données (Dashboards).
*   **Node Exporter** : Métriques système (CPU, Disque, RAM).
*   **Alerting** : Seuils critiques configurés (CPU > 80%, Disque > 90%).
