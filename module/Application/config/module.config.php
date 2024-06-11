<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Application\Service\ProductService;
use Application\Repository\ProductRepository;
use Application\Listener\UpdateProductListener;
use Application\Listener\InsertProductListener;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Application\Repository\LogProductRepository;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/[:action[/:id]]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ReflectionBasedAbstractFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            // repositories
            ProductRepository::class => ReflectionBasedAbstractFactory::class,
            LogProductRepository::class => ReflectionBasedAbstractFactory::class,

            // services
            Service\ProductService::class => ReflectionBasedAbstractFactory::class,

            // listeners
            UpdateProductListener::class => ReflectionBasedAbstractFactory::class,
            InsertProductListener::class => ReflectionBasedAbstractFactory::class,
        ]
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AttributeDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\\Entity' => __NAMESPACE__ . '_driver'
                ],
            ],
        ],
    ],
    'event_listeners' => [
        'update.product' => [ // Nome do evento
            UpdateProductListener::class // Classe responsável pelo evento
        ],
        'insert.product' => [
            UpdateProductListener::class,
            InsertProductListener::class
        ]
    ],
];
