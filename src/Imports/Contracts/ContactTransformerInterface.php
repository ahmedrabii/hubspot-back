<?php

namespace App\Imports\Contracts;

use App\Entity\Contact;

interface ContactTransformerInterface
{
    /**
     * @param array $data
     * @return array<Contact>
     */
    public function transform(array $data): array;

}
