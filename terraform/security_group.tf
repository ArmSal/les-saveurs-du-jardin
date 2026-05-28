# Groupe de securite pour autoriser le trafic reseau vers notre serveur
resource "aws_security_group" "lsdj_sg" {
  name        = "lsdj-security-group"
  description = "Autorise le trafic pour l'application Les Saveurs du Jardin"

  # Port 22 : SSH pour l'administration et Ansible
  ingress {
    description = "SSH"
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # Port 80 : HTTP pour l'application Symfony
  ingress {
    description = "HTTP"
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # Port 443 : HTTPS securise
  ingress {
    description = "HTTPS"
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # Port 3000 : Interface Grafana - acces restreint a l'IP administrateur
  ingress {
    description = "Grafana Dashboards (admin only)"
    from_port   = 3000
    to_port     = 3000
    protocol    = "tcp"
    cidr_blocks = [var.admin_ip_cidr]
  }

  # Port 9090 : Interface Prometheus - acces restreint a l'IP administrateur
  ingress {
    description = "Prometheus UI (admin only)"
    from_port   = 9090
    to_port     = 9090
    protocol    = "tcp"
    cidr_blocks = [var.admin_ip_cidr]
  }

  # Port 8081 : Adminer - acces restreint a l'IP administrateur (hors production)
  ingress {
    description = "Adminer DB UI (admin only)"
    from_port   = 8081
    to_port     = 8081
    protocol    = "tcp"
    cidr_blocks = [var.admin_ip_cidr]
  }

  # Regle par defaut pour autoriser le serveur a sortir sur Internet (mises a jour, telechargements, etc.)
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "lsdj-sg"
  }
}
