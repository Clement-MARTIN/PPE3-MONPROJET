<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{

    /**
     * Permet d'avoir la config de base d'un champ
     * @param $label
     * @param $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder){
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, $this->getConfiguration("Votre Email : ", "Entrez votre email"))
            ->add('password', PasswordType::class, $this->getConfiguration("Votre Mot de passe : ","Votre mot de passe"))
            ->add('nom', TextType::class, $this->getConfiguration("Votre Nom :", "Votre nom"))
            ->add('prenom', TextType::class, $this->getConfiguration("Votre Prénom :", "Votre prénom"))
            ->add('age', IntegerType::class, $this->getConfiguration("Votre Age :", "Votre âge"))
            ->add('adresse', TextType::class, $this->getConfiguration("Votre Adresse :", "Votre adresse"))
            ->add('phone', TextType::class, $this->getConfiguration("Votre Téléphone :", "Votre numero de téléphone"))
            ->add('roles', ChoiceType::class,  [
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'label' => 'Choisir votre status :',
                'attr' => ['class' => 'form-select'],
                'choices'  => [
                    'Acheteur' => 'ROLE_ACHETEUR',
                    'Vendeur' => 'ROLE_VENDEUR',
                ],
            ])

        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
