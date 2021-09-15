<?php 

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajout des champs dans le formulaire
        $builder
            ->add('title')
            ->add('content')
            ->add('enabled')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Indique que ce formulaire est lié à l'entité Game
        $resolver->setDefaults([
            'data_class' => Game::class // Game::class retourne une chaine avec l'espace de nom vers cette classe
        ]);
    }
}