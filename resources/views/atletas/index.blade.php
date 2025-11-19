@extends('layouts.app')

@section('title', 'Atletas - CBF Antidoping')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Atletas Cadastrados</h2>
    <a href="/atletas/create" class="btn btn-primary">+ Novo Atleta</a>
</div>

<div class="filters">
    <form method="GET" action="/atletas">
        <div class="form-group">
            <label for="busca">Buscar</label>
            <input type="text" id="busca" name="busca" class="form-control" 
                   value="{{ request('busca') }}" placeholder="Nome, documento ou clube">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="">Todos</option>
                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        @if(request('busca') || request('status'))
        <a href="/atletas" class="btn btn-secondary">Limpar</a>
        @endif
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Data Nascimento</th>
            <th>Documento</th>
            <th>Clube</th>
            <th>Federação</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($atletas as $atleta)
        <tr>
            <td>{{ $atleta->nome }}</td>
            <td>{{ $atleta->data_nascimento->format('d/m/Y') }}</td>
            <td>{{ $atleta->documento }}</td>
            <td>{{ $atleta->clube ?? '-' }}</td>
            <td>{{ $atleta->federacao ?? '-' }}</td>
            <td>
                <span class="badge badge-{{ $atleta->status }}">
                    {{ ucfirst($atleta->status) }}
                </span>
            </td>
            <td>
                <div class="actions">
                    <a href="/atletas/{{ $atleta->id }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Ver</a>
                    <a href="/atletas/{{ $atleta->id }}/edit" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Editar</a>
                    @if($atleta->status === 'ativo')
                    <form method="POST" action="/atletas/{{ $atleta->id }}" style="display: inline;" 
                          onsubmit="return confirm('Deseja realmente inativar este atleta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Inativar</button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center; padding: 2rem;">Nenhum atleta encontrado.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $atletas->links() }}
</div>
@endsection

