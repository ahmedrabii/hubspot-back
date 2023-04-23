<?php

namespace App\Imports\Hubspot\Company;

use App\Entity\Company;
use App\Imports\Contracts\CompanyTransformerInterface;
use DateTimeImmutable;
use Exception;

class CompanyTransformer implements CompanyTransformerInterface
{
    public const SOURCE = 'HubSpot';
    private DateTimeImmutable $fromDate ;

    public function __construct()
    {
        $this->fromDate = new DateTimeImmutable('2021-06-21');
    }

    /**
     * @param array $data
     * @return Company[]
     * @throws Exception
     */
    public function transform(array $data): array
    {
        $companiesObjects = [];
        foreach ($data as $company) {
            $createdAt = new DateTimeImmutable($company['createdAt']);
            if ($this->fromDate <= $createdAt) {
                foreach (CompanyClientBuilder::PROPERTIES as $property) {
                    if (!isset($company['properties'][$property])) {
                        $company['properties'][$property] = '';
                    }
                }
                $companyObject = new Company();
                $properties = $company['properties'];
                $companyObject
                    ->setSource(self::SOURCE)
                    ->setSourceId($company['id'])
                    ->setSourceCreatedAt($createdAt)
                    ->setName($properties['name'])
                    ->setIndustry($properties['industry'])
                    ->setCity($properties['city'])
                    ->setCountry($properties['country'])
                    ->setWebsite($properties['website'])
                    ->setPhone($properties['phone'])
                    ->setZip($properties['zip'])
                    ->setNumberOfEmployees($properties['numberofemployees'])
                    ->setAnnualRevenue($properties['annualrevenue'])
                    ->setDescription($properties['description']);
                $companiesObjects[] = $companyObject;
            }

        }
        return $companiesObjects;
    }
}
