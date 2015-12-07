<?php

namespace TM\BlogBundle\Entity;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
	public function last($id, $limit = null)
    {
        $qb = $this->createQueryBuilder('c')
        	 ->leftJoin('c.article', 'a')
             ->addSelect('a')
             ->leftJoin('c.user', 'u')
             ->addSelect('u')
             ->where('a.id = :id')
             ->setParameter('id', $id)
             ->orderBy('c.date', 'DESC')
             ->setMaxResults($limit);

        return $qb  ->getQuery()
                    ->getResult();
    }

    public function all($limit = null)
    {
        $qb = $this->createQueryBuilder('c')
             ->leftJoin('c.article', 'a')
             ->addSelect('a')
             ->leftJoin('c.user', 'u')
             ->addSelect('u')
             ->orderBy('c.date', 'DESC')
             ->setMaxResults($limit);

        return $qb  ->getQuery()
                    ->getResult();
    }
}