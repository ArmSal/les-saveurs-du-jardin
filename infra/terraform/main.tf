# infra/terraform/main.tf

terraform {
  required_version = ">= 1.5.0"

  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.0"
    }
  }

  # Configuration du backend S3 pour stocker le State de manière sécurisée
  # Note : Le bucket doit être créé manuellement ou via un script de boostrap au préalable
  backend "s3" {
    bucket         = "lsj-terraform-state"
    key            = "dev/terraform.tfstate"
    region         = "eu-west-3" # Paris
    encrypt        = true
    dynamodb_table = "lsj-terraform-lock"
  }
}

provider "aws" {
  region = var.aws_region
}
