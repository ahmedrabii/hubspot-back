<?php

namespace App\Imports\Contracts;

interface ImporterInterface
{
    public function import(): void;
    public function beforeImport(): void;

}
