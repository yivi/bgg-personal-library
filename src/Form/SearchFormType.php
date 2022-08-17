<?php

declare(strict_types=1);

namespace App\Form;

use App\Controller\Dto\SearchParamDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gameName', TextType::class, ['required' => false])
            ->add('playerCount', NumberType::class, ['required' => false])
            ->add('exactPlayerCount', NumberType::class, ['required' => false])
            ->add('minPlaytime', NumberType::class, ['required' => false])
            ->add('maxPlaytime', NumberType::class, ['required' => false])
            ->add('minWeight', NumberType::class, ['required' => false])
            ->add('maxWeight', NumberType::class, ['required' => false])
            ->add('orderBy', HiddenType::class)
            ->add('order', HiddenType::class)
            ->add('search', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => SearchParamDto::class,
                'method'     => 'get',
            ]
        );
    }
}
