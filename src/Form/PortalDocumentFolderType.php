<?php

namespace App\Form;

use App\Entity\PortalDocumentFolder;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortalDocumentFolderType extends AbstractType
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Nom du Dossier',
                'attr' => ['class' => 'w-full px-3 py-2 border border-slate-300 rounded-lg outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500']
            ])
            ->add('parent', EntityType::class, [
                'class' => PortalDocumentFolder::class,
                'choice_label' => 'name',
                'label' => 'Dossier Parent',
                'required' => false,
                'placeholder' => '-- Aucun (Dossier Principal) --',
                'attr' => ['class' => 'w-full px-3 py-2 border border-slate-300 rounded-lg outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 bg-white']
            ])
            ->add('rolesPermitted', ChoiceType::class, [
                'label' => 'Visible par les rôles',
                'choices' => $this->getRoleChoices(),
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'attr' => ['class' => 'flex gap-4 flex-wrap'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PortalDocumentFolder::class,
        ]);
    }

    private function getRoleChoices(): array
    {
        $roles = $this->roleRepository->findAllOrdered();
        $choices = [];
        foreach ($roles as $role) {
            $choices[$role->getLabel()] = $role->getName();
        }
        return $choices;
    }
}


