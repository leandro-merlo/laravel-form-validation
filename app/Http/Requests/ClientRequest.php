<?php

namespace App\Http\Requests;

use App\Client;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $this->sanitize();
        $id = $this->route('client');
        if (is_object($id)){
            $id = $id->id;
        }
        $rules = [
            'nome' => 'required|max:100',
            'email' => "required|email|unique:clients,email,$id",
            'telefone' => 'required',
        ];
        $pessoa = $this->get('pessoa');
        if ($pessoa == Client::PESSOA_FISICA) :
            $estados_civis = implode(',', array_keys(Client::ESTADOS_CIVIS));
            $pfRules = [
                'documento' => "required|documento:cpf|unique:clients,documento,$id",
                'data_nasc' => 'required|date',
                'estado_civil' => "required|in:$estados_civis",
                'sexo' => 'required|in:m,f'
            ];
            $rules = array_merge($rules, $pfRules);
        else:
            $pjRules = [
                'documento' => "required|documento:cpnj|unique:clients,documento,$id",
                'fantasia' => 'required',
            ];
            $rules = array_merge($rules, $pjRules);
        endif;
        return $rules;
    }

    public function messages()
    {
        $pessoa = $this->get('pessoa') ;
        return [
            'data_nasc.required' => 'O campo data de nascimento é obrigatório.',
            'documento.documento' => "O campo " . ($pessoa == Client::PESSOA_FISICA ? 'CPF' : 'CNPJ') . ' é inválido.',
        ];
    }

    public function sanitize(){
        $input = $this->all();
        if (isset($input['documento']) && !empty($input['documento'])):
            $input['documento'] = str_replace('.', '', $input['documento']);
            $input['documento'] = str_replace('/', '', $input['documento']);
            $input['documento'] = str_replace('-', '', $input['documento']);
            $input['documento'] = str_replace(' ', '', $input['documento']);
        endif;
        $this->replace($input);
    }

}
