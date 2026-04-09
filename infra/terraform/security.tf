# infra/terraform/security.tf

# 1. Security Group pour l'Application (EC2)
resource "aws_security_group" "app_sg" {
  name        = "${var.project_name}-app-sg"
  description = "Autorise HTTP et SSH"
  vpc_id      = aws_vpc.main.id

  # Accès HTTP (Public)
  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 8080
    to_port     = 8080
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # Accès SSH (À restreindre en prod)
  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"] 
  }

  # Flux de monitoring (Prometheus/Grafana)
  ingress {
    from_port   = 3000
    to_port     = 3000
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # Autoriser tout le trafic sortant
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "${var.project_name}-app-sg"
  }
}

# 2. Security Group pour la Base de Données (RDS)
resource "aws_security_group" "db_sg" {
  name        = "${var.project_name}-db-sg"
  description = "Autorise Postgres depuis l'app"
  vpc_id      = aws_vpc.main.id

  # Autorise uniquement le trafic provenant du Security Group de l'App
  ingress {
    from_port       = 5432
    to_port         = 5432
    protocol        = "tcp"
    security_groups = [aws_security_group.app_sg.id]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "${var.project_name}-db-sg"
  }
}
