<?php

namespace App\Form\Admin;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Magasin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'choices' => [
                    'Monsieur' => 'Mr',
                    'Madame' => 'Mrs',
                ],
            ])
            ->add('nom', null, [
                'label' => 'Nom de famille',
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire']),
                    new Regex([
                        'pattern' => '/^[A-Z]/',
                        'message' => 'Le nom doit commencer par une majuscule'
                    ])
                ]
            ])
            ->add('prenom', null, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(['message' => 'Le prénom est obligatoire']),
                    new Regex([
                        'pattern' => '/^[A-Z]/',
                        'message' => 'Le prénom doit commencer par une majuscule'
                    ])
                ]
            ])
            ->add('date_naissance', null, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'La date de naissance est obligatoire'])
                ]
            ])
            ->add('code_postal', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le code postal est obligatoire']),
                    new Regex([
                        'pattern' => '/^[0-9]{5}$/',
                        'message' => 'Le code postal doit contenir exactement 5 chiffres'
                    ])
                ]
            ])
            ->add('adresse', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'L\'adresse est obligatoire'])
                ]
            ])
            ->add('adresse_complement', null, [
                'label' => 'Complément d\'adresse',
                'required' => false
            ])
            ->add('telephone', null, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le numéro de téléphone est obligatoire']),
                    new Regex([
                        'pattern' => '/^[0-9]{10}$/',
                        'message' => 'Le téléphone doit contenir exactement 10 chiffres (ex: 0612345678)'
                    ])
                ]
            ])
            ->add('client_number', null, ['required' => false])
            ->add('magasinEntity', EntityType::class, [
                'class' => Magasin::class,
                'choice_label' => 'nom',
                'label' => 'Établissement rattaché',
                'required' => true,
                'placeholder' => 'Choisir un établissement',
                'attr' => ['class' => 'magasin-selector'],
                'query_builder' => function(\App\Repository\MagasinRepository $repo) use ($options) {
                    $qb = $repo->createQueryBuilder('m')->where('m.isActive = true');
                    if (!empty($options['available_magasins'])) {
                        $qb->andWhere('m.id IN (:ids)')
                           ->setParameter('ids', array_map(fn($m) => $m->getId(), $options['available_magasins']));
                    }
                    return $qb->orderBy('m.nom', 'ASC');
                }
            ])
        ;

        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'L\'adresse email est obligatoire']),
                    new Email(['message' => 'Format d\'email invalide'])
                ]
            ])
            ->add('roleEntity', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'label',
                'label' => 'Niveau d\'Accès',
                'attr' => ['class' => 'role-selector'],
                'required' => true,
                'placeholder' => 'Choisir un niveau d\'accès',
                'disabled' => $options['is_directeur'],
                'query_builder' => function(\App\Repository\RoleRepository $repo) use ($options) {
                    $qb = $repo->createQueryBuilder('r');
                    if (!empty($options['available_roles'])) {
                        $qb->where('r.id IN (:ids)')
                           ->setParameter('ids', array_map(fn($role) => $role->getId(), $options['available_roles']));
                    }
                    return $qb->orderBy('r.priority', 'ASC');
                }
            ])
        ;

        $builder
            ->add('is_active', CheckboxType::class, [
                'label' => 'Statut du Compte',
                'required' => false,
                'disabled' => $options['is_directeur'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Nouveau Mot de Passe',
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit faire au moins {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&._-])[A-Za-z\d@$!%*?&._-]{8,}$/',
                        'message' => 'Le mot de passe doit contenir : 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.'
                    ])
                ]
            ])
            ->add('photo_file', FileType::class, [
                'label' => 'Photo de Profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPG, PNG, WEBP)',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'available_roles' => [],
            'available_magasins' => [],
            'is_directeur' => false,
        ]);

        $resolver->setAllowedTypes('available_roles', 'array');
        $resolver->setAllowedTypes('available_magasins', 'array');
    }
}


