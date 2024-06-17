# Api Laravel

## Setup (Ubuntu/Mint)
#### 1. Instalar Composer: 
    $ sudo apt-get install composer
#### 2. Instalar extensões do PHP necessárias:
    $ sudo apt-get install php8.1-xml php8.1-zip php8.1-curl php8.1-mysql
#### 3. Criar o projeto Lavarel:
    $ composer create-project laravel/laravel minha-api
#### 4. Entrar na pasta do projeto:
    $ cd minha-api
#### 5. Subir o servidor: (deveria estar disponível no navegador) 
    $ php artisan serve
#### 6. Subir o MariaDB e Adminer com Docker (colocar o docker-compose.yml desse repositório na raiz do projeto):
    $ docker-compose up -d

## API

#### 1. Criar banco de dados "tarefa"

#### 2. Adicionar dados do banco ao arquivo .env:
    DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3307
	DB_DATABASE=tarefa
	DB_USERNAME=root
	DB_PASSWORD=123

#### 3. Caso não possua "routes/api.php" execute:
    $ php artisan install:api

#### 4. Criar model e migration de Tarefa: 
    $ php artisan make:model Tarefa -m

#### 5. Adicionar campos de Tarefa na migration de criação da tabela:
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users');
        $table->string('titulo');
        $table->text('descricao');
        $table->date('data_limite');
        $table->boolean('concluida')->default(false);

#### 6. Efetuar migração: 
	$ php artisan migrate

#### 7. Criar controllers:
	$ php artisan make:controller TarefaController --resource
	$ php artisan make:controller UserController --resource

#### 8. Código do método index do UserController:
	return User::all();

#### 9. Rota do método index do UserController no api.php:
	Route::get('/users',[UserController::class,'index']);

#### 10. Acessar http://localhost:8000/api/users

#### 11. Criar resources:
	$ php artisan make:resource UserResource
	$ php artisan make:resource TarefaResource

#### 12. Código do método toArray do UserResource:
	 return [
            'id' => $this->id,
            'nome' => $this->name,
            'email' => $this->email,
        ];

#### 13. Código do método index do UserController:
	return UserResource::collection(User::all());

#### 14. Código do método show do UserController:
	return new UserResource(User::where('id', $id)->first());

#### 15. Rota do método show do UserController no api.php:
	Route::get('/users/{user}',[UserController::class,'show']);

#### 16. Código do método index do TarefaController:
        return TarefaResource::collection(Tarefa::all());

#### 17. Código do método show do TarefaController:
        return new TarefaResource(Tarefa::where('id', $id)->first());

#### 18. Rota dos método index e show do TarefaController no api.php:
	Route::get('/tarefas',[TarefaController::class,'index']);
	Route::get('/tarefas/{tarefa}',[TarefaController::class,'show']);

#### 19. Adicionar método "user" em Tarefa:
	public function user()
	{
        	return $this->belongsTo(User::class);
	}

#### 20. Código do método toArray do TarefaResource:
	return [
            'id' => $this->id,
            'usuario' => [
                'id' => $this->user->id,
                'nome' => $this->user->name,
                'email' => $this->user->email,
            ],
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_limite' => Carbon::parse($this->data_limite)->format('d/m/Y'),
            'status' => $this->concluida ? 'Concluída' : 'Pendente',
        ];


## [Playlist Laravel 10 + Sanctum](https://youtube.com/playlist?list=PLyugqHiq-SKdFqLIM3HgCAnG8_7wUqHMm&si=4gpAFCGIKirXCNVW)
## [Documentação](https://laravel.com/docs/10.x/eloquent-resources)
