<?php

namespace App\Repository;

use App\Entity\Blog;
use App\Entity\Compte;
use App\Entity\Categories;
use App\Service\ParamsService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    /**
     * Variable $this->_listLimit
     *
     * @var ParamsService
     */
    private $_listLimit;

    /**
     * Variable $this->_language
     *
     * @var ParamsService
     */
    private $_language;

    /**
     * Void __construct()
     *
     * @param ParamsService   $params   comment
     * @param ManagerRegistry $registry comment
     */
    public function __construct(ParamsService $params, ManagerRegistry $registry)
    {
        $this->_listLimit = $params->config()['site']['listLimit'];
        $this->_language = $params->locale();
        parent::__construct($registry, Blog::class);
    }

    /**
     * Function findByTotalAll()
     * 
     * @return array
     */
    public function findByTotalAll(): array
    {
        return $this->createQueryBuilder('B')
            ->select("count(B.id) AS total")
            ->where('B.publish = :publish')
            ->andWhere('B.language = :language')
            ->setParameter('publish', true)
            ->setParameter('language', $this->_language)
            ->orderBy('B.id', 'ASC')
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Function findByAll(int $page)
     * 
     * @param integer $page comment
     * 
     * @return array
     */
    public function findByAll(int $page): array
    {
        $firstResult = ($page - 1) * $this->_listLimit;

        return $this->createQueryBuilder('B')
            ->select(
                'B.title, B.slug, B.created, B.metadesc, 
                 B.metakeys, B.hits, B.image,  
                 Cat.name AS categorie, 
                 C.nom, C.prenom, C.pseudo'
            )
            ->join(Categories::class, 'Cat', 'WITH', 'Cat.id = B.category')
            ->join(Compte::class, 'C', 'WITH', 'C.id = B.compte')
            ->where('B.publish = :publish')
            ->andWhere('B.language = :language')
            ->setParameter('publish', true)
            ->setParameter('language', $this->_language)
            ->orderBy('B.id', 'ASC')
            ->setFirstResult($firstResult)
            ->setMaxResults($this->_listLimit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Function findBySlug(string $slug)
     * 
     * @param string $slug comment
     * 
     * @return void
     */
    public function findBySlug(string $slug)
    {
        return $this->createQueryBuilder('B')
            ->select(
                'B.title, B.slug, B.content, B.created, B.metadesc, 
                 B.metakeys, B.hits, B.image,  
                 Cat.name AS categorie, 
                 C.nom, C.prenom, C.pseudo'
            )
            ->join(Categories::class, 'Cat', 'WITH', 'Cat.id = B.category')
            ->join(Compte::class, 'C', 'WITH', 'C.id = B.compte')
            ->where('B.publish = :publish')
            ->andWhere('B.slug = :slug')
            ->setParameter('publish', true)
            ->setParameter('slug', $slug)
            ->orderBy('B.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Blog[] Returns an array of Blog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Blog
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
