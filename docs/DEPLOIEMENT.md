# 🚀 Guide de Déploiement - Les Saveurs du Jardin

Ce guide explique étape par étape comment déployer l'application et l'infrastructure, du provisionnement initial à la vérification finale.

---

## 📋 Prérequis généraux

Avant de commencer, assurez-vous d'avoir :
1. Un compte **AWS** actif.
2. Une paire de clés SSH créée sur AWS nommée `lsdj` (téléchargez le fichier `lsdj.pem` et placez-le à la racine du projet).
3. **Docker Desktop** et **Git** installés sur votre machine locale.

---

## 🛠️ Étape 1 : Provisionnement avec Terraform

Terraform va créer automatiquement la machine virtuelle (EC2) sur AWS avec le bon système d'exploitation et les ports réseau ouverts.

1. Allez dans le dossier `terraform/` :
   ```bash
   cd terraform
   ```
2. Initialisez Terraform (télécharge le connecteur AWS) :
   ```bash
   terraform init
   ```
3. Créez l'infrastructure :
   ```bash
   terraform apply
   ```
   *Tapez `yes` lorsque le terminal vous le demande.*
4. Notez l'adresse IP publique affichée à la fin du processus (ex: `35.180.116.20`).

---

## ⚙️ Étape 2 : Configuration du serveur avec Ansible

Ansible va installer Docker et configurer le serveur distant automatiquement.

1. Ouvrez le fichier d'inventaire d'Ansible `ansible/inventory/hosts.ini` et remplacez l'adresse IP par celle affichée par Terraform :
   ```ini
   [webservers]
   35.180.116.20 ansible_user=ubuntu ansible_ssh_private_key_file=../lsdj.pem
   ```
2. Allez dans le dossier `ansible/` :
   ```bash
   cd ansible
   ```
3. Lancez le playbook de configuration :
   ```bash
   ansible-playbook -i inventory/hosts.ini playbook.yml
   ```

---

## 🔄 Étape 3 : Automatisation CI/CD avec GitHub

Le pipeline GitHub Actions s'occupe de tester le code, construire l'image Docker, la scanner et la déployer sur votre instance EC2.

1. Allez sur votre dépôt GitHub : **Settings > Secrets and variables > Actions**.
2. Ajoutez les secrets suivants :
   - `EC2_HOST` : L'adresse IP publique de votre instance EC2.
   - `EC2_USER` : `ubuntu`
   - `EC2_SSH_KEY` : Copiez-collez tout le contenu de votre fichier privé `lsdj.pem`.
   - `MYSQL_PASSWORD_TEST` : Un mot de passe temporaire pour la base de données de test (ex: `root_test`).
3. Poussez votre code sur la branche `main` :
   ```bash
   git push origin main
   ```
   *Le pipeline GitHub Actions va se déclencher automatiquement et déployer l'application.*

---

## 🔍 Étape 4 : Vérification du Déploiement

Sur votre machine locale Windows 11, vous pouvez utiliser les scripts PowerShell pour vérifier le bon fonctionnement :

1. Ouvrez PowerShell et allez à la racine du projet :
   ```powershell
   cd c:\laragon\www\DevOps\les-saveurs-du-jardin
   ```
2. Pour vérifier votre environnement local :
   ```powershell
   .\scripts\verify\check_services.ps1
   ```
3. Pour vérifier l'instance de production sur AWS EC2 (ex: `35.180.116.20`) :
   ```powershell
   .\scripts\verify\check_services.ps1 -TargetHost 35.180.116.20
   ```
   *Le script testera la connexion HTTP à l'adresse indiquée sur tous les ports exposés par l'application et la supervision.*
