<?php 

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\Support;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class GameType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /*
    PHP 8

    public function __construct(private Security $security)
    {

    }
    */

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
        ;

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add('enabled', ChoiceType::class, [
                'label' => 'game.enabled',
                'choices' => [ // Choix proposés
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true, // type de selection
            ]);
        }

        $builder->add('support', EntityType::class, [
                'class' => Support::class,
                'required' => false,
                'group_by' => 'constructor',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.year');
                }
            ])

            ->add('categories', EntityType::class, [
                'label' => 'game.categories',
                'multiple' => true,
                'expanded' => true,
                'class' => Category::class,
            ])

            // Ajout du formulaire ImageType 
            ->add('image', ImageType::class)

            ->add('deleteImage', CheckboxType::class, [
                'label' => 'game.delete_image',
                'required' => false,
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