<?php

namespace App\Imports\Hubspot\Company;

use App\Entity\Company;
use App\Entity\Contact;
use App\Imports\Contracts\ImporterInterface;
use Doctrine\ORM\EntityManagerInterface;

class CompanyImporter implements ImporterInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CompanyClientBuilder   $builder,
        private readonly CompanyTransformer     $transformer
    ) {
    }

    public function import(): void
    {
        $data = $this->getContent();
        $companies = $this->transformer->transform($data['results']);
        foreach ($companies as $company) {
            $this->em->persist($company);
        }
        if (!empty($companies)) {
            $this->em->flush();
        }
        if ($this->builder->hasNext()) {
            $this->import();
        }
    }

    public function getContent(): array
    {
        $response = $this->builder->getClient()->request(
            'GET',
            $this->builder->url
        );
        $content = $response->toArray();
        $this->builder->hasNext($content);
        return $content;
    }

    public function beforeImport(): void
    {
        $this->em->getRepository(Contact::class)->truncate();
        $this->em->getRepository(Company::class)->truncate();
    }
}
