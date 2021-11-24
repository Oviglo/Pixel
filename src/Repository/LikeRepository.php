<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Like;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

    public function findOneByUserAndGame(User $user, Game $game): ?Like
    {
        $qb = $this->createQueryBuilder('l')
            ->where('l.user = :user')
            ->andWhere('l.game = :game')
            ->setParameter(':user', $user)
            ->setParameter(':game', $game)
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    } 
}
