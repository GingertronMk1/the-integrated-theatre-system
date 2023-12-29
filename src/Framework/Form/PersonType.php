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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userChoices = ['---' => null];
        foreach ($this->userFinder->findAll() as $user) {
            $userChoices[$user->email] = $user->id;
        }

        $currentYear = (int) (new DateTimeImmutable())->format('Y');

        $builder
            ->add(
                'name',
                TextType::class,
            )
            ->add(
                'userId',
                ChoiceType::class,
                [
                    'choices' => $userChoices,
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
                ]
            )
            ->add(
                'endYear',
                NumberType::class,
            )
            ->add(
                'submit',
                SubmitType::class
            )
        ;
    }
}
