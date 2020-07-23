<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\BarCodes;

class BarCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // "chassi" => "required|unique:bar_codes",
            // "connectCar" => "required|unique:bar_codes"
            "codes" => "array|required",
            "codes.*.chassi" => "required",
            "codes.*.connectCar" => "required",
        ];
    }

    public function messages()
    {
        return [
            "chassi.unique" => "Este Chassi já foi cadastrado!",
            "connectCar.unique" => "Este Codigo da ConnectCar já foi cadastrado!",
            "chassi.required" => "O campo chassi é obrigatorio",
            "connectCar.required" => "O campo connectCar é obrigatorio"
        ];
    }
}
