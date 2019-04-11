<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'choices' => array(
                    'Unsubscribed' => '0',
                    'By Email' => '1',
                    'By Phone' => '2',
                ),]
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

}