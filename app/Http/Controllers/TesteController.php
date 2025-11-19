<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teste;
use App\Models\Atleta;

class TesteController extends Controller
{
    public function index(Request $request)
    {
        $query = Teste::with('atleta');

        if ($request->has('atleta_id')) {
            $query->where('atleta_id', $request->atleta_id);
        }

        if ($request->has('resultado')) {
            $query->where('resultado', $request->resultado);
        }

        if ($request->has('busca')) {
            $busca = $request->busca;
            $query->whereHas('atleta', function($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%");
            });
        }

        $testes = $query->orderBy('data_coleta', 'desc')->paginate(15);
        $atletas = Atleta::where('status', 'ativo')->orderBy('nome')->get();

        return view('testes.index', compact('testes', 'atletas'));
    }

    public function create()
    {
        $atletas = Atleta::where('status', 'ativo')->orderBy('nome')->get();
        return view('testes.create', compact('atletas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'atleta_id' => 'required|exists:atletas,id',
            'data_coleta' => 'required|date',
            'competicao' => 'nullable|string|max:255',
            'laboratorio' => 'required|string|max:255',
            'resultado' => 'required|in:pendente,negativo,positivo',
            'observacoes' => 'nullable|string',
        ]);

        Teste::create($request->all());

        return redirect('/testes')->with('sucesso', 'Teste registrado com sucesso!');
    }

    public function edit($id)
    {
        $teste = Teste::with('atleta')->findOrFail($id);
        return view('testes.edit', compact('teste'));
    }

    public function update(Request $request, $id)
    {
        $teste = Teste::findOrFail($id);

        $request->validate([
            'resultado' => 'required|in:pendente,negativo,positivo',
            'observacoes' => 'nullable|string',
        ]);

        $teste->update([
            'resultado' => $request->resultado,
            'observacoes' => $request->observacoes,
        ]);

        return redirect('/testes')->with('sucesso', 'Teste atualizado com sucesso!');
    }
}

