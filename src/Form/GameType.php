<?php 

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajout des champs dans le formulaire
        $builder
            ->add('title', null, [
                'label' => 'game.title'
            ])
            ->add('content', null, [
                'label' => 'game.content',
                'help' => 'game.content_help',
                'attr' => ['rows' => 6] // Modifie les attributs HTML du champ
            ])
            ->add('enabled', ChoiceType::class, [
                'label' => 'game.enabled',
                'choices' => [ // Choix proposés
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true, // type de selection
            ])
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