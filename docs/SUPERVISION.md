# 📊 Guide de Supervision - Les Saveurs du Jardin

Ce document explique simplement comment fonctionne le système de surveillance (monitoring) de notre application et de notre serveur en temps réel.

---

## 🛠️ 1. Vue d'ensemble de la Pile de Supervision

Pour surveiller l'état de santé de notre infrastructure, nous utilisons une suite d'outils complémentaires lancés dans nos conteneurs Docker :

```
[ Serveur / Conteneurs ] 
       │ (génèrent des métriques)
       ▼
 [ Exporters (Node, cAdvisor, etc.) ] ◄─── (Scrape toutes les 15s) ─── [ Prometheus ]
                                                                             │
      ┌──────────────────────────────────────────────────────────────────────┴───┐
      ▼ (Requêtes SQL/PromQL)                                                    ▼ (Envoi d'alertes)
 [ Grafana (Visualisation) ]                                            [ Alertmanager ]
                                                                                 │
                                                                                 ▼ (Webhook)
                                                                            [ Discord ]
```

---

## 📥 2. Collecte des Données avec Prometheus

**Prometheus** est le cœur du système. Son rôle est de récupérer (on dit **scraper**) régulièrement les métriques de notre serveur et de nos conteneurs.

* **Fréquence** : Toutes les 15 secondes (`scrape_interval: 15s`), Prometheus interroge les différents composants pour obtenir leurs données à jour.
* **Les Exporters** : Ce sont de petits agents spécialisés qui traduisent les informations de chaque service dans un format que Prometheus comprend :
  1. **Node Exporter** : Récupère les métriques physiques du serveur AWS (utilisation CPU, RAM restante, espace disque utilisé).
  2. **cAdvisor** : Récupère les métriques de chaque conteneur Docker individuellement (ex: combien de RAM consomme le conteneur `lsj-app`).
  3. **Nginx Exporter** : Surveille le nombre de visites sur le site et les requêtes en cours.
  4. **PHP-FPM Exporter** : Surveille le nombre d'ouvriers (workers) PHP actifs pour traiter les requêtes Symfony.
  5. **MySQL Exporter** : Surveille les performances de la base de données (nombre de connexions, requêtes lentes).

---

## 📈 3. Visualisation avec Grafana

**Grafana** est l'interface graphique qui permet de transformer les chiffres bruts de Prometheus en magnifiques graphiques faciles à lire.

Trois tableaux de bord (**Dashboards**) pré-configurés sont disponibles :
1. **Infrastructure (Système)** : Affiche la santé globale du serveur (CPU, RAM, Disque, Débit réseau). Utile pour savoir s'il faut agrandir notre machine AWS.
2. **Database (Base de données)** : Permet de voir le nombre de connexions MySQL actives et la vitesse d'exécution des requêtes.
3. **Application & Nginx** : Permet de suivre le nombre de visiteurs sur le site, le temps de réponse moyen des pages et le taux d'erreurs (ex: pages 404 ou erreurs 500).

* **Accès local** : [http://localhost:3000](http://localhost:3000) (Identifiants configurés dans le fichier `.env`).

---

## 🚨 4. Alertes et Notifications avec Alertmanager

Il n'est pas possible de regarder les graphiques Grafana toute la journée. C'est pourquoi nous avons configuré un système d'alerte automatique.

### Règles d'Alerte (`alert_rules.yml`)
Prometheus analyse les métriques en continu. Si une condition critique est remplie, une alerte est déclenchée. Exemples de règles configurées :
* **Instance Down** : Si un service complet s'arrête.
* **Host CPU High** : Si l'utilisation du processeur du serveur dépasse 80% pendant plus de 2 minutes.
* **Disk Space Low** : S'il reste moins de 10% d'espace libre sur le disque dur.

### Envoi sur Discord
Lorsqu'une alerte se déclenche :
1. Prometheus envoie l'alerte à **Alertmanager**.
2. Alertmanager regroupe les alertes pour éviter de saturer le canal.
3. Alertmanager envoie une notification formatée directement sur un salon **Discord** dédié grâce à un Webhook.

* **Sécurité** : Pour que le lien de notification Discord ne soit pas visible publiquement sur GitHub, Alertmanager lit l'URL du webhook à partir d'un fichier local secret (`discord_webhook_url`) injecté de manière sécurisée lors du déploiement.
