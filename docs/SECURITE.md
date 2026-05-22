# 🛡️ Guide de Sécurité - Les Saveurs du Jardin

Ce document explique de manière simple les mesures de sécurité mises en place pour protéger l'application et l'infrastructure du projet.

---

## 🔑 1. Gestion des Secrets et des Mots de Passe

Pour éviter que des personnes non autorisées accèdent à nos bases de données ou à nos outils, les secrets ne doivent **jamais** être écrits directement dans le code source ou envoyés sur GitHub.

### Le fichier `.env` (Local)
* **Rôle** : Contient les mots de passe et configurations de notre machine de développement.
* **Sécurité** : Ce fichier est listé dans le fichier `.gitignore`. Git l'ignore donc complètement et il reste uniquement sur votre ordinateur.
* **Fichier d'exemple** : Le fichier `docker/.env.example` sert de modèle pour les nouveaux développeurs. Il contient des valeurs vides ou fictives.

### Ansible Vault (Production)
Pour envoyer de manière sécurisée les mots de passe de production au serveur AWS, nous utilisons **Ansible Vault** :
* Ansible Vault permet de **chiffrer** (crypter) un fichier contenant les mots de passe avec une clé secrète.
* Le fichier chiffré s'appelle `secrets.yml` et ressemble à une suite de caractères incompréhensibles dans Git.
* Seule la personne possédant la clé de déchiffrement peut lire ou modifier ces mots de passe lors du déploiement.

---

## 🌐 2. Sécurisation du Réseau (Pare-feu AWS)

Sur AWS, nous limitons les accès extérieurs grâce au **Security Group** (le pare-feu de l'instance EC2). Il est configuré dans le code **Terraform** (`security_group.tf`) :

* **Ports ouverts au public** :
  * `80` (HTTP) & `443` (HTTPS) : Pour que les utilisateurs puissent visiter le site web.
* **Ports restreints (à sécuriser en production)** :
  * `22` (SSH) : Pour permettre aux développeurs et à GitHub Actions de configurer le serveur.
  * `3000` (Grafana) & `9090` (Prometheus) : Pour la supervision.
  * `8081` (Adminer) : Pour gérer la base de données.
* **Base de données isolée** : Le port de la base de données MySQL (`3306` interne / `3307` externe) n'est **pas ouvert** sur le pare-feu AWS. Personne ne peut s'y connecter directement depuis Internet.

---

## 🔒 3. HTTPS et Chiffrement des Communications

Toutes les connexions entre l'utilisateur et le site doivent être cryptées pour éviter le vol de données.

* **Nginx** sert de point d'entrée unique (Reverse Proxy).
* **Let's Encrypt** fournit des certificats SSL gratuits et officiels.
* **Redirection automatique** : Si un utilisateur tente de se connecter en HTTP (non sécurisé), Nginx le redirige automatiquement vers le protocole HTTPS (sécurisé).

---

## 🧪 4. Analyse des Vulnérabilités (Trivy)

Dans notre pipeline d'intégration continue (CI/CD) sur GitHub Actions :
* L'outil **Trivy** est exécuté automatiquement à chaque fois qu'on pousse du code.
* Il scanne l'image Docker de notre application pour détecter d'éventuelles failles de sécurité dans les packages installés.
* Si une faille critique est trouvée, le déploiement est bloqué afin d'éviter de mettre en production un conteneur vulnérable.

---

## 💻 5. Sécurité Applicative (Symfony)

L'application Symfony intègre par défaut plusieurs protections essentielles :

1. **Hachage des mots de passe** : Les mots de passe des utilisateurs sont chiffrés en base de données avec l'algorithme robuste **Argon2id**. Même si la base de données était volée, les mots de passe resteraient illisibles.
2. **Protection CSRF** : Protection contre les attaques de falsification de requêtes via des jetons de sécurité uniques insérés dans chaque formulaire de l'application.
3. **Contrôle d'accès (RBAC)** : Un système de rôles (ex: `ROLE_USER`, `ROLE_ADMIN`, `ROLE_LIVREUR`) contrôle précisément quelles pages chaque utilisateur a le droit de voir ou de modifier.
