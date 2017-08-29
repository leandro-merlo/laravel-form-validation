@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de clientes</h3>
        </div>
        <div class="row" style="margin-bottom: 28px">
            <a href="{{ action('ClientController@create', ['pessoa' => \App\Client::PESSOA_FISICA] ) }}"
               class="btn btn-primary">Novo - Pessoa Física</a>
            <a href="{{ action('ClientController@create', ['pessoa' => \App\Client::PESSOA_JURIDICA]) }}"
               class="btn btn-primary">Novo - Pessoa Jurídica</a>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Data Nasc.</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Sexo</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->nome }}</td>
                            <td>{{ $client->documento }}</td>
                            <td>@if ($client->pessoa == \App\Client::PESSOA_FISICA){{ date_format(date_create_from_format('d/m/Y', $client->data_nasc), 'd/m/Y') }} @else {{ 'NP' }}@endif</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->telefone }}</td>
                            <td>{{ $client->sexo }}</td>
                            <td>
                                <a href="{{ route('clients.edit', ['id' => $client->id]) }}"><i class="glyphicon glyphicon-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection