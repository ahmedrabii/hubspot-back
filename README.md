# kaffeine

## PHP Version 

```sh
"php": ">=8.1"
```

## Project Setup

```sh
composer install
```

### Generate SSL Key for JWT

```sh
php bin/console lexik:jwt:generate-keypair
```

### Environment variables with [Dotenv]

```sh
# change according to your needs
DATABASE_URL=mysql://user@password@127.0.0.1:3306/kaffein?serverVersion=mariadb-10.4.6
HUBSPOT_API_KEY=----
HUBSPOT_COMPANY_URL=https://api.hubapi.com/crm/v3/objects/companies
HUBSPOT_CONTACT_URL=https://api.hubapi.com/crm/v3/objects/contacts
```

### Create Database

```sh
php bin/console doctrine:database:create
```

### Migrate database

```sh
php bin/console doctrine:migrations:migrate
```

### Loading fixtures

```sh
php bin/console doctrine:fixtures:load
```

### Run local server with [Symfony CLI](https://symfony.com/download)

```sh
# it is best if you install the certificates and enabling TLS
symfony server:ca:install
symfony server:start  -d
```

### Access API documentation 

```sh
https://127.0.0.1:8000/api/docs
```

### Execute tests via PHPUnit

```sh
# preparing environment
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force -q --no-interaction --env=test
php bin/console d:f:l --no-interaction --env=test
# run tests
vendor/bin/phpunit
```

### Pipeline for tests with GitHub Actions

#### See [test-symfony-application.yml](https://github.com/ahmedrabii/hubspot-back/blob/main/.github/workflows/test-symfony-application.yml)
