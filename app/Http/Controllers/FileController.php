<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Input;
use Response;

class FileController extends Controller
{

    public function download(Request $request,$name)
    {
        $token = "106c0939-9d67-4928-a909-27fdbf4d65be";
        $getToken = $request->get('token');

        if($token === $getToken){
            $file = File::where('name', $name)->first();

            if (isset($file)) {
                $path = public_path(). '/storage/'. $file->path;
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nome = $file->file.'.'. $ext;
                return Response::download($path, $nome);
            }

        }

        return response()->json([
            'message' => "Arquivo não encontrado!"
        ], 404);
    }


}
