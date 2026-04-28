# CAHIER DES CHARGES - PORTAIL LSDJ (Enterprise Edition)

**Version:** 2.1  
**Date:** Avril 2026  
**Projet:** Portail de Gestion ERP Multi-Magasin  
**Technologie:** Symfony 7.4 LTS (PHP 8.2), MySQL 8.0, TailwindCSS, Docker, Prometheus, Grafana

---

## TABLE DES MATIÈRES

1. [PRÉSENTATION DU PROJET](#1-présentation-du-projet)
2. [ARCHITECTURE TECHNIQUE & DEVOPS](#2-architecture-technique--devops)
3. [MODULES FONCTIONNELS MÉTIERS](#3-modules-fonctionnels-métiers)
4. [SYSTÈME DE PERMISSIONS (RBAC)](#4-système-de-permissions-rbac)
5. [MODÈLE DE DONNÉES & ENTITÉS](#5-modèle-de-données--entités)
6. [INTERFACES UTILISATEUR & UI/UX](#6-interfaces-utilisateur--uiux)
7. [ÉCOSYSTÈME DE DÉPLOIEMENT (CI/CD)](#7-écosystème-de-déploiement-cicd)
8. [CONTRAINTES DE SÉCURITÉ & PERFORMANCE](#8-contraintes-de-sécurité--performance)

---

## 1. PRÉSENTATION DU PROJET

### 1.1 Contexte
Le Portail **Les Saveurs Du Jardin (LSDJ)** est une solution ERP centralisée conçue pour optimiser la gestion opérationnelle d'une entreprise multisite. Il répond aux besoins critiques de coordination entre les magasins physiques et la direction centrale.

### 1.2 Objectifs Stratégiques
- **Centralisation** : Unifier la gestion RH et logistique sur une plateforme unique.
- **Transparence** : Permettre un suivi en temps réel des commandes et des plannings.
- **Conformité** : Garantir la validité légale des documents via la signature électronique.
- **Observabilité** : Monitorer l'état de santé de l'infrastructure pour garantir une haute disponibilité.

### 1.3 Périmètre Utilisateurs
Le système gère quatre types de profils avec des vues différenciées :
- **Directeur (Admin)** : Accès global stratégique.
- **Responsables de Magasin** : Gestion opérationnelle du site rattaché.
- **Employés** : Consultation des ressources personnelles (horaires, documents).
- **Clients/Utilisateurs Externes** : Interaction limitée via le catalogue et les commandes.

---

## 2. ARCHITECTURE TECHNIQUE & DEVOPS

### 2.1 Stack Technologique Professionnelle
| Composant | Technologie | Rôle |
|-----------|-------------|------|
| **Backend** | Symfony 7.4 LTS (PHP 8.2.30) | Logique métier et API |
| **Base de données** | MySQL 8.0 | Stockage relationnel persistant |
| **Infrastructure** | Docker & Docker Compose | Conteneurisation des services |
| **Serveur Web** | Nginx | Reverse proxy et gestion des assets |
| **Supervision** | Prometheus & Grafana | Monitoring et Alerting (BC03) |
| **Frontend** | Twig + Tailwind CSS | Interface réactive et moderne |

### 2.2 Structure des Répertoires (Standard Symfony)
```text
portal/
├── bin/                    # Scripts console et utilitaires
├── config/                 # Configuration du framework et des bundles
├── docker/                 # Configurations Nginx, Prometheus et PHP
├── migrations/             # Historique des évolutions de base de données
├── public/                 # Point d'entrée web (index.php, CSS, JS)
├── src/
│   ├── Controller/         # Contrôleurs métiers (20 contrôleurs)
│   ├── Entity/             # Modèles de données (23 entités)
│   ├── Service/            # Logique transverse (AccessHelper, etc.)
│   └── Security/           # Gestion de l'authentification et des Voters
├── templates/              # Vues Twig organisées par module
└── compose.yaml            # Définition de l'infrastructure Docker
```

---

## 3. MODULES FONCTIONNELS MÉTIERS

### 3.1 Module RH - Plannings & Horaires
- **Planning Dynamique** : Vue calendrier interactive avec codes couleurs par employé.
- **Validation Mensuelle** : Processus de verrouillage des heures en fin de mois avec signature.
- **Export Reporting** : Génération automatique de rapports PDF professionnels pour la comptabilité.

### 3.2 Module RH - Gestion des Congés
- **Workflow de Demande** : Système de soumission avec statut (En attente, Modifié, Validé).
- **Circuit de Signature** : Validation par le manager déclenchant une signature numérique.
- **Calculateur** : Décompte automatique des jours payés et non payés.

### 3.3 Module Logistique - Ventes & Commandes
- **Catalogue Centralisé** : Gestion des stocks et des tarifs par catégorie.
- **Panier & Commandes** : Tunnel d'achat optimisé pour les commandes internes/externes.
- **Suivi en temps réel** : Workflow de statut (Préparation, Livraison, Archivage).

### 3.4 Module Logistique - Transport & Maintenance
- **Flotte Camion** : Suivi de l'immatriculation et de l'état des véhicules.
- **Maintenance Magasin** : Gestion des tâches de nettoyage et de maintenance technique.

### 3.5 Module Gestion Documentaire (Coffre-fort)
- **Structure Hiérarchique** : Organisation par dossiers avec permissions granulaires.
- **Signature Électronique** : Intégration légale pour les contrats et avenants.

---

## 4. SYSTÈME DE PERMISSIONS (RBAC)

Le portail implémente un modèle de sécurité granulaire unique basé sur 6 niveaux d'accès :

| Niveau | Code | Portée |
|--------|------|--------|
| **Aucun** | `AUCUN_ACCES` | Module invisible pour l'utilisateur. |
| **Personnel** | `ACCES_PERSONNEL` | Accès limité à ses propres données. |
| **Lecture Site** | `LECTURE_MAGASIN` | Consultation des données d'un seul magasin. |
| **Lecture Globale** | `LECTURE_TOTALE` | Consultation de l'ensemble du groupe. |
| **Gestion Site** | `ADMIN_MAGASIN` | CRUD sur les données de son propre magasin. |
| **Super Admin** | `ACCES_TOTAL` | Contrôle total sur l'ensemble du portail. |

---

## 5. MODÈLE DE DONNÉES & ENTITÉS

### 5.1 Entités Cœurs
- **Utilisateurs** : `User`, `Role`, `ModulePermission`.
- **RH** : `PortalHoraire`, `PortalConge`, `PortalMonthlyValidation`, `UserObservation`.
- **Logistique** : `PortalProduct`, `PortalCommandes`, `TransEtLog`, `CleaningTask`.
- **Infrastructure** : `ObservationMonthLock`, `PortalWeekLock`.

---

## 6. INTERFACES UTILISATEUR & UI/UX

L'interface a été conçue pour offrir une expérience "Premium" :
- **Modernisme** : Utilisation de la police *Plus Jakarta Sans* et design épuré Tailwind.
- **Interactivité** : Micro-animations CSS, loaders personnalisés et feedbacks par "Toasts".
- **Responsive** : Adaptation totale aux terminaux mobiles pour les employés sur le terrain.

---

## 7. ÉCOSYSTÈME DE DÉPLOIEMENT (CI/CD)

Conformément aux exigences du titre **DevOps**, le projet inclut :
- **Automatisation CI** : Pipeline GitHub Actions pour le linting, les tests unitaires et le build Docker.
- **Security Scans** : Audit automatique des vulnérabilités PHP (Symfony Security Check).
- **Continuous Deployment** : Préparation au déploiement via Terraform (Infrastructure) et Ansible (Configuration).

---

## 8. CONTRAINTES DE SÉCURITÉ & PERFORMANCE

- **Protection CSRF** : Active sur l'ensemble des formulaires métiers.
- **Hachage Sécurisé** : Utilisation de l'algorithme Argon2id pour les mots de passe.
- **Optimisation Performance** : Mise en cache Symfony et compression des assets via Nginx.
- **Supervision (BC03)** : Collecte de métriques (CPU, RAM, temps de réponse) pour l'alerting proactif.

---
**Document révisé - Avril 2026**
