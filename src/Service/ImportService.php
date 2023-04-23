<?php

namespace App\Service;

use App\Imports\MasterImporter;
use Closure;

class ImportService
{
    public function __construct(private readonly MasterImporter $importer)
    {
    }

    public function import(Closure $callback = null): void
    {
        $this->importer->import($callback);
    }
}
