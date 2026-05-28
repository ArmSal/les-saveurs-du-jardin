#!/bin/bash
# =============================================================================
# Script de sauvegarde MySQL - Les Saveurs du Jardin (LSDJ)
# =============================================================================
# Compétence ASD couverte : CP6 - Gérer le stockage des données
# Critère RE : "Les données sont sauvegardées"
#
# Usage : ./backup_mysql.sh
# Planification : cron quotidien à 03h00 (configuré par Ansible)
# Rétention : 7 jours (fichiers plus anciens supprimés automatiquement)
# =============================================================================

set -euo pipefail

# --- Configuration ---
BACKUP_DIR="/home/ubuntu/backups/mysql"
CONTAINER_NAME="lsj-db"
DATABASE="lsj_db"
RETENTION_DAYS=7
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="${BACKUP_DIR}/lsj_db_${TIMESTAMP}.sql.gz"
LOG_FILE="${BACKUP_DIR}/backup.log"
ENV_FILE="/home/ubuntu/les-saveurs-du-jardin/docker/.env"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" | tee -a "${LOG_FILE}"
}

# --- Création du répertoire de sauvegarde ---
mkdir -p "${BACKUP_DIR}"
chmod 750 "${BACKUP_DIR}"

log "========================================================"
log "Démarrage de la sauvegarde de la base de données LSDJ"
log "========================================================"

# --- Chargement du mot de passe depuis .env ---
if [ ! -f "${ENV_FILE}" ]; then
    log "ERREUR : Fichier .env introuvable : ${ENV_FILE}"
    exit 1
fi

MYSQL_ROOT_PASSWORD=$(grep -E "^MYSQL_ROOT_PASSWORD=" "${ENV_FILE}" | cut -d'=' -f2- | tr -d '"'"'")
if [ -z "${MYSQL_ROOT_PASSWORD}" ]; then
    log "ERREUR : MYSQL_ROOT_PASSWORD non défini dans ${ENV_FILE}"
    exit 1
fi

# --- Vérification que le container MySQL est actif ---
if ! docker ps --format '{{.Names}}' | grep -q "^${CONTAINER_NAME}$"; then
    log "ERREUR : Le container '${CONTAINER_NAME}' n'est pas en cours d'exécution"
    exit 1
fi

# --- Exécution du dump MySQL ---
log "Création du dump : ${BACKUP_FILE}"
docker exec "${CONTAINER_NAME}" mysqldump \
    -u root \
    -p"${MYSQL_ROOT_PASSWORD}" \
    --single-transaction \
    --routines \
    --triggers \
    --events \
    --add-drop-table \
    "${DATABASE}" | gzip > "${BACKUP_FILE}"

DUMP_STATUS=${PIPESTATUS[0]}
if [ "${DUMP_STATUS}" -ne 0 ]; then
    log "ERREUR : mysqldump a échoué (code ${DUMP_STATUS})"
    rm -f "${BACKUP_FILE}"
    exit 1
fi

# --- Vérification de l'intégrité du fichier ---
if [ ! -s "${BACKUP_FILE}" ]; then
    log "ERREUR : Le fichier de sauvegarde est vide"
    rm -f "${BACKUP_FILE}"
    exit 1
fi

SIZE=$(du -sh "${BACKUP_FILE}" | cut -f1)
log "Sauvegarde réussie : ${BACKUP_FILE} (${SIZE})"

# --- Rotation : suppression des sauvegardes de plus de ${RETENTION_DAYS} jours ---
log "Nettoyage des sauvegardes de plus de ${RETENTION_DAYS} jours..."
DELETED=$(find "${BACKUP_DIR}" -name "lsj_db_*.sql.gz" -mtime "+${RETENTION_DAYS}" -print -delete | wc -l)
log "${DELETED} fichier(s) supprimé(s)"

# --- Rapport final ---
BACKUP_COUNT=$(find "${BACKUP_DIR}" -name "lsj_db_*.sql.gz" | wc -l)
BACKUP_TOTAL_SIZE=$(du -sh "${BACKUP_DIR}" --exclude="*.log" 2>/dev/null | cut -f1)
log "Sauvegardes disponibles : ${BACKUP_COUNT} fichier(s), ${BACKUP_TOTAL_SIZE} au total"
log "Sauvegarde terminée avec succès."
