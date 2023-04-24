<?php

namespace App\Imports\Hubspot\Contact;

use App\Entity\Contact;
use App\Imports\Contracts\ImporterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ContactImporter implements ImporterInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ContactClientBuilder   $builder,
        private readonly ContactTransformer     $transformer
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function import(): void
    {
        $data = $this->getContent();
        $contacts = $this->transformer->transform($data['results']);
        foreach ($contacts as $contact) {
            $this->em->persist($contact);
        }
        if (!empty($contacts)) {
            $this->em->flush();
        }
        if ($this->builder->hasNext()) {
            $this->import();
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
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
    }
}
