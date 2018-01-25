<?php 

namespace Business\Clases\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuspenderClasesRequest extends FormRequest
{

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
            "fechaDesde" => "required|date",
            "fechaHasta" => "bail|required_if:indefinido,false|nullable|date",
            "indefinido" => "required",
            "accion" => "required",
            "dias.*.diaSemana" => "required_with:dias",
            "dias.*.rangosHorarios.*.horaDesde" => "required_with:dias.*.rangosHorarios",
            "dias.*.rangosHorarios.*.horaHasta" => "required_with:dias.*.rangosHorarios",
            "dias.*.rangosHorarios.*.horaDesde" => "date_format:H:i:s",
            "dias.*.rangosHorarios.*.horaHasta" => "date_format:H:i:s",
            "dias.*.rangosHorarios.*" => "valid_range"
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
            "date" => "El dato no tiene un formato de fecha válido",
            "required_if" => "El dato es obligatorio",
            "required_with" => "El dato es obligatorio",
            "date_format" => "El dato no tiene un formato de hora válido",
            "valid_range" => "Fecha Desde no puede ser mayor a Fecha Hasta"
        ];
    }

}