<?php 

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\Support;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

            ->add('category', EntityType::class, options: [
                'class' => Category::class,
                'expanded' => true,
            ])

            ->add('supports', EntityType::class, [
                'class' => Support::class,
                'multiple' => true,
                'expanded' => true, // Affiche sous forme de checkbox
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    // Modifie la requête pour afficher la liste des supports dans le formulaire
                    return $er->createQueryBuilder('s')
                        ->where('s.published = true')
                        ->orderBy('s.name', 'ASC')
                    ;
                }
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