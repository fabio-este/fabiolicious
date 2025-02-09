<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Site Package',
    'description' => 'Frontend &amp; Backend Customization for fabio-licio.us',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '15.0.0-15.99.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'FabioLicious\\SitePackage\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Fabio Stegmeyer',
    'author_email' => 'fabio.stegmeyer@gmail.com',
    'author_company' => 'Pheenix Coaching',
    'version' => '1.0.0',
];
