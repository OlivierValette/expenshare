<?php

namespace App\Repository;

use App\Entity\Expense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Expense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expense[]    findAll()
 * @method Expense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Expense::class);
    }
    
    public function personExpense($id): array
    {
        $qb = $this->createQueryBuilder('e');
        
        $qb = $qb->select('e')
            ->innerJoin('e.person', 'p')
            ->andWhere($qb->expr()->eq('p.id', ':id'));
        
        $qb = $qb->setParameter('id', $id);
        
        return $qb->getQuery()->getArrayResult();
    }
}
