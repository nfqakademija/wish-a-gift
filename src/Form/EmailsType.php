<?php

namespace App\Form;

use App\Entity\GiftList;
use App\Entity\Gift;
use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class EmailsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class,
                array(
                    'required' => true,
                    'constraints' => array(new NotBlank(), new Length(['max' => 100]))
                ))
            ->add('emails', CollectionType::class, [
//                'constraints' => array(new Email(), new NotBlank()),
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => EmailType::class,
                'entry_options' => array(
                    'attr' => ['class' => 'form-group'],
                ),
                'prototype' => true,
                'label' => false,
//                'delete_empty' => function (Gift $gift = null) {
//                return null === $gift || empty($gift->getTitle());
//                },
//                'disabled' => !$options['allow_gift_editing'],
            ])
            ->add('send', SubmitType::class);

    }
//
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => GiftList::class,
//            'allow_gift_editing' => true,
//            "allow_extra_fields" => true
//        ));
//    }
}
