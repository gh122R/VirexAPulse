<?php

declare(strict_types=1);

namespace App\Core\Environment;

use App\Core\Facades\Environment\Loader as EnvironmentLoader;

class EnvValidator
{
    public function validate(): bool
    {
        try {
            EnvironmentLoader::Dotenv()
                ->required(['DRIVER', 'HOST', 'DATABASE', 'USERNAME', 'PASSWORD'])
                ->notEmpty();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}