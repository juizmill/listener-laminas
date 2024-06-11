<?php

namespace Application\Repository;

use Doctrine\ORM\EntityManager;
use Application\Entity\Product;
use Application\Entity\LogProduct;

class LogProductRepository
{
    public function __construct(protected EntityManager $entityManager)
    {
    }

    public function create(Product $product, string $eventName): void
    {
        $name = sprintf('Event: %s, Product Id: %s, Name: %s', $eventName, $product->getId(), $product->getName());

        $logProduct = new LogProduct();
        $logProduct->setName($name);

        $this->entityManager->persist($logProduct);
        $this->entityManager->flush();
    }
}