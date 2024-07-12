<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = (new Finder())
    ->in(__DIR__)
    ->ignoreVCSIgnored(true)
;

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules([
        '@PER-CS2.0' => true,
        '@PhpCsFixer' => true,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false
    ])
    ->setFinder($finder)
;
