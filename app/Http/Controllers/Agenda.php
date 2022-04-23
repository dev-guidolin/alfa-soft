<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Agenda extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $users =  User::paginate(15);
        return view('pages.contact_list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('pages.contact_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (!isset($data['name']) or !isset($data['contact']) or !isset($data['email'])):
            return response()->json([
                'success' => false,
                'message' => 'Todos os campos do formulário são obrigatórios'
            ]);
        endif;

        if (strlen($data['name']) < 5 || strlen($data['name']) > 20):
            return  response()->json([
                'success' => false,
                'message' => 'O campo nome deve deve ser maior que 5 carateres e menor que 20 carateres'
            ]);
        endif;
        if (strlen($data['contact']) != 14):
            return  response()->json([
                'success' => false,
                'message' => 'O campo contato deve ter pelo menos 14 carateres'
            ]);
        endif;

        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
            return response()->json([
                'success' => false,
                'message' => 'Por favor, insera um email válido'
            ]);
        endif;

        $exist_email = User::whereEmail($request->email)->withTrashed()->get()->first();
        $exist_contact = User::whereContact($request->contact)->withTrashed()->get()->first();

        if($exist_email)
        {
            return response()->json([
                'success' => false,
                'message' => "O email {$request->email} já está cadastrado, escolha outro"
            ]);
        }

        if($exist_contact)
        {
            return response()->json([
                'success' => false,
                'message' => "O contato {$request->contact} já está cadastrado, escolha outro"
            ]);
        }


        try {
            $data['role'] = 'user';
            User::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Usuário criado com sucesso'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::findorFail($id);
        $image = file_get_contents('https://randomuser.me/api/');
        $image = json_decode($image)->results[0];


        return view('pages.contact_detail', compact('user','image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        try
        {
            $user = User::findorFail($id);
            return view('pages.contact_edit', compact('user'));

        }
        catch(ModelNotFoundException  $e)
        {
            return redirect('/');
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
       $request->validate([
            'id' => 'required',
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
        ]);
        $user = User::find($request->id);
        if($request->email != $user->email){
            $exist_email = User::whereEmail($request->email)->get()->first();
             if($exist_email)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'O email a ser atualizado já existe no banco de dados, por favor escolha outro email.'
                ]);
            }
        }
        if($request->contact != $user->contact){
            $exist_email = User::whereEmail($request->contact)->get()->first();
            if($exist_email)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'O contacto a ser atualizado já existe no banco de dados, por favor escolha outro contacto.'
                ]);
            }
        }

        $user->name = $request->name;
        $user->contact = $request->contact;
        $user->email = $request->email;
        $user->update();

        return response()->json([
            'success' => true,
            'message' => "Dados atualizados com sucesso"
        ]);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user)
        {
            return  view('pages.contact_delete',['success'=>false,'message' => "Usuário não encontrado."]);
        }
        try {
           $user->delete();
           return  view('pages.contact_delete',['success'=>true,'message' => "Usuário {$user->name} apagado com sucesso"]);
        }catch (\Exception $e){
            return  view('pages.contact_delete',['success'=>false,'message' => "Erro ao apgar o usuário  {$user->name}"]);
        }

    }
}
