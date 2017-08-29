<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use Notifiable;

    protected $fillableGeneral = ['nome', 'documento', 'email', 'telefone', 'data_nasc','inadimplente'];
    protected $fillableFisica = ['sexo', 'estado_civil', 'deficiencia'];
    protected $fillableJuridica = ['fantasia'];

    const ESTADOS_CIVIS = [
        1 => 'Solteiro',
        2 => 'Casado',
        3 => 'Divorciado',
    ];

    const PESSOA_FISICA = 'fisica';
    const PESSOA_JURIDICA = 'juridica';

    public function isPessoaFisica()
    {
        return $this->pessoa == Client::PESSOA_FISICA;
    }

    public function fill(array $attributes)
    {
        if ($this->id == null) :
            $this->pessoa = (isset($attributes['pessoa']) && $attributes['pessoa'] == self::PESSOA_JURIDICA) ?
                self::PESSOA_JURIDICA : self::PESSOA_FISICA;
        endif;
        $this->setFillable();
        return parent::fill($attributes);
    }

    private function setFillable()
    {
        if ($this->isPessoaFisica()):
            $this->fillable = array_merge($this->fillableGeneral, $this->fillableFisica);
        else:
            $this->fillable = array_merge($this->fillableGeneral, $this->fillableJuridica);
        endif;
    }

    /**
     *
     * Este serve para o formulário pegar as informações no formato certo
     *
     * @param $value
     * @return string
     */
    public function getDataNascAttribute($value){
        return Carbon::parse($value)->format('d/m/Y');
    }

    /**
     * Este recebe os dados do formulário e converte em data no padrão Ano/Mes/Dia
     *
     * @param $value
     * @return string
     */
    public function formDataNascAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
}
