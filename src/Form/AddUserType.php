<?php

namespace App\Form;

use App\Entity\UsersW;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,
                                                    ['attr' => ['placeholder' => 'Enter Your Name',
                                                        'pattern' => '[a-zA-Z0-9]+',
                                                        'title' => 'Include a-Z and 0-9']])
            ->add('homePage', UrlType::class, ['attr' => ['placeholder' => 'http://Homepage',
                                                          'pattern'=> 'https?://.+',
                                                          'title' => 'Include http://' ]])
            ->add('email', EmailType::class, ['attr' =>
                                       ['placeholder' => 'Enter Your Email','pattern' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 3}$']
                      ])
            ->add('message', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UsersW::class,
        ]);
    }
}
