# Configuration de Terraform et du fournisseur AWS
terraform {
  required_version = ">= 1.0.0"
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 4.0"
    }
  }
}

# Configuration du provider AWS avec la region definie
provider "aws" {
  region = var.aws_region
}

# Recuperer dynamiquement la derniere AMI officielle d'Ubuntu 24.04 LTS
data "aws_ami" "ubuntu" {
  most_recent = true

  filter {
    name   = "name"
    values = ["ubuntu/images/hvm-ssd/ubuntu-noble-24.04-amd64-server-*"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  owners = ["099720109477"] # Identifiant de Canonical (editeur d'Ubuntu)
}

# Definition de l'instance EC2 pour notre serveur
resource "aws_instance" "lsdj_server" {
  ami           = data.aws_ami.ubuntu.id
  instance_type = var.instance_type
  key_name      = var.key_name

  # Association du groupe de securite
  vpc_security_group_ids = [aws_security_group.lsdj_sg.id]

  # Configuration du disque dur principal (30 Go standard)
  root_block_device {
    volume_size = 30
    volume_type = "gp2"
  }

  tags = {
    Name = "lsdj-ec2-instance"
  }
}
