<?php 

namespace App\Repository;

use App\Entity\Game;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $qb = $this->createQueryBuilder('g')
            ->addSelect('i, s, u')
            ->leftJoin('g.image', 'i')
            ->leftJoin('g.support', 's')
            ->leftJoin('g.user', 'u')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findEnabled(): array 
    {
        $qb = $this->createQueryBuilder('g')
            ->addSelect('i, s, u')
            ->leftJoin('g.image', 'i')
            ->leftJoin('g.support', 's')
            ->leftJoin('g.user', 'u')
            ->where('g.enabled = true')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findByUser(User $user): array 
    {
        $qb = $this->createQueryBuilder('g')
            ->addSelect('i, s, u')
            ->leftJoin('g.image', 'i')
            ->leftJoin('g.support', 's')
            ->leftJoin('g.user', 'u')
            ->where('g.user = :user')
            ->setParameter(':user', $user)
        ;

        return $qb->getQuery()->getResult();
    }
}