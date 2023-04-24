<?php

namespace App\Imports\Hubspot\Company;

use App\Imports\Contracts\ClientBuilderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CompanyClientBuilder implements ClientBuilderInterface
{
    public const PROPERTIES = [
        'name',
        'industry',
        'city',
        'country',
        'website',
        'phone',
        'zip',
        'numberofemployees',
        'annualrevenue',
        'description',
    ];

    public const QUERY_LIMIT = 3;
    private string $credentials = '';
    public string $url = '';
    private bool $hasNext = false;

    public function __construct(
        private HttpClientInterface $client,
        private readonly string     $hubspotApiKey,
        private readonly string     $hubspotCompanyUrl
    ) {
    }

    public function initCredentials(): void
    {
        $this->credentials = $this->hubspotApiKey;
        $this->url = $this->hubspotCompanyUrl;
    }

    public function hasNext(array $content = []): bool
    {
        if (!empty($content)) {
            if (isset($content['paging']['next']['link'])) {
                $this->url = $content['paging']['next']['link'];
                $this->hasNext = true;
            } else {
                $this->hasNext = false;
            }
        }
        return $this->hasNext;
    }

    public function getClient(): HttpClientInterface
    {
        if (!$this->hasNext) {
            $this->initRequest();
            $queryString = http_build_query(['properties' => self::PROPERTIES, 'limit' => self::QUERY_LIMIT]);
            $queryString = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $queryString);
            $this->url = $this->url . '?' . $queryString;
        }
        return $this->client;
    }

    public function initRequest(): void
    {
        $this->initCredentials();
        $this->client = $this->client->withOptions([
            'auth_bearer' => $this->credentials,
        ]);
    }
}
