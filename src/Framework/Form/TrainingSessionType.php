<?php

declare(strict_types=1);

namespace App\Framework\Form;

use App\Application\Person\PersonFinderInterface;
use App\Application\TrainingItem\TrainingItemFinderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class TrainingSessionType extends AbstractType
{
    public function __construct(
        public PersonFinderInterface $personFinder,
        public TrainingItemFinderInterface $trainingItemFinder
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $items = $this->trainingItemFinder->findAll();
      $people = $this->personFinder->findAll();
      $builder
        ->add('happenedAt', DateTimeType::class)
        ->add(
            'items',
            ChoiceType::class,
            [
              'multiple' => true,
              'choices' => $items,
              'choice_label' => 'name',
              'choice_value' => 'id'
            ]
        )
        ->add(
            'trainers',
            ChoiceType::class,
            [
              'multiple' => true,
              'choices' => $people,
              'choice_label' => 'name',
              'choice_value' => 'id'
            ]
        )
        ->add(
            'trainees',
            ChoiceType::class,
            [
              'multiple' => true,
              'choices' => $people,
              'choice_label' => 'name',
              'choice_value' => 'id'
            ]
        )
        ->add('submit', SubmitType::class)
      ;
    }
}
