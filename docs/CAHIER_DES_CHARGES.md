# CAHIER DES CHARGES - PORTAIL LSDJ

**Version:** 1.1  
**Date:** Avril 2026  
**Projet:** Portail de Gestion Multi-Magasin  
**Technologie:** Symfony 7, PHP 8.2, PostgreSQL 16, TailwindCSS, Docker

---

## TABLE DES MATIÈRES

1. [Présentation du Projet](#1-présentation-du-projet)
2. [Architecture Technique](#2-architecture-technique)
3. [Modules Fonctionnels](#3-modules-fonctionnels)
4. [Système de Permissions](#4-système-de-permissions)
5. [Modèle de Données](#5-modèle-de-données)
6. [Interfaces Utilisateur](#6-interfaces-utilisateur)
7. [Fonctionnalités Détaillées](#7-fonctionnalités-détaillées)
8. [Contraintes et Prérequis](#8-contraintes-et-prérequis)
9. [Infrastructure et Déploiement (DevOps)](#9-infrastructure-et-déploiement-devops)

---

## 2. ARCHITECTURE TECHNIQUE

### 2.1 Stack Technique
| Composant | Technologie |
|-----------|-------------|
| Framework Backend | Symfony 7 (PHP 8.2+) |
| Base de données | PostgreSQL 16 |
| ORM | Doctrine (DBAL/ORM) |
| Frontend | Twig + TailwindCSS |
| Authentification | Symfony Security |
| Infrastructure | AWS (EC2, RDS, VPC, S3) |
| DevOps | Terraform, Ansible, Docker |
| Supervision | Prometheus & Grafana |

---

## 8. CONTRAINTES ET PRÉREQUIS

### 8.1 Contraintes Techniques
- PHP 8.2 ou supérieur
- PostgreSQL 16
- Extensions PHP: PDO, GD/Imagick, mbstring, xml, pdo_pgsql
- Serveur web: Nginx (Containerisé)
- Mémoire: Minimum 512MB (AWS t3.micro eligible)

### 8.3 Prérequis Déploiement
- Docker Engine & Docker Compose Plugin installés
- AWS CLI configuré pour le provisionnement Terraform
- SSH Agent avec clé privée pour Ansible

### 8.4 Configuration Requise (.env)
```env
APP_ENV=prod
APP_SECRET=<secret_local_uniquement>
DATABASE_URL="postgresql://dbadmin:admin123@lsj-rds-endpoint:5432/lsj_db?serverVersion=16&charset=utf8"
```

---

## 9. INFRASTRUCTURE ET DÉPLOIEMENT (DEVOPS)

### 9.1 Architecture Cloud (BC01)
L'infrastructure est hébergée sur **AWS** et entièrement gérée en **Infrastructure as Code (IaC)**.

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

### 9.2 Cycle de Vie et CI/CD
Chaque modification du code déclenche un pipeline automatisé :

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

---

**Fin du Cahier des Charges**
