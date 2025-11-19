@extends('layouts.app')

@section('title', 'Detalhes do Atleta - CBF Antidoping')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Detalhes do Atleta</h2>
        <a href="/atletas" class="btn btn-secondary">Voltar</a>
    </div>
    
    <div class="card" style="margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1.5rem;">Informações Pessoais</h3>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <div>
                <strong>Nome:</strong><br>
                {{ $atleta->nome }}
            </div>
            <div>
                <strong>Data de Nascimento:</strong><br>
                {{ $atleta->data_nascimento->format('d/m/Y') }}
            </div>
            <div>
                <strong>Documento:</strong><br>
                {{ $atleta->documento }}
            </div>
            <div>
                <strong>Status:</strong><br>
                <span class="badge badge-{{ $atleta->status }}">{{ ucfirst($atleta->status) }}</span>
            </div>
            <div>
                <strong>Clube:</strong><br>
                {{ $atleta->clube ?? '-' }}
            </div>
            <div>
                <strong>Federação:</strong><br>
                {{ $atleta->federacao ?? '-' }}
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <a href="/atletas/{{ $atleta->id }}/edit" class="btn btn-primary">Editar Atleta</a>
        </div>
    </div>
    
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Histórico de Testes Antidoping</h3>
            <a href="/testes/create?atleta_id={{ $atleta->id }}" class="btn btn-primary">+ Novo Teste</a>
        </div>
        
        @if($atleta->testes->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Data Coleta</th>
                    <th>Competição</th>
                    <th>Laboratório</th>
                    <th>Resultado</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($atleta->testes->sortByDesc('data_coleta') as $teste)
                <tr>
                    <td>{{ $teste->data_coleta->format('d/m/Y') }}</td>
                    <td>{{ $teste->competicao ?? '-' }}</td>
                    <td>{{ $teste->laboratorio }}</td>
                    <td>
                        <span class="badge badge-{{ $teste->resultado }}">
                            {{ ucfirst($teste->resultado) }}
                        </span>
                    </td>
                    <td>{{ $teste->observacoes ?? '-' }}</td>
                    <td>
                        <a href="/testes/{{ $teste->id }}/edit" class="btn btn-primary" 
                           style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="text-align: center; padding: 2rem; color: #666;">
            Nenhum teste registrado para este atleta.
        </p>
        @endif
    </div>
</div>
@endsection

