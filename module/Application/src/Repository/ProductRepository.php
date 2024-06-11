<?php

namespace Application\Repository;

use Doctrine\ORM\EntityManager;
use Application\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository
{
    protected EntityRepository $repository;

    public function __construct(protected EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(Product::class);
    }

    public function all(): array
    {
        return $this->repository->findAll();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function insert(array $data): Product
    {
        $product = new Product();
        $product->setName($data['name']);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product->setName($data['name']);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}