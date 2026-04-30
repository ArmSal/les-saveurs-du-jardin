<?php

namespace App\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class UserCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Mot de Passe',
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\NotBlank(['message' => 'Le mot de passe est obligatoire']),
                    new \Symfony\Component\Validator\Constraints\Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit faire au moins {{ limit }} caractères',
                    ]),
                    new \Symfony\Component\Validator\Constraints\Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&._-])[A-Za-z\d@$!%*?&._-]{8,}$/',
                        'message' => 'Le mot de passe doit contenir : 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.'
                    ])
                ]
            ])
        ;
    }

    public function getParent(): string
    {
        return UserType::class;
    }
}


