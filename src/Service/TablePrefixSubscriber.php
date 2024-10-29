<?php

namespace App\Service;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;

class TablePrefixSubscriber implements EventSubscriber
{
    private $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function getSubscribedEvents(): array
    {
        return ['loadClassMetadata'];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args): void
    {
        $classMetadata = $args->getClassMetadata();
        
        // Ajouter le préfixe à toutes les tables
        if (!$classMetadata->isInheritanceTypeSingleTable()) {
            $classMetadata->setPrimaryTable([
                'name' => $this->prefix . $classMetadata->getTableName(),
            ]);
        }

        // Ajouter le préfixe aux tables d'associations (jointures)
        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] === \Doctrine\ORM\Mapping\ClassMetadata::MANY_TO_MANY && isset($mapping['joinTable'])) {
                $mappedTableName = $this->prefix . $mapping['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $mappedTableName;
            }
        }
    }
}
