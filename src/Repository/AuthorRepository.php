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

    public function save(Author $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Author $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    protected function getLikePattern(string $value): string
    {
        return '%'.mb_strtolower($value, 'UTF-8').'%';
    }

    public function searchAllAuthors(Author $entity)
    {
        $queryBuilder = $this->createQueryBuilder('a');
        if (null !== $entity->getName()) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like($queryBuilder->expr()->lower('a.name'), ':name'))
                ->setParameter('name', $this->getLikePattern($entity->getName()))
            ;
        }

        if (null !== $entity->getFirstName()) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like($queryBuilder->expr()->lower('a.firstName'), ':firstName'))
                ->setParameter('firstName', $this->getLikePattern($entity->getFirstName()))
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
