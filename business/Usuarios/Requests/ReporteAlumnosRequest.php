<?php

namespace Business\Usuarios\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ReporteAlumnosRequest extends FormRequest
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
            'fechaDesde' => 'required|date',
            'fechaHasta' => 'required|date',
            'frecuencia' => 'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "required" => "El dato es obligatorio",
            "numeric" => "El teléfono sólo debe contener números"
        ];
    }

}
