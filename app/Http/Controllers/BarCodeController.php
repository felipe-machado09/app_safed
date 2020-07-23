<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarCodes;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarCodeRequest;
use Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Excel as BaseExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CodeExports;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendMailJob;
use Illuminate\Support\Str;

class BarCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barcodes = BarCodes::get();
        return response()->json([
            'data' => $barcodes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BarCodeRequest $request)
    {
        $validated = $request->validated();

        $user_id = Auth::user()->id;

        foreach($request->codes as $item){

            $barCode = new BarCodes();

            $barCode->user_id = $user_id;
            $barCode->chassi = $item['chassi'];
            $barCode->connectCar = $item['connectCar'];
            $barCode->save();
        }

        return response()->json([
            'data' => "Dados inseridos com sucesso!"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ExportExcelYesterday()
    {
        $user = Auth::user();
        $type = 'yesterday';
        SendMailJob::dispatch($user,$type);
         // return new SendMail($user);
         // return Mail::send(new SendMail($user));
       return response()->json([
        'message' => "Em instantes você receberá o relatório em seu email!"
        ]);
    }
    public function ExportExcelToday()
    {
        $user = Auth::user();
        $type = 'today';
        SendMailJob::dispatch($user,$type);
         // return new SendMail($user);
         // return Mail::send(new SendMail($user));
       return response()->json([
        'message' => "Em instantes você receberá o relatório em seu email!"
    ]);

    }
    public function ExportExcelWeek()
    {
        $user = Auth::user();
        $type = 'week';
        SendMailJob::dispatch($user,$type);

        return response()->json([
            'message' => "Em instantes você receberá o relatório em seu email!"
        ]);
    }
    public function ExportExcelMonth()
    {
        $user = Auth::user();
        $type = 'month';
        SendMailJob::dispatch($user,$type);
        return response()->json([
            'message' => "Em instantes você receberá o relatório em seu email!"
        ]);
    }
    public function ExportExcelInterval(Request $request)
    {
        $user = Auth::user();
        $start = $request->get('start');
        $end = $request->get('end');
        $type = 'interval';

        SendMailJob::dispatch($user,$type, $start, $end);
        return response()->json([
            'message' => "Em instantes você receberá o relatório em seu email!"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
