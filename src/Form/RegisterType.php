<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// Type == texte/pwd/email etc..
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                ['attr' => ['placeholder' => 'Veuillez entrer votre email']]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => 'Prénom',
                    'constraints' => new Length(null, 2, 30),
                    'attr' => ['placeholder' => 'Votre prénom ici']
                ]
            )
            //TextType == typage
            //Label change firstName par Prénom
            ->add(
                'lastname',
                TextType::class,
                [
                    'label' => 'Nom',
                    'attr' => ['placeholder' => 'Votre nom ici'],
                    'constraints' => new Length(null, 2, 30)
                ]
            )
            //IMPORTANT TRAITEMENT DU MDP EN BDD VIA LE FORM
            /* RepeatedType permet de vérifier les MDP */
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe doivent être identique',
                    'label' => 'Mot de passe',
                    'required' => true,
                    'first_options' => [
                        'label' => 'Mot de passe',
                        'attr' => ['placeholder' => 'Veuillez entrer votre mot de passe']
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe',
                        'attr' => ['placeholder' => 'Veuillez entrer votre mot de passe']
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                ['label' => 'S\'inscrire']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
