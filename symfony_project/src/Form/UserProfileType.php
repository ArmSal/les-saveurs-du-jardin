<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isSuperAdmin = $options['is_super_admin'] ?? false;
        $isDisabled = !$isSuperAdmin;

        $builder
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
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
                'disabled' => $isDisabled,
            ])
            ->add('client_number', null, [
                'label' => 'Numéro Client',
                'disabled' => $isDisabled,
            ])
            ->add('civility', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => [
                    'Mr' => 'Mr',
                    'Mrs' => 'Mrs',
                ],
                'disabled' => true,
            ])
            ->add('nom', null, [
                'label' => 'Nom',
                'disabled' => true,
            ])
            ->add('prenom', null, [
                'label' => 'Prénom',
                'disabled' => true,
            ])
            ->add('date_naissance', null, [
                'widget' => 'single_text',
                'label' => 'Date de Naissance',
                'required' => false,
                'disabled' => true,
            ])
            ->add('code_postal', null, [
                'label' => 'Code Postal',
                'required' => false,
            ])
            ->add('adresse', null, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('adresse_complement', null, [
                'label' => "Complément d'adresse",
                'required' => false,
            ])
            ->add('telephone', null, [
                'label' => 'Numéro de Téléphone',
                'required' => false,
            ])
            ->add('magasin', ChoiceType::class, [
                'label' => 'Magasin / Point de retrait',
                'choices' => [
                    'Client' => 'Client',
                    'Olivet' => 'Olivet',
                    'St Gervais' => 'St Gervais',
                    'Villemandeur' => 'Villemandeur',
                    'Saran' => 'Saran',
                    'Noyers' => 'Noyers',
                ],
                'required' => true,
                'disabled' => $isDisabled,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_super_admin' => false,
        ]);
    }
}


