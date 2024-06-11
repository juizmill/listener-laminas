<?php

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Laminas\Cache',
    'Laminas\Paginator',
    'Laminas\Router',
    'Laminas\Validator',
    'Laminas\Cache\Storage\Adapter\Filesystem',
    'Laminas\Cache\Storage\Adapter\Memory',
    'DoctrineModule',
    'DoctrineORMModule',
    'Application',
];
