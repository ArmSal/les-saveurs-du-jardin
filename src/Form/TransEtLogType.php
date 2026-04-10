<?php

namespace App\Form;

use App\Entity\Magasin;
use App\Entity\TransEtLog;
use App\Entity\TransEtLogCamion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransEtLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all',
                ],
            ])
            ->add('camion', EntityType::class, [
                'label' => 'Camion',
                'class' => TransEtLogCamion::class,
                'choice_label' => 'nom',
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('c.nom', 'ASC');
                },
                'placeholder' => 'Choisir un camion...',
                'attr' => [
                    'class' => 'w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all',
                ],
            ])
            ->add('magasins', EntityType::class, [
                'label' => 'Magasins',
                'class' => Magasin::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('m')
                        ->where('m.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('m.nom', 'ASC');
                },
                'by_reference' => false,
                'attr' => [
                    'class' => 'grid grid-cols-2 sm:grid-cols-3 gap-3',
                ],
            ])
            ->add('observation', TextareaType::class, [
                'label' => 'Observation (optionnel)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Notes ou observations...',
                    'maxlength' => 200,
                    'rows' => 3,
                    'class' => 'w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TransEtLog::class,
        ]);
    }
}
