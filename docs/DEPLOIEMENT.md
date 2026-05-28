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

---

## Étape 5 (optionnelle) : Déploiement sur Kubernetes

Le dossier `kubernetes/` contient les manifests pour déployer l'application sur un cluster Kubernetes (AWS EKS, K3s, etc.) en alternative à Docker Compose. Cette approche est recommandée pour une infrastructure à grande échelle nécessitant la haute disponibilité et le scaling automatique.

### Prérequis Kubernetes

- `kubectl` configuré et connecté au cluster
- `nginx-ingress-controller` installé :
  ```bash
  kubectl apply -f https://raw.githubusercontent.com/kubernetes/ingress-nginx/controller-v1.10.1/deploy/static/provider/aws/deploy.yaml
  ```

### Déploiement

Appliquer les manifests dans l'ordre (les fichiers sont numérotés à cet effet) :

```bash
# 1. Créer le namespace isolé
kubectl apply -f kubernetes/00-namespace.yaml

# 2. Créer les secrets et configmap (modifier les mots de passe dans 01-secrets-configmap.yaml d'abord)
kubectl apply -f kubernetes/01-secrets-configmap.yaml

# 3. Déployer la base de données (StatefulSet avec PVC gp2)
kubectl apply -f kubernetes/02-db-statefulset.yaml

# 4. Déployer l'application PHP-FPM + Nginx (2 replicas, RollingUpdate)
kubectl apply -f kubernetes/03-app-deployment.yaml

# 5. Déployer la stack de supervision (Prometheus + Grafana)
kubectl apply -f kubernetes/04-monitoring.yaml

# 6. Exposer l'application via Ingress
kubectl apply -f kubernetes/05-ingress.yaml
```

### Vérification

```bash
# Vérifier l'état de tous les pods
kubectl get pods -n lsdj

# Vérifier les services
kubectl get services -n lsdj

# Vérifier l'Ingress (récupérer l'adresse du Load Balancer)
kubectl get ingress -n lsdj

# Suivre les logs de l'application
kubectl logs -n lsdj -l app=lsdj-app -f
```

### Comparaison Docker Compose vs Kubernetes

| Critère | Docker Compose | Kubernetes |
|---|---|---|
| Simplicité | Simple, mono-serveur | Plus complexe, multi-nœuds |
| Haute disponibilité | Non (single point of failure) | Oui (replicas, auto-restart) |
| Scaling | Manuel | Automatique (HPA) |
| Rolling updates | Non natif | Natif (RollingUpdate) |
| Usage recommandé | Dev local / petit prod | Production à grande échelle |

L'architecture Docker Compose est retenue pour ce projet car elle correspond à l'infrastructure mono-serveur sur AWS EC2. Les manifests Kubernetes constituent la trajectoire d'évolution vers un cluster distribué.

---

## Sauvegarde des données (CP6)

Le script `scripts/backup/backup_mysql.sh` est automatiquement installé et planifié par Ansible lors du provisionnement. Il s'exécute chaque nuit à 03h00 :

```bash
# Exécuter une sauvegarde manuelle
/home/ubuntu/backup_mysql.sh

# Consulter les journaux de sauvegarde
tail -f /home/ubuntu/backups/mysql/backup.log

# Lister les sauvegardes disponibles
ls -lh /home/ubuntu/backups/mysql/
```

Politique de rétention : **7 jours** — les fichiers plus anciens sont supprimés automatiquement. Les sauvegardes sont stockées au format compressé (`.sql.gz`) dans `/home/ubuntu/backups/mysql/`.
