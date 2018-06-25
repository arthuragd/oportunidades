<?php
// src/Form/UserType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
            ->add('username', TextType::class, array('attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px')))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password', 'attr' => array ('class'=> 'form-control','style' => 'margin-bottom:15px')),
                'second_options' => array('label' => 'Repeat Password', 'attr' => array ('class'=> 'form-control','style' => 'margin-bottom:15px')),
            ))
            ->add('roles', ChoiceType::class, array(
                'label' => 'Funcao',
                'attr' => array('class'=> 'form-control','style' => 'margin-bottom:15px'),
                'choices' => array(
                                    'Gestor' => 'ROLE_USER',
                                    'Candidato' => 'ROLE_CANDIDATE')
                ))
            ->add('save', SubmitType::class, array('label' => 'Register','attr' => array('class' => 'btn btn-success')));
    }
//type="password"
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}