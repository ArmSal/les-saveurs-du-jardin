<?php

namespace App\Form;

use App\Entity\CleaningTask;
use App\Entity\Magasin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CleaningTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isReadOnly = $options['is_read_only'] ?? false;
        $attr = $isReadOnly ? ['disabled' => 'disabled'] : [];

        $builder
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'attr' => array_merge([
                    'class' => 'w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all',
                ], $attr),
            ])
            ->add('magasin', EntityType::class, [
                'label' => 'Magasin',
                'class' => Magasin::class,
                'choice_label' => 'nom',
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('m')
                        ->where('m.isActive = :active')
                        ->setParameter('active', true)
                        ->orderBy('m.nom', 'ASC');
                },
                'placeholder' => 'Choisir un magasin...',
                'attr' => array_merge([
                    'class' => 'w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all',
                ], $attr),
            ])
            ->add('items', CollectionType::class, [
                'label' => false,
                'entry_type' => CleaningTaskItemType::class,
                'allow_add' => !$isReadOnly,
                'allow_delete' => !$isReadOnly,
                'by_reference' => false,
                'attr' => [
                    'class' => 'space-y-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CleaningTask::class,
            'is_read_only' => false,
        ]);
    }
}
