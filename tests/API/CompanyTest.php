<?php

namespace App\Tests\API;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Company;

class CompanyTest extends ApiTestCase
{
    public function testLogin(): void
    {
        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'username' => 'admin@kaffein.com',
            'password' => 'kaffein',
        ]]);

        if (isset($response->toArray()['token'])) {
            $this->token = $response->toArray()['token'];
        }

        $this->assertResponseIsSuccessful();
    }

}