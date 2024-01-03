<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Runtime\SymfonyRuntime;

class FlyRuntime extends SymfonyRuntime
{
    public function __construct(array $options = [])
    {
        $options['disable_dotenv'] = true;

        parent::__construct($options);
    }    
}
