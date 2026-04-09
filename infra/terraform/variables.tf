# infra/terraform/variables.tf

variable "aws_region" {
  description = "Région AWS pour le déploiement"
  type        = string
  default     = "eu-west-3" # Paris
}

variable "project_name" {
  description = "Nom du projet pour le tagging"
  type        = string
  default     = "lsj-devops"
}

variable "environment" {
  description = "Environnement (dev, prod, test)"
  type        = string
  default     = "dev"
}

variable "db_password" {
  description = "Mot de passe pour RDS (Passé via variable d'env)"
  type        = string
  sensitive   = true
}
