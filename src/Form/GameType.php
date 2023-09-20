<?php 

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add('name', options: [
                'label' => 'Nom du jeu',
                'help' => 'Quel est le titre du jeu ?',
            ])
            ->add('description', options: [
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('releaseDate', options: [
                'years' => range(1972, date('Y') + 2), // de 1972 à la date courante + 2 ans
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Indique que ce formulaire va traiter les données d'objet Game
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}