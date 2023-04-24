<?php

namespace App\Imports;

use App\Imports\Contracts\ImporterInterface;
use App\Imports\Hubspot\Company\CompanyImporter;
use App\Imports\Hubspot\Contact\ContactImporter;
use Closure;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MasterImporter
{
    public const IMPORTERS = [
        CompanyImporter::class,
        ContactImporter::class,
    ];

    public function __construct(private readonly ContainerInterface  $container)
    {
    }

    public function import(Closure $callback = null): void
    {
        foreach (self::IMPORTERS as $importer) {
            /** @var ImporterInterface $importerService */
            $importerService = $this->container->get($importer);
            $importerService->beforeImport();
            $importerService->import();
            if ($callback) {
                $callback();
            }
        }

    }

}
