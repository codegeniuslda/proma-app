# ProMa App

Aplicação desenvolvida com Laravel para gestão de colaboradores, estabelecimentos e registos de tempo.

## Versão do Laravel

Este projeto utiliza **Laravel 10** (`laravel/framework: ^10.10`), conforme definido no `composer.json`.

## Requisitos

- PHP **8.1** ou superior
- Composer
- Node.js e NPM
- Base de dados (configurada no arquivo `.env`)

## Como rodar o projeto

### 1) Instalar dependências do PHP

```bash
composer install
```

### 2) Criar arquivo de ambiente

Linux/macOS:

```bash
cp .env.example .env
```

Windows (cmd):

```cmd
copy .env.example .env
```

### 3) Configurar variáveis de ambiente

Edite o arquivo `.env` com os dados da sua base de dados (host, porta, nome da base, utilizador e palavra-passe).

### 4) Gerar chave da aplicação

```bash
php artisan key:generate
```

### 5) Executar migrations e seeders (opcional, mas recomendado)

```bash
php artisan migrate --seed
```

### 6) Instalar dependências do frontend

```bash
npm install
```

### 7) Compilar assets em desenvolvimento

```bash
npm run dev
```

### 8) Iniciar servidor local

```bash
php artisan serve
```

A aplicação ficará disponível em:
`http://127.0.0.1:8000`

## Comandos úteis

- Rodar testes:

```bash
php artisan test
```

- Limpar cache/config:

```bash
php artisan optimize:clear
```
