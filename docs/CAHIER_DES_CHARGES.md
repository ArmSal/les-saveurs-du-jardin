# CAHIER DES CHARGES - PORTAIL LSDJ (Enterprise Edition)

**Version:** 2.1 
**Date:** Avril 2026 
**Projet:** Portail de Gestion ERP Multi-Magasin 
**Technologie:** Symfony 7.4 LTS (PHP 8.2), MySQL 8.0, TailwindCSS, Docker, Prometheus, Grafana

---

## TABLE DES MATIÃˆRES

1. [PRÃ‰SENTATION DU PROJET](#1-prÃ©sentation-du-projet)
2. [ARCHITECTURE TECHNIQUE & INFRASTRUCTURE](#2-architecture-technique--infrastructure)
3. [MODULES FONCTIONNELS MÃ‰TIERS](#3-modules-fonctionnels-mÃ©tiers)
4. [SYSTÃˆME DE PERMISSIONS (RBAC)](#4-systÃ¨me-de-permissions-rbac)
5. [MODÃˆLE DE DONNÃ‰ES & ENTITÃ‰S](#5-modÃ¨le-de-donnÃ©es--entitÃ©s)
6. [INTERFACES UTILISATEUR & UI/UX](#6-interfaces-utilisateur--uiux)
7. [Ã‰COSYSTÃˆME DE DÃ‰PLOIEMENT (CI/CD)](#7-Ã©cosystÃ¨me-de-dÃ©ploiement-cicd)
8. [CONTRAINTES DE SÃ‰CURITÃ‰ & PERFORMANCE](#8-contraintes-de-sÃ©curitÃ©--performance)

---

## 1. PRÃ‰SENTATION DU PROJET

### 1.1 Contexte
Le Portail **Les Saveurs Du Jardin (LSDJ)** est une solution ERP centralisÃ©e conÃ§ue pour optimiser la gestion opÃ©rationnelle d'une entreprise multisite. Il rÃ©pond aux besoins critiques de coordination entre les magasins physiques et la direction centrale.

### 1.2 Objectifs StratÃ©giques
- **Centralisation** : Unifier la gestion RH et logistique sur une plateforme unique.
- **Transparence** : Permettre un suivi en temps rÃ©el des commandes et des plannings.
- **ConformitÃ©** : Garantir la validitÃ© lÃ©gale des documents via la signature Ã©lectronique.
- **ObservabilitÃ©** : Monitorer l'Ã©tat de santÃ© de l'infrastructure pour garantir une haute disponibilitÃ©.

### 1.3 PÃ©rimÃ¨tre Utilisateurs
Le systÃ¨me gÃ¨re quatre types de profils avec des vues diffÃ©renciÃ©es :
- **Directeur (Admin)** : AccÃ¨s global stratÃ©gique.
- **Responsables de Magasin** : Gestion opÃ©rationnelle du site rattachÃ©.
- **EmployÃ©s** : Consultation des ressources personnelles (horaires, documents).
- **Clients/Utilisateurs Externes** : Interaction limitÃ©e via le catalogue et les commandes.

---

## 2. ARCHITECTURE TECHNIQUE & INFRASTRUCTURE

### 2.1 Stack Technologique Professionnelle
| Composant | Technologie | RÃ´le |
|-----------|-------------|------|
| **Backend** | Symfony 7.4 LTS (PHP 8.2.30) | Logique mÃ©tier et API |
| **Base de donnÃ©es** | MySQL 8.0 | Stockage relationnel persistant |
| **Infrastructure** | Docker & Docker Compose | Conteneurisation des services |
| **Serveur Web** | Nginx | Reverse proxy et gestion des assets |
| **Supervision** | Prometheus & Grafana | Monitoring et Alerting |
| **Frontend** | Twig + Tailwind CSS | Interface rÃ©active et moderne |

### 2.2 Structure des RÃ©pertoires (Standard Symfony)
```text
portal/
â”œâ”€â”€ bin/          # Scripts console et utilitaires
â”œâ”€â”€ config/         # Configuration du framework et des bundles
â”œâ”€â”€ docker/         # Configurations Nginx, Prometheus et PHP
â”œâ”€â”€ migrations/       # Historique des Ã©volutions de base de donnÃ©es
â”œâ”€â”€ public/         # Point d'entrÃ©e web (index.php, CSS, JS)
â”œâ”€â”€ src/
â”‚  â”œâ”€â”€ Controller/     # ContrÃ´leurs mÃ©tiers (20 contrÃ´leurs)
â”‚  â”œâ”€â”€ Entity/       # ModÃ¨les de donnÃ©es (23 entitÃ©s)
â”‚  â”œâ”€â”€ Service/      # Logique transverse (AccessHelper, etc.)
â”‚  â””â”€â”€ Security/      # Gestion de l'authentification et des Voters
â”œâ”€â”€ templates/       # Vues Twig organisÃ©es par module
â””â”€â”€ compose.yaml      # DÃ©finition de l'infrastructure Docker
```

---

## 3. MODULES FONCTIONNELS MÃ‰TIERS

### 3.1 Module RH - Plannings & Horaires
- **Planning Dynamique** : Vue calendrier interactive avec codes couleurs par employÃ©.
- **Validation Mensuelle** : Processus de verrouillage des heures en fin de mois avec signature.
- **Export Reporting** : GÃ©nÃ©ration automatique de rapports PDF professionnels pour la comptabilitÃ©.

### 3.2 Module RH - Gestion des CongÃ©s
- **Workflow de Demande** : SystÃ¨me de soumission avec statut (En attente, ModifiÃ©, ValidÃ©).
- **Circuit de Signature** : Validation par le manager dÃ©clenchant une signature numÃ©rique.
- **Calculateur** : DÃ©compte automatique des jours payÃ©s et non payÃ©s.

### 3.3 Module Logistique - Ventes & Commandes
- **Catalogue CentralisÃ©** : Gestion des stocks et des tarifs par catÃ©gorie.
- **Panier & Commandes** : Tunnel d'achat optimisÃ© pour les commandes internes/externes.
- **Suivi en temps rÃ©el** : Workflow de statut (PrÃ©paration, Livraison, Archivage).

### 3.4 Module Logistique - Transport & Maintenance
- **Flotte Camion** : Suivi de l'immatriculation et de l'Ã©tat des vÃ©hicules.
- **Maintenance Magasin** : Gestion des tÃ¢ches de nettoyage et de maintenance technique.

### 3.5 Module Gestion Documentaire (Coffre-fort)
- **Structure HiÃ©rarchique** : Organisation par dossiers avec permissions granulaires.
- **Signature Ã‰lectronique** : IntÃ©gration lÃ©gale pour les contrats et avenants.

---

## 4. SYSTÃˆME DE PERMISSIONS (RBAC)

Le portail implÃ©mente un modÃ¨le de sÃ©curitÃ© granulaire unique basÃ© sur 6 niveaux d'accÃ¨s :

| Niveau | Code | PortÃ©e |
|--------|------|--------|
| **Aucun** | `AUCUN_ACCES` | Module invisible pour l'utilisateur. |
| **Personnel** | `ACCES_PERSONNEL` | AccÃ¨s limitÃ© Ã  ses propres donnÃ©es. |
| **Lecture Site** | `LECTURE_MAGASIN` | Consultation des donnÃ©es d'un seul magasin. |
| **Lecture Globale** | `LECTURE_TOTALE` | Consultation de l'ensemble du groupe. |
| **Gestion Site** | `ADMIN_MAGASIN` | CRUD sur les donnÃ©es de son propre magasin. |
| **Super Admin** | `ACCES_TOTAL` | ContrÃ´le total sur l'ensemble du portail. |

---

## 5. MODÃˆLE DE DONNÃ‰ES & ENTITÃ‰S

### 5.1 EntitÃ©s CÅ“urs
- **Utilisateurs** : `User`, `Role`, `ModulePermission`.
- **RH** : `PortalHoraire`, `PortalConge`, `PortalMonthlyValidation`, `UserObservation`.
- **Logistique** : `PortalProduct`, `PortalCommandes`, `TransEtLog`, `CleaningTask`.
- **Infrastructure** : `ObservationMonthLock`, `PortalWeekLock`.

---

## 6. INTERFACES UTILISATEUR & UI/UX

L'interface a Ã©tÃ© conÃ§ue pour offrir une expÃ©rience "Premium" :
- **Modernisme** : Utilisation de la police *Plus Jakarta Sans* et design Ã©purÃ© Tailwind.
- **InteractivitÃ©** : Micro-animations CSS, loaders personnalisÃ©s et feedbacks par "Toasts".
- **Responsive** : Adaptation totale aux terminaux mobiles pour les employÃ©s sur le terrain.

---

## 7. Ã‰COSYSTÃˆME DE DÃ‰PLOIEMENT (CI/CD)

ConformÃ©ment aux standards de production, le projet inclut :
- **Automatisation CI** : Pipeline GitHub Actions pour le linting, les tests unitaires et le build Docker.
- **Security Scans** : Audit automatique des vulnÃ©rabilitÃ©s PHP (Symfony Security Check).
- **Continuous Deployment** : PrÃ©paration au dÃ©ploiement via Terraform (Infrastructure) et Ansible (Configuration).

---

## 8. CONTRAINTES DE SÃ‰CURITÃ‰ & PERFORMANCE

- **Protection CSRF** : Active sur l'ensemble des formulaires mÃ©tiers.
- **Hachage SÃ©curisÃ©** : Utilisation de l'algorithme Argon2id pour les mots de passe.
- **Optimisation Performance** : Mise en cache Symfony et compression des assets via Nginx.
- **Supervision** : Collecte de mÃ©triques (CPU, RAM, temps de rÃ©ponse) pour l'alerting proactif.

---
**Document rÃ©visÃ© - Avril 2026**

