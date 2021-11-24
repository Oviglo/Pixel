<?php 

namespace App\Repository;

use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        // Indique que le repository est associé à l'entité Game
        parent::__construct($registry, Game::class);
    }

    public function findAll(): array 
    {
        /*
        SELECT g.*, i.*, u.*, s.* FROM game AS g
        LEFT JOIN image AS i ON i.id = g.image_id
        ... 
        */
        $qb = $this->createQueryBuilder('g');

        $this->addJoin($qb);

        return $qb->getQuery()->getResult();
    }

    public function findEnabled(): array 
    {
        $qb = $this->createQueryBuilder('g');

        $this->addJoin($qb);
        $qb->where('g.enabled = true');

        return $qb->getQuery()->getResult();
    }

    public function findByUser(User $user): array 
    {
        $qb = $this->createQueryBuilder('g');

        $this->addJoin($qb);


        $qb->where('g.user = :user')
            ->setParameter(':user', $user)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findPagination(int $page = 1, int $itemCount = 20, string $search = ''): Paginator
    {
        $begin = ($page - 1) * $itemCount;

        $qb = $this->createQueryBuilder('g')
            ->setMaxResults($itemCount) // LIMIT
            ->setFirstResult($begin) // OFFSET
        ;

        if ('' !== $search) {
            $qb->where('g.title LIKE :search')
                ->setParameter(':search', '%'.$search.'%')
            ;
        }

        $this->addJoin($qb);

        return new Paginator($qb->getQuery());
    }

    private function addJoin(QueryBuilder $qb): void 
    {
        $qb->addSelect('i, s, u, c')
            ->leftJoin('g.image', 'i')
            ->leftJoin('g.support', 's')
            ->leftJoin('g.user', 'u')
            ->leftJoin('g.categories', 'c')
        ;
    }
}