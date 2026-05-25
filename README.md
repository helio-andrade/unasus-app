# UNASUS Importador

Aplicacao Laravel para cadastro/login de usuarios e processamento de uma planilha Excel de alunos.

## Requisitos

- PHP 8.3+
- Composer
- Extensoes PHP: `pdo_sqlite`, `fileinfo`, `zip`

## Instalacao

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

A aplicacao usa SQLite por padrao. O arquivo fica em `database/database.sqlite`.

## Troca para MySQL

Altere o `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unasus
DB_USERNAME=root
DB_PASSWORD=
```

Depois rode:

```bash
php artisan migrate
```

## Fluxo

- `/cadastro`: cria usuario com nome, e-mail e senha.
- `/login`: autentica o usuario.
- `/upload`: rota protegida para envio do Excel.

O Excel deve ter os cabecalhos `Nome`, `CPF`, `Email` ou `E-mail`, e `Telefone`.

## Validacoes

- Nome obrigatorio.
- CPF com 11 digitos e digito verificador valido.
- E-mail em formato valido.
- Telefone somente numerico.

## Testes

```bash
php artisan test
```
