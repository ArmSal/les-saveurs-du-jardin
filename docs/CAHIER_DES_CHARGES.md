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
- **Réseau** : VPC personnalisé avec subnet public (Serveur App) et subnets privés (Base de données RDS).
- **Gestion d'état** : Utilisation d'un bucket **AWS S3** pour le stockage distant du `terraform.tfstate`.
- **Sécurité** : Groupes de sécurité (Security Groups) limitant les flux entrants au strict nécessaire (80, 443, 22).

### 9.2 Provisionnement et Configuration
- **Terraform** : Provisionnement des ressources AWS (VPC, EC2, RDS).
- **Ansible** : Configuration post-installation du serveur (installation Docker, sécurisation OS, fail2ban).

### 9.3 Supervision et Alerting (BC03)
La plateforme est monitorée en temps réel via une stack **Prometheus & Grafana**.
- **Indicateurs clés (KPIs)** :
  - Charge CPU (Alerte si > 80%)
  - Espace Disque (Alerte si > 90%)
  - Temps de réponse PHP-FPM (Alerte si > 2s)

### 9.4 Cycle de Vie et CI/CD
Chaque modification du code déclenche un pipeline automatisé :
1. **Tests** : Validation syntaxique, sécurité et tests fonctionnels (WebTestCase).
2. **Docker Security** : Scan de vulnérabilités via **Trivy**.
3. **Build** : Création de l'image Docker optimisée pour la production.

---

**Fin du Cahier des Charges**
