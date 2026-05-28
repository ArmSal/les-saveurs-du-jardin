# Region AWS ou deployer l'infrastructure
variable "aws_region" {
  description = "Region AWS pour le deploiement"
  type        = string
  default     = "eu-west-3" # Paris
}

# Type d'instance EC2
variable "instance_type" {
  description = "Type de l'instance EC2"
  type        = string
  default     = "t3.small"
}

# Nom de la paire de cles SSH creee sur AWS
variable "key_name" {
  description = "Nom de la cle SSH sur AWS pour se connecter a l'instance"
  type        = string
  default     = "lsdj"
}

# CIDR autorise pour les interfaces d'administration (Grafana, Prometheus, Adminer)
# Restreindre a l'IP de l'administrateur en production (ex: "203.0.113.10/32")
variable "admin_ip_cidr" {
  description = "CIDR IP autorise pour acceder aux interfaces d'administration. Restreindre en production."
  type        = string
  default     = "0.0.0.0/0"
}
