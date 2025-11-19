@extends('layouts.app')

@section('title', 'Editar Teste - CBF Antidoping')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 2rem;">Editar Teste Antidoping</h2>
        
        <form method="POST" action="/testes/{{ $teste->id }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Atleta</label>
                <input type="text" class="form-control" value="{{ $teste->atleta->nome }}" disabled>
            </div>
            
            <div class="form-group">
                <label>Data de Coleta</label>
                <input type="text" class="form-control" 
                       value="{{ $teste->data_coleta->format('d/m/Y') }}" disabled>
            </div>
            
            <div class="form-group">
                <label>Competição</label>
                <input type="text" class="form-control" value="{{ $teste->competicao ?? '-' }}" disabled>
            </div>
            
            <div class="form-group">
                <label>Laboratório</label>
                <input type="text" class="form-control" value="{{ $teste->laboratorio }}" disabled>
            </div>
            
            <div class="form-group">
                <label for="resultado">Resultado *</label>
                <select id="resultado" name="resultado" class="form-control" required>
                    <option value="pendente" {{ $teste->resultado === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="negativo" {{ $teste->resultado === 'negativo' ? 'selected' : '' }}>Negativo</option>
                    <option value="positivo" {{ $teste->resultado === 'positivo' ? 'selected' : '' }}>Positivo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes" class="form-control" rows="4">{{ $teste->observacoes }}</textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/testes" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

