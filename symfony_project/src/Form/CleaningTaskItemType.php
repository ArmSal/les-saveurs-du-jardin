<?php

namespace App\Form;

use App\Entity\CleaningTaskItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CleaningTaskItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description de la tâche...',
                    'class' => 'w-full px-2 sm:px-3 py-1.5 sm:py-2 bg-white border border-slate-200 rounded-lg text-xs sm:text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none overflow-hidden min-h-[32px] sm:min-h-[38px] leading-tight',
                    'rows' => 1,
                    'style' => 'height: auto; min-height: 32px;',
                ],
            ])
            ->add('completed', CheckboxType::class, [
                'label' => 'Terminé',
                'required' => false,
                'attr' => [
                    'class' => 'w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CleaningTaskItem::class,
        ]);
    }
}
