<?php

namespace App\Traites;

trait RepositoryTrait
{
    public function truncate(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $platform = $connection->getDatabasePlatform();
        $sql = [
            'SET FOREIGN_KEY_CHECKS=0;',
            $platform->getTruncateTableSQL($this->getClassMetadata()->getTableName(), true).';',
            'SET FOREIGN_KEY_CHECKS=1;',
        ];
        $connection->executeQuery(implode('', $sql));
    }
}
