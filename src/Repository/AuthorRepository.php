<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }


    public function searchalph()
    {
        return $this->createQueryBuilder('a')
            ->join('a.books', 'b')
            ->join('b.author', 'author') 
            ->addSelect('b')
            ->addSelect('author') 
            ->orderBy('author.email', 'ASC') 
            ->getQuery()
            ->getResult();
    }
    

    public function minmax($min, $max)
{
    $em = $this->getEntityManager();

    return $em->createQuery('SELECT a FROM App\Entity\Author a WHERE a.nblivre BETWEEN :min AND :max')
        ->setParameters([
            'min' => $min,
            'max' => $max
        ])
        ->getResult();
}

public function deleteAuthors()
{
    $em = $this->getEntityManager();
    
    $qr = $em->createQuery('DELETE FROM App\Entity\Author a WHERE a.nb_books = 0');
    return $qr->execute();
}






//    /**
//     * @return Author[] Returns an array of Author objects
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

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}

