<?php

declare(strict_types=1);

namespace Owl\Bundle\EquipmentBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Owl\Component\Equipment\Repository\EquipmentAttributeValueRepositoryInterface;

class EquipmentAttributeValueRepository extends EntityRepository implements EquipmentAttributeValueRepositoryInterface
{
    public function findByJsonChoiceKey(string $choiceKey): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.json LIKE :key')
            ->setParameter('key', '%"' . $choiceKey . '"%')
            ->getQuery()
            ->getResult()
        ;
    }
}
