<?php

namespace Application\Listener;

use Application\Entity\Product;
use Laminas\EventManager\EventInterface;
use Application\Repository\LogProductRepository;

class UpdateProductListener
{
    public function __construct(protected LogProductRepository $logProductRepository)
    {
    }

    public function __invoke(EventInterface $event): void
    {
        /** @var Product $product */
        $product = $event->getParams();
        $this->logProductRepository->create($product, 'update');
    }
}