<?php 

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findFiltered(
<<<<<<< HEAD
        string $published = 'ALL', 
        string $search = '',
=======
        string $published, 
        string $search = '', 
>>>>>>> TP3
        string $category = 'ALL',
        int $itemCount = 10,
        int $page = 1
    ): Paginator
    {
<<<<<<< HEAD
        $offset = ($page - 1) * $itemCount;

        $qb = $this->createQueryBuilder('g')
            ->addSelect('c, s, a')
            ->leftJoin('g.category', 'c')
            ->leftJoin('g.supports', 's')
            ->leftJoin('g.author', 'a')
            ->setMaxResults($itemCount) // LIMIT
            ->setFirstResult($offset) // OFFSET
=======
        $begin = ($page - 1) * $itemCount; // Calcul de l'offset

        $qb = $this->createQueryBuilder('g')
            ->addSelect('c, s, a') // Ajout de select pour limiter le nombre de requêtes automatiques
            ->leftJoin('g.category', 'c') // Jointure sur la catégorie
            ->leftJoin('g.supports', 's')
            ->leftJoin('g.author', 'a')

            ->setMaxResults($itemCount) // LIMIT
            ->setFirstResult($begin) // OFFSET
>>>>>>> TP3
        ;

        if ($published !== 'ALL') {
            $qb->where('g.published = :published')
                ->setParameter('published', $published === '1')
            ;
        }

        if ($search !== '') {
            $qb->andWhere('g.name LIKE :search')
                ->setParameter('search', "%$search%")
            ;
        }

        if ($category !== 'ALL') {
            $qb->andWhere('c.id = :category')
<<<<<<< HEAD
                ->setParameter(':category', $category)
            ;
        }

=======
                ->setParameter('category', (int)$category)
            ;
        }

        // Permet de faire la requête pour la liste de la page ET le nombre total pour calculer le nombre de page
>>>>>>> TP3
        return new Paginator($qb->getQuery());
    }
}