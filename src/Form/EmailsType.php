<?php

namespace App\Form;

use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EmailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'url',
                TextType::class,
                [
                'required' => true,
                'constraints' => [new NotBlank(), new Length(['max' => 255])]
                ]
            )
            ->add('emails', CollectionType::class, [
                'constraints' => [new All(new Email()), new All(new NotBlank()), new All(new Length(['max' => 255]))],
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => EmailType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ],
                'prototype' => true,
                'label' => false,
            ])
            ->add('send', SubmitType::class);
    }
}
