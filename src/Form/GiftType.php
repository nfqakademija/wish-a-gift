<?php

namespace App\Form;

use App\Entity\Gift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class GiftType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                array(
                    'constraints' => array(new NotBlank(), new Length(array('min' => 3)), new Length(['max' => 255])),
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Enter gift...',
                        'class' => 'form-control'
                    ]                ))
            ->add('reservable', CheckboxType::class,
                array(
                    'label' => false,
                    'attr' => [
                        'checked' => 'checked'
                    ]
                ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Gift::class,
        ));
    }
}
