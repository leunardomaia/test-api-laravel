1. Instalar PHP e Composer.
2. $ composer global require laravel/installer
3. * Descomentar fileinfo no php.ini (foi preciso no Windows)
4. Setar variável de ambiente do composer (foi preciso no Linux)
  - $ composer global config bin-dir --absolute --quiet
  - copie o resultado
  - Agora, edite seu arquivo ~/.bashrc através do comando $ nano ~/.bashrc e adicione a seguinte linha: export PATH=$PATH:RESULTADO_DO_COMANDO_ANTERIOR
  - $ source ~/.bashrc
5. $ laravel new minha-api
6. $ cd minha-api
7. $ php artisan serve //deveria estar disponível no navegador
8. $ php artisan make:resource
	- nome: UserResource
9. Arrumar o retorno da resource
10. $ php artisan make:controller
	- nome: UserController
	- tipo: api
	- criar model: User
11. Arrumar variáveis do banco no .env
12. $ php artisan migrate // cria tabela no banco
13. Em routes/api.php setar a rota de users:
	 Route::resources([
	 	 'users' => UserController::class,
	 ]);
14. $ php artisan route:list  // para ver se as rotas de users estão disponíveis
15. Usar header "accept = application/json" no postman para apenas respostas em Json
16. Escrever os métodos do UserController

links: 
	- https://laravel.com/docs/10.x/eloquent-resources
	- https://www.youtube.com/watch?v=0TnToyz3dn0&t=368s
