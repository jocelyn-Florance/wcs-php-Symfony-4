<?php

namespace App\Repository;

use App\Entity\Categorys;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Categorys|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorys|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorys[]    findAll()
 * @method Categorys[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorysRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categorys::class);
    }



}
