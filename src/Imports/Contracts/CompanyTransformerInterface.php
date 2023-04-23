<?php

namespace App\Imports\Contracts;

use App\Entity\Company;

interface CompanyTransformerInterface
{
    /**
     * @param array $data
     * @return array<Company>
     */
    public function transform(array $data): array;

}
