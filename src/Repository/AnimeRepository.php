<?php

namespace App\Repository;

use App\Entity\Anime;
use App\Entity\Category;
use App\Entity\WatchList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Anime>
 *
 * @method Anime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anime[]    findAll()
 * @method Anime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
     private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Anime::class);
    }

    public function findAnimes(int $page,  WatchList $watchList = null): PaginationInterface
    {
        $data = $this->createQueryBuilder('p')
        
         
        
        ->addOrderBy('p.id', 'ASC');
        $data->getQuery()
        ->getResult();
   
        $animes = $this->paginatorInterface->paginate( $data, $page, 9);
        return $animes;
    }
}

//    /**
//     * @return Anime[] Returns an array of Anime objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Anime
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

