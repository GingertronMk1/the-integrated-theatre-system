<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Application\CrewRole\CrewRoleFinderInterface;
use App\Application\Person\PersonFinderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CrewMemberType extends AbstractType
{
    public function __construct(
        private readonly CrewRoleFinderInterface $crewRoleFinder,
        private readonly PersonFinderInterface $personFinder,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('crewRole', ChoiceType::class, [
                'choices' => $this->crewRoleFinder->findAll(),
                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
            ->add('person', ChoiceType::class, [
                'choices' => $this->personFinder->findAll(),
                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
            ->add('notes', TextareaType::class, ['required' => false])
            ->add(
                'submit',
                SubmitType::class
            )
        ;
    }
}
