# infra/terraform/database.tf

resource "aws_db_instance" "postgres" {
  allocated_storage      = 20
  db_name                = "lsj_db"
  engine                 = "postgres"
  engine_version         = "16"
  instance_class         = "db.t3.micro"
  username               = "dbadmin"
  password               = var.db_password
  db_subnet_group_name   = aws_db_subnet_group.main.name
  vpc_security_group_ids = [aws_security_group.db_sg.id]
  skip_final_snapshot    = true
  publicly_accessible    = false

  tags = {
    Name = "${var.project_name}-rds"
  }
}

output "db_endpoint" {
  value = aws_db_instance.postgres.endpoint
}
