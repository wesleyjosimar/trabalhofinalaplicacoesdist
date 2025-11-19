@extends('layouts.app')

@section('title', 'Usuários - CBF Antidoping')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Usuários do Sistema</h2>
    <a href="/usuarios/create" class="btn btn-primary">+ Novo Usuário</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Perfil</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->nome }}</td>
            <td>{{ $usuario->email }}</td>
            <td>
                <span class="badge {{ $usuario->perfil === 'admin' ? 'badge-ativo' : 'badge-pendente' }}">
                    {{ ucfirst($usuario->perfil) }}
                </span>
            </td>
            <td>
                <div class="actions">
                    <a href="/usuarios/{{ $usuario->id }}/edit" class="btn btn-primary" 
                       style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Editar</a>
                    @if($usuario->id != session('usuario_id'))
                    <form method="POST" action="/usuarios/{{ $usuario->id }}" style="display: inline;" 
                          onsubmit="return confirm('Deseja realmente excluir este usuário?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Excluir</button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align: center; padding: 2rem;">Nenhum usuário encontrado.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $usuarios->links() }}
</div>
@endsection

