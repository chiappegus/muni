<?php

namespace App\Form;

use App\Entity\Persona;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class PersonaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Persona|null $persona */
        $persona = $options['data'] ?? null;
        //dd($persona);
        $isEdit = $persona && $persona->getId();
        //dd($isEdit);
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('dni')
            ->add('intendente');

        $imageConstraints = [
            new Image([
                // 'maxSize' => '5k', = 400
                //'maxSize' => '1024k',2097152
                //'mimeTypes'        => ["image/gif", "image/png"],
                'mimeTypes'              => "image/*",
                //'mimeTypes' => "image/png",
                'maxSize'                => "8M",
                'mimeTypesMessage'       => 'El archivo no es una imagen válida.',
                'sizeNotDetectedMessage' => 'El archivo no es una imagen válida',
                // 'maxSize' => '5M',
                //'maxHeight' => '8M',
            ]),
        ];

        if (!$isEdit || !$persona->getImageFilename()) {
            $imageConstraints[] = new NotNull([
                'message' => 'Por favor Subi una IMAGEN menor a 1MB',
            ]);
        };
        // dd($imageConstraints);

        $builder
            ->add('imageFile', FileType::class, [
                'mapped'      => false,
                'required'    => false,
                'constraints' => $imageConstraints,

            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Persona::class,
        ]);
    }
}
