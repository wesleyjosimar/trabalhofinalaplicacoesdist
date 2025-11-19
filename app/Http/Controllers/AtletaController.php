<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atleta;

class AtletaController extends Controller
{
    public function index(Request $request)
    {
        $query = Atleta::query();

        if ($request->has('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('documento', 'like', "%{$busca}%")
                  ->orWhere('clube', 'like', "%{$busca}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $atletas = $query->orderBy('nome')->paginate(15);

        return view('atletas.index', compact('atletas'));
    }

    public function create()
    {
        return view('atletas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'documento' => 'required|string|unique:atletas,documento',
            'clube' => 'nullable|string|max:255',
            'federacao' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,inativo',
        ]);

        Atleta::create($request->all());

        return redirect('/atletas')->with('sucesso', 'Atleta cadastrado com sucesso!');
    }

    public function show($id)
    {
        $atleta = Atleta::with('testes')->findOrFail($id);
        return view('atletas.show', compact('atleta'));
    }

    public function edit($id)
    {
        $atleta = Atleta::findOrFail($id);
        return view('atletas.edit', compact('atleta'));
    }

    public function update(Request $request, $id)
    {
        $atleta = Atleta::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'documento' => 'required|string|unique:atletas,documento,' . $id,
            'clube' => 'nullable|string|max:255',
            'federacao' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,inativo',
        ]);

        $atleta->update($request->all());

        return redirect('/atletas')->with('sucesso', 'Atleta atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $atleta = Atleta::findOrFail($id);
        $atleta->status = 'inativo';
        $atleta->save();

        return redirect('/atletas')->with('sucesso', 'Atleta inativado com sucesso!');
    }
}

