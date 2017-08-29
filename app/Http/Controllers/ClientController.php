<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use Insight\Utils\ValidarStrings;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundException;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $estados_civis = Client::ESTADOS_CIVIS;
        $client = new Client();
        $pessoa = $request->get('pessoa') == Client::PESSOA_JURIDICA ?
            $request->get('pessoa') : Client::PESSOA_FISICA;
        return view('clients.create', compact('client', 'estados_civis', 'pessoa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $data = $request->all();
        if ($request->get('data_nasc')) $data['data_nasc'] =
            date_format(date_create_from_format('d/m/Y', $request->get('data_nasc')),
                'Y-m-d');
        $data['inadimplente'] = $request->get('inadimplente') ? $request->get('inadimplente') == 'on' : false;
        $cliente = new Client();
        $cliente->create($data);
        return redirect(route('clients.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $pessoa = $client->pessoa;
        $estados_civis = Client::ESTADOS_CIVIS;
        return view('clients.edit', compact('pessoa', 'client', 'estados_civis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\ClientRequest  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $data = $request->all();
        if ($request->get('data_nasc')) $data['data_nasc'] =
            date_format(date_create_from_format('d/m/Y', $request->get('data_nasc')),
                'Y-m-d');
        $data['inadimplente'] = $request->get('inadimplente') ? $request->get('inadimplente') == 'on' : false;
        $client->update($data);
        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
