# CAHIER DES CHARGES - PORTAIL LSDJ

**Version:** 1.0  
**Date:** Avril 2026  
**Projet:** Portail de Gestion Multi-Magasin  
**Technologie:** Symfony 6/7, PHP 8, MySQL, TailwindCSS

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

---

## 1. PRÉSENTATION DU PROJET

### 1.1 Contexte
Le Portail LSDJ est une plateforme web interne de gestion multi-magasin permettant la gestion centralisée des ressources humaines, des commandes, du catalogue produits et des documents pour l'entreprise LSDJ.

### 1.2 Objectifs
- Centraliser la gestion des employés et des magasins
- Gérer les commandes clients et internes
- Administrer le catalogue produits avec photos
- Gérer les congés et les horaires de travail
- Gérer les documents RH avec signature électronique
- Fournir un système de notifications en temps réel
- Implémenter un contrôle d'accès granulaire par rôle et par magasin

### 1.3 Périmètre
**Utilisateurs concernés:**
- Directeur (accès total)
- Responsables de magasin (accès magasin uniquement)
- Employés (accès personnel)
- Clients externes (commandes)

---

## 2. ARCHITECTURE TECHNIQUE

### 2.1 Stack Technique
| Composant | Technologie |
|-----------|-------------|
| Framework Backend | Symfony 6/7 (PHP 8.2+) |
| Base de données | MySQL 8.0 |
| ORM | Doctrine |
| Frontend | Twig + TailwindCSS |
| Authentification | Symfony Security |
| Pagination | KnpPaginatorBundle |
| Génération PDF | Dompdf |
| Gestion de fichiers | Symfony Filesystem |

### 2.2 Structure des Répertoires
```
portal/
├── bin/                    # Scripts et commandes
├── config/                 # Configuration Symfony
├── migrations/            # Migrations Doctrine
├── public/                # Point d'entrée web
├── src/
│   ├── Controller/       # Contrôleurs 
│   ├── Entity/          # Entités
│   ├── Form/            # Formulaires
│   ├── Repository/      # Repositories
│   ├── Service/         # Services métier
│   └── Security/        # Voters et sécurité
├── templates/           # Templates Twig
├── storage/            # Fichiers uploadés
│   ├── documents/
│   ├── documents_rh/
│   ├── products/
│   ├── shortcuts/
│   └── users/
└── var/                # Cache et logs
```

---

## 3. MODULES FONCTIONNELS

### 3.1 Module Authentification & Sécurité
**Entités:** `User`, `Role`, `Magasin`, `ModulePermission`, `Article`, `Commande`,`Conge`, `Horaire`, 

