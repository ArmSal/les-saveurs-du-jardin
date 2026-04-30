<?php

namespace App\Form;

use App\Entity\PortalProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\PortalCategorieProduit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

class PortalProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference')
            ->add('code_barre')
            ->add('designation')
            ->add('unite')
            ->add('categoryEntity', EntityType::class, [
                'class' => PortalCategorieProduit::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie...',
            ])
            ->add('image_file', FileType::class, [
                'label' => 'Photo du produit',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPG, PNG, WEBP)',
                    ])
                ],
            ])
            ->add('tva', null, [
                'label' => 'TVA (%)',
                'attr' => ['placeholder' => '20.00']
            ])
            ->add('prix', null, [
                'label' => 'Prix Unitaire (€)',
                'attr' => ['placeholder' => '0.00']
            ])
            ->add('qte_stock', null, [
                'label' => 'Stock Actuel',
                'attr' => ['placeholder' => '0']
            ])
            ->add('description', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PortalProduct::class,
        ]);
    }
}


