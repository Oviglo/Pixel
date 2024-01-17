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
        string $published = 'ALL', 
        string $search = '', 
        string $category = 'ALL',
        int $itemCount = 10,
        int $page = 1
    ): Paginator
    {
        $begin = ($page - 1) * $itemCount; // Calcul de l'offset

        $qb = $this->createQueryBuilder('g')
            ->addSelect('c, s, a') // Ajout de select pour limiter le nombre de requêtes automatiques
            ->leftJoin('g.category', 'c') // Jointure sur la catégorie
            ->leftJoin('g.supports', 's')
            ->leftJoin('g.author', 'a')

            ->setMaxResults($itemCount) // LIMIT
            ->setFirstResult($begin) // OFFSET
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
                ->setParameter('category', (int)$category)
            ;
        }

        // Permet de faire la requête pour la liste de la page ET le nombre total pour calculer le nombre de page
        return new Paginator($qb->getQuery());
    }
}