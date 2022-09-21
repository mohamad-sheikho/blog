<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => [
                    'placeholder' => "Ajoutez un titre à l'article"
                ]
            ])
            ->add('contenu', null,[
                'attr' =>[
                    'placeholder' => "Ajoutez du contenu à votre article"
                ]
            ])
            ->add('dateCreation', null, [
                'widget' => 'single_text'
            ])
            ->add('categories', EntityType::class,[
                'class' => Category::class,
                'multiple' => true,
                'by_reference' => false
            ])
            ->add('brouillon', submitType::class,[
                'label' => 'Entregistrer en brouillon'
            ])

            ->add('publier', SubmitType::class,[
                'label' => 'Publier'
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
