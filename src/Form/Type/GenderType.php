<?php


namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GenderType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => array(
                'm' => 'Male',
                'f' => 'Female',
            ),]
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

}