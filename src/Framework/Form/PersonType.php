<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Application\User\UserFinderInterface;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class PersonType extends AbstractType
{
    public function __construct(
        private readonly UserFinderInterface $userFinder
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentYear = (int) (new DateTimeImmutable())->format('Y');

        $builder
            ->add(
                'name',
                TextType::class,
            )
            ->add(
                'user',
                ChoiceType::class,
                [
                    'choices' => $this->userFinder->findAll(),
                    'choice_label' => 'email',
                    'choice_value' => 'id',
                ]
            )
            ->add(
                'bio',
                TextareaType::class,
                ['required' => false]
            )
            ->add(
                'startYear',
                NumberType::class,
                [
                    'attr' => [
                        'max' => $currentYear,
                    ],
                    'constraints' => [
                        new LessThanOrEqual($currentYear),
                    ],
                    'required' => false,
                ]
            )
            ->add(
                'endYear',
                NumberType::class,
                ['required' => false],
            )
            ->add(
                'submit',
                SubmitType::class
            )
        ;
    }
}
