<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Domain\TrainingCategory\TrainingCategoryFinderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TrainingItemType extends AbstractType
{
    public function __construct(
        private readonly TrainingCategoryFinderInterface $trainingCategoryFinder
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class
            )
            ->add(
                'trainingCategory',
                ChoiceType::class,
                [
                    'choices' => $this->trainingCategoryFinder->findAll(),
                    'choice_value' => 'id',
                    'choice_label' => 'name',
                ]
            )
            ->add(
                'isDangerous',
                CheckboxType::class,
                ['required' => false]
            )
            ->add(
                'submit',
                SubmitType::class
            )
        ;
    }
}
