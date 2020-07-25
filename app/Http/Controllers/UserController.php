<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderby('name','asc')->paginate(5);
        return response()->json([
            'data' => $users
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $user_id = Auth::user()->id;

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password =  Hash::make($request->input('password'));
        $user->save();

        return response()->json([
            'data' => "Dados inseridos com sucesso!"
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $user = User::find($id);

        if(isset($user)){

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password =  Hash::make($request->input('password'));
            $user->update();

            return response()->json([
                'data' => "Usúario atualizado com sucesso!"
            ], 200);
        }
        return response()->json([
            'message' => 'Usúario não encontrado!'
        ], 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(isset($user)){
            $user->delete();
            return response()->json([
                'message' => 'Usúario Deletado com sucesso!'
            ], 200);
        }
        return response()->json([
            'message' => 'Usúario não encontrado!'
        ], 404);


    }
}
