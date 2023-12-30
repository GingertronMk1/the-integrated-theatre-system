<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__.'/assets',
        __DIR__.'/config',
        __DIR__.'/migrations',
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $ecsConfig->dynamicSets(['@Symfony']);

    $ecsConfig->ruleWithConfiguration(
        GlobalNamespaceImportFixer::class,
        [
            'import_classes' => true,
        ]
        );
};
