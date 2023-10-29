<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }


    public function searchref($ref){
        return $this->createQueryBuilder('a')
        ->where('a.ref=:name')
        ->setParameter('name', $ref)
        ->getQuery()
        ->getResult();
        }

        public function findByBooksSorting()
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a') // Assurez-vous que 'author' est le nom de la relation entre Book et Author
            ->orderBy('a.username', 'ASC') // Tri par nom d'auteur en ordre alphabétique
            ->getQuery()
            ->getResult();
    }

    public function findBooks_2023()
    {
        $em = $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')
            ->where('b.publicationDate < :year')
            ->andWhere('a.nb_books > :count')
            ->setParameters([
                'year' => new \DateTime('2023-01-01'),
                'count' => 35,
            ])
            ->orderBy('b.publicationDate', 'ASC')
            ->getQuery();

        return $em->getResult();
    }


    public function updateWilliam()
    {
        $em = $this->getEntityManager();
        $authorRepository = $em->getRepository(Author::class);

        $shakespeareAuthor = $authorRepository->findOneBy(['username' => 'William Shakespeare']);

        if ($shakespeareAuthor) {
            $em = $this->_em->createQueryBuilder()
                ->update(Book::class, 'b')
                ->set('b.category', ':newCategory')
                ->where('b.author = :shakespeareAuthor')
                ->setParameter('newCategory', 'Romance')
                ->setParameter('shakespeareAuthor', $shakespeareAuthor)
                ->getQuery();

            return $em->execute();
        }

        return false; 
    }


    public function SumBooks()
    {
        $em = $this->getEntityManager();
       return $em->createQuery('SELECT SUM(b.nb_books) as total FROM App\Entity\Book b WHERE b.category = :category ')
        ->setParameter('category', 'Science Fiction');
        ->getResult();
    }



    public function BooksBetween()
    {
        $em = $this->getEntityManager();

        return $em->createQuery('SELECT b FROM App\Entity\Book b WHERE b.publicationDate BETWEEN :startDate AND :endDate ')
        ->setParameter('startDate', new \DateTime('2014-01-01'))
        ->setParameter('endDate', new \DateTime('2018-12-31'));
        ->getResult();
    }



}



//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

