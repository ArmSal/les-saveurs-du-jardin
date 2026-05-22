# Output pour afficher l'adresse IP publique de notre serveur apres la creation
output "instance_public_ip" {
  description = "Adresse IP publique du serveur EC2"
  value       = aws_instance.lsdj_server.public_ip
}

# Output pour afficher l'identifiant de l'instance
output "instance_id" {
  description = "ID de l'instance creee"
  value       = aws_instance.lsdj_server.id
}
