<?php

namespace App\Form;

use App\Entity\Gift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class GiftType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                [
                    'constraints' => [new Length(['min' => 3]), new Length(['max' => 255])], // TODO: add NotBlank
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Enter gift...',
                        'class' => 'form-control'
                    ]
                ])
            ->add('reservable', CheckboxType::class,
                [
                    'label' => false,
//                    'data' => true,
                    'value' => $this->checkedCheckbox(), // TODO: it should automatically work, without setting value
                ]

            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Gift::class,
        ));
    }

    public function checkedCheckbox()
    {
        $gift = new Gift();
        if ($gift->getReservable()) { // TODO: will it ever be false? Redundant logic
            return true;
        }
        return false;
    }
}
