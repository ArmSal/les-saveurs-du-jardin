# infra/terraform/compute.tf

# 1. Sélection de l'AMI (Ubuntu 22.04 LTS)
data "aws_ami" "ubuntu" {
  most_recent = true
  owners      = ["099720109477"] # Canonical

  filter {
    name   = "name"
    values = ["ubuntu/images/hvm-ssd/ubuntu-jammy-22.04-amd64-server-*"]
  }
}

# 2. Instance EC2
resource "aws_instance" "app_server" {
  ami                    = data.aws_ami.ubuntu.id
  instance_type          = "t3.micro"
  subnet_id              = aws_subnet.public.id
  vpc_security_group_ids = [aws_security_group.app_sg.id]
  key_name              = "lsj-key" # On supposera que cette clé existe déjà sur AWS

  root_block_device {
    volume_size = 20 # 20GB (Free Tier allows up to 30GB)
    volume_type = "gp3"
  }

  tags = {
    Name = "${var.project_name}-server"
  }

  # Provisioning initial minimal (On laissera Ansible faire le reste)
  user_data = <<-EOF
              #!/bin/bash
              apt-get update
              apt-get install -y python3-pip
              EOF
}

output "instance_public_ip" {
  value = aws_instance.app_server.public_ip
}
