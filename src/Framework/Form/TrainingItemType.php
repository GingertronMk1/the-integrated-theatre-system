<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Application\TrainingCategory\TrainingCategoryFinderInterface;
use App\Application\TrainingItem\TrainingItemFinderInterface;
use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class TrainingItemType extends AbstractType
{
    public function __construct(
        private readonly TrainingCategoryFinderInterface $trainingCategoryFinder,
        private readonly TrainingItemFinderInterface $trainingItemFinder
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
                        new NotBlank()
                    ]
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
