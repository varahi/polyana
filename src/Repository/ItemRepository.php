<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public const TABLE = 'App\Entity\Item';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function save(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param array $order
     * @return Item[]
     */
    public function findAllOrder(array $order)
    {
        return $this->findBy([], $order);
    }

    /**
     * @param $limit
     * @param $offset
     * @return float|int|mixed|string
     */
    public function findLimitOrder($limit, $offset)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $expr = $qb->expr();

        $qb->select('i')
            ->from(self::TABLE, 'i')
            ->where($expr->neq('i.hidden', 1))
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('i.created', 'ASC');

        $reviews = $qb->getQuery()->getResult();
        return $reviews;
    }

    /**
     * @param Item $item
     */
    public function findByParams($category, $location)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $expr = $qb->expr();

        $qb->select('i')
            ->from(self::TABLE, 'i')
            ->where($expr->neq('i.hidden', 1))
            ->orderBy('i.created', 'DESC');

        if ($category) {
            $qb->join('i.category', 'c')
                ->andWhere($qb->expr()->eq('c.id', $category->getId()));
        }

        if ($location) {
            $qb->join('i.location', 'l')
                ->andWhere($qb->expr()->in('l.id', $location->getId()));
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Category $category
     * @param $limit
     * @return float|int|mixed|string
     */
    public function findByCategory(Category $category, $limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $expr = $qb->expr();
        $qb->select('i')
            ->from(self::TABLE, 'i')
            ->join('i.category', 'c')
            ->where($qb->expr()->eq('c.id', $category->getId()))
            ->setMaxResults($limit)
            ->orderBy('i.created', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function findByLocation(Location $location, $limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $expr = $qb->expr();
        $qb->select('i')
            ->from(self::TABLE, 'i')
            ->join('i.location', 'l')
            ->where($qb->expr()->in('l.id', $location->getId()))
            ->setMaxResults($limit)
            ->orderBy('i.created', 'DESC');

        return $qb->getQuery()->getResult();
    }



//    /**
//     * @return Item[] Returns an array of Item objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Item
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
