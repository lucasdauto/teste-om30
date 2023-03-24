<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CepController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {

    }

    public function show($cep)
    {
        if($cep){
            $cep = str_replace('-', '', $cep);
            $cep = str_replace('.', '', $cep);
            $cep = str_replace(' ', '', $cep);

            $dados = Redis::get($cep);

            if (!$dados)
            {
                $client = new Client();
                $response = $client->request('GET', 'https://viacep.com.br/ws/' . $cep . '/json/');
                $dados = json_decode($response->getBody(), true);
                Cache::put($cep, $dados, 60);
            }

            return response()->json($dados);
        }
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
