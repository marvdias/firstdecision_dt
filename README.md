# Desafio Tecnico First Decision
Foram utilizados:
- PHP 7.4
- PHPUnit
- Bootstrap 5.1

Pacotes PHP que devem ser incluidos:
- curl
- mbstring
- pgsql

# Para executar o projeto siga os seguintes passos:
- Execute o comando:
```
git clone https://github.com/marvdias/firstdecision_dt dt
```
## Instalar PHPUnit
```
cd desafioFD
composer require --dev phpunit/phpunit ^6.5
```

## Editar configurações de BD e ROOT PATH em:
```desafioFD/app/Core/config.php ```

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

## Para executar o teste unitário utilizar so comando abaixo na raiz do projeto:
```
cd desafioDT
./vendor/bin/phpunit 
```
