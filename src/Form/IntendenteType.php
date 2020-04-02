<?php

namespace App\Form;

use App\Entity\Intendente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntendenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('estado')
            ->add('fecha_inicio', DateType::class, [
                'widget' => 'single_text',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5'  => false,
                // adds a class that can be selected in JavaScript
                'attr'   => ['class' => 'js-datepicker'],
                'format' => 'dd/mm/yyyy',
            ])

            ->add('fin_Funcion', DateType::class, [
                'widget' => 'single_text',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5'  => false,
                // adds a class that can be selected in JavaScript
                'attr'   => ['class' => 'js-datepicker'],
                'format' => 'dd/mm/yyyy',
            ])
            //->add('fin_Funcion')
            //https://symfony.com/doc/current/reference/forms/types/date.html
            ->add('relation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Intendente::class,
        ]);
    }
}
