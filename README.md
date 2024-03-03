1. Instalar PHP e Composer.
2. $ composer global require laravel/installer
3. * Descomentar fileinfo no php.ini
4. $ laravel new minha-api
5. $ cd minha-api
6. $ php artisan serve //deveria estar disponível no navegador
7. $ php artisan make:resource
	- nome: UserResource
8. Arrumar o retorno da resource
9. $ php artisan make:controller
	- nome: UserController
	- tipo: api
	- criar model: User
10. Arrumar variáveis do banco no .env
11. $ php artisan migrate // cria tabela no banco
12. Em routes/api.php setar a rota de users:
	// Route::resources([
	// 	 'users' => UserController::class,
	// ]);
13. $ php artisan route:list  // para ver se as rotas de users estão disponíveis
14. Usar header "accept = application/json" no postman para apenas respostas em Json
15. Escrever os métodos do UserController

links: 
	- https://laravel.com/docs/10.x/eloquent-resources
	- https://www.youtube.com/watch?v=0TnToyz3dn0&t=368s
