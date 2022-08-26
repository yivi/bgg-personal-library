<?php

declare(strict_types=1);

namespace App\Form;

use App\Controller\Dto\SearchParamDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
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
                'label'    => 'Jugadores <span class="icon"><i class="group-line"></i></span>',
                'label_html' => true,
                'help'     => 'Min <span class="icon"><i class="group-line"></i></span> <= X <= Max <span class="icon"><i class="team-line"></i></span>',
                'help_html' => true,
                'html5'    => true,
            ])
            ->add('exactPlayerCount', NumberType::class, [
                'required' => false,
                'label'    => 'Max Jugadores <span class="icon"><i class="team-line"></i></span>',
                'label_html' => true,
                'html5'    => true,
            ])
            ->add('minPlaytime', NumberType::class, [
                'required' => false,
                'label'    => '<span class="icon"><i class="time-line"></i></span> Tiempo Mínimo',
                'label_html' => true,
                'help'     => 'Duración en minutos',
                'html5'    => true,
            ])
            ->add('maxPlaytime', NumberType::class, [
                'required' => false,
                'label'    => '<span class="icon"><i class="timer-line"></i></span>️Tiempo Máximo',
                'label_html' => true,
                'help'     => 'Duración en minutos',
                'html5'    => true,
            ])
            ->add(
                'minWeight', NumberType::class, [
                               'required'  => false,
                               'label'     => 'Complejidad BGG Mínima <span class="icon"><i class="scales-2-line"></i></span>',
                               'label_html' => true,
                               'help'      => '1 a 5. <a href="https://boardgamegeek.com/wiki/page/Weight" target="_blank">Ver más</a>',
                               'help_html' => true,
                               'html5'     => true,
                           ]
            )
            ->add(
                'maxWeight', NumberType::class, [
                               'required'  => false,
                               'label'     => 'Complejidad BGG Máxima <span class="icon"><i class="scales-2-line"></i></span>',
                               'label_html' => true,
                               'help'      => '1 a 5. <a href="https://boardgamegeek.com/wiki/page/Weight" target="_blank">Ver más</a>',
                               'help_html' => true,
                               'html5'     => true,
                           ]
            )
            ->add(
                'recommendedAge',
                NumberType::class, [
                    'required' => false,
                    'label'    => 'Edad Recomendada Máxima',
                    'html5'    => true,
                ]
            )
            ->add(
                'search',
                SubmitType::class, [
                    'label'    => 'Buscar',
                    'attr'     => ['class' => 'is-mobile is-rounded'],
                    'row_attr' => ['class' => 'form-button is-left'],
                ]
            )
            ->add(
                'clear',
                ResetType::class, [
                    'label'    => 'Borrar Filtros',
                    'attr'     => ['class' => 'is-mobile is-rounded is-danger', 'data-action' => 'search#clear'],
                    'row_attr' => ['class' => 'form-button is-right'],
                ]
            )
            ->add('orderBy', HiddenType::class)
            ->add('order', HiddenType::class);
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
