<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditionType extends AbstractType
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
            ->add('password', PasswordType::class, $this->getConfiguration("Votre mot de passe : ","******************"))
            ->add('phone', TextType::class, $this->getConfiguration("Votre Téléphone :", "Votre numero de téléphone"))
            ->add('nom', TextType::class, $this->getConfiguration("Votre Nom :", "Votre nom"))
            ->add('prenom', TextType::class, $this->getConfiguration("Votre Prénom :", "Votre prénom"))
            ->add('age', IntegerType::class, $this->getConfiguration("Votre Age :", "Votre âge"))
            ->add('adresse', TextType::class, $this->getConfiguration("Votre Adresse :", "Votre adresse"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
