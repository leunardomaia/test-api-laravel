# Api Laravel

## Setup (Ubuntu/Mint)
1. $ sudo apt-get install composer
2. $ sudo apt-get install php8.1 php8.1-cli php8.1-common php8.1-imap php8.1-redis php8.1-snmp php8.1-xml php8.1-zip php8.1-mbstring php8.1-curl
3. $ sudo apt-get install -y php-xml
4. $ sudo apt-get install -y php-gd
5. $ composer create-project laravel/laravel minha-api
6. $ cd minha-api
7. $ php artisan serve //deveria estar disponível no navegador
8. Suba o MariaDB e o Adminer com `$ docker-compose up -d` na raiz do projeto

## API
1. $ php artisan make:resource
	- nome: UserResource
2. Arrumar o retorno da resource
3. $ php artisan make:controller
	- nome: UserController
	- tipo: api
	- criar model: User
4. Arrumar variáveis do banco no .env
5. $ php artisan migrate // cria tabela no banco
6. Em routes/api.php setar a rota de users:
	 Route::resources([
	 	 'users' => UserController::class,
	 ]);
7. $ php artisan route:list  // para ver se as rotas de users estão disponíveis
8. Usar header "accept = application/json" no postman para apenas respostas em Json
9. Escrever os métodos do UserController

links: 
	- https://laravel.com/docs/10.x/eloquent-resources
	- https://www.youtube.com/watch?v=0TnToyz3dn0&t=368s
