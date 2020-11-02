<?php

namespace App\Form;

use App\Entity\Possess;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PossessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wish')
            ->add('user')
            ->add('equipment');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Possess::class,
            'allow_extra_fields' => false,
            'csrf_protection'    => false,
        ]);
    }
}
