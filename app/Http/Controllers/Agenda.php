<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::findorFail($id);
        return view('pages.contact_edit', compact('user'));
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
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
