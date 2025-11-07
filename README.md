# Laravel Pastry API

Api para o gerenciamento de uma pastelaria desenvolvida com Laravel 12 e a biblioteca sanctum para o gerenciamento de autenticação. O sistema permite
Listar, Criar, Ler, Editar e Excluir (CRUDL) dados para os seguintes módulos: Produtos, Clientes e Pedidos. Ainda conta com um sistema de autenticação com Login, Registo e Logout.

## tecnologias Usadas
- PHP 8.4
- Laravel 12
- Mysql
- Laravel sanctum
- PHPUnit 
- Docker com Laravel Sail
- Postman

## Requisitos
Necessário tr o docker instalado na máquina. Se for windows vai precisar do WSL

## Como instalar na máquina local
### clone o repositório
```bash
git clone https://github.com/katalekoweb/katalekoweb/laravel-pastry-api.git
cd katalekoweb/laravel-pastry-api
```

### Copie o ficheiro .env
```bash
cp .env.example .env
```

### Instale as dependencias
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### Rode os containers com o Laravel sail
```bash
./vendor/bin/sail up -d
```

### Gere a chave do programa
```bash
./vendor/bin/sail artisan key:generate
```

### Rode as migrations e os seeders
```bash
./vendor/bin/sail artisan migrate --seed
```

### Instale as dependencias npm
```bash
./vendor/bin/sail npm i
```

### Faça o build das libs npm
```bash
./vendor/bin/sail npm run build
```

### Acesse o seu projeto num de cliente de API como o post man ou Insonia
Url: http://locathost/api/v1/login, Method: POST \
Login | username:admin@admin.com, senha: password

### Como rodar os testes

Acessar o terminal do ambiente sail
### Faça o build das libs npm
```bash
./vendor/bin/sail bash
```

E rode:
```bash
php artisan test
```

## Meu email: juliofeli78@gmail.com
## Linkedin: https://www.linkedin.com/in/juliaokataleko
## Whatsapp: https://wa.me/244922660717

