<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Application\TrainingCategory\TrainingCategoryFinderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrainingItemType extends AbstractType
{
    public function __construct(
        private readonly TrainingCategoryFinderInterface $trainingCategoryFinder,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categoryChoices = [];
        foreach ($this->trainingCategoryFinder->findAll() as $category) {
            $categoryChoices[$category->name] = $category->id;
        }

        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'trainingCategoryId',
                ChoiceType::class,
                [
                    'choices' => $categoryChoices,
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
