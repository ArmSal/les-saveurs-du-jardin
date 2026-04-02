<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(min: 2, max: 50, minMessage: "Le nom doit faire au moins {{ limit }} caractères.")]
    private ?string $name = null;

    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'adresse email '{{ value }}' n'est pas valide.")]
    private ?string $email = null;

    #[Assert\NotBlank(message: "Le message ne peut pas être vide.")]
    #[Assert\Length(min: 10, minMessage: "Le message doit faire au moins {{ limit }} caractères.")]
    private ?string $message = null;

    // Getters and Setters
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): void { $this->name = $name; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): void { $this->email = $email; }
    public function getMessage(): ?string { return $this->message; }
    public function setMessage(?string $message): void { $this->message = $message; }
}
