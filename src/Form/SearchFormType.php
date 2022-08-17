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
            ->add('gameName', TextType::class, [
                'required' => false,
                'label'    => 'Nombre',
            ])
            ->add('playerCount', NumberType::class, [
                'required' => false,
                'label'    => 'Jugadores 👥',
                'help'     => 'Min 👥 <= X <= Max 👥',
            ])
            ->add('exactPlayerCount', NumberType::class, [
                'required' => false,
                'label'    => 'Max Jugadores 👥',
            ])
            ->add('minPlaytime', NumberType::class, [
                'required' => false,
                'label'    => '⏳Tiempo Mínimo',
                'help'     => 'Duración en minutos',
            ])
            ->add('maxPlaytime', NumberType::class, [
                'required' => false,
                'label'    => '⌛️Tiempo Máximo',
                'help'     => 'Duración en minutos',
            ])
            ->add(
                'minWeight', NumberType::class,
                [
                    'required'  => false,
                    'label'     => 'Complejidad BGG Mínima',
                    'help'      => '1 a 5. <a href="https://boardgamegeek.com/wiki/page/Weight" target="_blank">Ver más</a>',
                    'help_html' => true,
                ]
            )
            ->add(
                'maxWeight', NumberType::class,
                [
                    'required'  => false,
                    'label'     => 'Complejidad BGG Máxima',
                    'help'      => '1 a 5. <a href="https://boardgamegeek.com/wiki/page/Weight" target="_blank">Ver más</a>',
                    'help_html' => true,
                ]
            )
            ->add('recommendedAge', NumberType::class,
                  [
                      'required' => false,
                      'label' => 'Edad Recomendada Máxima'
                  ])
            ->add('orderBy', HiddenType::class)
            ->add('order', HiddenType::class)
            ->add('search', SubmitType::class, [
                'label' => 'Buscar'
            ]);
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
