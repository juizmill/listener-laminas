<?php

namespace Application\Service;

use Application\Entity\Product;
use Application\Repository\ProductRepository;
use Laminas\EventManager\EventManagerInterface;

class ProductService
{
    public function __construct(
        protected EventManagerInterface $eventManager,
        protected ProductRepository $productRepository
    ) {
        $this->eventManager->setIdentifiers([__CLASS__, get_class($this)]);
    }

    public function findOne(int $id): ?Product
    {
        $product = $this->productRepository->find($id);
        if (! $product) {
            throw new \Exception('Product not found');
        }

        return $product;
    }

    public function finAll(): array
    {
        return $this->productRepository->all();
    }

    public function update(array $data): Product
    {
        $product = $this->productRepository->find($data['id']);

        $product = $this->productRepository->update($product, $data);
        $this->eventManager->trigger(__FUNCTION__ . '.product', $this, $product);

        return $product;
    }

    public function insert(array $data): void
    {
        $product = $this->productRepository->insert($data);
        $this->eventManager->trigger(__FUNCTION__ . '.product', $this, $product);
    }
}