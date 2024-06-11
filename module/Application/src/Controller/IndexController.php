<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\ProductService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function indexAction()
    {
        $this->productService->insert([
            'name' => 'Product ' . rand(1, 100),
        ]);

        $products = $this->productService->finAll();

        return new ViewModel(compact('products'));
    }

    public function editAction()
    {
        $id = $this->params('id');
        $product = $this->productService->update([
            'id' => $id,
            'name' => 'Eita foi editado Data: ' . date('Y-m-d H:i:s'),
        ]);

        return new ViewModel(compact('product'));
    }
}
