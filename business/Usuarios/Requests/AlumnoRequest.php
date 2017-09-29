<?php

namespace Business\Usuarios\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class AlumnoRequest extends FormRequest
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
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'domicilio' => 'required',
            'telefono' => 'required',
            'alumno.tieneAntecDeportivos' => 'required'
        ];
    }

    public function response(array $errors)
    { 
        return new JsonResponse($errors, 422);
    }

}