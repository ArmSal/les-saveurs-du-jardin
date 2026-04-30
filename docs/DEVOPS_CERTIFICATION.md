# 🎓 Certification ASD - Traçabilité des Compétences (DevOps)

Ce document trace les réalisations du projet **Les Saveurs Du Jardin** avec les critères d'évaluation du titre professionnel **Administrateur Systèmes DevOps (ASD)**.

---

## 🛠️ BC01 : Automatiser le déploiement d'une infrastructure (Infrastructure as Code)

**Objectif :** Concevoir, provisionner et configurer l'infrastructure cible de manière reproductible.

| Réalisation | Fichier / Dossier associé | Statut |
|-------------|---------------------------|--------|
| **Conteneurisation Multi-Stage** | [`Dockerfile`](../Dockerfile) | ✅ Validé |
| Optimisation PHP-FPM pour Production | [`docker/php/prod.ini`](../docker/php/prod.ini) | ✅ Validé |
| Définition de la stack complète (8 services) | [`compose.yaml`](../compose.yaml) | ✅ Validé |
| **Provisionnement Cloud (AWS)** | [`infra/terraform/`](../infra/terraform/) | ✅ Validé |
| Création VPC, Subnets et Security Groups | `infra/terraform/network.tf` / `security.tf` | ✅ Validé |
| **Gestion de la Configuration** | [`infra/ansible/`](../infra/ansible/) | ✅ Validé |
| Automatisation installation Docker & Déploiement App | `infra/ansible/playbook.yml` | ✅ Validé |

---

## 🚀 BC02 : Déployer en continu une application (CI/CD)

**Objectif :** Mettre en place un pipeline d'Intégration et de Déploiement Continus robuste et sécurisé.

| Réalisation | Fichier / Dossier associé | Statut |
|-------------|---------------------------|--------|
| **Pipeline Global GitHub Actions** | [`.github/workflows/ci.yml`](../.github/workflows/ci.yml) | ✅ Validé |
| Isolation des variables d'environnement de Test | `.env.test` | ✅ Validé |
| **Tests Fonctionnels Automatisés** | [`tests/Controller/SecurityControllerTest.php`](../tests/Controller/SecurityControllerTest.php) | ✅ Validé |
| Validation stricte des dépendances | `composer validate --strict` (Job CI) | ✅ Validé |
| **Analyse de Sécurité Applicative** | `symfonycorp/security-checker-action` (Job CI) | ✅ Validé |
| **Scan de Vulnérabilités de l'Image** | `aquasecurity/trivy-action` (Job CI) | ✅ Validé |
| **Déploiement Automatisé** | Job `deploy` (Simulation Push GHCR & EC2 Pull) | ✅ Validé |

---

## 📊 BC03 : Superviser le système d'information (Observabilité)

**Objectif :** Mettre en œuvre une supervision proactive pour garantir la haute disponibilité.

| Réalisation | Fichier / Dossier associé | Statut |
|-------------|---------------------------|--------|
| **Collecte de Métriques (Scraping)** | [`docker/prometheus/prometheus.yml`](../docker/prometheus/prometheus.yml) | ✅ Validé |
| Exposition des métriques matérielles (Host) | Service `node-exporter` | ✅ Validé |
| Exposition des métriques conteneurs (Docker) | Service `cadvisor` | ✅ Validé |
| **Dashboard de Visualisation (Auto-provisionné)** | [`docker/grafana/provisioning/dashboards/lsdj-monitoring.json`](../docker/grafana/provisioning/dashboards/lsdj-monitoring.json) | ✅ Validé |
| Graphiques Temps Réel (CPU, RAM, Disk I/O) | *Dashboard Grafana* | ✅ Validé |
| **Règles d'Alerting (Thresholds)** | [`docker/prometheus/alert_rules.yml`](../docker/prometheus/alert_rules.yml) | ✅ Validé |
| Alerte Critique : Espace Disque < 10% | `HostOutOfDiskSpace` | ✅ Validé |
| Alerte Warning : Charge CPU > 80% | `HostHighCpuLoad` | ✅ Validé |
