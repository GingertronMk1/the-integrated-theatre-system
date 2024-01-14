<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Application\Person\PersonFinderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CastMemberType extends AbstractType
{
    public function __construct(
        private readonly PersonFinderInterface $personFinder,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', TextType::class)
            ->add(
                'person',
                ChoiceType::class,
                [
                    'choices' => $this->personFinder->findAll(),
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                ]
            )
            ->add(
                'submit',
                SubmitType::class
            )

        ;
    }
}
