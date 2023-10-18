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
use Symfony\Component\Security\Core\Security;

class GameType extends AbstractType
{
    public function __construct(private Security $security)
    {
        
    }

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
            ->add('category', EntityType::class, [
                'class' => Category::class,
            ])

            ->add('supports', EntityType::class, options: [
                'class' => Support::class,
                'multiple' => true,
                'expanded' => true, // Affiche sous forme de checkbox
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('s')
                        ->where('s.published = true')
                        ->orderBy('s.name', 'ASC')
                    ;
                }
            ])
        ;

        // Ajoute le champ seulement si l'utilisateur est admin
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add('published');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Indique que ce formulaire va traiter les données d'objet Game
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}