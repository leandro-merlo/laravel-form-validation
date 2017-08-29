@extends('layouts.app')

@section('css-extra')
    <link rel="stylesheet" href="/css/bootstrap-datepicker3.css">
    <link rel="stylesheet" href="/css/bootstrap-switch.min.css">
@endsection

@section('content')
    <div class="container novo-cliente-estado-civil">
        @if ($errors->any())
            <ul class="alert alert-danger list-unstyled">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
        <div class="row">
            <h3 class="col-lg-12">{{ 'Editando Cliente - ' . $client->nome }}</h3>
            {{ Form::model($client, ['route' => ['clients.update', $client], 'method' => 'put']) }}
                {{Form::hidden('pessoa', $pessoa)}}
                <div class="form-group col-md-8">
                    {{ Form::label('nome', 'Nome', ['class' => 'control-label']) }}
                    {{ Form::text('nome', old('nome'), ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-md-4">
                    {{ Form::label('documento', $pessoa == \App\Client::PESSOA_FISICA ? 'CPF' : 'CNPJ' , ['class' => 'control-label']) }}
                    {{ Form::text('documento', old('documento', $client->documento), ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-md-8">
                    {{ Form::label('email', 'E-mail', ['class' => 'control-label']) }}
                    {{ Form::text('email', old('email', $client->email), ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-md-4">
                    {{ Form::label('telefone', 'Telefone', ['class' => 'control-label']) }}
                    {{ Form::text('telefone', old('telefone', $client->telefone), ['class' => 'form-control']) }}
                </div>
                @if($pessoa == \App\Client::PESSOA_FISICA)
                <div class="form-group col-md-4">
                    {{ Form::label('estado_civil', 'Estado Civil', ['class' => 'control-label']) }}
                    {{ Form::select('estado_civil', $estados_civis, old('estado_civil', $client->estado_civil),
                        ['class' => 'form-control', 'placeholder' => 'Selecione o estado civil']) }}
                </div>
                <div class="form-group col-md-4">
                    {{ Form::label('data_nasc', 'Data de Nascimento', ['class' => 'control-label']) }}
                    {{ Form::text('data_nasc', old('data_nasc', $client->data_nasc), ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-md-4">
                    {{ Form::label('sexo', 'Sexo', ['class' => 'control-label']) }}<br>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default {!! old('sexo', $client->sexo)=='m' ? 'active' : '' !!}">
                            <input type="radio" name="sexo" id="sexo_masculino" value="m" autocomplete="off" {!! old('sexo',$client->sexo)=='m' ? 'checked="checked"' : '' !!}>Masculino
                        </label>
                        <label class="btn btn-default {!! old('sexo', $client->sexo)=='f' ? 'active' : '' !!}">
                            <input type="radio" name="sexo" id="sexo_feminino"  value="f" autocomplete="off" {!! old('sexo',$client->sexo)=='f' ? 'checked="checked"' : '' !!}>Feminino
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    {{ Form::label('deficiencia', 'Deficiência', ['class' => 'control-label']) }}
                    {{ Form::text('deficiencia', old('deficiencia', $client->deficiencia), ['class' => 'form-control']) }}
                </div>
                @else
                <div class="form-group col-md-6">
                    {{ Form::label('fantasia', 'Nome Fantasia', ['class' => 'control-label']) }}
                    {{ Form::text('fantasia', old('fantasia', $client->fantasia), ['class' => 'form-control']) }}
                </div>
                @endif
                <div class="form-group col-md-4">
                    {{ Form::label('inadimplente', 'Inadimplente?', ['class' => 'control-label']) }}
                    <div>
                        {{ Form::checkbox('inadimplente',old('inadimplente', $client->inadimplente) , old('inadimplente', $client->inadimplente), ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    {{ Form::reset('Reset', ['class' => 'btn btn-default']) }}
                    {{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('javascripts-extra')
    <script src="/js/bootstrap-datepicker.js"></script>
    <script src="/locale/bootstrap-datepicker.pt-BR.min.js"></script>
    <script src="/inputmask/inputmask.min.js"></script>
    <script src="/inputmask/jquery.inputmask.min.js"></script>
    <script src="/js/bootstrap-switch.min.js"></script>
    <script>
        $(document).ready(function(){
            var pessoa = '{{ $pessoa }}';
            $('#data_nasc').datepicker({
                language: 'pt-BR',
            });
            $('#data_nasc').inputmask("99/99/9999", { clearIncomplete: true });
            $val = $('#documento').val();
            if (pessoa == '{{\App\Client::PESSOA_FISICA}}') {
                $('#documento').inputmask({ mask: '999.999.999-99', clearIncomplete: true, removeMaskOnSubmit: true });
            } else {
                if ($val.length < 15) $val = '0' + $val.toString();
                $('#documento').inputmask({ mask: '99[9].999.999/9999-99', clearIncomplete: true, removeMaskOnSubmit: true});
            }
            $('#documento').val($val);
            $('#telefone').inputmask('(99) 9999[9]-9999', { clearIncomplete: true });
            $('#inadimplente').bootstrapSwitch();
        });
    </script>
@endsection