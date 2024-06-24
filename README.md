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

#### 21. Rota do método store do TarefaController no api.php:
    Route::post('/tarefas',[TarefaController::class, 'store']);

#### 22. Código do método store do TarefaController (Create / POST):
        $tarefa = Tarefa::create([
                'user_id' => $request->user_id,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'data_limite' => $request->data_limite,
    	‘concluida’=> $request->concluida,
            ]);

        return response()->json(new TarefaResource($tarefa), 201);
	
#### 23. Adicionar no model Tarefa o atributo fillable com os campos preenchíveis:
    protected $fillable = [
            'user_id',
            'titulo',
            'descricao',
            'data_limite',
            'concluida'
        ];


#### 24. Instalar o Postman:
    $ comando

#### 25. No Postman enviar requisição http para http://localhost:8000/api/tarefas utilizando o método POST com o seguinte JSON no corpo:
    {
        "user_id": 1,
        "titulo": "Primeira tarefa criada pela API.",
        "descricao": "Essa é a descrição da Primeira tarefa criada pela API.",
        "data_limite": "2024/06/29",
        "concluida": 0
    }


#### 26. Adicionar validação dos campos no início do método store do TarefaController:

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'titulo' => 'required',
                'descricao' => 'required',
                'data_limite' => required|date_format:Y/m/d,
                'concluida' =>  'numeric|between:0,1',
            ]);
    
            if($validator->fails()) 
            {
                return response()->json($validator->errors(), status: 400);
            }


#### 27. Simplificar o restante do método store do TarefaController:
    $tarefa = Tarefa::create($validator->validate());
    
    return response()->json(new TarefaResource($tarefa), 201);

#### 28. Rota do método update do TarefaController no api.php:
    Route::put('/tarefas/{tarefa}',[TarefaController::class, 'update']);

#### 29. Código do método update do TarefaController:
        $tarefa = Tarefa::find($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'titulo' => 'required',
            'descricao' => 'required',
            'data_limite' => 'required|date_format:Y/m/d',
            'concluida' =>  'numeric|between:0,1'
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), status: 400);
        }

        $validated = $validator->validate();

        $tarefa->update([
            'user_id' => $validated['user_id'],
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'data_limite' => $validated['data_limite'],
            'concluida' => $validated['concluida'],
        ]);

        return new TarefaResource($tarefa);

#### 30. No Postman enviar requisição http para http://localhost:8000/api/tarefas/1 utilizando o método PUT com o seguinte JSON no corpo:
    {
        "user_id": 1,
        "titulo": "Tarefa atualizada pela API.",
        "descricao": "Essa é a descrição da Tarefa atualizada pela API.",
        "data_limite": "2024/08/30",
        "concluida": 1
    }

#### 31. Rota do método destroy do TarefaController no api.php:
	Route::delete('/tarefas/{tarefa}',[TarefaController::class, 'destroy']);



#### 32. Código do método destroy do TarefaController:
	    $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json(['mensagem' => 'Tarefa não encontrada.'], status: 404);
        }
        
        $tarefa->delete();

        return response()->json(['mensagem' => 'Tarefa removida.']);

	
#### 33. No Postman enviar requisição http para http://localhost:8000/api/tarefas/1 utilizando o método DELETE (Deve remover na primeira tentativa e falhar na segunda);

## AUTENTICAÇÃO

Rota do método store do UserController no api.php:
Route::post('/users', [UserController::class, 'store']);



Código do método store do UserController:
       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) 
        {
            return response()->json($validator->errors(), status: 400);
        }

        $tarefa = User::create($validator->validate());

        return response()->json(new UserResource($tarefa), 201);

No Postman enviar requisição http para http://localhost:8000/api/users utilizando o método POST com o seguinte JSON no corpo:
{
    "name": "Leo",
    "email": "leo@email.com",
    "password": "senha"
}


Criar controller de autenticação:
		$ php artisan make:controller AuthController



Rota do método login do AuthController no api.php:
Route::post('/login', [AuthController::class, 'login']);


	

Código do método login do AuthController :
  public function login(Request $request) {
        if (Auth::attempt($request->only('email','password'))) {
            $token = $request->user()->createToken('tarefa')->plainTextToken;
            return response()->json(['mensagem' => 'Autorizado.', 'token' => $token], status: 200);
        }
        return response()->json(['mensagem' => 'Não autorizado.'], status: 401);
    }


No Postman enviar requisição http para http://localhost:8000/api/login utilizando o método POST com o seguinte JSON no corpo:
{
    "email":"leo@email.com",
    "password":"senha"
}

Alterar rota do método index do UserController no api.php para ter autenticação:

Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');

No Postman enviar requisição http para http://localhost:8000/api/users utilizando o método GET e provavelmente falhará;

No Postman enviar a mesma requisição novamente porém adicione o Header “Authorization” com o valor “Bearer ” somado ao token recebido no login, como no exemplo abaixo (substitua pelo seu token):
Bearer 7|9syvshUtPgYkhtoDudPG9NdxlEGOwdXnPrsO1J6ke32ef22f

Adicionar rota do método logout do AuthController no api.php com autenticação:
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Código do método logout do AuthController :
public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['mensagem' => 'Token removido.'], status: 200);
    }


No Postman enviar requisição http para http://localhost:8000/api/logout utilizando o método POST com um token válido no Header “Authorization”, como no exemplo abaixo (substitua pelo seu token): 
Bearer 7|9syvshUtPgYkhtoDudPG9NdxlEGOwdXnPrsO1J6ke32ef22f




## [Playlist Laravel 10 + Sanctum](https://youtube.com/playlist?list=PLyugqHiq-SKdFqLIM3HgCAnG8_7wUqHMm&si=4gpAFCGIKirXCNVW)
## [Documentação](https://laravel.com/docs/10.x/eloquent-resources)
