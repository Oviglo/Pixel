<?php 

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}