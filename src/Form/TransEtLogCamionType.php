<?php

namespace App\Form;

use App\Entity\TransEtLogCamion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransEtLogCamionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du camion',
                'attr' => [
                    'placeholder' => 'Ex: Camion 1',
                    'class' => 'w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all',
                ],
            ])
            ->add('immatriculation', TextType::class, [
                'label' => 'Immatriculation (optionnel)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: AB-123-CD',
                    'class' => 'w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all',
                ],
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
                'attr' => [
                    'class' => 'w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TransEtLogCamion::class,
        ]);
    }
}
