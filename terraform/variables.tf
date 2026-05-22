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
  default     = "t3.small" # Gratuit (Free Tier)
}

# Nom de la paire de cles SSH creee sur AWS
variable "key_name" {
  description = "Nom de la cle SSH sur AWS pour se connecter a l'instance"
  type        = string
  default     = "lsdj"
}
