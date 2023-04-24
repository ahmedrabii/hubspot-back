<?php

namespace App\Imports\Hubspot\Contact;

use App\Entity\Company;
use App\Entity\Contact;
use App\Imports\Contracts\ContactTransformerInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ContactTransformer implements ContactTransformerInterface
{
    public const SOURCE = 'HubSpot';

    private array $companies = [];

    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /**
     * @param array $data
     * @return Contact[]
     * @throws Exception
     */
    public function transform(array $data): array
    {
        $contactsObjects = [];
        foreach ($data as $contact) {
            $createdAt = new DateTimeImmutable($contact['createdAt']);
            foreach (ContactClientBuilder::PROPERTIES as $property) {
                if (!isset($contact['properties'][$property])) {
                    $contact['properties'][$property] = '';
                }
            }
            $properties = $contact['properties'];
            $sourceCompanyId = $properties['associatedcompanyid'];
            if (empty($this->companies[$sourceCompanyId])) {
                $company = $this->em->getRepository(Company::class)->findOneBy(['sourceId' => $sourceCompanyId]);
                if ($company) {
                    $this->companies[$sourceCompanyId] = $company;
                } else {
                    continue;
                }
            } else {
                $company = $this->companies[$sourceCompanyId];
            }
            $contactObject = new Contact();
            $contactObject
                ->setSource(self::SOURCE)
                ->setSourceId($contact['id'])
                ->setSourceCreatedAt($createdAt)
                ->setFirstName($properties['firstname'])
                ->setLastName($properties['lastname'])
                ->setEmail($properties['email'])
                ->setPhone($properties['phone'])
                ->setJobTitle($properties['jobtitle'])
                ->setCompany($company);
            $contactsObjects[] = $contactObject;
        }
        return $contactsObjects;
    }
}
