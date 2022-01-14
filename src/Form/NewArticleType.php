<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewArticleType extends AbstractType
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
            ->add('name', TextType::class, $this->getConfiguration("Nom de l'article", "Le nom de l'article"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description de l'article", "Entrez une belle description de l'article"))
            ->add('prix', NumberType::class, $this->getConfiguration("Le prix", "Le prix"))
            ->add('fraisDePort', NumberType::class, $this->getConfiguration("Les frais de port", "Le prix"))
            ->add('quantite', NumberType::class, $this->getConfiguration("La quantité", "La quantité"))
            ->add('origine', TextType::class, $this->getConfiguration("Le pays / région d'origine", "Le nom du pays / région"))
            ->add('idCat', EntityType::class, ['class' => Categorie::class, 'choice_label' => 'name_cat',
                'label' => "Catérogie de l'article"])
            ->add('images', FileType::class, [
                'label' => 'Sélectionner les images',
                'multiple' =>true,
                'mapped' =>false,
                'required' =>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
