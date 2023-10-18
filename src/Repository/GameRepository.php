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
        // Game::class = 'App\Entity\Game'
        parent::__construct($registry, Game::class);
    }

    public function findAlpha(): array 
    {
        $qb = $this->createQueryBuilder('g')
            ->orderBy('g.name', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findFiltered(
        string $published = 'ALL', 
        string $search = '', 
        string $category = 'ALL',
        int $itemCount = 10,
        int $page = 1
    )
    {
        $offset = ($page - 1) * $itemCount;

        $qb = $this->createQueryBuilder('g')
            ->addSelect('c, s, a')
            ->leftJoin('g.category', 'c')
            ->leftJoin('g.supports', 's')
            ->leftJoin('g.author', 'a')
            ->setMaxResults($itemCount) // LIMIT
            ->setFirstResult($offset) // OFFSET
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
                ->setParameter('category', (int) $category)
            ;
        }

        return new Paginator($qb->getQuery());
    }
}