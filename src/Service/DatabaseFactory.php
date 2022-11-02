<?php
declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;

class DatabaseFactory
{
    /**
     * Create a Doctrine entity manager
     *
     * @return EntityManager
     */
    public static function create()
    {
        $isDevMod = true;
        $metadata = ORMSetup::createAnnotationMetadataConfiguration([__DIR__ . '/../Entity'], $isDevMod);

        $dbParams = [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ .'/../../database.sqlite'
        ];

        return EntityManager::create($dbParams, $metadata);
    }
}
