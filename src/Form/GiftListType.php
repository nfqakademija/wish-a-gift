<?php

namespace App\Form;

use App\Entity\GiftList;
use App\Entity\Gift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class GiftListType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('uuid', TextType::class, ['disabled' => true])
//            ->add('uuidAdmin', HiddenType::class)
            ->add('firstname', TextType::class,
                array(
                    'required' => true,
                    'constraints' => array(new NotBlank(), new Length(['max' => 100]))
                ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'constraints' => array(new Email(), new NotBlank())
            ))
            ->add('title', TextType::class,
                array(
                'required' => true,
                'constraints' => array(new Length(array('min' => 3)), new NotBlank())
                ))
            ->add('description', TextareaType::class,
                array(
                    'required' => true,
                    'constraints' => array(new Length(array('min' => 3)), new NotBlank())
                ))
            ->add('gifts', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => GiftType::class,
                'prototype' => GiftType::class])
            ->add('Save', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => GiftList::class,
//            "allow_extra_fields" => true
        ));
    }
}
