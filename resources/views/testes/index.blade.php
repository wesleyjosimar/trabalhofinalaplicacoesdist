@extends('layouts.app')

@section('title', 'Testes Antidoping - CBF Antidoping')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Testes Antidoping</h2>
    <a href="/testes/create" class="btn btn-primary">+ Novo Teste</a>
</div>

<div class="filters">
    <form method="GET" action="/testes">
        <div class="form-group">
            <label for="atleta_id">Atleta</label>
            <select id="atleta_id" name="atleta_id" class="form-control">
                <option value="">Todos</option>
                @foreach($atletas as $atleta)
                <option value="{{ $atleta->id }}" {{ request('atleta_id') == $atleta->id ? 'selected' : '' }}>
                    {{ $atleta->nome }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="resultado">Resultado</label>
            <select id="resultado" name="resultado" class="form-control">
                <option value="">Todos</option>
                <option value="pendente" {{ request('resultado') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="negativo" {{ request('resultado') == 'negativo' ? 'selected' : '' }}>Negativo</option>
                <option value="positivo" {{ request('resultado') == 'positivo' ? 'selected' : '' }}>Positivo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="busca">Buscar Atleta</label>
            <input type="text" id="busca" name="busca" class="form-control" 
                   value="{{ request('busca') }}" placeholder="Nome do atleta">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
        @if(request('atleta_id') || request('resultado') || request('busca'))
        <a href="/testes" class="btn btn-secondary">Limpar</a>
        @endif
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Atleta</th>
            <th>Data Coleta</th>
            <th>Competição</th>
            <th>Laboratório</th>
            <th>Resultado</th>
            <th>Observações</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($testes as $teste)
        <tr>
            <td>
                <a href="/atletas/{{ $teste->atleta->id }}" style="color: #006600; text-decoration: none;">
                    {{ $teste->atleta->nome }}
                </a>
            </td>
            <td>{{ $teste->data_coleta->format('d/m/Y') }}</td>
            <td>{{ $teste->competicao ?? '-' }}</td>
            <td>{{ $teste->laboratorio }}</td>
            <td>
                <span class="badge badge-{{ $teste->resultado }}">
                    {{ ucfirst($teste->resultado) }}
                </span>
            </td>
            <td>{{ $teste->observacoes ? (strlen($teste->observacoes) > 50 ? substr($teste->observacoes, 0, 50) . '...' : $teste->observacoes) : '-' }}</td>
            <td>
                <a href="/testes/{{ $teste->id }}/edit" class="btn btn-primary" 
                   style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Editar</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center; padding: 2rem;">Nenhum teste encontrado.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination">
    {{ $testes->links() }}
</div>
@endsection

