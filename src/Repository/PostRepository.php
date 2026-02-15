<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /*Recupere les deniere actualités, trie par ID décroissant et limit a 3*/
    /*Pour la pagge accueil*/
public function findLatest(int $limit = 3): array
{
    return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

/* Recupere toutes les actualités, tries <decroissant></decroissant>*
*Utilisée pour la page toutes les actualités*/
public function findAllOrdered(): array
{
    return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'DESC')
        ->getQuery()
        ->getResult();
}

}
