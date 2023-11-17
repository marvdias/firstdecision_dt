# Desafio Tecnico First Decision
- PHP 7.4
- PHPUnit
- Bootstrap 5.1

## Instalar PHPUnit
```
cd desafioDT
composer require --dev phpunit/phpunit ^6.5
composer require --dev phpunit/dbunit
```

## Para executar o teste unitário utilizar so comando abaixo na raiz do projeto:
```
cd desafioDT
./vendor/bin/phpunit 
```

## Editar configurações em:
```/app/core/config.php ```

## Criar tabela do banco Postgres com o comando abaixo:
```
-- Criar a tabela "users"
CREATE TABLE "users" (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) CHECK (LENGTH(name) >= 3 AND LENGTH(name) <= 50),
    email VARCHAR(255),
    password VARCHAR(255)
);
```