**Fonctionnalités:**
- Authentification email/mot de passe
- Gestion des rôles hiérarchiques (Directeur, Responsable, Employé)
- Gestion multi-magasin
- Permissions granulaires par module (6 niveaux d'accès)
- Numéro client unique généré automatiquement
- Photo de profil et signature électronique

### 3.2 Module Dashboard
**Contrôleur:** `DashboardController`

**Fonctionnalités:**
- Vue d'ensemble des commandes actives
- Calcul du chiffre d'affaires total
- Statistiques des employés (travaillent/absents)
- Liste des commandes récentes
- Liste des employés en congé
- Raccourcis personnalisables
- Sélecteur de semaines pour rapports

### 3.3 Module Agenda (Planning)


**Fonctionnalités:**
- Vue calendrier des horaires de travail
- Création/modification/suppression des plages horaires
- Codes couleur par employé
- Verrouillage des horaires validés
- Filtre par magasin
- Vue quotidienne, hebdomadaire, mensuelle

### 3.4 Module RH - Congés

**Fonctionnalités:**
- **Employé:**
  - Demande de congé (date début/fin, type, commentaire)
  - Suivi des demandes (En attente, Modifiée, Acceptée)
  - Historique personnel des congés
  
- **Manager:**
  - Validation/Rejet des demandes avec signature
  - Modification des dates avec notification
  - Calcul des jours payés/non payés
  - Statistiques par magasin
  - Gestion des différents types de congés
  - Export PDF des validations

**Workflow de validation:**
```
PENDING → MODIFIED → ACCEPTED_BY_EMPLOYEE → APPROVED
       → REJECTED
       → CANCELLED
```

### 3.5 Module RH - Validation Mensuelle

**Fonctionnalités:**
- Validation mensuelle des horaires par employé
- Signature électronique avec timestamp
- Génération de PDF de validation
- Historique des validations mensuelles
- Vue récapitulative par semaine et par mois

### 3.6 Module Produits

**Fonctionnalités:**
- CRUD complet des produits
- Gestion des catégories
- Upload de photos produits
- Recherche par référence, code-barre, désignation
- Filtrage par catégorie
- Tri multi-colonnes
- Gestion du stock (quantité)
- Prix et TVA
- Pagination (20 éléments/page)

**Champs produit:**
- Référence, Code-barre, Désignation
- Unité, Catégorie, Prix, TVA
- Quantité stock, Description, Image

### 3.7 Module Commandes

**Fonctionnalités:**
- **Panier d'achat:**
  - Ajout/Suppression/Modification des quantités
  - Session-based (non persistant)
  
- **Commandes:**
  - Création de commande depuis le panier
  - Statuts: En attente, Modifiée, Confirmée, En préparation, Préparée, Livrée, Archivée, Annulée
  - Historique des changements de statut
  - Suivi des commandes avec lien unique
  - Filtrage par statut et par magasin
  - Notifications automatiques

### 3.8 Module Documents

**Fonctionnalités:**
- Gestion hiérarchique avec dossiers
- Upload de documents (PDF, images, etc.)
- Permissions par rôle sur les documents
- Documents globaux vs documents personnels
- **Documents RH spécifiques:**
  - Contrats avec demande de signature
  - Signature électronique intégrée
  - Statut de signature (En attente, Signé)
  - Envoi ciblé par employé

### 3.9 Module Notifications

**Fonctionnalités:**
- Système de notification en temps réel
- Types: NEW_PRODUCT, ORDER_STATUS, CONGE, etc.
- Badge de notification non lue
- Liste des notifications avec lien vers l'élément concerné
- Marquage comme lu

### 3.10 Module Paramètres

**Fonctionnalités:**
- Gestion des raccourcis (création, ordre d'affichage)
- Configuration des couleurs du calendrier
- Gestion de la signature électronique
- Upload de photo de profil

---

## 4. SYSTÈME DE PERMISSIONS

### 4.1 Niveaux d'Accès
Le système implémente 6 niveaux d'accès par module:

| Niveau | Code | Description |
|--------|------|-------------|
| Aucun accès | `AUCUN_ACCES` | Module invisible |
| Accès Personnel | `ACCES_PERSONNEL` | Accès aux données personnelles uniquement |
| Lecture Magasin | `LECTURE_MAGASIN` | Lecture données du magasin |
| Lecture Totale | `LECTURE_TOTALE` | Lecture tous les magasins |
| Admin Magasin | `ADMIN_MAGASIN` | CRUD sur son magasin |
| Accès Total | `ACCES_TOTAL` | CRUD sur tous les magasins |

### 4.2 Modules Protégés
- `dashboard` - Tableau de bord
- `agenda` - Planning horaires
- `rh_validation` - Validation mensuelle RH
- `rh_conge` - Gestion des congés
- `rh_documents` - Documents RH
- `documents` - Documents généraux
- `produits` - Catalogue produits
- `commandes` - Gestion des commandes
- `users` - Gestion des utilisateurs
- `shortcuts` - Raccourcis personnalisés
- `access_management` - Gestion des accès

### 4.3 Logique d'Accès
- **Directeur:** ACCES_TOTAL sur tous les modules
- **Responsable Magasin:** ADMIN_MAGASIN ou LECTURE_MAGASIN sur son magasin
- **Employé:** ACCES_PERSONNEL sur les modules RH, LECTURE sur produits/commandes

---

## 5. MODÈLE DE DONNÉES

### 5.1 Entités Principales

## 6. INTERFACES UTILISATEUR

### 6.1 Structure des Templates

```
templates/
├── base.html.twig           # Layout principal avec navigation
├── admin/                   # Administration
│   ├── users/
│   ├── roles/
│   └── permissions/
├── agenda/                  # Planning
│   ├── index.html.twig
│   ├── _calendar_views/
│   └── _modals/
├── dashboard/               # Tableau de bord
│   └── index.html.twig
├── produit/               # Catalogue
│   ├── index.html.twig
│   ├── new.html.twig
│   ├── edit.html.twig
│   ├── show.html.twig
│   └── categories/
├── cart/                    # Panier
│   └── index.html.twig
├── commande/               # Commandes
│   ├── index.html.twig
│   ├── show.html.twig
│   └── mes_commandes.html.twig
├── rh/                     # Ressources Humaines
│   ├── conge.html.twig
│   ├── validation.html.twig
│   ├── documents.html.twig
│   └── suivi.html.twig
├── document/               # Documents
│   ├── index.html.twig
│   ├── upload.html.twig
│   └── signer.html.twig
├── notification/          # Notifications
│   └── index.html.twig
├── settings/              # Paramètres
│   └── index.html.twig
├── security/              # Authentification
│   └── login.html.twig
└── static/                # Pages statiques
    ├── home.html.twig
    ├── about.html.twig
    └── contact.html.twig
```

### 6.2 Composants UI Communs
- **Navigation:** Sidebar responsive avec menu collapsible
- **Header:** Notifications, profil utilisateur, recherche
- **Tableaux:** Tri, filtrage, pagination intégrés
- **Formulaires:** Validation côté client et serveur
- **Modales:** Création/édition sans changement de page
- **Flash Messages:** Notifications de succès/erreur

---

## 7. FONCTIONNALITÉS DÉTAILLÉES

### 7.1 Gestion des Accès (AccessHelper)
Le service `AccessHelper` fournit les méthodes suivantes:
- `canView`
- `canEdit`
- `isFullAccess`
- `isMagasinOnly`
- `isFullView`

### 7.2 Workflow des Congés
1. Employé soumet une demande (PENDING)
2. Manager consulte et peut:
   - Approuver directement (APPROVED)
   - Rejeter (REJECTED)
   - Modifier les dates (MODIFIED)
3. Si modifié, employé accepte (ACCEPTED_BY_EMPLOYEE)
4. Manager approuve finalement (APPROVED)
5. Signature électronique et génération PDF

### 7.3 Workflow des Commandes
```
En attente → Modifiée → Confirmée → En préparation → Préparée → Livrée → Archivée
        ↓
     Annulée
```

### 7.4 Gestion des Fichiers
**Stockage:**
- `storage/products/` - Images produits
- `storage/documents/` - Documents généraux
- `storage/documents_rh/` - Documents RH (contrats...)
- `storage/users/` - Photos de profil
- `storage/shortcuts/` - Icônes de raccourcis

**Sécurité:**
- Vérification des extensions autorisées
- Renommage des fichiers (slug + uniqid)
- Permissions lecture/écriture contrôlées

### 7.5 Notifications Automatiques
Déclenchées par:
- Création d'un nouveau produit
- Changement de statut de commande
- Réponse à une demande de congé
- Envoi d'un document à signer

---

## 8. CONTRAINTES ET PRÉREQUIS

### 8.1 Contraintes Techniques
- PHP 8.2 ou supérieur
- MySQL 8.0 ou MariaDB 10.6+
- Extensions PHP: PDO, GD/Imagick, mbstring, xml
- Serveur web: Apache 2.4+ ou Nginx
- Mémoire: Minimum 256MB (512MB recommandé)

### 8.2 Contraintes de Sécurité
- Authentification obligatoire pour tous les modules (sauf public)
- CSRF protection sur tous les formulaires
- Mots de passe hashés (bcrypt)
- Upload de fichiers contrôlé et limité
- Permissions d'accès vérifiées à chaque requête

### 8.3 Prérequis Déploiement
- Document root pointant sur `public/`
- Répertoire `var/` writable par le serveur web
- Répertoire `storage/` writable par le serveur web
- Base de données créée avec charset utf8mb4

### 8.4 Configuration Requise (.env)
```env
APP_ENV=prod
APP_SECRET=<clé_secrète_32_caractères>
DATABASE_URL="mysql://user:pass@host:3306/dbname?serverVersion=8.0&charset=utf8mb4"
MAILER_DSN=null://null
```

**Fin du Cahier des Charges**
