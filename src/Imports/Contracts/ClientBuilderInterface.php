<?php

namespace App\Imports\Contracts;

use Symfony\Contracts\HttpClient\HttpClientInterface;

interface ClientBuilderInterface
{
    public function initCredentials(): void;
    public function hasNext(): bool;
    public function initRequest(): void;
    public function getClient(): HttpClientInterface;

}
