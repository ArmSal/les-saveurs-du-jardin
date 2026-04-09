# Architecture Technique - LSDJ

## 🏗️ 1. Infrastructure Cloud (AWS)
L'infrastructure est provisionnée via **Terraform** sur AWS.

```mermaid
graph TD
    subgraph "AWS Cloud (eu-west-3)"
        subgraph "VPC (10.0.0.0/16)"
            subgraph "Public Subnet (10.0.1.0/24)"
                EC2[EC2 Instance: lsj-server]
                SG_EC2[Security Group: allow 80, 22, 3000]
            end
            
            subgraph "Private Subnets (10.0.2.0/24)"
                RDS[(AWS RDS: PostgreSQL)]
                SG_RDS[Security Group: allow 5432 from EC2]
            end
        end
    end

    User((Utilisateur)) -->|Port 8080| EC2
    EC2 -->|SQL| RDS
```

## 🚀 2. Pipeline CI/CD & Déploiement
Le flux de livraison est automatisé via **GitHub Actions**.

```mermaid
sequenceDiagram
    participant Dev as Développeur
    participant GH as GitHub Actions
    participant AWS as Infrastructure AWS

    Dev->>GH: Git Push
    GH->>GH: PHP Syntax & Security Check
    GH->>GH: Unit & Functional Tests (PHPUnit)
    GH->>GH: Build Docker Image
    GH->>GH: Vulnerability Scan (Trivy)
    GH->>AWS: Provision (Terraform)
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
