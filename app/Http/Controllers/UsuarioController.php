<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::orderBy('nome')->paginate(15);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|string|min:6',
            'perfil' => 'required|in:admin,operacional',
        ]);

        Usuario::create($request->all());

        return redirect('/usuarios')->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'senha' => 'nullable|string|min:6',
            'perfil' => 'required|in:admin,operacional',
        ]);

        $data = $request->except('senha');
        if ($request->filled('senha')) {
            $data['senha'] = $request->senha;
        }

        $usuario->update($data);

        return redirect('/usuarios')->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        
        if ($usuario->id == session('usuario_id')) {
            return redirect('/usuarios')->with('erro', 'Você não pode excluir seu próprio usuário.');
        }

        $usuario->delete();

        return redirect('/usuarios')->with('sucesso', 'Usuário excluído com sucesso!');
    }
}

